<?php

namespace App\Repositories;

use App\Exceptions\Invoice\AllInvoiceException;
use App\Exceptions\Invoice\CreateInvoiceException;
use App\Exceptions\Invoice\UpdateInvoiceException;
use App\Exceptions\Invoice\DeleteInvoiceException;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Storage;
use PDF;
use Carbon\Carbon;

abstract class InvoiceRepository implements RepositoryInterface
{
    private $model;
    
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }
    
    public function create(array $data)
    {
        try 
        {
            $invoice = $this->model->create($data);
            
            return [
                'invoice' => $this->find($invoice->id)
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
                    'message' => 'Could`nt find invoice',
                ];
            }

            $this->model->destroy($id);

            return [
                'success' => true,
                'message' => 'Deleted successfully',
                'invoice' => $temp,
            ];
        }
        catch (\Exception $exception) {
            throw new DeletedInvoiceException($exception->getMessage());
        }
    }
    
    public function update(array $data, $id)
    {
        try {
            if(!$temp = $this->model->find($id))
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find invoice',
                ];
            }

            $temp->update($data);
            $temp->save();
            
            return [
                'success' => true,
                'message' => 'Updated successfully!',
                'invoice' => $this->find($temp->id),
            ];
        }
        catch (\Exception $exception) {
            throw new UpdateInvoiceException($exception->getMessage());
        }
    }
    
    public function find($id)
    {
        try 
        {
            $invoice = $this->model::with('customer.market.area', 'invoice_products.product.brand', 'invoice_products.product.unit', 'invoice_products.product.category', 'order.customer.market.area')->find($id);
            if(!$invoice)
            {
                return [
                    'success' => false,
                    'message' => 'Could`nt find invoice',
                ];
            }
            return [
                'success' => true,
                'invoice' => $invoice,
            ];
        }
        catch (\Exception $exception) {

        }
    }
    
    public function all()
    {
        try {
            return $this->model::with('customer.market.area', 'invoice_products.product')->get();
        }
        catch (\Exception $exception) {
            throw new AllInvoiceException($exception->getMessage());
        }
    }

    public function paginate($pagination)
    {
        try {
            return $this->model::with('customer')->orderBy('id', 'DESC')->paginate($pagination);
        }
        catch (\Exception $exception) {
            throw new AllInvoiceException($exception->getMessage());
        }
    }

    public function search_invoices($query)
    {
        // foreign fields
        // customers
        $customers = Customer::select('id')->where('name', 'LIKE', '%'.$query.'%')->get();
        $customer_ids = [];
        foreach($customers as $customer){
            array_push($customer_ids, $customer->id);
        }

        // search block
        $invoices = Invoice::where('article', 'LIKE', '%'.$query.'%')
                        ->orWhereIn('customer_id', $customer_ids)
                        ->orWhere('total', 'LIKE', '%'.$query.'%')
                        ->paginate(env('PAGINATION'));

        return $invoices;
    }

    public function generate_invoice_pdf()
    {
        $test = "ayy";
        $customPaper = array(0,0,930,600);
        $pdf = PDF::loadview('admin.invoice.invoice_pdf', compact('test'))->setPaper( $customPaper , 'landscape');
        return $pdf->stream(Carbon::now() . '.pdf');
    }
}