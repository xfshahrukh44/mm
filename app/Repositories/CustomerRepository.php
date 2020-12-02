<?php

namespace App\Repositories;

use App\Exceptions\Customer\AllCustomerException;
use App\Exceptions\Customer\CreateCustomerException;
use App\Exceptions\Customer\UpdateCustomerException;
use App\Exceptions\Customer\DeleteCustomerException;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Storage;

abstract class CustomerRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }
    
    public function create(array $data)
    {
        try 
        {
            // shop_picture
            if(array_key_exists('shop_picture', $data)){
                $image = explode(',', $data['shop_picture'])[1];
                $imageName = Str::random(10).'.'.'png';
                Storage::disk('shops')->put($imageName, base64_decode($image));
                $data['shop_picture'] = $imageName;
            }
            // shop_keeper_picture
            if(array_key_exists('shop_keeper_picture', $data)){
                $image = explode(',', $data['shop_keeper_picture'])[1];
                $imageName = Str::random(10).'.'.'png';
                Storage::disk('shopkeepers')->put($imageName, base64_decode($image));
                $data['shop_keeper_picture'] = $imageName;
            }

            $customer = $this->model->create($data);
            
            return [
                'customer' => $this->find($customer->id)
            ];
        }
        catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    
    public function delete($id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find customer',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedCustomer' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletedCustomerException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find customer',
                ];
            }

            // shop_picture
            if(array_key_exists('shop_picture', $data)){
                Storage::disk('shops')->delete($temp->shop_picture);
                $image = explode(',', $data['shop_picture'])[1];
                $imageName = Str::random(10).'.'.'png';
                Storage::disk('shops')->put($imageName, base64_decode($image));
                $data['shop_picture'] = $imageName;
            }
            // shop_keeper_picture
            if(array_key_exists('shop_keeper_picture', $data)){
                Storage::disk('shopkeepers')->delete($temp->shop_keeper_picture);
                $image = explode(',', $data['shop_keeper_picture'])[1];
                $imageName = Str::random(10).'.'.'png';
                Storage::disk('shopkeepers')->put($imageName, base64_decode($image));
                $data['shop_keeper_picture'] = $imageName;
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_customer' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateCustomerException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $customer = $this->model::with('market.area')->find($id);
            if(!$customer)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find customer',
                ];
            }
            return [
                'success' => true,
                'customer' => $customer,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('market.area')->get();
        }
        catch (\Exception $exception) {
            throw new AllCustomerException($exception->getMessage());
        }
    }
}
