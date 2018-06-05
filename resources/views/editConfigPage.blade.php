@extends('layouts.app')

@section('content')
<div class="container">
<a href="/systemConfig" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <br>
    <br>
    <h1>Edit Config '{{ $field }}'</h1>
    <br>
    <form action="/editConfig/{{$field}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="exampleInputPassword1">New Value for {{ $field }}</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="newValue">
        </div>
        <button class="btn btn-primary">Save Changes</button>
    </form>
    <br>
</div>
@endsection