@extends('layouts.admin')

@section('content')
    @include('admin.navbackInt') 
    <br>
    <br>
    <h1>Add New Interest</h1>
    <br>
    <form action="/addInt" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputPassword1">Add Interest</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="name">
        </div>
        <button class="btn btn-primary">Save Interest</button>
    </form>
    <br>
@endsection