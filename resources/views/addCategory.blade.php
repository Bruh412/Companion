@extends('layouts.app')

@section('content')
<div class="container">
    @include('navbackCat') 
    <br>
    <br>
    <h1>Add new category</h1>
    <br>
    <form action="/addCat" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputPassword1">Add Category</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="category">
        </div>
        <button class="btn btn-primary">Save Category</button>
    </form>
    <br>
</div>
@endsection