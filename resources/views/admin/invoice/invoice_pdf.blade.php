<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INVOICE</title>
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
            border-bottom: 1px solid gray;
        }
    </style>
    <body>
        <div class="master_img">
            <img class="img-fluid" src="{{asset('/pdf_img/mg-01.jpg')}}" alt="Master">
        </div>
    
        <div class="gold_img">
            <img class="img-fluid" src="/pdf_img/mg-01.jpg" alt="Gold">
        </div>
    
        <div class="headin_gs">
            <h5><u>Stockists</u></h5>
            <h5>AA.Brothers</h5>
            <h6>0311-1039785</h6>
        </div>
    
        <div>
            <br>
            <label for="" style="position: absolute; top:1rem; margin-bottom:5%;" >Customer Name
                <input type="text" class="border_none" value="shaikh muhammad sheharyar" style="width: 80%;">
            </label>
           
            <label for="" class="" style="position: absolute; top:11rem; left:26rem;">Rider Name
                 <input type="text" class="border_none" value="shaikh muhammad sheharyar" style="width: 100%;">
            </label>
            
            <label for="" class="" style="position: absolute; top:12.6rem; left:26rem ;width: 20rem;">Company name & #
                <input type="text" class="border_none" value="SuiDhagaa ,29A" style="width: 40%;">
            </label>

            <label for="" class="" style="position: absolute; top:14.1rem; left:26rem;width: 20rem;">Supplier
                <input type="text" class="border_none" value="master material">
            </label>

            <label for="" class="" style="position: absolute; top:15.8rem; left:26rem;width: 20rem;">Contact
                <input type="text" class="border_none" value="09132722191">
            </label>
            <br>            
            <label for="" class="" style="position: absolute; top:17.9rem; left:26rem;width: 20rem;">Address
                <input type="text" class="border_none" value="Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi." style="font-size:10px;">
            </label>

        </div>
        {{-- <br> --}}
        <div>
            <label for="">Invoice</label>
            <input type="text" class="border_none" value="">
        </div>
        <div>
            <label for="">Order</label>
            <input type="text" class="border_none" value="">
        </div>
        <div>
            <label for="">Shop name & #</label>
            <input type="text" class="border_none" value="core2plus ,29A">
        </div>
        <div>
            <label for="">Mobile # </label>
            <input type="text" class="border_none" value="0311-2233446">
        </div>
        <div>
            <label for="">Market & area:</label>
            <input type="text" class="border_none" value="Rufimall, Mosamiyat.">
        </div>
    
        <div class="">
            <label for="">Bill#</label>
            <input type="text" class="bills border_none" value="7899 PKR" >
            
            <label for="" class="date_lable">Date</label>
            <input type="text" class="date border_none" value="09/01/2021" style="width:10%;">
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
            <tr>
              <td style="text-align: center">550</td>
              <td style="text-align: center"> is simply dummy text of the printing and typesetting industry.</td>
              <td style="text-align: center">9</td>
              <td style="text-align: center">10000</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Total</td>
                <td style="text-align: right">200</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Previous Bal.</td>
                <td style="text-align: right">790</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Total Due</td>
                <td style="text-align: right">8800</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none">
                    <input type="text">
                    <br>
                    <label  style="margin-left:5%;" for="">Customer Receiving</label>
                </td>
                <td style="border: none; font-size:14px;">Amount Received</td>
                <td style="text-align: right">100</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Balance Due</td>
                <td style="text-align: right">963</td>
            </tr>
        </table>
        <p style=" text-align: center; font-size:8px;">This is a compelete generated invoice and requires no signature</p>
        
        {{-- 2nd invoice --}}

        <div class="master_img" style="">
            <img class="img-fluid" src="../public/pdf_img/mg-02.jpg" alt="Master">
        </div>
    
        <div class="gold_img">
            <img class="img-fluid" src="../public/pdf_img/mg-01.jpg" alt="Gold">
        </div>
    
        <div style="position:absolute; top:41rem;text-align: center;">
            <h5><u>Stockists</u></h5>
            <h5>AA.Brothers</h5>
            <h6>0311-1039785</h6>
        </div>
    
        <div style="position: absolute; top:33rem;">
            <br>
            <label for="" style="position: absolute; top:13.7rem; margin-bottom:5%;" >Customer Name
                <input type="text" class="border_none" value="shaikh muhammad sheharyar" style="width: 80%;">
            </label>
           
            <label for="" class="" style="position: absolute; top:13.8rem; left:26rem;">Rider Name
                 <input type="text" class="border_none" value="shaikh muhammad sheharyar" style="width: 100%;">
            </label>
            
            <label for="" class="" style="position: absolute; top:15.2rem; left:26rem ;width: 20rem;">Company name & #
                <input type="text" class="border_none" value="SuiDhagaa ,29A" style="width: 40%;">
            </label>

            <label for="" class="" style="position: absolute; top:16.5rem; left:26rem;width: 20rem;">Supplier
                <input type="text" class="border_none" value="master material">
            </label>

            <label for="" class="" style="position: absolute; top:18rem; left:26rem;width: 20rem;">Contact
                <input type="text" class="border_none" value="09132722191">
            </label>
            <br>            
            <label for="" class="" style="position: absolute; top:20rem; left:26rem;width: 20rem;">Address
                <input type="text" class="border_none" value="Plot 247, sector 16b, Malik Anwar goth, Gabol town, North Karachi." style="font-size:10px;">
            </label>

        </div>
        {{-- <br> --}}
        <div>
            <label for="">Invoice</label>
            <input type="text" class="border_none" value="">
        </div>
        <div>
            <label for="">Order</label>
            <input type="text" class="border_none" value="">
        </div>
        <div>
            <label for="">Shop name & #</label>
            <input type="text" class="border_none" value="core2plus ,29A">
        </div>
        <div>
            <label for="">Mobile # </label>
            <input type="text" class="border_none" value="0311-2233446">
        </div>
        <div>
            <label for="">Market & area:</label>
            <input type="text" class="border_none" value="Rufimall, Mosamiyat.">
        </div>
    
        <div class="">
            <label for="">Bill#</label>
            <input type="text" class="bills border_none" value="7899 PKR" >
            
            <label for="" class="date_lable" >Date</label>
            <input type="text" class="date border_none" value="09/01/2021" style="width:10%;">
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
            <tr>
              <td style="text-align: center">550</td>
              <td style="text-align: center"> is simply dummy text of the printing and typesetting industry.</td>
              <td style="text-align: center">9</td>
              <td style="text-align: center">10000</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Total</td>
                <td style="text-align: right">200</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Previous Bal.</td>
                <td style="text-align: right">790</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Total Due</td>
                <td style="text-align: right">8800</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none">
                    <input type="text">
                    <br>
                    <label  style="margin-left:5%;" for="">Customer Receiving</label>
                </td>
                <td style="border: none; font-size:14px;">Amount Received</td>
                <td style="text-align: right">100</td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none; font-size:14px;">Balance Due</td>
                <td style="text-align: right">963</td>
            </tr>
        </table>
        <p style=" text-align: center; font-size:8px;">This is a compelete generated invoice and requires no signature</p>

    </body>
</html>