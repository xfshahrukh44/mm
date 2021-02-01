<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$pdf_name}}</title>
</head>

    <style>
        table,td,th{
            border: 1px solid black;
        }
        label, input, td, th{
            font-size: 10px;
        }
        th{
            text-align: center;
        }
        .details{
            width: 10%;
        }
        .master_img{
            width: 25%; 
            margin-left: 24%;
            /* margin-top: 10%; */
        }
        .gold_img{
            width: 25%; 
            margin-left: 50%;
            margin-top: -19%;
            margin-bottom: 10%;
        }
        .headin_gs{
            /* font-family: inherit !important; */
            text-align: center;
            margin-top: -9%; 
        }
        h5{
            margin-bottom: -3px;
            font-size: 18px;
        }
        h6{
            font-size: 17px;
        }
        .bills, .date{
            width: 30%;
        }
        .date_lable{
            margin-left: 24.5%;
        }
        .ms{
            width: 90%;
        }
        table{
            width: 100%;
        }
        .border_none{
            border: none;
            /* border-bottom: 1px solid gray; */
            margin-top:1%;
        }
    </style>
    <body>
        <div class="master_img">
            <img class="img-fluid" src="../public/pdf_img/mg-02.jpg" alt="Master">
        </div>
    
        <div class="gold_img">
            <img class="img-fluid" src="../public/pdf_img/mg-01.jpg" alt="Gold">
        </div>
    
        <div class="headin_gs">
            <p style="font-size: 14px;">Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi.</p>
        </div>
    
        <div>
            <br>
            <label for="" style="position: absolute; top:0.8rem;" ><strong>Customer Name:</strong>
                <input type="text" class="border_none" value="{{$invoice->customer ? $invoice->customer->name : NULL}}" style="margin-top: 0.72%;">
            </label>
           
            <label for="" class="" style="position: absolute; top:9.5rem; left:35rem;"><strong>Rider Name:</strong>
                 <input type="text" class="border_none" value="{{$invoice->rider_id ? return_user_name($invoice->rider_id) : NULL}}"  style="margin-top: 3.1%;">
            </label>
            
            <label for="" class="" style="position: absolute; top:11.5rem; left:35.97rem;width: 20rem;"><strong>Supplier:</strong>
                <input type="text" class="border_none" value="Master material" style="margin-top: 1.55%;">
            </label>

            <label for="" class="" style="position: absolute; top:12.8rem; left:36.15rem;width: 20rem;"><strong>Contact:</strong>
                <input type="text" class="border_none" value="0311-1039785"  style="margin-top: 1.55%;">
            </label>

            <label for="" class="date_lable"  style="position: absolute; top:14rem; left:26.265rem; width: 20rem;"><strong>Date:</strong>
                <input type="text" class="date border_none" value="{{return_date_pdf($invoice->created_at)}}" style="margin-top: 1.65%;">
            </label>
        </div>
        {{-- <br> --}}
        <div>
            <label for="" style="margin-top: 1%; margin-left: 2.64rem"><strong>Invoice:</strong></label>
            <input type="text" class="border_none" value="{{$invoice->id}}" style="margin-top: 1.3%;">
        </div>
        <div>
            <label for="" style="margin-left: 3.09rem"><strong>Order:</strong></label>
            <input type="text" class="border_none" value="{{$invoice->order ? $invoice->order->id : NULL}}" style="margin-top: 0.27%;">
        </div>
        <div style="margin-top:-1%;">
            <label for="" style="margin-left: 0.28rem"><strong>Shop name & #:</strong></label>
            <input type="text" class="border_none" value="{{$invoice->customer ? $invoice->customer->shop_name . ' - ' . $invoice->customer->shop_number : NULL}}" style="margin-top: 0.25%;">
        </div>
        <div style="margin-top:-1%;">
            <label for="" style="margin-left: 2.29rem"><strong>Mobile #:</strong></label>
            <input type="text" class="border_none" value="{{$invoice->customer ? $invoice->customer->contact_number : NULL}}" style="margin-top: 0.3%;">
        </div>
        <div style="margin-top:-1%;">
            <label for="" style="margin-left: 0.69rem"><strong>Market & area:</strong></label>
            <input type="text" class="border_none" value="{{($invoice->customer && $invoice->customer->market && $invoice->customer->market->area) ? $invoice->customer->market->name.'-'.$invoice->customer->market->area->name : NULL}}" style="margin-top: 0.3%; width:60%;">
        </div>
        <div>
            <img src="../public/pdf_img/NULK.png" alt="" style="width: 25%; position:absolute; z-index:-111; left:35%; opacity:0.4;">
        </div>
    
        <table>
            <tr>
              <th>Qty.</th>
              <th>Details</th>
              <th>Rate</th>
              <th>Amount</th>
            </tr>
            @foreach($invoice->invoice_products as $invoice_product)
                <tr>
                    <td style="text-align: center">{{$invoice_product->quantity}}</td>
                    <td style="text-align: center">{{$invoice_product->product ? ($invoice_product->product->category->name . ' - ' . $invoice_product->product->brand->name . ' - ' . $invoice_product->product->article) : NULL}}</td>
                    <td style="text-align: center">{{$invoice_product->price}}</td>
                    <td style="text-align: center">{{$invoice_product->quantity * $invoice_product->price}}</td>
                </tr>
            @endforeach
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Total</td>
                <td style="text-align: right">{{$invoice->total}}</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Previous Bal.</td>
                <td style="text-align: right">{{$invoice->previous_balance}}</td>
                <!-- <td style="text-align: right">{{$invoice->customer->outstanding_balance + $invoice->amount_pay - $invoice->total}}</td> -->
                <!-- <td style="text-align: right">{{$invoice->customer->outstanding_balance - $invoice->amount_pay}}</td> -->
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Total Due</td>
                <td style="text-align: right">{{$invoice->total + $invoice->previous_balance}}</td>
                <!-- <td style="text-align: right">{{$invoice->customer->outstanding_balance + $invoice->amount_pay}}</td> -->
                <!-- <td style="text-align: right">{{$invoice->customer->outstanding_balance - $invoice->amount_pay}}</td> -->
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none">
                    <input type="text">
                    <br>
                    <label  style="margin-left:5%;" for="">Customer Receiving</label>
                </td>
                <td style="border: none; font-size:14px;">Amount Received</td>
                <td style="text-align: right">{{($invoice->amount_pay != 0) ? $invoice->amount_pay : ""}}</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Balance Due</td>
                <td style="text-align: right">{{(($invoice->amount_pay != 0) ? ($invoice->total + $invoice->previous_balance) - $invoice->amount_pay : "")}}</td>
                <!-- <td style="text-align: right">{{$invoice->customer->outstanding_balance}}</td> -->
            </tr>
        </table>
        <p style=" margin-left:23%; font-size:12px;">This is a computer generated invoice and requires no signature</p>
        
    </body>
</html>