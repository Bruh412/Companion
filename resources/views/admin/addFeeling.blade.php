@extends('layouts.admin')

@section('content')
<a href="/feelings" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <br>
    <br>
    <h1>Add New Feeling</h1>
    <br>
    <form action="/addFeeling" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputPassword1">Add Feeling</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="name">
        </div>
        <button class="btn btn-primary">Save Feeling</button>
    </form>
    <br>
</div>
@endsection