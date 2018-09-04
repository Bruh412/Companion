@extends('layouts.admin')

@section('content')

    <h1>Quotes</h1>

     <!-- <div class="form-group">
        <p>Choose category:</p>
        <select class="form-control input-sm" name="category" id="category">
            <option value="all">All</option>
            @foreach($categories as $category)
                <option value="{{ $category->categoryName }}">{{ $category->categoryName }}</option>
            @endforeach
            <option value="none">None</option>
        </select>
     </div> -->

    <div id="category-view">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            List of Quotes
        </div>
        <div class="card-body">
            <div class="table-responsive">
    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        @if($list->isEmpty())
            <tr>
                <td colspan="3"><h5>Nothing to output...</h5><td>
            </tr>
        @else
            <tr>
                <th>Quote</th>
                <th>Author</th>
                <th>Category</th>
                <th colspan="2" width="10%">Options</th>
            </tr>
            @foreach($list as $row)
                <tr>
                    <td>{{ $row['quoteText'] }}</td>
                    <td>{{ $row['quoteAuthor'] }}</td>
                    <td>
                        <ul type="none">
                    @foreach($row->quoteCategory as $category)
                        <li>{{ $category->categories->categoryName }}</li>
                    @endforeach
                        </ul>
                    </td>

                    <td>
                        <a href="{{ url('/quote/'.$row['quoteID']. '/edit') }}" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;"><abbr title="Edit"><i class="fas fa-pen-fancy"></i></abbr></a>
                    </td>
                    <td>
                        <a href="#" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;" data-toggle="modal" data-target="#deleteQuote{{ $row['quoteID'] }}"><abbr title="Delete"><i class="fas fa-trash-alt"></i></abbr></a>
                    </td>
                </tr>
                <div class="modal fade" id="deleteQuote{{ $row['quoteID'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You are about to delete a quote!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this quote? You cannot undo your action once it has been done.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="{{ url('/quote/'.$row['quoteID']. '/delete') }}">Delete</a>
                </div>
                </div>
            </div>
            </div>
            @endforeach
        @endif
        </table>
        </div>
        </div>
        </div>
        @if(!$list->isEmpty())
        <div>
            {{ $list->links() }}
        </div>
        @endif
            <a href="{{ url('/addQuote') }}" class="btn btn-primary"> <i class="fas fa-plus-circle"></i> Add Quote</a>
            <a href="{{ url('/api/addquote') }}" class="btn btn-primary"> <i class="fas fa-plus-circle"></i> Add Quote From API</a>
        <br>
    </div>


<script>
$(document).ready(function() {
    $('#category').on('change',function(){
        var cat = $('#category option:selected').val();
        console.log(cat);
        $.ajax({
            type: "get",
            data:  "cat_name=" + cat,
            url: "<?php echo url('/category-view')?>",
            success: function(data){
                console.log(data);
                // $("#post").val("");
                $('#category-view').empty().html(data);
            }
        });
                
    });
});
</script>
@endsection