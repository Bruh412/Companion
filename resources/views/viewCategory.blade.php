@extends('layouts.app')

@section('content')
<div class="container">

    @include('navbackCat')
     <h1>{{ $category['categoryName'] }} Keywords</h1>

    <table class="table table-striped">
    @if($list->isEmpty())
        <tr>
            <td colspan="3"><h5>Nothing to output...</h5><td>
        </tr>
    @else
        <tr>
            <th>Keywords</th>
            <th colspan="2">Options</th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['keywordName'] }}</td>
                
                <td><a href="/deleteKeyword/{{ $category['categoryID'] }}/{{ $row['keywordID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Delete</a></td>
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <form action="/addKeyword/{{ $category['categoryID'] }}" method="get">
        <button class="btn btn-primary">Add Keyword</button>
    </form>
    <br>
</div>
@endsection