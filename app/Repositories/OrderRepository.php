<?php

namespace App\Repositories;

use App\Exceptions\Order\AllOrderException;
use App\Exceptions\Order\CreateOrderException;
use App\Exceptions\Order\UpdateOrderException;
use App\Exceptions\Order\DeleteOrderException;
use App\Models\Order;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Support\Facades\DB;

abstract class OrderRepository implements RepositoryInterface
{
    private $model;
    private $customerService;
    
    public function __construct(Order $order, CustomerService $customerService)
    {
        $this->model = $order;
        $this->customerService = $customerService;
    }
    
    public function create(array $data)
    {
        try 
        {
            $order = $this->model->create($data);
            
            return [
                'order' => $this->find($order->id)
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
                    'message' => 'Could`nt find order',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedOrder' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteOrderException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find order',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_order' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateOrderException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $order = $this->model::with('customer.market.area', 'order_products.product.brand', 'order_products.product.unit', 'order_products.product.category')->find($id);
            if(!$order)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find order',
                ];
            }
            return [
                'success' => true,
                'order' => $order,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('customer.market.area', 'order_products.product')->get();
        }
        catch (\Exception $exception) {
            throw new AllOrderException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::with('customer')->orderBy('status', 'DESC')->orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllOrderException($exception->getMessage());
        }
    }

    public function search_orders($data)
    {
        $query = $data['query'];

        // foreign fields
        // customers
        $customers = $this->customerService->search_customers_all($query);
        $customer_ids = [];
        foreach($customers as $customer){
            array_push($customer_ids, $customer->id);
        }

        // search block
        if($data['dispatch_date'] == NULL){
            $orders = Order::whereIn('customer_id', $customer_ids)
                            ->orWhere('id', 'LIKE', '%'.$query.'%')
                            ->orWhere('total', 'LIKE', '%'.$query.'%')
                            ->orWhere('status', 'LIKE', '%'.$query.'%')
                            ->orderBy('status', 'DESC')
                            ->orderBy('created_at', 'DESC')
                            ->paginate(env('PAGINATION'));
        }
        else{
            $dispatch_date = $data['dispatch_date'];

            $orders = Order::whereDate('dispatch_date', $dispatch_date)
                            ->where(function($q) use($customer_ids, $query){
                                $q->orWhereIn('customer_id', $customer_ids);
                                $q->orWhere('id', 'LIKE', '%'.$query.'%');
                                $q->orWhere('total', 'LIKE', '%'.$query.'%');
                                $q->orWhere('status', 'LIKE', '%'.$query.'%');
                            })
                            ->orderBy('status', 'DESC')
                            ->orderBy('created_at', 'DESC')
                            ->paginate(env('PAGINATION'));
        }

        return $orders;
    }

    public function search_orders_all($data)
    {
        $query = $data['query'];

        // foreign fields
        // customers
        $customers = $this->customerService->search_customers_all($query);
        $customer_ids = [];
        foreach($customers as $customer){
            array_push($customer_ids, $customer->id);
        }

        // search block
        if($data['dispatch_date'] == NULL){
            $orders = Order::whereIn('customer_id', $customer_ids)
                            ->orWhere('id', 'LIKE', '%'.$query.'%')
                            ->orWhere('total', 'LIKE', '%'.$query.'%')
                            ->orWhere('status', 'LIKE', '%'.$query.'%')
                            ->orderBy('status', 'DESC')
                            ->orderBy('created_at', 'DESC')
                            ->get();
        }
        else{
            $dispatch_date = $data['dispatch_date'];

            $orders = Order::whereDate('dispatch_date', $dispatch_date)
                            ->where(function($q) use($customer_ids, $query){
                                $q->orWhereIn('customer_id', $customer_ids);
                                $q->orWhere('id', 'LIKE', '%'.$query.'%');
                                $q->orWhere('total', 'LIKE', '%'.$query.'%');
                                $q->orWhere('status', 'LIKE', '%'.$query.'%');
                            })
                            ->orderBy('status', 'DESC')
                            ->orderBy('created_at', 'DESC')
                            ->get();
        }

        return $orders;
    }

    public function fetch_pending_orders()
    {
        return $this->model->with('order_products.product')->where('status', 'pending')->get();
    }

    public function ready_to_dispatch($order_id)
    {
        $order = $this->model->find($order_id);

        if(!$order){
            return '';
        }

        $order->status = 'ready_to_dispatch';
        $order->save();
        return '';
    }
}