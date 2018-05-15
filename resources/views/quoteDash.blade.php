@extends('layouts.app')

@section('content')
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
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['quoteText'] }}</td>
                <td>{{ $row['quoteAuthor'] }}</td>
                <!-- <td><a href="#" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Edit</a></td> -->
                <!-- <td><a href="/deleteInt/{{ $row['interestID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Delete</a></td> -->
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <form action="/addQuote" method="get">
        <button class="btn btn-primary" style="font-size: 22px;">Add Quote</button>
    </form>
    <br>
@endsection