<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Assignment Notification</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f4f4f4; padding: 20px; margin: 0;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto;">
        <h2 style="color: #007BFF; font-size: 24px;">Trainer Assignment Notification for {{$data['leadName']}}</h2>

        <p style="font-size: 16px;">Hi <strong>{{$data['trainerName']}},</strong></p>

        <p style="font-size: 16px;">We have scheduled you to provide <strong>{{$data['trainingType']}}</strong> for <strong>{{$data['companyName']}}</strong>. {{$data['primaryContact']}}Training will take place on <strong>{{$data['trainingSchedule']}}</strong> at <strong>{{$data['customerLocation']}}</strong>. {{ $data['paymentInfo'] ? 'Please see the details below with payment information.' : '' }}</p>

        <!-- <p style="font-size: 16px;">If they fill any amount against trainer that needs to be filled here.</p> -->
        <h3 style="color: #333; font-size: 18px;">Payment information:</h3>
        @if (is_array($data['paymentInfoData']) && count($data['paymentInfoData']) > 1)
        @if($data['paymentInfo'] && $data['paymentInfoData'] != '')
        @foreach($data['paymentInfoData'] as $trainer)
        @php
        $trainerDetail = \App\Models\User::find($trainer['checkbox']);
        @endphp
        <ul style="font-size: 16px; list-style-type: none; padding: 0;">
            <li><strong>Trainer's Name:</strong> {{$trainerDetail->name}}</li>
            <li><strong>Contact Email:</strong> <a href="mailto:{{$trainerDetail->email}}" style="color: #007BFF; text-decoration: none;">{{$trainerDetail->email}}</a></li>
            <li><strong>Training Schedule:</strong> {{$data['trainingSchedule']}}</li>
            <li><strong>Training Cost:</strong> {{$trainer['amount']}}</li>
        </ul>
        @endforeach
        @endif
        @else
        @php
        $trainerDetailElse = \App\Models\User::find($data['paymentInfoData']->checkbox);
        @endphp
        <ul style="font-size: 16px; list-style-type: none; padding: 0;">
            <li><strong>Trainer's Name:</strong> {{$trainerDetailElse->name}}</li>
            <li><strong>Contact Email:</strong> <a href="mailto:{{$trainerDetailElse->email}}" style="color: #007BFF; text-decoration: none;">{{$trainerDetailElse->email}}</a></li>
            <li><strong>Training Schedule:</strong> {{$data['trainingSchedule']}}</li>
            <li><strong>Training Cost:</strong> {{$data['paymentInfoData']->amount}}</li>
        </ul>
        @endif
        <p style="font-size: 16px;"><strong>Thank you</strong></p>
    </div>
</body>

</html>