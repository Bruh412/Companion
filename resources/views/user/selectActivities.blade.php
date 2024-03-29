<?php 
use App\QueueTalkCircle;
use App\FacilitatorSpec; 
?>

<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Companion</title>

        <!-- Fonts -->
       <meta charset="UTF-8">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="#">Companion</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Journal</a>
        </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a href="/logout" class="dropdown-item">Logout</a>

                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
    </div>
    </nav>
    
    <div class="container">
            <br>
            <center>
                <h1>We've chosen some activities that are helpful for the group...</h1>
                <h5>These activities are carefully picked based on what problems the seekers are facing.</h5>
            </center>
            <br>
            <br>

            <form action="/submitActs/{{ $groupID }}" method="post">
            @csrf
                <div>
                    <table>
                        @foreach($activities as $act)
                            <tr>
                                <td><input type="checkbox" value="{{ $act['activity']->actID }}" name='selected[]'></td>
                                <td>
                                    <ul type='none'>
                                        <li><strong>{{ $act['activity']->title }}</strong></li>
                                        <li>{{ $act['activity']->details }}</li>
                                        <li>Requires {{ $act['activity']->participants }} member/s</li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <center>
                        <button class="btn btn-primary" style="font-size: 30px;">Select Activities</button>
                    </center> 
                </div>
            </form>
    </div>
 