@extends('layouts.app')

@section('content')

<div class="container">

<a href="/viewCat/{{ $category['categoryID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">{{ "< Back" }}</a>
    <h1>{{ $category['categoryName'] }} Related Images</h1>

    @if($category->images != [])
    <table>
        @foreach($category->images as $image)
            <tr>
                <td><img src="{{ $image['imageContent'] }}" width="320px" height="320px"></td>
                    
                <td>
                    <form action="/deleteImg/{{ $image['catImageID'] }}" method="get">
                        {{ csrf_field() }}
                        <button class="btn btn-danger" type="submit">X</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    @endif


</div>

@endsection