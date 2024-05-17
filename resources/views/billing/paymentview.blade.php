@php
$logo = URL::asset('storage/uploads/logo/');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        text-align: center;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .payment-options img {
        width: 100px;
        margin: 10px;
        cursor: pointer;
        transition: transform 0.3s ease-in-out;
    }

    .payment-options img:hover {
        transform: scale(1.1);
    }

    .logo-img {
        width: 10%;
    }
    </style>
</head>
@include('partials.admin.head')

<body>
    <div class="container">
        <img src="{{$logo.'/logo.png' }}" alt="Logo" class="logo-img">
        <h4>Select Mode of payment</h4>
        <div class="row form-group">
            <div class="col-md-12">
                <label for="modeofpayment"></label>
                <input type="radio" name="modeofpayment" value="online"> Online
                <input type="radio" name="modeofpayment" value="cash"> Cash
                <input type="radio" name="modeofpayment" value="cheque"> Cheque
            </div>
        </div>
        <div class="paymentopt" style= "display:none;">
            <h4>Click Here to pay</h4>
            <div class="payment-options">
                <a href="{{route('pay',urlencode(encrypt($new_id)))}}" class="btn btn-primary">Pay Now</a>
            </div>
        </div>
        <!-- <img data-paylink="{{ url('/paypal/billing/payment/') }}/{{Request::segment(2)}}" src="https://imgs.search.brave.com/F2X32YQLP77NPXmbREsXY2P3dZPYQYmrSrb3A9ycd9I/rs:fit:860:0:0/g:ce/aHR0cHM6Ly8xMDAw/bG9nb3MubmV0L3dw/LWNvbnRlbnQvdXBs/b2Fkcy8yMDE3LzA1/L0NvbG9yLVBheXBh/bC1Mb2dvLTUwMHg0/MDQuanBn" alt="PayPal">
            <img data-paylink="{{ url('/stripe/billing/payment/') }}/{{Request::segment(2)}}" src="https://imgs.search.brave.com/LoWta5ojUgjpQs9ZlNd28kZoOaB8oXZdrQ78xSzEkA4/rs:fit:860:0:0/g:ce/aHR0cHM6Ly93d3cu/ZWRpZ2l0YWxhZ2Vu/Y3kuY29tLmF1L3dw/LWNvbnRlbnQvdXBs/b2Fkcy9uZXctc3Ry/aXBlLWxvZ28tcG5n/LTg2MHgzNjEucG5n" alt="Stripe" > -->

        <!-- <div id="paypal" style="display: none;">
        </div>
        <div id="stripe" style="display: none;">
        </div> -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    // jQuery(function($){
    // $('div.payment-options > img').click(function(){
    //     let id = $(this).data('paylink');
    //     window.location.href = id;
    // })
    // });    
    jQuery(function($) {
        $('input[name = "modeofpayment"]').change(function() {
            $('.paymentopt').hide();  
            let val = $(this).val();
            if(val == 'online'){
              $('.paymentopt').show();  
            }
        })
    });
    </script>
</body>

</html>