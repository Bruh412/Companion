@extends('layouts.app')

@section('content')
<a href="/viewCat/{{ $category['categoryID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <br>
    <br>
    <h1>Add new keyword to {{ $category['categoryName'] }}</h1>
    <br>
    <form action="/addKeyword/{{ $category['categoryID'] }}" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td colspan="2"><span>Keyword Name: </span></td>
                <td><input type="text" name="keyword"  class="form-control{{ $errors->has('keyword') ? ' is-invalid' : '' }}" value="{{ old('keyword') }}"></td>
                <td>
                @foreach($errors->get('keyword') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
        </table>
        <br>
        <button class="btn btn-primary" style="font-size: 22px;">Save Keyword</button>
    </form>
    <br>
@endsection