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
            <th>Video Title</th>
            <th>Video Description</th>
            <th></th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['video_title'] }}</td>
                <td>{{ $row['video_desc'] }}</td>
                <td>
                     <a href="{{ url('/video/'.$row['videoID']. '/view') }}" class="btn btn-link text-muted">View</a>
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
        <a href="{{ url('/video') }}" class="btn btn-primary">Add Video From API</a>
    <br>
</div>
@endsection