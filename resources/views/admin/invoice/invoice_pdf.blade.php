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
        .table3,.table4, .tbl_3{
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
            width: 10%;
        }
        .gold_img{
            width: 10%;
        }
        .both_img{
<<<<<<< HEAD
            text-align: center;
=======
            margin-top: -5%;
>>>>>>> 479f6c528571d10d3d73a07d22b3d7378d75fd60
        }
        .headin_gs{
            text-align: center;
            margin-top: -2%;
        }
        h5{
            font-size: 18px;
        }
        h6{
            font-size: 17px;
        }
        .ms{
            width: 90%;
        }
        .table3{
            width: 100%;
            margin-top:-8%
        }
        .table4{
            width: 100%;
            margin-top:-14%
        }
        .nulki_img{
            text-align: center;
        }
        .nulki_img img{
            width: 25%;
            margin-top: 10%;
            opacity: 0.6;
        }
        .nulki_img2{
            text-align: center;
        }
        .nulki_img2 img{
            width: 25%;
            margin-top: 13%;
            opacity: 0.6;
        }
    </style>
    <body>
        <div class="both_img">
            <img class="img-fluid master_img" src="../public/pdf_img/mg-02.jpg" alt="Master">
            <img class="img-fluid gold_img" src="../public/pdf_img/mg-01.jpg" alt="Gold">
        </div>

        <div class="headin_gs">
<<<<<<< HEAD
            <p style="font-size: 10px;">Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi.</p>
=======
            <p style="font-size: 10px;  margin-top:-2%;">Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi.</p>
