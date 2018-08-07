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
                <h1>Meet your groupmates!</h1>
            </center>

            <div>
                <ul>
                @foreach($group as $member)
                    @if($member['userType'] == 'facilitator')
                        <li><h3><b>{{ $member['first_name'] }} {{ $member['last_name'] }} - Host</b></h3></li>
                        <ul>
                            <li>Specialization/s: </li>
                            <?php
                                foreach (FacilitatorSpec::where('user_id', $member['user_id'])->get() as $spec) { ?>
                                    <li><b><?php echo $spec->spec['spec_name'] ?></b></li>
                            <?php 
                            }
                            ?>
                        </ul>
                    @else
                        <li>
                            <h3>{{ $member['first_name'] }} {{ $member['last_name'] }}
                            @if($member['user_id'] == Auth::user()->user_id)
                                --- You!
                            @endif
                            </h3>
                        </li>
                        @if(Auth::user()->userType == 'facilitator')
                            <ul>
                                <li>Problem/s: </li>
                                <?php
                                    foreach (QueueTalkCircle::where('user_id', $member['user_id'])->get()[0]->problems as $prob) { ?>
                                        <li><b><?php echo $prob->problem['problem_name'] ?></b></li>
                                <?php 
                                }
                                ?>
                            </ul>
                        @endif
                        <br>
                    @endif
                        <ul>
                            <?php
                                $queued = QueueTalkCircle::where('user_id', $member['user_id'])->get()[0];

                                $lat = $queued['latitude'];
                                $long = $queued['longitude'];                            

                                $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&sensor=false'); 
                                
                                $output= json_decode($geocode);
                                
                                echo '<li>Location: ';
                                    for($j=0;$j<2;$j++){
                                        if($output->results != [])
                                            echo '<b>'.$output->results[0]->address_components[$j]->long_name.'</b>';
                                        else
                                            echo "Try Again";
                                        
                                        if($j != 1)
                                        echo ", ";
                                    }
                                echo '</li>: ';
                            ?>
                        </ul>
                        <ul>
                            <li>Interest/s: </li>
                            <?php
                                foreach ($member->interests as $interest) { ?>
                                    <li><b><?php echo $interest->interest['interestName'] ?></b></li>
                            <?php 
                            }
                            ?>
                        </ul>
                        <br><br>
                @endforeach

                @if(Auth::user()->userType == 'facilitator')
                <center>
                    <form action="/selectActivities/{{ $dbgroup->groupID }}" method="get">
                        <button class="btn btn-primary" style="font-size: 30px;">
                            Get Activities!
                        </button>
                    </form>
                </center>
                @endif
                
                </ul>
            </div>
    </div>
 