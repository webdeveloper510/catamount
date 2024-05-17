<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            font-size: 2em;
            margin-top: 10px;
        }
        .details {
            margin: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .details p {
            font-size: 1.2em;
            color: #555;
            margin: 10px 0;
        }
        .date-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="http://127.0.0.1/main-file/storage/uploads/logo/logo.png" alt="Logo" class="logo">
        <h1>Meeting Details</h1>
    </div>
    <div class="details">
        <!-- <p>ID: {{ $meeting->id }}</p> -->
        <p>EMAIL: {{ $meeting->email }}</p>
        <p>TYPE: {{ $meeting->type }}</p>
        <p>COMPANY NAME: {{ $meeting->company_name }}</p>
        <p>FUNCTION : {{ $meeting->function }}</p>
        <p>FUNCTION PACKAGE: {{ $meeting->func_package }}</p>
        <p>VENUE SELECTION: {{ $meeting->venue_selection }}</p>
        <p>ROOMS: {{ $meeting->room }}</p>
        <div class="date-container">
            <p>START TIME: {{ $meeting->start_time }}</p>
            <p>END TIME: {{ $meeting->end_time }}</p>
        </div>
    </div>
</body>
</html>
