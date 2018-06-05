@extends('layouts.app')

@section('content')

<div class="container">
    <a href="/home" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
     <h1>Companion Configuration</h1>

    <table class="table table-striped">
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
                    <td><a href="/editConfig/{{ $field }}" class="btn btn-info">Edit Config</a></td>
                </tr>   
            @endif
        @endforeach

    </table>
</div>

@endsection