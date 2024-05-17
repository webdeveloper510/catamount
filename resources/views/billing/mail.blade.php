@php
$url = route('billing.payview',urlencode(encrypt($meeting->id)));
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
Dear {{ $meeting->name }},<br>

<b>Click the link below to pay:</b><br>
<p>{{$url}}</p>

Thank you for your time and collaboration.<br>
Best regards,
</body>
</html>