<?php

namespace App\Repositories;

use App\Exceptions\Receiving\AllReceivingException;
use App\Exceptions\Receiving\CreateReceivingException;
use App\Exceptions\Receiving\UpdateReceivingException;
use App\Exceptions\Receiving\DeleteReceivingException;
use App\Models\Receiving;
use App\Models\Customer;

abstract class ReceivingRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Receiving $receiving)
    {
        $this->model = $receiving;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $receiving = $this->model->create($data);
            
            return [
                'receiving' => $this->find($receiving->id)
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
                    'message' => 'Could`nt find receiving',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'receiving' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeleteReceivingException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find receiving',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'receiving' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateReceivingException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $receiving = $this->model::with('invoice.order.customer.market.area', 'customer.market.area')->find($id);
            if(!$receiving)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find receiving',
                ];
            }
            return [
                'success' => true,
                'receiving' => $receiving,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('invoice')->get();
        }
        catch (\Exception $exception) {
            throw new AllReceivingException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::orderBy('is_received', 'ASC')->orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllReceivingException($exception->getMessage());
        }
    }

    public function paginate_by_user_id($pagination, $user_id)
    {
        try {
            return $this->model->where('created_by', $user_id)->orderBy('is_received', 'ASC')->orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllReceivingException($exception->getMessage());
        }
    }

    public function search_receivings($data)
    {
        $query = $data['query'];
        $status = $data['status'];

        // foreign fields
        // customers
        $customers = Customer::where('name', 'LIKE', '%'. $query .'%')->get();
        $customer_ids = [];
        foreach($customers as $customer){
            array_push($customer_ids, $customer->id);
        }

        // search block
        if($status != NULL){
            $receivings = Receiving::where(function($q) use($query, $customer_ids){
                                        $q->whereIn('customer_id', $customer_ids);
                                        $q->orWhere('invoice_id', 'LIKE', '%'.$query.'%');
                                        $q->orWhere('amount', 'LIKE', '%'.$query.'%');
                                    })
                                    ->where('is_received', $status)
                                    ->orderBy('is_received', 'ASC')
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(env('PAGINATION'));
        }
        else{
            $receivings = Receiving::whereIn('customer_id', $customer_ids)
                                    ->orWhere('invoice_id', 'LIKE', '%'.$query.'%')
                                    ->orWhere('amount', 'LIKE', '%'.$query.'%')
                                    ->orderBy('is_received', 'ASC')
                                    ->orderBy('created_at', 'DESC')
                                    ->paginate(env('PAGINATION'));
        }

        

        return $receivings;
    }

    public function search_receivings_by_user_id($data, $user_id)
    {
        $query = $data['query'];
        $status = $data['status'];

        // foreign fields
        // customers
        $customers = Customer::where('name', 'LIKE', '%'. $query .'%')->get();
        $customer_ids = [];
        foreach($customers as $customer){
            array_push($customer_ids, $customer->id);
        }

        // search block
        if($status != NULL){
            $receivings = Receiving::where('created_at', $user_id)
                                ->where(function($q){
                                    $q->orWhereIn('customer_id', $customer_ids);
                                    $q->orWhere('invoice_id', 'LIKE', '%'.$query.'%');
                                    $q->orWhere('amount', 'LIKE', '%'.$query.'%');
                                })
                                ->where('is_received', $status)
                                ->orderBy('is_received', 'ASC')
                                ->orderBy('created_at', 'DESC')
                                ->paginate(env('PAGINATION'));
        }
        else{
            $receivings = Receiving::where('created_at', $user_id)
                                ->where(function($q){
                                    $q->orWhereIn('customer_id', $customer_ids);
                                    $q->orWhere('invoice_id', 'LIKE', '%'.$query.'%');
                                    $q->orWhere('amount', 'LIKE', '%'.$query.'%');
                                })
                                ->orderBy('is_received', 'ASC')
                                ->orderBy('created_at', 'DESC')
                                ->paginate(env('PAGINATION'));
        }
        

        return $receivings;
    }

    public function fetch_receivings(array $data){
        if($data['user_id'] == 'All'){
            $receivings = $this->model->with('customer.market.area', 'invoice.order', 'user')
                        ->whereDate('created_at', '>=', $data['date_from'])
                        ->whereDate('created_at', '<=', $data['date_to'])
                        ->orderBy('is_received', 'ASC')
                        ->orderBy('created_at', 'DESC')
                        ->get();
        }
        else{
            $receivings = $this->model->with('customer.market.area', 'invoice.order', 'user')
                        ->where('created_by', $data['user_id'])
                        ->whereDate('created_at', '>=', $data['date_from'])
                        ->whereDate('created_at', '<=', $data['date_to'])
                        ->orderBy('is_received', 'ASC')
                        ->orderBy('created_at', 'DESC')
                        ->get();
        }
        $total = 0;
        foreach($receivings as $receiving){
            $total += $receiving->amount;
        }

        return [
            'receivings' => $receivings,
            'total' => $total
        ];
    }

    public function toggle_is_received($id)
    {
        $receiving = $this->model->find($id);
        $receiving->is_received = ($receiving->is_received == 0) ? 1 : 0;
        $receiving->saveQuietly();
    }
}