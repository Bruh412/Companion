@extends('layouts.admin')

@section('content')
<script>
    function checkImages(){
        if(document.getElementById("images").files.length == 0 )
            document.getElementById("imagesButton").disabled = true;
        else
            document.getElementById("imagesButton").disabled = false;
    }
</script>


    @include('admin.navbackCat')
     <h1>{{ $category['categoryName'] }} Keywords</h1>
    
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Add Images</button>&nbsp&nbsp&nbsp
    <a href="/viewCategoryImages/{{ $category['categoryID'] }}" style="color: #636b6f;padding: 0 10px;font-size: 13px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;">View Images</a><br><br>

    <div class="card mb-3" style="background:rgba(255,255,255,0.2);">
        <div class="card-header" style="background:rgba(255,255,255,0.65);">
            <i class="fas fa-table"></i>
            List of Keywords
        </div>
        <div class="card-body">
            <div class="table-responsive">
    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                
                <td width="5%"><a href="#" style="color: #636b6f;padding: 0 10px;font-size: 20px;font-weight: 600;letter-spacing: .1rem;text-decoration: none;text-transform: uppercase;" data-toggle="modal" data-target="#deleteKeyw{{ $row['keywordID'] }}"><i class="fas fa-trash-alt"></i></a></td>
            </tr>
            <div class="modal fade" id="deleteKeyw{{ $row['keywordID'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">You are about to delete a keyword from "{{ $category['categoryName'] }}"!</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "{{ $row['keywordName'] }}"? You cannot undo your action once it has been done.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" href="/deleteKeyword/{{ $category['categoryID'] }}/{{ $row['keywordID'] }}">Delete</a>
                </div>
                </div>
            </div>
            </div>
        @endforeach
    @endif
    </table>
    </div>
    </div>
    </div>
    @if(!$list->isEmpty())
    <div>
        {{ $list->links() }}
    </div>
    @endif
    <form action="/addKeyword/{{ $category['categoryID'] }}" method="get">
        <button class="btn btn-primary">Add Keyword</button>
    </form>
    <br>

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