<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Assignment Notification</title>
</head>

<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f4f4f4; padding: 20px; margin: 0;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto;">
        @if($data['mode'] === 'lead')
        {{-- lead --}}
        <p style="font-size: 16px;">Hi <strong>{{$data['trainerName']}}</strong>,</p>
        <p style="font-size: 16px;">We have assigned a lead to provide <strong>{{$data['leadName']}}</strong> for <strong>{{$data['companyName']}}</strong>. Your point of contact is <strong>{{$data['primaryContact']}}</strong> and training is expected to be On Start date: <strong>{{$data['trainingSchedule']}}</strong> at <strong>{{$data['customerLocation']}}</strong>.</p>
        {{-- lead end --}}
        @else
        {{-- trainer --}}
        @if (is_array($data['paymentInfoData']) && count($data['paymentInfoData']) >= 1)
        <p style="font-size: 16px;">Hi <strong>{{$data['userName']}},</strong></p>
        <p style="font-size: 16px;">We have scheduled training as discussed. Please find the details,</p>
        @php
        $trainers = array_keys($data['paymentInfoData']);
        $trainerDetail = \App\Models\User::whereIn('id',$trainers)->get();
        $name = implode(' / ', $trainerDetail->pluck('name')->toArray());
        $emails = $trainerDetail->pluck('email')->map(function($email) {
        return "<a href='mailto:{$email}' style='color: #007BFF; text-decoration: none;'>{$email}</a>";
        })->toArray();
        $emailLinks = implode(' / ', $emails);
        @endphp
        <h3 style="color: #333; font-size: 18px;">Training Details:</h3>
        <ul style="font-size: 16px; list-style-type: none; padding: 0;">
            <li><strong>Training:</strong>{{$data['leadName']}}</li>
            <li><strong>Trainer(s):</strong>{{$name}}</li>
            <li><strong>Contact Email:</strong>{!!$emailLinks!!}</li>
            <li><strong>Location:</strong> {{$data['customerLocation']}}</li>
            <li><strong>Training Schedule:</strong> {{$data['trainingSchedule']}}</li>
        </ul>

        @else
        @php
        $trainerDetail = \App\Models\User::find($data['paymentInfoData']->checkbox);
        @endphp
        <p style="font-size: 16px;">Hi <strong>{{$data['trainerName']}},</strong></p>
        <p style="font-size: 16px;">We have scheduled you to provide <strong>{{$data['leadName']}}</strong>. Your contact is <strong>{{$data['primaryContact']}}</strong> and training will take place on <strong>{{$data['trainingSchedule']}}</strong> at <strong>{{$data['customerLocation']}}</strong> . Please see the details below with payment information.</p>
        <h3 style="color: #333; font-size: 18px;">Payment information:</h3>
        <ul style="font-size: 16px; list-style-type: none; padding: 0;">
            <li><strong>Trainer:</strong> {{$trainerDetail->name}}</li>
            <li><strong>Email:</strong> <a href="mailto:{{$trainerDetail->email}}" style="color: #007BFF; text-decoration: none;">{{$trainerDetail->email}}</a></li>
            <li><strong>Training Schedule:</strong> {{$data['trainingSchedule']}}</li>
            <li><strong>Training Cost:</strong> {{$data['paymentInfoData']->amount}}</li>
        </ul>
        @endif


        {{-- trainer end --}}

        @endif
        <p style="font-size: 16px;"><strong>Thank you</strong></p>
    </div>
</body>

</html>