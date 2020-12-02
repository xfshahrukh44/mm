<?php

namespace App\Repositories;

use App\Exceptions\Product\AllProductException;
use App\Exceptions\Product\CreateProductException;
use App\Exceptions\Product\UpdateProductException;
use App\Exceptions\Product\DeleteProductException;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Storage;

abstract class ProductRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Product $product)
    {
        $this->model = $product;
    }
    
    public function create(array $data)
    {
        try 
        {
            // product_picture
            if(array_key_exists('product_picture', $data)){
                $image = explode(',', $data['product_picture'])[1];
                $imageName = Str::random(10).'.'.'png';
                Storage::disk('products')->put($imageName, base64_decode($image));
                $data['product_picture'] = $imageName;
            }

            $product = $this->model->create($data);
            
            return [
                'product' => $this->find($product->id)
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
                    'message' => 'Could`nt find product',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'deletedProduct' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletedProductException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product',
                ];
            }

            // product_picture
            if(array_key_exists('product_picture', $data)){
                Storage::disk('products')->delete($temp->product_picture);
                $image = explode(',', $data['product_picture'])[1];
                $imageName = Str::random(10).'.'.'png';
                Storage::disk('products')->put($imageName, base64_decode($image));
                $data['product_picture'] = $imageName;
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'updated_product' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateProductException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $product = $this->model::with('category', 'brand', 'unit')->find($id);
            if(!$product)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find product',
                ];
            }
            return [
                'success' => true,
                'product' => $product,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('category', 'brand', 'unit')->get();
        }
        catch (\Exception $exception) {
            throw new AllProductException($exception->getMessage());
        }
    }
}
