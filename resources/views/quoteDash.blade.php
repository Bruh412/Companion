@extends('layouts.app')

@section('content')
<div class="container">
     <h1>List of Quotes</h1>

    <table class="table table-striped">
    @if($list->isEmpty())
        <tr>
            <td colspan="3"><h5>Nothing to output...</h5><td>
        </tr>
    @else
        <tr>
            <th>Quote</th>
            <th>Author</th>
            <th>Category</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['quoteText'] }}</td>
                <td>{{ $row['quoteAuthor'] }}</td>
                <td>
                    <ul>
                @foreach($row->quoteCategory as $category)
                    <li>{{ $category->categories->categoryName }}</li>
                @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ url('/quote/'.$row['quoteID']. '/edit') }}" class="btn btn-info">Edit</a>
                </td>
                <td>
                    <form>
                    <a href="{{ url('/quote/'.$row['quoteID']. '/delete') }}" class="btn btn-danger">Delete</a>
                    <form>
                </td>
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <!-- <form action="/addQuote" method="get"> -->
        <!-- <button class="btn btn-primary" style="font-size: 22px;">Add Quote</button> -->
        <a href="{{ url('/addQuote') }}" class="btn btn-primary">Add Quote</a>
    <!-- </form> -->
    <br>

</div>
@endsection