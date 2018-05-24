<?php
// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

// dd(Uuid::uuid1()->toString());
?>

@extends('layouts.app')

@section('content')
<div class="container">
    @include('navbackAct') 
    <br>
    <br>
    @if($mode == 'edit')
        <h1>Edit activity</h1>
        <br>
        <form action="/saveAct/edit" method="post" enctype="multipart/form-data">
        <input type="hidden" value="{{ $act['actID'] }}" name="secretID" >
    @else
        <h1>Add new activity</h1>
        <br>
        <form action="/saveAct" method="post" enctype="multipart/form-data">
    @endif
        {{ csrf_field() }}
        <table>
            <tr>
                <td colspan="2"><span>Activity Title: </span></td>
                @if($mode == 'edit')
                    <td><input type="text" name="title"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $act['title'] }}"></td>
                @else
                    <td><input type="text" name="title"  class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}"></td>
                @endif
                <td>
                @foreach($errors->get('title') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="2"><span>Activity Details: </span></td>
                @if($mode == 'edit')
                    <td><textarea name="details" cols="35" rows="5"  class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}">{{ $act['details'] }}</textarea></td>
                @else
                    <td><textarea name="details" cols="35" rows="5"  class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}">{{ old('details') }}</textarea></td>
                @endif
                <td>
                @foreach($errors->get('details') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
            <tr>
                <td>Add Steps: &emsp;&emsp;</td>
                <td><button type="button" onclick="addSteps()" class="btn btn-info">Add</button></td>
                <td>
                    <ol id="stepSpace">
                         <!--DOM insertion  -->
                    </ol>
                </td>
                <td>
                @foreach($errors->get('step') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="2"><span>Required Participants: </span></td>
                <td>
                    <select name="participants" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="5">5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Equipment Needed: &emsp;&emsp;</td>
                <td><button type="button" onclick="addEquip()" class="btn btn-info">Add</button></td>
                <!-- @if($mode == 'edit')
                    <td><input type="text" name="equipment"  class="form-control{{ $errors->has('equipment') ? ' is-invalid' : '' }}" value="{{ $act['equipment'] }}"></td>
                @else
                    <td><input type="text" name="equipment"  class="form-control{{ $errors->has('equipment') ? ' is-invalid' : '' }}" value="{{ old('equipment') }}"></td>
                @endif -->
                <td>
                    <table id="equipmentSpace">
                         <!--DOM insertion  -->
                    </table>
                </td>
                <td>
                @foreach($errors->get('equipment') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="2">Time Needed: </td>
                <td>
                    <select name="time" id="time" onchange="showOrHideTime(this)"  class="form-control">
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
                </td>
            </tr>
            <!-- <tr>
                <td>Game to embed: </td>
                @if($mode == 'edit')
                    <td><input type="text" name="embed"  class="form-control{{ $errors->has('embed') ? ' is-invalid' : '' }}" value="{{ $act['embed'] }}"></td>
                @else
                    <td><input type="text" name="embed"  class="form-control{{ $errors->has('embed') ? ' is-invalid' : '' }}"></td>
                @endif
            </tr> -->
            <tr>
                <td colspan="2">Gender Compatibility: </td>
                <td>
                    &nbsp;
                    <input type="radio" name="gender" value="Both" checked="checked">Both
                    <input type="radio" name="gender" value="Male">Male
                    <input type="radio" name="gender" value="Female">Female
                </td>
            </tr>
            <tr>
                <td colspan="2">Add media: </td>
                <td><input type="file" name="media[]" accept="audio/*,video/*,image/*" multiple></td>
            </tr>
            <tr>
                <td colspan="2">Add Interests: </td>
                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">
                    Add Tags
                </button></td>
                <td>
                @foreach($errors->get('tags') as $errorMsg)
                    {{ $errorMsg }}
                @endforeach
                </td>         
            </tr>
            <tr>
                <td colspan="2">Problem: </td>
                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter1">
                    Add Problem
                </button></td>
            </tr>
           
            
        </table>
        <br>
        @if($mode == 'edit')
            <button class="btn btn-primary" style="font-size: 22px;">Save Changes</button> 
        @else
            <button class="btn btn-primary" style="font-size: 22px;">Save Activity</button>
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
            var list = document.getElementById("stepSpace");
            // var div1 = document.createElement("DIV");
            // div1.setAttribute("class", "form-group row");
            // var div2 = document.createElement("DIV");
            // div2.setAttribute("class", "col-xs-1");
            var li = document.createElement("LI");
            var step = document.createElement("INPUT");
            step.setAttribute("type", "text");
            step.setAttribute("name", "step[]");
            step.setAttribute("class", "form-control");
            step.setAttribute("placeholder", "Enter step");

            // li.appendChild(div1);
            // li.appendChild(div2);
            li.appendChild(step);
            list.appendChild(li);
        }
    </script>
@endsection