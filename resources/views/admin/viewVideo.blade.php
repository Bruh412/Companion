@extends('layouts.admin')

@section('content')

    <a href="{{ url('/videos') }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>

    <iframe class="w-100" height="700" src="https://www.youtube.com/embed/{{ $video->videoApi_id }}" allowfullscreen align="middel"></iframe> 
    <div class="row">
        <h5>{{ $video->video_title }}</h5>
    </div>
</div>
@endsection