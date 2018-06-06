<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>Companion</title>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #FFB75E, #FFC837);
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
         .container {
            color: black;
        } 
    </style>
</head>
<body height="500px">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" >Companion</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"  onClick="getLocation()">Profile</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter" onClick="getLocation()">Join TalkCircle</a>
        <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter" onClick="getLocation()">Join TalkCircle</button> -->
        <!-- <button type="submit">Join TalkCircle</button> -->
        <form action="/groupFaci/{{ Auth::user()->user_id }}" method="post">
            {{ csrf_field() }}
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Just a question before joining...</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" class="btn btn-danger">&times;</span>
                                    </button>
                                </div>
                                        
                                        <div class="modal-body">
                                            <h4>Join TalkCircle today!</h4>
                                            <p>Help people by being there for them when they need a listening ear.</p>
                                            <input type="hidden" name="long" id="long">
                                            <input type="hidden" name="lat" id="lat">
                                        
                                        </div>
                                        <script>
                                            var long = document.getElementById("long");
                                            var lat = document.getElementById("lat");

                                            function getLocation() {
                                                console.log(navigator.geolocation);
                                                if (navigator.geolocation) {
                                                    navigator.geolocation.getCurrentPosition(showPosition);
                                                } else { 
                                                    // long.value = "null";
                                                    // lat.value = "null";
                                                    long.value = position.coords.longitude;
                                                    lat.value = position.coords.latitude;
                                                }
                                            }

                                            function showPosition(position) {
                                                long.value = position.coords.longitude;
                                                lat.value = position.coords.latitude;
                                            }

                                        </script>
                                        <div class="modal-footer">
                                                <button type="submit" class="btn btn-info" id="imagesButton">Join Queue</button>
                                                <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                                        </div>
                                    
                                </div>
                            </div>
                </div>
            </form>
        </li>
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <!-- <a class="dropdown-item" href="/logout"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a> -->
                    <a href="/logout" class="dropdown-item">Logout</a>

                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        </div>
    </div>
    </div>
    </nav>

        <main class="main py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
