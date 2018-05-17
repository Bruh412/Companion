@extends('layouts.app')

@section('content')
     <h1>List of Feelings</h1>

    <table class="table table-striped">
    @if($list->isEmpty())
        <tr>
            <td colspan="3"><h5>Nothing to output...</h5><td>
        </tr>
    @else
        <tr>
            <th>Feeling Name</th>
            <th colspan="2">Options</th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['post_feeling_name'] }}</td>
                
                <!-- <td><a href="/viewAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">View</a></td> -->
                <!-- <td><a href="/editAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Edit</a></td> -->
                <td><a href="/deleteFeeling/{{ $row['post_feeling_id'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Delete</a></td>
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <form action="/addFeeling" method="get">
        <button class="btn btn-primary" style="font-size: 22px;">Add Feeling</button>
    </form>
    <br>

@endsection