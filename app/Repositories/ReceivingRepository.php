<?php

namespace App\Repositories;

use App\Exceptions\Receiving\AllReceivingException;
use App\Exceptions\Receiving\CreateReceivingException;
use App\Exceptions\Receiving\UpdateReceivingException;
use App\Exceptions\Receiving\DeleteReceivingException;
use App\Models\Receiving;

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
            return $this->model::orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllReceivingException($exception->getMessage());
        }
    }

    public function paginate_by_user_id($pagination, $user_id)
    {
        try {
            return $this->model->where('created_by', $user_id)->orderBy('created_at', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllReceivingException($exception->getMessage());
        }
    }

    public function search_receivings($query)
    {
        // foreign fields

        // search block
        $receivings = Receiving::where('invoice_id', 'LIKE', '%'.$query.'%')
                        ->orWhere('amount', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $receivings;
    }

    public function fetch_receivings(array $data){
        $receivings = $this->model->with('customer.market.area', 'invoice.order')->where('created_by', $data['user_id'])->whereDate('created_at', $data['date'])->get();
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
