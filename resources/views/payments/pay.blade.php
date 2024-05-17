@php
$months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 =>
'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
$pay = App\Models\PaymentLogs::where('event_id',$event->id)->get();
$total = 0;
foreach($pay as $p){
$total += $p->amount;
}
$payinfo = App\Models\PaymentInfo::where('event_id',$event->id)->orderBy('id', 'desc')->first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
@include('partials.admin.head')

<body style="min-height: 0vh;">
    <div class="container mt-5 ">
        <div class="row">
            <div class="col-md-12">
                @if(session('success_msg'))
                <div class="alert alert-success">{{session('success_msg')}}</div>
                @endif
                @if(session('error_msg'))
                <div class="alert alert-danger">{{session('error_msg')}}</div>
                @endif
            </div>
            <div class="col-md-12" style="border-radius: 5px;padding: 10px;">
                <h4 class="text-center">Fill Details for further payment</h4>
                <div class="panel panel-primary">
                    <div>
                        <form method="post" action="{{ route('dopay.online',urlencode(encrypt($event->id))) }}">
                            @csrf
                            <div class="row form-group ">
                                <div class="col-md-6">
                                    <label>Owner</label>
                                    <input type="text" name="owner" class="form-control" value="{{$event->name}}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label>CVV</label>
                                    <input type="number" name="cvv" class="form-control" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class=" col-md-6">
                                    <label>Card Number</label>
                                    <input type="number" name="cardNumber" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control"
                                        value="{{ isset($balance) ? $balance :($event->total - $total) }}"
                                        >
                                    <!-- <input type="number" name="amount" class="form-control"
                                        value="{{ isset($payinfo) ? $payinfo->amounttobepaid : ($event->total - $total) }}"
                                        > -->
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class=" col-md-6">
                                    <label>Exp Date</label>
                                    <select class="form-control" name="expiration-month">
                                        @foreach($months as $k => $v)
                                        <option value="{{ $k }}">{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Exp Year</label>
                                    <select class="form-control" name="expiration-year">
                                        @for($i = date('Y'); $i <= (date('Y') + 15); $i++) <option value="{{ $i }}">
                                            {{$i}}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <button class="btn btn-primary" type="submit" style="float: right;">Make
                                        Payment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<style>
.container {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    max-width: 550px;
    width: 100%;
    animation: fadeInUp 0.6s ease;
}
</style>
@include('partials.admin.footer')