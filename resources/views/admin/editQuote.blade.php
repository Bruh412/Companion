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
             <textarea rows="5" class="form-control" id="exampleInputEmail1" name="text">{{ $text }}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Quote Author</label>
            <input type="text" class="form-control" id="exampleInputPassword1" value="{{ $author }}" name="author">
        </div>
        @if($mode == 'add')
            <div class="form-group">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">Add Category</button> 
            </div>
        @else
            <div class="form-group">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter1">Edit Category</button> 
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class="btn btn-danger" href="{{ url('/quotes') }}">Cancel</a>

@if($mode == 'add')
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
@else
<!-- POPUP AREA -->
    <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">
                        @foreach($categories as $category)
                            <tr>
                                <?php $c = 0; ?>
                                @foreach($matchQuotes as $row)
                                    @if($row->categoryID == $category->categoryID)
                                        <?php $c++ ?>
                                    @endif
                                @endforeach
                                @if($c!=0)
                                    <td><input type="checkbox" name="categories[]" value="{{ $category['categoryName'] }}" checked></td>
                                    <td>{{ $category['categoryName'] }}</td>
                                @else
                                    <td><input type="checkbox" name="categories[]" value="{{ $category['categoryName'] }}"></td>
                                    <td>{{ $category['categoryName'] }}</td>
                                @endif
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
@endif
@endsection