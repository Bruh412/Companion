<?php
// dd($list->isEmpty());
?>

@extends('layouts.app')

@section('content')
<div class="container">
     <h1>List of Activities</h1>

    <table class="table table-striped">
    @if($list->isEmpty())
        <tr>
            <td colspan="3"><h5>Nothing to output...</h5><td>
        </tr>
    @else
        <tr>
            <th>Activity Title</th>
            <th>Activity Details</th>
            <th>Participants Needed</th>
            <th colspan="3">Options</th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['title'] }}</td>
                <td>{{ $row['details'] }}</td>
                <td>{{ $row['participants'] }}</td>
                
                <td><a href="/viewAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">View</a></td>
                <td><a href="/editAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Edit</a></td>
                <td><a href="/deleteAct/{{ $row['actID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Delete</a></td>
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <form action="/addAct" method="get">
        <button class="btn btn-primary" >Add Activity</button>
    </form>
    <br>
</div>
    <!-- <form action="/indiActs" method="get">
        <button class="btn btn-info" >Get individual acts</button>
    </form>
    <form action="/pairActs" method="get">
        <button class="btn btn-info" >Get pair acts</button>
    </form>
    <form action="/groupActs" method="get">
        <button class="btn btn-info" >Get group acts</button>
    </form> -->
    <!-- <embed src="https://www.silvergames.com/en/give-up-2/iframe"></embed> -->

@endsection