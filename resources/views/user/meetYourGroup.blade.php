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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDpz7JmYU3-2CsRVbv3JHKzP-vdzkhgCrY&amp;sensor=false&amp;libraries=places"></script>            
        <script type="text/javascript">
             var getLocationName = function(lat,long,container) {
                var cLocationName = "";
                var latlng = new google.maps.LatLng(lat, long);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latlng}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results[1]) {
                        cLocationName = results[1].formatted_address;
                        if(container!=null){
                            $(container).html(cLocationName);
                        }
                    } else {
                        setTimeout(function(){
                            getLocationName(lat,long,container);
                        },1000);
                    }
                });
                return cLocationName;s
            };
        </script>
            <br>
            <center>
                <h1>Meet your groupmates!</h1>
            </center>

            <div>
                <ul>
                @foreach($group as $member)
                    @if($member['user']['userType'] == 'facilitator')
                        <li><h3><b>{{ $member['user']['first_name'] }} {{ $member['user']['last_name'] }} - Host</b></h3></li>
                        <ul>
                            <li>Specialization/s: </li>
                            <?php
                                foreach (FacilitatorSpec::where('user_id', $member['user']['user_id'])->get() as $spec) { ?>
                                    <li><b><?php echo $spec->spec['spec_name'] ?></b></li>
                            <?php 
                            }
                            ?>
                        </ul>
                    @else
                        <li>
                            <h3>{{ $member['user']['first_name'] }} {{ $member['user']['last_name'] }}
                            @if($member['user']['user_id'] == Auth::user()->user_id)
                                --- You!
                            @endif
                            </h3>
                        </li>
                        @if(Auth::user()->userType == 'facilitator')
                            <ul>
                                <li>Problem/s: </li>
                                <?php
                                    foreach (QueueTalkCircle::where('user_id', $member['user']['user_id'])->get()[0]->problems as $prob) { ?>
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
                                $queued = QueueTalkCircle::where('user_id', $member['user']['user_id'])->get()[0];

                                $lat = $queued['latitude'];
                                $long = $queued['longitude'];                            

                                // $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&sensor=false'); 
                                
                                // $output= json_decode($geocode);
                                
                                echo '<li>Location: ';
                                    for($j=0;$j<2;$j++){
                                        // if($output->results != [])
                                        //     echo '<b>'.$output->results[0]->address_components[$j]->long_name.'</b>';
                                        // else
                                        //     echo "Try Again";
                                        
                                        if($j != 1)
                                        echo ", ";
                                    }
                                    ?> 
                                        <span class="location_name_text" data-long="{{ $queued['longitude'] }}" data-lat="{{ $queued['latitude'] }}"></span>
                                        
                                    <?php
                                echo '</li>: ';
                            ?>
                        </ul>
                        <ul>
                            <li>Interest/s: </li>
                            <?php
                                foreach ($member['user']->interests as $interest) { ?>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $(".location_name_text").each(function(e){
                var long = $(this).attr("data-long");
                var lat = $(this).attr("data-lat");
                var location_name = getLocationName(lat,long,$(this));
            });
        });
    </script>