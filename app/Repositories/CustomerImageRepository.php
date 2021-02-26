<?php

namespace App\Repositories;

use App\Exceptions\CustomerImage\AllCustomerImageException;
use App\Exceptions\CustomerImage\CreateCustomerImageException;
use App\Exceptions\CustomerImage\UpdateCustomerImageException;
use App\Exceptions\CustomerImage\DeleteCustomerImageException;
use App\Models\CustomerImage;
use App\Models\Customer;

abstract class CustomerImageRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(CustomerImage $customer_image)
    {
        $this->model = $customer_image;
    }
    
    public function create(array $data)
    {
        try 
        {
            $customer_image = $this->model->create($data);
            
            return [
                'customer_image' => $this->find($customer_image->id)
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
                    'message' => 'Could`nt find customer_image',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'customer_image' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteCustomerImageException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find customer_image',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'customer_image' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateCustomerImageException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $customer_image = $this->model::with('customer')->find($id);
            if(!$customer_image)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find customer_image',
                ];
            }
            return [
                'success' => true,
                'customer_image' => $customer_image,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('customer')->get();
        }
        catch (\Exception $exception) {
            throw new AllCustomerImageException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllUserException($exception->getMessage());
        }
    }

    public function search_customer_images($query)
    {
        // foreign fields
        // customers
        $customers = Customer::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $customer_ids = [];
        foreach($customers as $customer){
            array_push($customer_ids, $customer->id);
        }

        // search block
        $customer_images = CustomerImage::where('location', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('customer_id', $customer_ids)
                        ->paginate(env('PAGINATION'));

        return $customer_images;
    }
}
