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

        <p style="font-size: 16px;">Dear <strong>{{$data['trainerName']}},</strong></p>

        <p style="font-size: 16px;">We are pleased to inform you that a users has been assigned to assist you with your <strong>{{$data['trainingType']}}</strong>. <strong>{{$data['userName']}}</strong>, our experienced trainer, will be guiding you through the training sessions to ensure you gain the knowledge and skills you need.</p>

        <!-- <h3 style="color: #333; font-size: 18px;">Users Details:</h3>
        <ul style="font-size: 16px; list-style-type: none; padding: 0;">
            <li><strong>Trainer's Name:</strong> {{$data['trainerName']}}</li>
            <li><strong>Contact Email:</strong> <a href="mailto:{{trainingMail}}" style="color: #007BFF; text-decoration: none;">{{$data['trainingMail']}}</a></li>
            <li><strong>Training Schedule:</strong> {{$data['trainingSchedule']}}</li>
        </ul> -->
    </div>
</body>

</html>