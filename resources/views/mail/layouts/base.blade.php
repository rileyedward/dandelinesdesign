<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>@yield('title', 'Dandelines Design')</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin: 8px 0 0 0;
        }
        .email-content {
            padding: 40px 30px;
        }
        .email-content h2 {
            color: #111827;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }
        .email-content h3 {
            color: #374151;
            font-size: 18px;
            font-weight: 600;
            margin: 30px 0 15px 0;
        }
        .email-content p {
            margin: 0 0 20px 0;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s ease;
        }
        .button:hover {
            transform: translateY(-1px);
        }
        .order-summary {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-item {
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 0;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-total {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            text-align: right;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #ec4899;
        }
        .email-footer {
            background-color: #f3f4f6;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer p {
            color: #6b7280;
            font-size: 14px;
            margin: 0 0 10px 0;
        }
        .email-footer a {
            color: #ec4899;
            text-decoration: none;
        }
        .email-footer a:hover {
            text-decoration: underline;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                width: 100% !important;
            }
            .email-header,
            .email-content,
            .email-footer {
                padding: 20px !important;
            }
            .email-header h1 {
                font-size: 24px !important;
            }
            .button {
                display: block !important;
                text-align: center !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>Dandelines Design</h1>
            <p>Creative Events • Floral Arrangements • Custom Artwork</p>
        </div>
        
        <div class="email-content">
            @yield('content')
        </div>
        
        <div class="email-footer">
            <p><strong>Dandelines Design</strong></p>
            <p>Thank you for choosing us for your creative needs!</p>
            <p>
                <a href="{{ config('app.url') }}">Visit our website</a> |
                <a href="{{ config('app.url') }}/contact">Contact us</a>
            </p>
            <p style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
                © {{ date('Y') }} Dandelines Design. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>