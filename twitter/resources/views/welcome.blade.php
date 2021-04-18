<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="home-container">
            <div id="home-buttons-container">
                <h1>Join Twotter today</h1>
                <div class="home-button" onclick="window.location='/register';">
                    <span>Sign up</span>
                </div>
                <div class="home-button" onclick="window.location='/login';">
                    <span>Log in</span>
                </div>
                <div class="home-button" onclick="window.location='/twoots';">
                    <span>Anonymously</span>
                </div>
            </div>
        </div>
    </body>
</html>
