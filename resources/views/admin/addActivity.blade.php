<?php
// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

// dd(Uuid::uuid1()->toString());
?>

@extends('layouts.app')

@section('content')
<div class="container">
    @include('admin.navbackAct') 
    <br>
    <br>
    @if($mode == 'edit')
        <h3 style="text-align: center;">Edit activity</h3>
        <br>
        <form action="/saveAct/edit" method="post" enctype="multipart/form-data">
        <input type="hidden" value="{{ $act['actID'] }}" name="secretID" >
    @else
        <h3 style="text-align: center;">Add new activity</h3>
        <br>
        <form action="/saveAct" method="post" enctype="multipart/form-data">
    @endif
        {{ csrf_field() }}
        <div class="form-group">
            <label for="exampleInputPassword1">Activity Title</label>
			@if($mode == 'edit')
				<input type="text" name="title"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $act['title'] }}">
			@else
				<input type="text" name="title"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}">
            @endif
            @foreach($errors->get('title') as $errorMsg)
                    <h6 style="color:red; font-weight: bold"> {{ $errorMsg }} </h6>
            @endforeach
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Activity Details</label>
            @if($mode == 'edit')
                <textarea rows="5" class="form-control" id="exampleInputEmail1" name="details" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
                   {{ $act['details'] }}
                </textarea>
            @else
                <textarea rows="5" class="form-control" id="exampleInputEmail1" name="details" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
                    {{ old('details') }}
                </textarea>
            @endif
            @foreach($errors->get('details') as $errorMsg)
                    <h6 style="color:red; font-weight: bold"> {{ $errorMsg }} </h6>
            @endforeach
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Add Steps</label>
            <button type="button" onclick="addSteps()" class="btn btn-info" style="font-size: 10px;">Add</button>
            <!-- <td> -->
            <table>
                <ol id="stepSpace">
                    
                </ol>
            </table>
            
            <!-- </td> -->
            @foreach($errors->get('step') as $errorMsg)
                    <h6 style="color:red; font-weight: bold"> {{ $errorMsg }} </h6>
            @endforeach
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Required Participants</label>
            <select class="form-control" id="sel1" name="participants">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Equipment Needed</label>
            <button type="button" onclick="addEquip()" class="btn btn-info">Add</button>
            <table id="equipmentSpace">
                    
            </table>
            @foreach($errors->get('equipment') as $errorMsg)
                <h6 style="color:red; font-weight: bold"> {{ $errorMsg }} </h6>
            @endforeach
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Time Needed</label>
            <select name="time" id="time" onchange="showOrHideTime(this)" class="form-control">
                <option value="none">---</option>
                @for ($i = 1; $i <= 60; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
            <select name="timeDeno" id="timeDeno"  class="form-control">
                <option value="sec">Seconds</option>
                <option value="min">Minutes</option>
                <option value="hour">Hours</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Gender Compatibility</label>
            <select name="gender" id="gender"  class="form-control">
                <option value="Both">Both</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Add Media</label>
            <input type="file" name="media[]" accept="audio/*,video/*,image/*" multiple class="form-control"> 
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Add Interests</label>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">
                Add Tags
            </button>
            @foreach($errors->get('tags') as $errorMsg)
                <h6 style="color:red; font-weight: bold"> {{ $errorMsg }} </h6>
            @endforeach  
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Activity Problem</label>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter1">
                    Add Problem
            </button>
            <!-- @foreach($errors->get('tags') as $errorMsg)
                {{ $errorMsg }}
            @endforeach   -->
        </div>

        @if($mode == 'edit')
            <button class="btn btn-primary">Save Changes</button>
        @else
            <button class="btn btn-primary">Save Activity</button>
        @endif

        <!-- POPUP AREA -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Interests</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            @foreach($tags as $row)
                                <tr>
                                    <td><input type="checkbox" name="tags[]" value="{{ $row['interestName'] }}"></td>
                                    <td>{{ $row['interestName'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF POPUP AREA        -->
        <!-- POPUP AREA -->
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Interests</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            @foreach($problems as $row)
                                <tr>
                                    <td><input type="checkbox" name="problems[]" value="{{ $row['problem_name'] }}"></td>
                                    <td>{{ $row['problem_name'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF POPUP AREA        -->
    </form>
    <br>
</div>

    <script>
        var timeDeno = document.getElementById('timeDeno');
            timeDeno.style.visibility = 'hidden';

        function hide(){
            var timeDeno = document.getElementById('timeDeno');
            timeDeno.style.visibility = 'hidden';
        }

        function show(){
            var timeDeno = document.getElementById('timeDeno');
            timeDeno.style.visibility = 'visible';
        }

        function showOrHideTime(select){
            if(select.value != "none"){
            show();
            }else{
            hide();
        }}

        function addEquip() {
            var table = document.getElementById("equipmentSpace");
            var tr = document.createElement("TR");
            var td1 = document.createElement("TD");
            var td2 = document.createElement("TD");
            var item = document.createElement("INPUT");
            item.setAttribute("type", "text");
            item.setAttribute("name", "equipment[]");
            item.setAttribute("class", "form-control");
            item.setAttribute("placeholder", "Enter item");
            var qty = document.createElement("INPUT");
            qty.setAttribute("type", "number");
            qty.setAttribute("name", "quantity[]");
            qty.setAttribute("class", "form-control");
            qty.setAttribute("placeholder", "Quantity");

            td1.appendChild(item);
            td2.appendChild(qty);
            tr.appendChild(td1);
            tr.appendChild(td2);
            table.appendChild(tr);
        }

        function addSteps() {
            // $('#stepSpace').append('<div class="row m-0"><div class="col-10 p-0"><input name="step[]" type="text" class="form-control w-100" placeholder="Enter Step"></div><div class="col-2 p-0"><button type="submit" class="btn btn-danger w-100" name="submit" style="font-size: 10px; margin-bottom: -9px; margin-left: 10px;">Delete</button></div></div>');

            $('#stepSpace').append('<tr><td><li><input name="step[]" type="text" class="form-control" placeholder="Enter Step"></li></td><td><button type="submit" class="btn btn-danger" name="submit" style="font-size: 10px; margin-bottom: -9px; margin-left: 10px;">Delete</button></td></tr>');
            // var list = document.getElementById("stepSpace");
            // var tr = document.createElement("tr");
            // var tl = document.createElement("tl");
            // var li = document.createElement("LI");
            // var step = document.createElement("INPUT");
            // var button = document.createElement("BUTTON");
            // var spanDelete = document.createElement("SPAN");
            // step.setAttribute("type", "text");
            // step.setAttribute("name", "step[]");
            // step.setAttribute("class", "form-control");
            // step.setAttribute("placeholder", "Enter step");
            // button.setAttribute("name", "submit");
            // button.setAttribute("type", "submit");
            // button.setAttribute("class", "btn btn-danger");
            // spanDelete.setAttribute("text", "Delete");
            // li.appendChild(step);
            // button.innerHTML = "Delete";
            // li.appendChild(button);
            // list.appendChild(li);
        }
    </script>
@endsection