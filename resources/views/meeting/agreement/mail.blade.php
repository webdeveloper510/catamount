@php
$url = route('meeting.signedagreement',urlencode(encrypt($meeting->id)));
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement</title>
</head>
<body>
Dear {{ $meeting->name }},<br>

<p>{{$content}}</p><br>

<b>Click the link below to sign the agreement:</b><br>
<p>{{$url}}</p>

Thank you for your time and collaboration.<br>
Best regards,
</body>
</html>