@extends('layouts.admin')

@section('content')
<a href="/viewCat/{{ $category['categoryID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <br>
    <br>
    <h1>Add New Keyword To {{ $category['categoryName'] }}</h1>
    <br>
    <form action="/addKeyword/{{ $category['categoryID'] }}" method="post" enctype="multipart/form-data">
        @csrf
       <div class="form-group">
            <label for="exampleInputPassword1">Add Keyword</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="keyword">
        </div>
        <button class="btn btn-primary">Save Keyword</button>
    </form> 
    <br>
@endsection