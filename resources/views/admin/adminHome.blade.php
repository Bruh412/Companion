<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Companion</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .flex-center{
                color: white;
                background: -webkit-linear-gradient(right, #FDC830, #F37335);
                background: -moz-linear-gradient(right, #FDC830, #F37335);
                background: -o-linear-gradient(right, #FDC830, #F37335);
                background: linear-gradient(to left, #FDC830, #F37335);
            }

            .links a {
                color: white;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <!-- <a class="dropdown-item" href="/logout"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a> -->
                        <a href="/logout">Logout</a>

                                    <!-- <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                        @csrf
                                </form> -->
                        <!-- <a href="{{ url('/home') }}">Home</a> -->
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Admin Home
                </div>

                <div class="links">
                    <!-- <a href="/checkQueue/S0003">TestGroup</a> -->
                    <a href="/activities">Activities</a>
                    <a href="/interests">Interests</a>
                    <a href="/feelings">Feelings</a>
                    <a href="/categories">Categories</a>
                    <a href="/quotes">Quotes</a>
                    <a href="/venueDash">Venues</a>
                    <a href="/videos">Videos</a>
                    <a href="/systemConfig">Configuration</a>
                    
                </div>
            </div>
        </div>
    </body>
</html>
