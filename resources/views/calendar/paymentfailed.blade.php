@php
$logo = URL::asset('storage/uploads/logo/');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: grid;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .failed-container {
            text-align: center;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            margin: 20px;
            animation: fadeInUp 0.6s ease;
        }

        h1 {
            color: #e74c3c;
            /* Red color for the heading */
            font-size: 36px;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .button-container {
            margin-top: 20px;
        }

        .button {
            padding: 12px 24px;
            font-size: 18px;
            color: #ffffff;
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            /* Red gradient button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .button:hover {
            background: linear-gradient(45deg, #c0392b, #e74c3c);
            /* Darker red gradient on hover */
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="failed-container">
      
        <div class="logo-container">
            <img src="{{$logo.'/logo.png' }}" alt="Logo" class="logo-img">
        </div>
        <h1>Payment Failed!</h1>
        <p>We're sorry, but your payment was unsuccessful.</p>
        <div class="button-container">
            <a href="{{ url('/') }}" class="button">Return to Homepage</a>
        </div>
    </div>
</body>

</html>