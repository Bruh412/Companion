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

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
	 crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="{{ asset('js/app.js') }}" defer></script>
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet" type="text/css">
	<style>
		html,
		body {
			background-color: #fff;
			color: #636b6f;
			font-family: 'Raleway', sans-serif;
			font-weight: 100;
			height: 100vh;
			margin: 0;
			/* padding-bottom: 1.5rem; */
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

		.mw-card {
			/* border-color: #FFB75E; */
		}

		.mw-cd-h {
			background-color: #FFB75E;
			border-bottom: none !important;
		}

		li {
			border: none !important;
		}

		.modal-backdrop {
			z-index: 1020 !important;
		}

		.mt-4 {
			margin-top: 1.5rem !important;
		}

		.mx-2 {
			margin-right: 0.5rem !important;
			margin-left: 0.5rem !important;
		}

		.box-writter {
			position: relative;
		}

		.box-writter textarea {
			padding-top: 2rem;
			transition: all ease-in-out 0.3s;
			-moz-transition: all ease-in-out 0.3s;
			-webkit-transition: all ease-in-out 0.3s;
			min-height: 4rem;
			padding-bottom: 0px;
		}

		.box-writter .box-writter-actions {
			height: 0px;
			overflow: hidden;
			transition: all ease-in-out 0.3s;
			-moz-transition: all ease-in-out 0.3s;
			-webkit-transition: all ease-in-out 0.3s;
			position: absolute;
			bottom: 5px;
			left: 0;
			right: 0;
			margin: 0;
			padding: 0 30px;
			width: 100%;
			background-color: transparent !important;
		}

		.box-writter textarea:focus,
		.box-writter textarea:hover,
		.box-writter textarea:valid {
			box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.14), 0 3px 20px -2px rgba(0, 0, 0, 0.2), 0 1px 25px 0 rgba(0, 0, 0, 0.12);
		}

		.box-writter textarea {
			padding-top: 1.5rem;
		}

		.box-writter textarea:valid {
			min-height: 12rem;
		}

		.box-writter textarea:valid+.box-writter-actions {
			height: auto;
		}

		.bg-white {
			background-color: #fff !important;
			border-color: #fff;
		}

		.box-writter .box-writter-actions .btn {
			font-size: 10px;
		}

		.btn {
			display: -webkit-inline-box;
			display: -ms-inline-flexbox;
			display: inline-flex;
			font-size: 0.875rem;
			font-family: "Montserrat", sans-serif;
			cursor: pointer;
			border-width: 2px;
			-webkit-box-align: center;
			-ms-flex-align: center;
			align-items: center;
		}

		.btn:disabled {
			opacity: .65;
		}

		.fs-16 {
			font-size: 1rem !important;
		}

		input,
		textarea {
			letter-spacing: 0;
		}

		select::-ms-expand {
			display: none;
		}

		select {
			-webkit-appearance: none;
			appearance: none;
		}

		.plans-btn {
			/* display: inline-block; */
			padding: 0.7em 1.7em;
			margin: 0 0.3em 0.3em 0;
			border-radius: 0.2em;
			box-sizing: border-box;
			text-decoration: none;
			font-family: 'Roboto', sans-serif;
			font-weight: 400;
			color: white;
			background-color: #9a4ef1;
			box-shadow: inset 0 -0.6em 1em -0.35em rgba(0, 0, 0, 0.17), inset 0 0.6em 2em -0.3em rgba(255, 255, 255, 0.15), inset 0 0 0em 0.05em rgba(255, 255, 255, 0.12);
			text-align: center;
			position: relative;
		}

		.plans-btn:active {
			box-shadow: inset 0 0.6em 2em -0.3em rgba(0, 0, 0, 0.15), inset 0 0 0em 0.05em rgba(255, 255, 255, 0.12);
		}

		@media all and (max-width:30em) {
			.plans-btn {
				display: block;
				margin: 0.4em auto;
			}
		}

		.block {
			width: 100%;
			border: none;
			cursor: pointer;
		}

		.button-3d.button-action {
			-webkit-box-shadow: 0 7px 0 #8bc220, 0 8px 3px rgba(0, 0, 0, 0.3);
			box-shadow: 0 7px 0 #8bc220, 0 8px 3px rgba(0, 0, 0, 0.3);
		}

		.button-action:visited,
		.button-action-flat:visited {
			color: white;
		}

		.button:visited {
			color: #666666;
		}

		.button-3d.button-action {
			-webkit-box-shadow: 0 7px 0 #8bc220, 0 8px 3px rgba(0, 0, 0, 0.3);
			box-shadow: 0 7px 0 #8bc220, 0 8px 3px rgba(0, 0, 0, 0.3);
		}

		.button-action:visited,
		.button-action-flat:visited {
			color: white;
		}

		.button:visited {
			color: #666666;
		}

		.showcase .button,
		.showcase .button-dropdown,
		.showcase .button-group {
			margin: 5px;
		}

		a,
		a:visited {
			color: #229ffd;
		}

		.button-3d {
			position: relative;
			top: 0;
			-webkit-box-shadow: 0 7px 0 #bbbbbb, 0 8px 3px rgba(0, 0, 0, 0.2);
			box-shadow: 0 7px 0 #bbbbbb, 0 8px 3px rgba(0, 0, 0, 0.2);
		}

		.button-pill {
			border-radius: 200px;
		}

		.button-action,
		.button-action-flat {
			background-color: #a5de37;
			border-color: #a5de37;
			color: white;
		}

        .text-muted {
            color: #BCF !important;
        }
	</style>
