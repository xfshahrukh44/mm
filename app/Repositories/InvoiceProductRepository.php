<?php

namespace App\Repositories;

use App\Exceptions\InvoiceProduct\AllInvoiceProductException;
use App\Exceptions\InvoiceProduct\CreateInvoiceProductException;
use App\Exceptions\InvoiceProduct\UpdateInvoiceProductException;
use App\Exceptions\InvoiceProduct\DeleteInvoiceProductException;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Storage;

abstract class InvoiceProductRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(InvoiceProduct $invoiceProduct)
    {
        $this->model = $invoiceProduct;
    }
    
    public function create(array $data)
    {
        try 
        {
            $invoiceProduct = $this->model->create($data);
            
            return [
                'invoiceProduct' => $this->find($invoiceProduct->id)
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
                    'message' => 'Could`nt find invoiceProduct',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'invoiceProduct' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletedInvoiceProductException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find invoiceProduct',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'invoiceProduct' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateInvoiceProductException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $invoiceProduct = $this->model::with('product', 'invoice.customer.market.area')->find($id);
            if(!$invoiceProduct)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find invoiceProduct',
                ];
            }
            return [
                'success' => true,
                'invoiceProduct' => $invoiceProduct,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('product', 'invoice.customer.market.area')->get();
        }
        catch (\Exception $exception) {
            throw new AllInvoiceProductException($exception->getMessage());
        }
    }
}
