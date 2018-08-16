@extends('layouts.app')

@section('content')
<div class="container" >
        <form method="post" action="{{ url('/addQuote') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="exampleInputEmail1">Quote Text</label>
             <textarea rows="5" class="form-control" id="exampleInputEmail1" name="text">{{$newData['quoteText']}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Quote Author</label>
            <input type="text" class="form-control" id="exampleInputPassword1" value="{{$newData['quoteAuthor']}}" name="author">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">Add Category</button> 
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class="btn btn-danger" href="{{ url('/quotes') }}">Cancel</a>

<!-- POPUP AREA -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        @foreach($categories as $category)
                            <tr>
                                <td><input type="checkbox" name="categories[]" value="{{ $category['categoryName'] }}"></td>
                                <td>{{ $category['categoryName'] }}</td>
                            </tr>   
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    
    </form>
    </div>
<!-- END OF POPUP AREA        -->
@endsection