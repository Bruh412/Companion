@extends('layouts.app')

@section('content')
<div class="container" >
    @if($mode == 'add')
        <form method="post" action="{{ url('/addQuote') }}">
        {!!
            $text = '';
            $author = '';
        !!}
    @elseif($mode == 'edit')
        <form method="post" action="{{ url('/quote/edit') }}"> 
        <!-- {!!
            $text = $quote['quoteText'];
            $author = $quote['quoteAuthor'];
        !!} -->
        <input type="hidden" value="{{ $quote['quoteID'] }}" name="quoteid">
    @endif


    <!-- <form method="post" action="{{ url('quote/edit') }}"> -->
        {{ csrf_field() }}
        <div class="form-group">
            <label for="exampleInputEmail1">Quote Text</label>
             <textarea rows="5" class="form-control" id="exampleInputEmail1" name="text">
                {{ $text }}
            </textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Quote Author</label>
            <input type="text" class="form-control" id="exampleInputPassword1" value="{{ $author }}" name="author">
        </div>
        <div class="form-group">
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">Add Category</button> 
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" name="clear" class="btn btn-danger">Clear</button>

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