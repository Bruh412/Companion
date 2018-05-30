@extends('layouts.app')

@section('content')

<div class="container">

    @include('navbackCat')
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