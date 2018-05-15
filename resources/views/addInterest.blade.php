@extends('layouts.app')

@section('content')
    @include('navbackInt') 
    <br>
    <br>
    <h1>Add new interest</h1>
    <br>
    <form action="/addInt" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td colspan="2"><span>Interest Name: </span></td>
                <td><input type="text" name="name"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"></td>
                <td>
                @foreach($errors->get('name') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
        </table>
        <br>
        <button class="btn btn-primary" style="font-size: 22px;">Save Interest</button>
    </form>
    <br>
@endsection