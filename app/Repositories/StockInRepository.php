<?php

namespace App\Repositories;

use App\Exceptions\StockIn\AllStockInException;
use App\Exceptions\StockIn\CreateStockInException;
use App\Exceptions\StockIn\UpdateStockInException;
use App\Exceptions\StockIn\DeleteStockInException;
use App\Models\StockIn;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

abstract class StockInRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(StockIn $stockIn)
    {
        $this->model = $stockIn;
    }
    
    public function create(array $data)
    {
        try 
        {    
            $stockIn = $this->model->create($data);
            
            return [
                'stockIn' => $this->find($stockIn->id)
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
                    'message' => 'Could`nt find stockIn',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedStockIn' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletedStockInException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find stockIn',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_stockIn' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateStockInException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $stockIn = $this->model::with('product')->find($id);
            if(!$stockIn)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find stockIn',
                ];
            }
            return [
                'success' => true,
                'stockIn' => $stockIn,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('product')->get();
        }
        catch (\Exception $exception) {
            throw new AllStockInException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllStockInException($exception->getMessage());
        }
    }

    public function search_stockIns($query)
    {
        // foreign fields
        // products
        $products = Product::select('id')->where('article', 'LIKE', '%'.$query.'%')->get();
        $product_ids = [];
        foreach($products as $product){
            array_push($product_ids, $product->id);
        }

        // search block
        $stockIns = StockIn::whereIn('product_id', $product_ids)
                        ->orWhere('quantity', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $stockIns;
    }
}
