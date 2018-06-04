@extends('layouts.app1')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($seekersPost->isEmpty())
                <div class="card">
                    <div class="card-header">
                        <strong>No posts available</strong>
                    </div>
                </div>
            @else
            @foreach($seekersPost as $post)
                <div class="card">
                    <div class="card-header">
                        <strong>{{ $post->user->first_name.' '.$post->user->last_name }}</strong>
                            <a style="float: right;" href="{{ url('comment/'.$post['post_id'].'/add') }}">Comments</a>
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
                            <span style="float: right; color: graxy;">{{ $var }} comments</span>
                        @endif
                    </div>
                </div>
                <br>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection