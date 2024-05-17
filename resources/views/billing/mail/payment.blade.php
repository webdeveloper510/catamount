@php
$event = App\Models\Meeting::find($id);
$payurl =route('billing.getpaymentlink',urlencode(encrypt($id)))
@endphp


Dear {{ $event->name }},<br>


<b>Click the link below to pay:</b><br>
<p>{{$payurl}}</p>

Thank you for your time and collaboration.<br>
Best regards,
