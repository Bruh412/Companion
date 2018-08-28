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
       
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- BUTTON CSS -->
	 	<link rel="stylesheet" type="text/css" href="{{ asset('button-css/normalize.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('button-css/vicons-font.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('button-css/base.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('button-css/buttons.css') }}" />
        
    <style>
        html, body {
            background: linear-gradient(to right, #70e1f5, #ffd194);
            color: white;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
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
		.btn {
			margin-top: 0rem;
			padding: 3rem 7rem;
			font-size: 22px;
			line-height: normal;
            background-color: #FFB75E;
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
            border: none;
		}
		.ds{
			background-color: transparent;
		}
        .seeker:hover, .faci:hover{
            background: linear-gradient(to right, #F09819 , #EDDE5D);
            border: none;
        }
        .btn-info {
            color: #fff;
            background: linear-gradient(to right, #F09819 , #EDDE5D) !important;
            border: none !important;
        }
		</style>
    </head>
<body>
    <div class="container" style="padding-top: 2rem;">
		<div class="jumbotron ds" style="text-align: center;">
			<h1 class="display-4" style="color: #404040">Register As</h1>
		</div>

		<div class="container">
			<div class="row" style="text-align:center">
				<div class="col-md-6">
					<form method="post" action="{{ url('/register/seeker') }}">
						{{ csrf_field() }}
						<button class="button button--ujarak button--border-thin button--text-thick" name="type" value="Seeker">Seeker</button>
					</form>
				</div>
				<div class="col-md-6">
					<form method="post" action="{{ url('/register/facilitator') }}">
						{{ csrf_field() }}
						<button class="button button--ujarak button--border-thin button--text-thick" name="type" value="Facilitator">Facilitator</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>