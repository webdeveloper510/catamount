<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            color: #333333;
        }
        .content p {
            line-height: 1.6;
            color: #555555;
        }
        @media (max-width: 600px) {
            .container {
                width: 100% !important;
                margin: 0 auto;
                padding: 0 !important;
            }
            .content, .header {
                padding: 10px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Our Campaign</h1>
        </div>
        <div class="content">
            <h2>Latest Updates</h2>
            {!! $campaignlist->template !!}
            <p><b>{{ $campaignlist->description }}</b></p>
        </div>
    </div>
</body>
</html>