</head>

<body style="padding: 20px; background: #d53369;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #cbad6d, #d53369);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #cbad6d, #d53369); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">

	<div style="background-color:white; min-height: 96vh; height:96vh; overflow: auto;">

		<nav class="navbar navbar-expand-lg " style="background-color: #FFB75E;">
			<div class="container">
				<a class="navbar-brand text-white">Companion</a>
				<!-- <div class="text-white" style="border-right: 0.5px solid; height: 1.5rem;"></div> -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
				 aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav" style="font-size: 1rem; padding-left: 7px;">
						<li class="nav-item active">
							<a class="nav-labels nav-link text-white pr-2 pl-2" href="{{ url('/wall')}}">Home
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-labels nav-link text-white" href="#">Notiications</a>
						</li>
						<li class="nav-item">
							<a class="nav-labels nav-link text-white" href="#">Profile</a>
						</li>
						<li class="nav-item">
							<form action="/groupUser/{{ Auth::user()->user_id }}" method="post">
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
												<h4>How are you feeling today? What seems to be bothering you?</h4>
												<input type="hidden" name="long" id="long">
												<input type="hidden" name="lat" id="lat"> @foreach($problems as $prob)
												<div class="form-check" style="background-color: white;">
													<input class="form-check-input" type="checkbox" value="{{ $prob->problem_id }}" id="defaultCheck1" name="problems[]">
													<label class="form-check-label" for="defaultCheck1">
														{{ $prob->problem_name }}
													</label>
												</div>
												@endforeach
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
						<li class="nav-item">
							<a class="nav-labels nav-link text-white" href="checkQueue/{{ Auth::user()->user_id }}">Check Group</a>
						</li>
					</ul>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto" style="font-size: 1rem">
							<li class="nav-item dropdown">
								<a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
								 aria-expanded="false" v-pre>
									{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
									<span class="caret"></span>
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
								<h5 class="card-title mb-1" style="font-weight: bold;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
								<h6 class="card-subtitle mb-2 text-muted" style="padding-top: 5px;">
									<?php echo '@' . Auth::user()->username ?>
								</h6>
							</div>
						</div>
						<br>
						<a href="#" class="button7 btn plans-btn block" style="background: #F09819;  /* fallback for old browsers */
                                                                        background: -webkit-linear-gradient(to right, #EDDE5D, #F09819);  /* Chrome 10-25, Safari 5.1-6 */
                                                                        background: linear-gradient(to right, #EDDE5D, #F09819); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                                                                        max-height: 45px; color: white;">
							<span style="font-size:2em; font-family:'Comic Sans MS'; border-right:1px solid rgba(255,255,255,0.5); padding-right:0.3em; margin-right:0.3em; vertical-align:middle">
								<i class="fas fa-sticky-note"></i>
							</span>
							My Plans
						</a>
						<br>
						<a href="#" class="button7 btn plans-btn block" style="background: #22c1c3;  /* fallback for old browsers */
                                                                        background: -webkit-linear-gradient(to bottom, #fdbb2d, #22c1c3);  /* Chrome 10-25, Safari 5.1-6 */
                                                                        background: linear-gradient(to bottom, #fdbb2d, #22c1c3); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                                                                        max-height: 45px; color: white; margin-top: 5px;">
							<span style="font-size:1.5em; font-family:'Comic Sans MS'; border-right:1px solid rgba(255,255,255,0.5); padding-right:0.3em; margin-right:0.3em; vertical-align:middle">
								<i class="fa fa-users"></i>
							</span>
							Talk Circle
						</a>
						<a href="#" class="button7 btn plans-btn block" style="background: #FEAC5E;  /* fallback for old browsers */
                                                                        background: -webkit-linear-gradient(to bottom, #4BC0C8, #C779D0, #FEAC5E);  /* Chrome 10-25, Safari 5.1-6 */
                                                                        background: linear-gradient(to bottom, #4BC0C8, #C779D0, #FEAC5E); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                                                                        max-height: 45px; color: white; margin-top: 5px;">
							<span style="font-size:2em; font-family:'Comic Sans MS'; border-right:1px solid rgba(255,255,255,0.5); padding-right:0.3em; margin-right:0.3em; vertical-align:middle">
								<i class="fa fa-user"></i>
							</span>
							People
						</a>

						<button class="btn block button-3d button-action button-pill" style="display: block; margin-top: 60px; padding: 10px; font-size: 30px;"
						 data-toggle="modal" data-target="#exampleModalCenter" onClick="getLocation()">Create TalkCircle</button>
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