@extends('layouts.admin')

@section('content')
     <h1>Activities</h1>
     
     <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-table"></i>
            List of Activities
        </div>
        <div class="card-body">
            <div class="table-responsive">
    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    @if($list->isEmpty())
        <thead>
            <tr>
                <td colspan="3"><h5>Nothing to output...</h5><td>
            </tr>
        </thead>
    @else
        <thead>
            <tr>
                <th width="10%">Activity Title</th>
                <th>Activity Details</th>
                <th width="13%">Participants Needed</th>
                <th colspan="3">Options</th>
            </tr>
        </thead>
        @foreach($list as $row)
            <tbody>
                <tr>
                    <td>{{ $row['title'] }}</td>
                    <td>{{ $row['details'] }}</td>
                    <td>{{ $row['participants'] }}</td>
                    
                    <td><a href="/viewAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;"><abbr title="View Activity"><i class="fas fa-eye"></i></abbr></a></td>
                    <td><a href="/editAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;"><abbr title="Edit"><i class="fas fa-pen-fancy"></i></abbr></a></td>
                    <td><a href="#" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;" data-toggle="modal" data-target="#deleteAct{{ $row['actID'] }}"><abbr title="Delete"><i class="fas fa-trash-alt"></i></abbr></a></td>
                </tr>
            </tbody>
            <div class="modal fade" id="deleteAct{{ $row['actID'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You are about to delete an activity!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "{{ $row['title'] }}"? You cannot undo your action once it has been done.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/deleteAct/{{ $row['actID'] }}">Delete</a>
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
    <form action="/addAct" method="get">
        <button class="btn btn-primary" >
            <i class="fas fa-plus-circle"></i>
            Add Activity
        </button>
    </form>
@endsection