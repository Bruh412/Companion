@extends('layouts.app')

@section('content')
<script>
    function checkImages(){
        if(document.getElementById("images").files.length == 0 )
            document.getElementById("imagesButton").disabled = true;
        else
            document.getElementById("imagesButton").disabled = false;
    }
</script>

<div class="container">

    @include('admin.navbackCat')
     <h1>{{ $category['categoryName'] }} Keywords</h1>
    
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">Add Images</button>&nbsp&nbsp&nbsp
    <a href="/viewCategoryImages/{{ $category['categoryID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">View Images</a><br><br>

    <table class="table table-striped">
    @if($list->isEmpty())
        <tr>
            <td colspan="3"><h5>Nothing to output...</h5><td>
        </tr>
    @else
        <tr>
            <th>Keywords</th>
            <th colspan="2">Options</th>
        </tr>
        @foreach($list as $row)
            <tr>
                <td>{{ $row['keywordName'] }}</td>
                
                <td><a href="/deleteKeyword/{{ $category['categoryID'] }}/{{ $row['keywordID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">Delete</a></td>
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <form action="/addKeyword/{{ $category['categoryID'] }}" method="get">
        <button class="btn btn-primary">Add Keyword</button>
    </form>
    <br>
</div>

<!-- POPUP AREA -->
<form action="{{ url('/addImage/').'/'.$category['categoryID'] }}" enctype="multipart/form-data" method="post">
{{ csrf_field() }}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="btn btn-danger">&times;</span>
                        </button>
                    </div>
                            
                            <div class="modal-body">
                                <p>* Add images that relate to the category. These images will be used for quote backgrounds.</p>
                                <p>* Darker images are more preferable.</p>
                                <p>* Images must be less than 20mb.</p>
                                <input type="file" name="media[]" accept="image/*" multiple id="images" onChange="checkImages()">
                            </div>
                            <div class="modal-footer">
                                    <button type="submit" class="btn btn-info" id="imagesButton" disabled>Submit</button>
                                    <button type="button" class="btn" data-dismiss="modal">Cancel</button>
                            </div>
                        
                    </div>
                </div>
    </div>
</form>
        <!-- END OF POPUP AREA        -->

@endsection