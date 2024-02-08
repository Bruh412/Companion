@extends('layouts.admin')

@section('content')
     <h1>Categories</h1>

    <div class="card mb-3" style="background:rgba(255,255,255,0.2);">
        <div class="card-header" style="background:rgba(255,255,255,0.65);">
            <i class="fas fa-table"></i>
            List of Categories
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
            <th>Category Name</th>
            <th colspan="2">Options</th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td width="50%">{{ $row['categoryName'] }}</td>
                
                <td><a href="/viewCat/{{ $row['categoryID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">View Keywords</a></td>
                <td><a href="#" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;" data-toggle="modal" data-target="#deleteCat{{ $row['categoryID'] }}"><abbr title="Delete"><i class="fas fa-trash-alt"></i></abbr></a></td>
            </tr>
            <div class="modal fade" id="deleteCat{{ $row['categoryID'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You are about to delete a category!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "{{ $row['categoryName'] }}"? You cannot undo your action once it has been done.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/deleteCat/{{ $row['categoryID'] }}">Delete</a>
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
    <form action="/addCat" method="get">
        <button class="btn btn-primary">
            <i class="fas fa-plus-circle"></i>
            Add Category
        </button>
    </form>
    <br>
@endsection