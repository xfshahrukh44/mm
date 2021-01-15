<?php

namespace App\Repositories;

use App\Exceptions\Customer\AllCustomerException;
use App\Exceptions\Customer\CreateCustomerException;
use App\Exceptions\Customer\UpdateCustomerException;
use App\Exceptions\Customer\DeleteCustomerException;
use App\Models\Customer;
use App\Models\Area;
use App\Models\Market;
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
                'customer' => $temp,
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

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'customer' => $this->find($temp->id),
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
            $customer = $this->model::with('market.area', 'special_discounts.product', 'ledgers')->find($id);
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

    public function paginate($pagination)
    {
        try {
            return $this->model::paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function search_customers($query)
    {
        // foreign fields
        // markets
        $markets = Market::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $market_ids = [];
        foreach($markets as $market){
            array_push($market_ids, $market->id);
        }
        // areas
        // $areas = Area::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        // $area_ids = [];
        // foreach($areas as $area){
        //     array_push($area_ids, $area->id);
        // }

        // relational work customer->market->area
        $areas = Area::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $area_ids = [];
        foreach($areas as $area){
            foreach($area->markets as $market){
                array_push($area_ids, $market->id);
            }
        }

        // search block
        $customers = Customer::where('name', 'LIKE', '%'.$query.'%')
                        ->orWhere('contact_number', 'LIKE', '%'.$query.'%')
                        ->orWhere('shop_name', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('market_id', $market_ids)
                        ->orWhereIn('market_id', $area_ids)
                        ->paginate(env('PAGINATION'));

        return $customers;
    }
}
