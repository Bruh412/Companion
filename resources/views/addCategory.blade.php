@extends('layouts.app')

@section('content')
    @include('navbackCat') 
    <br>
    <br>
    <h1>Add new category</h1>
    <br>
    <form action="/addCat" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td colspan="2"><span>Category Name: </span></td>
                <td><input type="text" name="category"  class="form-control{{ $errors->has('category') ? ' is-invalid' : '' }}" value="{{ old('category') }}"></td>
                <td>
                @foreach($errors->get('category') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>

            <!-- <tr>    
                <td colspan="4"><span>Add at least three keywords: </span></td>
            </tr>

            <tr>
                <td colspan="2">Keyword 1:</td>
                <td><input type="text" name="keywordIni[]"  class="form-control{{ $errors->has('keywordIni[]') ? ' is-invalid' : '' }}" value="{{ old('keywordIni[]') }}"></td>
                <td>
                @foreach($errors->get('keywordIni[]') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="2">Keyword 2:</td>
                <td><input type="text" name="keywordIni[]"  class="form-control{{ $errors->has('keywordIni[]') ? ' is-invalid' : '' }}" value="{{ old('keywordIni[]') }}"></td>
            </tr>
            <tr>
                <td colspan="2">Keyword 3:</td>
                <td><input type="text" name="keywordIni[]"  class="form-control{{ $errors->has('keywordIni[]') ? ' is-invalid' : '' }}" value="{{ old('keywordIni[]') }}"></td>
            </tr> -->
        </table>
        <br>
        <button class="btn btn-primary" style="font-size: 22px;">Save Category</button>
    </form>
    <br>
@endsection