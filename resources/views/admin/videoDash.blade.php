@extends('layouts.admin')

@section('content')
     <h1>Videos</h1>

    <div class="card mb-3" style="background:rgba(255,255,255,0.2);">
        <div class="card-header" style="background:rgba(255,255,255,0.65);">
            <i class="fas fa-table"></i>
            List of Videos
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
    </div>
    </div>
    </div>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
        <a href="{{ url('/video') }}" class="btn btn-primary">Add Video From API</a>
    <br>
@endsection