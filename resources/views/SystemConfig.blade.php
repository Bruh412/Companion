@extends('layouts.admin')

@section('content')

    <a href="/home" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
     <h1>System Configuration</h1>

    <div class="card mb-3" style="background:rgba(255,255,255,0.2);">
        <div class="card-header" style="background:rgba(255,255,255,0.65);">
            <i class="fas fa-table"></i>
            List of Configurations
        </div>
        <div class="card-body">
            <div class="table-responsive">
    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <tr>
            <th>Configurations</th>
            <th>Value</th>
            <th colspan="2">Options</th>
        </tr>
        @foreach($config as $field => $value)
            @if($field != 'id')

                <tr>
                    <td>{{ $field }}</td>
                    <td>{{ $value }}</td>
                    <td><a href="/editConfig/{{ $field }}" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;"><abbr title="Edit"><i class="fas fa-pen-fancy"></i></abbr></a></td>
                    
                </tr>   
            @endif
        @endforeach

    </table>
    </div>
    </div>
    </div>


@endsection