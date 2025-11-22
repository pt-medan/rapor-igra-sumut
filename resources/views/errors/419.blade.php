<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Page Expired') }}</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 20px;
            }

            .container {
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                max-width: 600px;
                width: 100%;
                padding: 40px;
                text-align: center;
            }

            .icon {
                font-size: 48px;
                margin-bottom: 20px;
            }

            h1 {
                font-size: 28px;
                color: #333;
                margin-bottom: 10px;
                font-weight: 600;
            }

            .code {
                display: inline-block;
                background: #f0f0f0;
                padding: 2px 8px;
                border-radius: 4px;
                font-weight: bold;
                color: #667eea;
                font-size: 24px;
                margin-bottom: 20px;
            }

            p {
                color: #666;
                font-size: 16px;
                line-height: 1.6;
                margin-bottom: 30px;
            }

            .reason {
                background: #f9f9f9;
                border-left: 4px solid #667eea;
                padding: 15px;
                text-align: left;
                margin: 20px 0;
                border-radius: 4px;
                color: #555;
                font-size: 14px;
            }

            .reason strong {
                display: block;
                margin-bottom: 8px;
                color: #333;
            }

            .actions {
                display: flex;
                gap: 12px;
                margin-top: 30px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn {
                display: inline-block;
                padding: 12px 24px;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                cursor: pointer;
                border: none;
                transition: all 0.3s ease;
            }

            .btn-primary {
                background: #667eea;
                color: white;
            }

            .btn-primary:hover {
                background: #5568d3;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            }

            .btn-secondary {
                background: #f0f0f0;
                color: #333;
            }

            .btn-secondary:hover {
                background: #e0e0e0;
            }

            .timer {
                margin-top: 20px;
                font-size: 14px;
                color: #999;
            }

            .spinner {
                display: inline-block;
                width: 16px;
                height: 16px;
                border: 3px solid #f0f0f0;
                border-top: 3px solid #667eea;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
                margin-left: 8px;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .countdown {
                font-weight: bold;
                color: #667eea;
            }

            @media (max-width: 600px) {
                .container {
                    padding: 30px 20px;
                }

                h1 {
                    font-size: 24px;
                }

                p {
                    font-size: 14px;
                }

                .actions {
                    flex-direction: column;
                }

                .btn {
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="icon">⏰</div>

            <h1>{{ __('Session Expired') }}</h1>
            <div class="code">419</div>

            <p>{{ __('Your session has expired due to inactivity. For security reasons, you need to log in again.') }}</p>

            <div class="reason">
                <strong>{{ __('Why did this happen?') }}</strong>
                {{ __('Your session expired after 12 hours of inactivity to protect your account. This is a security measure to prevent unauthorized access.') }}
            </div>

            <div class="actions">
                <button class="btn btn-primary" onclick="redirectTo('/login')">
                    {{ __('Log In Again') }}
                </button>
                <button class="btn btn-secondary" onclick="window.history.back()">
                    {{ __('Go Back') }}
                </button>
            </div>

            <div class="timer">
                {{ __('Redirecting to login page in') }} <span class="countdown" id="countdown">5</span> {{ __('seconds') }}
                <span class="spinner"></span>
            </div>
        </div>

        <script>
            // Auto-redirect after 5 seconds
            let seconds = 5;
            const countdownEl = document.getElementById('countdown');

            setInterval(() => {
                seconds--;
                countdownEl.textContent = seconds;

                if (seconds <= 0) {
                    redirectTo('/login');
                }
            }, 1000);

            function redirectTo(url) {
                window.location.href = url;
            }

            // Fallback: jika terjadi error, redirect immediately
            if (!countdownEl) {
                setTimeout(() => {
                    redirectTo('/login');
                }, 5000);
            }
        </script>
    </body>
</html>
