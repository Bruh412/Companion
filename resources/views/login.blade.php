
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

    <link href="{{ asset('/css/util.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('/css/main.css') }}" rel="stylesheet" type="text/css">
		<style>
			#bckgrnd {
				background: linear-gradient(to right, #F2994A , #F2C94C);
			}
			.login-container{
				background: none !important;
				padding-top: 140px;
			}
			.login-btn{
				background-color: #fc4a1a;
			}
			.login-btn:hover{
				background-color: #F2C94C;
			}
			.img-icon {
				position: absolute;
				width: 200px;
				height: 200px;
				border-radius: 100px;
				-webkit-border-radius: 100px;
				-moz-border-radius: 100px;
				position:absolute;
				left: 0;
				right: 0;
				margin:0 auto;
				top:0%;
			  }
			  .input-text {
				background: none !important;
			  }
		</style>
    </head>
    <body>
        <div class="limiter">
		<div class="container-login100" id="bckgrnd">
			<div class="login-container wrap-login100 p-t-50 p-b-90">
				<form class="login100-form validate-form flex-sb flex-w"  method="post" action="<?php echo url('/login') ?>">
				{{ csrf_field() }}
					<div>
						<img src="{{ asset('/image/logo.png') }}" class="img-icon">
						<!-- <span class=">Companion</span> -->
					</div>
					<span class="login100-form-title p-b-51" style="color : white">
						Login
					</span>

					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						<input class="input-text input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input-text input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<!-- <div class="flex-sb-m w-full p-t-3 p-b-24">
						<div>
							<a href="#" class="txt1">
								Forgot?
							</a>
						</div>
					</div> -->

					<div class="container-login100-form-btn m-t-17">
						<button class="login-btn login100-form-btn" type="submit" name="submit">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
    </body>
</html>