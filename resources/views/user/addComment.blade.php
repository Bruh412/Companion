@extends('layouts.app1')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">{{ $post->user->first_name.' '.$post->user->last_name }}
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
                    </div>
                    <textarea rows="3" class="form-control" name="comment" id="comment" placeholder="Add Comment...">
                    </textarea>
                        <input type="hidden" value="{{ csrf_token() }}" id="token">
                        <input type="hidden" name="postid" value="{{ $post->post_id }}" id="postid">
                        <button class="btn btn-link" type="submit" name="submit" style="float: right" id="addComment">Comment</button>
                        
                    <div id="comments">
                    @foreach($comments as $com)
                    <div class="card">
                    <div class="card-body">
                        <h6 class="card-title" style="font-weight: bold">{{ $com->user->first_name.' '.$com->user->last_name }}</h6>
                        <p class="card-text">{{ $com->comment_content }}</p>
                    </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            <br>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // alert("huhu");
        $("#addComment").click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var postid = $("#postid").val();
            var comment = $("#comment").val();
            var token = $("#token").val();
            // console.log(comment);
            $.ajax({
                type: "post",
                data:  "comment=" + comment + "&postid=" + postid + "&token=" + token,
                url: "<?php echo url('/comment/save')?>",
                success: function(data){
                    $("#comment").val("");
                    $("#comments").load(location.href + ' #comments');
                }
            });
        });
    });
</script>
@endsection