<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Page Title -->
        <title>{{ config('app.name', 'Dandelines Design') }} - Under Construction</title>

        <!-- Favicon -->
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Antic+Didone&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Antic Didone', serif;
                background-color: #f8f9fa;
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                padding: 0;
            }
            .container {
                text-align: center;
                max-width: 600px;
                padding: 2rem;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: #4a5568;
            }
            p {
                font-size: 1.1rem;
                line-height: 1.6;
                margin-bottom: 1.5rem;
                color: #718096;
            }
            .logo {
                margin-bottom: 2rem;
                max-width: 150px;
            }
            .coming-soon {
                font-size: 1.5rem;
                font-weight: bold;
                margin-top: 2rem;
                color: #4a5568;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Dandelines Design</h1>
            <div class="coming-soon">Coming Soon</div>
            <p>We're currently working on something beautiful. Our website is under construction, but we'll be launching soon.</p>
            <p>Thank you for your patience!</p>
        </div>
    </body>
</html>
