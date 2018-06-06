
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
            <a class="nav-link" href="#">Journal</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModalCenter" onClick="getLocation()">Join TalkCircle</a>
                <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter" onClick="getLocation()">Join TalkCircle</button> -->
                <!-- <button type="submit">Join TalkCircle</button> -->
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
                                                    <input type="hidden" name="lat" id="lat">
                                                    
                                                    @foreach($problems as $prob)
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
            <a class="nav-link" href="checkQueue/{{ Auth::user()->user_id }}">Check Group</a>
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
    
    <div class="container" style="padding-top: 2rem;">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <input type="hidden" value="{{ csrf_token() }}" id="token">
                <div class="form-group">
                    <label for="exampleInputEmail1">Add Post</label>
                    <textarea rows="5" class="form-control" id="post" name="post"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-11">
                        <select name="feeling" class="form-control" id="feeling">
                            <option value="null">....</option>
                            @foreach($feelings as $feeling)
                                <option value="{{ $feeling->post_feeling_name }}">{{ $feeling->post_feeling_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="submit" class="btn btn-info" name="submit" id="postBtn">Post</button>
                    </div>
                </div>

            <div id="posts">
            <?php $acc = -1 ?>
            @foreach($usersPost as $post)
            <?php $acc++ ?>
            <div id="accordion">
                <div class="card">
                    <div class="card-header">
                            {{ $post->user->first_name.' '.$post->user->last_name }}
                            <a style="float: right;" href="{{ url('post/'.$post['post_id'].'/edit') }}"> Edit</a>
                            <a style="float: right;" href="{{ url('post/'.$post['post_id'].'/delete') }}">Delete</a>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ $post->post_content }}
                        </p>
                        @if(is_null($post->usersPostFeeling))
                            <span></span>
                        @else
                        Feeling <span style="font-weight: bold; color: red;">{{ $post->usersPostFeeling->postFeeling->post_feeling_name }}</span>
                        @endif
                        <?php $var = 0 ?>
                        @foreach($post->comments as $check)
                            @if(!empty($check->comment_content))
                                <?php $var++ ?>
                            @endif
                        @endforeach
                        @if($var !=  0)
                            <a style="float: right" href="{{ url('post/'. $post->post_id .'/view') }}">View Comments</a>
                        @endif
                    </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="heading{{ $acc }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $acc }}" aria-expanded="true" aria-controls="collapse{{ $acc }}">
                            Media Wall
                            </button>
                        </h5>
                        </div>

                        <div id="collapse{{ $acc }}" class="collapse" aria-labelledby="heading{{ $acc }}" data-parent="#accordion">
                        @foreach($quotes as $row)
                            @foreach($row as $details => $value)
                            @if($post->post_id == $value->post_id)
                                <div class="card-body">
                                    <h5 class="card-title">{{ $value->quote->quoteText }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $value->quote->quoteAuthor }}</h6>
                                </div>
                            @endif
                            @endforeach
                        @endforeach
                        
                        @foreach($comp as $row)
                            @if($post->post_id == $row['post_id'])
                            @foreach($videos as $row1)
                                @foreach($row1 as $value)
                                @if($row['videoID'] == $value['videoID'])
                                <div class="card-body">
                                    <iframe width="700" height="315" src="https://www.youtube.com/embed/{{ $value->videos->videoApi_id }}"></iframe>
                                </div>
                                @endif
                                @endforeach
                            @endforeach
                            @endif
                        @endforeach
                        </div>
                    </div>
                    <?php $var = 0 ?>
                    @foreach($post->comments as $check)
                        @if(!empty($check->comment_content))
                            <?php $var++ ?>
                        @endif
                    @endforeach
                    @if($var !=  0)
                    <?php $acc++ ?>
                    <div class="card">
                        <div class="card-header" id="heading{{ $acc }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $acc }}" aria-expanded="false" aria-controls="collapse{{ $acc }}">
                            Comments
                            </button>
                        </h5>
                        </div>
                        <div id="collapse{{ $acc }}" class="collapse" aria-labelledby="heading{{ $acc }}" data-parent="#accordion">
                            @foreach($post->comments as $com)
                                <div class="card-body">
                                    <h6 class="card-title" style="font-weight: bold">{{ $com->user->first_name.' '.$com->user->last_name }}</h6>
                                    <p class="card-text">{{ $com->comment_content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
            </div>
            <br>
            @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // alert("huhu");
        $("#postBtn").click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var post = $("#post").val();
            var feeling = $("#feeling").val();
            var token = $("#token").val();
            // console.log(token);
            $.ajax({
                type: "post",
                data:  "post=" + post + "&feeling=" + feeling + "&token=" + token,
                url: "<?php echo url('/posts/save')?>",
                success: function(data){
                    // console.log(data);
                    $("#post").val("");
                    $('#posts').empty().html(data);
                }
            });
        });
    });
</script>
</body>