>>>>>>> 479f6c528571d10d3d73a07d22b3d7378d75fd60
        </div>

        <div class="row">
            <div>
                <table class="table-sm" align="right">
                    <tbody>
                        <tr>
                            <th class="text-left">Rider Name:</th>
                            <td class="text-left" value="{{$invoice->rider_id ? return_user_name($invoice->rider_id) : NULL}}">{{$invoice->rider_id ? return_user_name($invoice->rider_id) : NULL}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Supplier:</th>
                            <td class="text-left" value="Master material">Master material</td>
                        </tr>
                        <tr>
                            <th class="text-left">Contact:</th>
                            <td class="text-left" value="0311-1039785">0311-1039785</td>
                        </tr>
                        <tr>
                            <th class="text-left">Date:</th>
                            <td class="text-left" value="{{return_date_pdf($invoice->created_at)}}">{{return_date_pdf($invoice->created_at)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <table class="table-sm" align="left">
                    <tbody>
                        <tr>
                            <th class="text-left">Id:</th>
                            <td class="text-left" value="{{$invoice->id}}">{{$invoice->id}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Customer Name:</th>
                            <td class="text-left" value="{{$invoice->customer ? $invoice->customer->name : NULL}}">{{$invoice->customer ? $invoice->customer->name : NULL}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Order:</th>
                            <td class="text-left" value="{{$invoice->order ? $invoice->order->id : NULL}}">{{$invoice->order ? $invoice->order->id : NULL}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Shop Name:</th>
                            <td class="text-left" value="{{$invoice->customer ? $invoice->customer->shop_name . ' - ' . $invoice->customer->shop_number : NULL}}">
                            {{$invoice->customer ? $invoice->customer->shop_name . ' - ' . $invoice->customer->shop_number : NULL}}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Contact Number:</th>
                            <td class="text-left" value="{{$invoice->customer ? $invoice->customer->contact_number : NULL}}">
                            {{$invoice->customer ? $invoice->customer->contact_number : NULL}}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Market & area:</th>
                            <td class="text-left" value="{{($invoice->customer && $invoice->customer->market && $invoice->customer->market->area) ? $invoice->customer->market->name.'-'.$invoice->customer->market->area->name : NULL}}">
                            {{($invoice->customer && $invoice->customer->market && $invoice->customer->market->area) ? $invoice->customer->market->name.'-'.$invoice->customer->market->area->name : NULL}}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
<<<<<<< HEAD
        <div class="nulki_img ">
            <img src="../public/pdf_img/NULK.png" alt="">
        </div>
        <div class="">
            <table class="table3">
=======
        <br>
        <br>
        <br>
        <br>
            <img src="../public/pdf_img/NULK.png" alt="" style="width: 25%; position:absolute; z-index:-111; left:35%; opacity:0.4; top:16%;">
            <div class="mt-5">
                <table class="table3">
>>>>>>> 479f6c528571d10d3d73a07d22b3d7378d75fd60
                    <tr>
                    <th class="tbl_3">Qty.</th>
                    <th class="tbl_3">Details</th>
                    <th class="tbl_3">Rate</th>
                    <th class="tbl_3">Amount</th>
                    </tr>
                    @foreach($invoice->invoice_products as $invoice_product)
                        <tr>
                            <td class="tbl_3" style="text-align: center">{{number_format(intval($invoice_product->quantity))}}</td>
                            <td class="tbl_3" style="text-align: center">{{$invoice_product->product ? ($invoice_product->product->category->name . ' - ' . $invoice_product->product->brand->name . ' - ' . $invoice_product->product->article) : NULL}}</td>
                            <td class="tbl_3" style="text-align: center">{{number_format(intval($invoice_product->price))}}</td>
                            <td class="tbl_3" style="text-align: center">{{number_format(intval($invoice_product->quantity * $invoice_product->price))}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="tbl_3" style="border: none"></td>
                        <td class="tbl_3" style="border: none"></td>
                        <td class="tbl_3" style="border: none; font-size: 10px; font-weight:700;">Total</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->total))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Previous Bal.</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->previous_balance))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Discount</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->discount))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Total Due</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->total + $invoice->previous_balance - $invoice->discount))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none">
                            <input type="text">
                            <br>
                            <label for="">Customer Receiving</label>
                        </td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Amount Received</td>
                        <td class="tbl_3" style="text-align: right">{{($invoice->amount_pay != 0) ? number_format(intval($invoice->amount_pay)) : ""}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Balance Due</td>
                        <td class="tbl_3" style="text-align: right">{{(($invoice->amount_pay != 0) ? number_format(intval(($invoice->total + $invoice->previous_balance) - $invoice->amount_pay)) : number_format(intval(($invoice->total + $invoice->previous_balance) - 0)))}}</td>
                    </tr>
                </table>
            </div>

<<<<<<< HEAD
            <!-- message -->
            <div class="row text-center">
                <p style="font-size:12px; margin-top:-3%;">Discription</p>
=======
        <!-- message -->
        <div class="row text-center">
            <p style="font-size:12px;">Discription</p>
        </div>
        <!-- logos -->
        {{-- <div class="row text-center">
            <!-- sui dhaaga -->
            <div class="text-center" style="margin-right:4.8rem;">
                <img src="../public/img/sdpl4.png" alt="core2plusIcon" style="width: 10%; margin-top:-0.08rem;">
                <p style="font-size:8px;">www.masterdhaga.com</p>
            </div>
            <!-- powered by core2plus -->
            <div class="text-center" style="margin-left:4.8rem;">
                <p style="font-size:8px;">Powered By</p>
                <img src="../public/img/core2plusIcon.jpg" alt="core2plusIcon" style="width: 6%; margin-top:-0.5rem;">
                <p style="font-size:8px;">core2plus.com</p>
            </div>
        </div> --}}
        <br>
        <br>
        <br>
        {{-- customer pdf --}}
        <div class="both_img">
            <div class="master_img">
                <img class="img-fluid" src="../public/pdf_img/mg-02.jpg" alt="Master">
>>>>>>> 479f6c528571d10d3d73a07d22b3d7378d75fd60
            </div>
            <!-- logos -->
            {{-- <div class="row text-center">
                <!-- sui dhaaga -->
                <img src="../public/img/sdpl4.png" alt="core2plusIcon" style="width: 10%; margin-left:-11%;">
                <p style="font-size:8px; margin-top:6%; margin-left:-12%;">www.masterdhaga.com</p>
                <!-- powered by core2plus -->
                <p style="font-size:8px; margin-left:7%;">Powered By</p>
                <img src="../public/img/core2plusIcon.jpg" alt="core2plusIcon" style="width: 5%; margin-left:7%; margin-top:2%;">
                <p style="font-size:8px; margin-top:6%; margin-left:7%;" >core2plus.com</p>
            </div> --}}
        </div>


        {{-- CUSTOMER PDF --}}
        <div class="both_img">
            <img class="img-fluid master_img" src="../public/pdf_img/mg-02.jpg" alt="Master">
            <img class="img-fluid gold_img" src="../public/pdf_img/mg-01.jpg" alt="Gold">
        </div>

        <div class="headin_gs">
<<<<<<< HEAD
            <p style="font-size: 10px;">Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi.</p>
=======
            <p style="font-size: 10px;  margin-top:-3%;">Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi.</p>
>>>>>>> 479f6c528571d10d3d73a07d22b3d7378d75fd60
        </div>

        <div class="row">
            <div>
                <table class="table-sm" align="right">
                    <tbody>
                        <tr>
                            <th class="text-left">Rider Name:</th>
                            <td class="text-left" value="{{$invoice->rider_id ? return_user_name($invoice->rider_id) : NULL}}">{{$invoice->rider_id ? return_user_name($invoice->rider_id) : NULL}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Supplier:</th>
                            <td class="text-left" value="Master material">Master material</td>
                        </tr>
                        <tr>
                            <th class="text-left">Contact:</th>
                            <td class="text-left" value="0311-1039785">0311-1039785</td>
                        </tr>
                        <tr>
                            <th class="text-left">Date:</th>
                            <td class="text-left" value="{{return_date_pdf($invoice->created_at)}}">{{return_date_pdf($invoice->created_at)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <table class="table-sm" align="left">
                    <tbody>
                        <tr>
                            <th class="text-left">Id:</th>
                            <td class="text-left" value="{{$invoice->id}}">{{$invoice->id}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Customer Name:</th>
                            <td class="text-left" value="{{$invoice->customer ? $invoice->customer->name : NULL}}">{{$invoice->customer ? $invoice->customer->name : NULL}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Order:</th>
                            <td class="text-left" value="{{$invoice->order ? $invoice->order->id : NULL}}">{{$invoice->order ? $invoice->order->id : NULL}}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Shop Name:</th>
                            <td class="text-left" value="{{$invoice->customer ? $invoice->customer->shop_name . ' - ' . $invoice->customer->shop_number : NULL}}">
                            {{$invoice->customer ? $invoice->customer->shop_name . ' - ' . $invoice->customer->shop_number : NULL}}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Contact Number:</th>
                            <td class="text-left" value="{{$invoice->customer ? $invoice->customer->contact_number : NULL}}">
                            {{$invoice->customer ? $invoice->customer->contact_number : NULL}}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Market & area:</th>
                            <td class="text-left" value="{{($invoice->customer && $invoice->customer->market && $invoice->customer->market->area) ? $invoice->customer->market->name.'-'.$invoice->customer->market->area->name : NULL}}">
                            {{($invoice->customer && $invoice->customer->market && $invoice->customer->market->area) ? $invoice->customer->market->name.'-'.$invoice->customer->market->area->name : NULL}}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
<<<<<<< HEAD
        <div class="nulki_img2">
            <img src="../public/pdf_img/NULK.png" alt="">
        </div>
        <div class="">
            <table class="table4">
=======
        <br>
        <br>
        <br>
        <br>
            <img src="../public/pdf_img/NULK.png" alt="" style="width: 25%; position:absolute; z-index:-111; left:35%; opacity:0.4; top:58%;">
            <div class="mt-5">
                <table class="table3">
>>>>>>> 479f6c528571d10d3d73a07d22b3d7378d75fd60
                    <tr>
                    <th class="tbl_3">Qty.</th>
                    <th class="tbl_3">Details</th>
                    <th class="tbl_3">Rate</th>
                    <th class="tbl_3">Amount</th>
                    </tr>
                    @foreach($invoice->invoice_products as $invoice_product)
                        <tr>
                            <td class="tbl_3" style="text-align: center">{{number_format(intval($invoice_product->quantity))}}</td>
                            <td class="tbl_3" style="text-align: center">{{$invoice_product->product ? ($invoice_product->product->category->name . ' - ' . $invoice_product->product->brand->name . ' - ' . $invoice_product->product->article) : NULL}}</td>
                            <td class="tbl_3" style="text-align: center">{{number_format(intval($invoice_product->price))}}</td>
                            <td class="tbl_3" style="text-align: center">{{number_format(intval($invoice_product->quantity * $invoice_product->price))}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="tbl_3" style="border: none"></td>
                        <td class="tbl_3" style="border: none"></td>
                        <td class="tbl_3" style="border: none; font-size: 10px; font-weight:700;">Total</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->total))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Previous Bal.</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->previous_balance))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Discount</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->discount))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Total Due</td>
                        <td class="tbl_3" style="text-align: right">{{number_format(intval($invoice->total + $invoice->previous_balance - $invoice->discount))}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none">
                            <input type="text" style="display: none;">
                            <br>
                            <label for="" style="display: none;">Customer Receiving</label>
                        </td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Amount Received</td>
                        <td class="tbl_3" style="text-align: right">{{($invoice->amount_pay != 0) ? number_format(intval($invoice->amount_pay)) : ""}}</td>
                    </tr>
                    <tr>
                        <td style="border: none"></td>
                        <td style="border: none"></td>
                        <td style="border: none; font-size: 10px; font-weight:700;">Balance Due</td>
                        <td class="tbl_3" style="text-align: right">{{(($invoice->amount_pay != 0) ? number_format(intval(($invoice->total + $invoice->previous_balance) - $invoice->amount_pay)) : number_format(intval(($invoice->total + $invoice->previous_balance) - 0)))}}</td>
                    </tr>
                </table>
            </div>

            <!-- message -->
            <div class="row text-center">
                <p style="font-size:12px; margin-top:1%;">This is a computer generated invoice and requires no signature</p>
            </div>
            <!-- logos -->
            <div class="row text-center">
                <!-- sui dhaaga -->
                <img src="../public/img/sdpl4.png" alt="core2plusIcon" style="width: 10%; margin-left:-11%;">
                <p style="font-size:8px; margin-top:10%; margin-left:-12%;">www.masterdhaga.com</p>
                <!-- powered by core2plus -->
                <p style="font-size:8px; margin-left:7%;">Powered By</p>
                <img src="../public/img/core2plusIcon.jpg" alt="core2plusIcon" style="width: 5%; margin-left:7%; margin-top:2%;">
                <p style="font-size:8px; margin-top:10%; margin-left:7%;" >core2plus.com</p>
            </div>
        </div>

    </body>
</html>
