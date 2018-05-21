@extends('layouts.app')

@section('content')
<div class="container">
<a href="/quotes" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <br>
    <br>
    <h1>Add new quote</h1>
    <br>
    <form action="/addQuote" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td colspan="2"><span>Quote Text</span></td>
                <td><textarea name="text" cols="30" rows="10" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">{{ old('keyword') }}</textarea></td>
                <td>
                @foreach($errors->get('text') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="2"><span>Quote Author</span></td>
                <td><input type="text" name="author"  class="form-control{{ $errors->has('author') ? ' is-invalid' : '' }}" value="{{ old('author') }}"></td>
                <td>
                @foreach($errors->get('author') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
        </table>
        <br>
        <button class="btn btn-primary" style="font-size: 22px;">Save Quote</button>
    </form>
    <br>
    </div>
@endsection