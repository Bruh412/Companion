@extends('layouts.app')

@section('content')
<a href="/feelings" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <br>
    <br>
    <h1>Add new feeling</h1>
    <br>
    <form action="/addFeeling" method="post" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <td colspan="2"><span>Feeling Name: </span></td>
                <td><input type="text" name="name"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}"></td>
                <td>
                @foreach($errors->get('name') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
        </table>
        <br>
        <button class="btn btn-primary" style="font-size: 22px;">Save Feeling</button>
    </form>
    <br>
@endsection