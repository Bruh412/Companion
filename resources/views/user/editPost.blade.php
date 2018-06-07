
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
       <meta charset="UTF-8">
	   <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Companion</title>
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                padding-top: 1.5rem;
                background-color: #fffaf4;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .nav-labels:hover {
                background: #FFF;
                border-radius: 3px;
                color: #FFB75E !important;
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
            a {
                text-decoration: none;
            }
            .mw-card{
                border-color: #fffaf4;
            }
            .mw-cd-h{
                background-color: #fffaf4;
                border-bottom: none !important;
            }
        </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #FFB75E;">
    <div class="container">
    <a class="navbar-brand text-white">Companion</a>
    <!-- <div class="text-white" style="border-right: 0.5px solid; height: 1.5rem;"></div> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav" style="font-size: 1rem; padding-left: 7px;">
        <li class="nav-item active">
            <a class="nav-labels nav-link text-white pr-2 pl-2" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-labels nav-link text-white" href="#{{ url('/login') }}">Notiications</a>
        </li>
        <li class="nav-item">
            <a class="nav-labels nav-link text-white" href="#{{ url('/login') }}">Profile</a>
        </li>
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto" style="font-size: 1rem">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
    
    <div class="container" style="padding-top: 2rem;">
    <div class="w-100 h-100">
        <div class="row m-0">
            <div class="col-1"></div>
            <div class="col-3">
                <div class="card" style="width: 16rem;">
                <img class="card-img-top" src="{{ asset('/image/cover.jpg')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title text-center" style="font-weight: bold;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                </div>
            </div>
            <div class="col-7">
                <form method="post" action="{{ url('/posts/update') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea rows="5" class="form-control" id="exampleInputEmail1" name="post">{{ $record->post_content }}</textarea>
                    </div>
                    <div class="form-row m-0">
                        <div class="form-group col-md-10 pl-0">
                            <select name="feeling" class="form-control">
                                <option value="null">....</option>
                                @foreach($feelings as $feeling)
                                    <option value="{{ $feeling->post_feeling_name }}">{{ $feeling->post_feeling_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" value="{{ $record->post_id }}" name="postid">
                        <div class="form-group col-md-2 pr-0">
                            <button type="submit" class="btn btn-info w-100 pl-1 pr-1" name="submit" id="postBtn" style="background-color: #FFB75E; border-color: #FFB75E">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</div>
</body>