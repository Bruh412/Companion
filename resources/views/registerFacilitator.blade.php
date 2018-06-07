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
    <style>
        html, body {
            background-color: #fff;
            color: white;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #ffe259, #ffa751); 
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
        .in {
            padding-left: 18rem;
            padding-right: 18rem;
        }
		</style>
    </head>
<body>
    <div class="container" style="padding: 2rem;">
		<form method="post" action="{{ url('/register') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="container in">
                <h4 style="text-align: center">R E G I S T R A T I O N</h4><br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="exampleInputPassword1" name="fname" placeholder="First Name">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" id="exampleInputPassword1" name="lname" placeholder="Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputPassword1" name="email" placeholder="Email">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <select name="month" class="form-control">
                            <option selected>Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="day" class="form-control">
                            <option selected>Day</option>
                            <?php for($i = 1 ; $i <= 31; $i++) {?>
                                <option value="<?php echo $i?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select name="year" class="form-control">
                            <option selected>Year</option>
                            <?php for($i = 1985 ; $i <= 2020; $i++) {?>
                                <option value="<?php echo $i?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <select name="gender" class="form-control">
                         <option value="Female">Female</option>
                         <option value="Male">Male</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="exampleInputPassword1" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" name="confirm" placeholder="Confirm Password">
                </div>
                <label for="exampleFormControlInput1">Interests</label>
                <div class="form-check" style="background-color: white;">
                    @foreach($interests as $interest)
                    <input class="form-check-input" type="checkbox" value="{{ $interest->interestName }}" id="defaultCheck1" name="interests[]">
                    <label class="form-check-label" for="defaultCheck1">
                        {{ $interest->interestName }}
                    </label>
                    <br>
                    @endforeach
                </div>
                <br>
                <div class="form-group">
                    <span>Please upload a picture of your Certificate of Registration<span>
                    <input type="file" name="file" class="form-control"> 
                </div>
                <label for="exampleFormControlInput1">Specializations</label>
                <div class="form-check" style="background-color: white;">
                    @foreach($specs as $spec)
                    <input class="form-check-input" type="checkbox" value="{{ $spec->spec_name }}" id="defaultCheck1" name="specs[]">
                    <label class="form-check-label" for="defaultCheck1">
                        {{ $spec->spec_name }}
                    </label>
                    <br>
                    @endforeach
                </div>
                <br>
                <input type="hidden" name="userType" value="facilitator">
                <button class="btn btn-info" name="register">Register</button>
            </div>
        </form>
	</div>
</body>
</html>