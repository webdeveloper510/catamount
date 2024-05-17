<?php   
$logo=\App\Models\Utility::get_file('uploads/logo/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    p {
        margin-bottom: 20px;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .footer {
        margin-top: 20px;
        text-align: center;
        color: #666;
    }
    </style>
</head>

<body>

    <p>Dear {{ ucfirst($lead->name) }}</p>
    <div class="container">
        <p>Lead has been withdrawn.</p>

        <p>Thank you for your time and collaboration.</p>
        <p><strong>With regards</strong></p>
        <p><b>The Bond 1786</b></p>
        <div class="logo">
        <img src="{{$logo.'3_logo-light.png'}}" alt="{{ config('app.name', 'The Bond 1786') }}"
                        class="logo logo-lg nav-sidebar-logo" height="50" />
            <img src="{{ $logo.'3_logo-light.png' }}" alt="{{ config('app.name', 'The Bond 1786') }}"
                height="50">
        </div>
    </div>

    <div class="footer">
        <p>This email was generated automatically. Please do not reply.</p>
    </div>
</body>

</html>