<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Restaurant Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #ff7eb3, #ff758c);
                color: #ffffff;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                text-align: center;
                padding: 2rem;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }
            p {
                font-size: 1.2rem;
                margin-bottom: 2rem;
            }
            .btn {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                font-weight: bold;
                color: #ffffff;
                background: #ff4d4d;
                border: none;
                border-radius: 8px;
                text-decoration: none;
                transition: background 0.3s ease;
            }
            .btn:hover {
                background: #ff1a1a;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Welcome to the Restaurant Management System</h1>
            <p>Manage your restaurant efficiently with our powerful tools and features.</p>
            <a href="{{ route('concession') }}" class="btn">Go to Concession</a>
        </div>
    </body>
</html>