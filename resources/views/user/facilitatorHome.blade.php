@extends('layouts.app1')

@section('content')
<div class="container">
    <div class="w-100 h-100">
        <div class="row m-0">
            <div class="col-1"></div>
            <div class="col-3">
                <div class="card" style="width: 16rem;">
                <img class="card-img-top" src="{{ asset('/image/cover.jpg')}}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title mb-1 text-center" style="font-weight: bold;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}&nbsp;<i class="fas fa-check-circle" style="color:#FFB75E"></i></h5>
                    <h6 class="card-subtitle mb-2 text-muted text-center"><?php echo '@'.Auth::user()->username ?></h6>
                    <ul class="list-group list-group-flush text-center">
                        <li class="list-group-item p-0"><i class="fas fa-sticky-note"></i>&nbsp;My Plans</li>
                        <li class="list-group-item p-0"><i class="fas fa-users"></i>&nbsp;TalkCircle</li>
                        <li class="list-group-item p-0"><i class="fas fa-user"></i>&nbsp;People</li>
                    </ul>
                </div>
                </div>
                <br>    
                <button class="btn btn-primary" style="background-color: #FFB75E; border: none; width: 100%;">Create TalkCircle</button>
            </div>
            <div class="col-7">
                @if($seekersPost->isEmpty())
                <div class="card">
                    <div class="card-header">
                        <strong>No posts available</strong>
                    </div>
                </div>
            @else
            @foreach($seekersPost as $post)
            <div class="card" style="border-color: #FFB75E;">
                    <div class="card-header text-white" style="background-color: #FFB75E; font-weight: bold">
                        <strong>{{ $post->user->first_name.' '.$post->user->last_name }}</strong>
                            <!-- <a style="float: right;" href="{{ url('comment/'.$post['post_id'].'/add') }}">Comments</a> -->
                            
                            <a style="float: right" href="{{ url('/comment/'. $post->post_id .'/add') }}"><i class="fas fa-comments" style="color: white;"></i></a>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ $post->post_content }}
                        </p>
                        @if(empty($post->usersPostFeeling->postFeeling->post_feeling_name))
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
                            @if($var == 1)
                                <a style="float: right; color: #FFB75E;" href="{{ url('comment/'.$post['post_id'].'/add') }}">{{ $var }} comment</a> 
                            @else
                                <a style="float: right; color: #FFB75E;" href="{{ url('comment/'.$post['post_id'].'/add') }}">{{ $var }} comments</a> 
                            @endif
                        @endif
                    </div>
                </div>
                <br>
            @endforeach
            @endif
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</div>
@endsection