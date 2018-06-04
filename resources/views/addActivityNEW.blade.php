<!-- <table align="center">
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
                <td>
                    <table id="equipmentSpace">
                         
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
           <tr>
            @if($mode == 'edit')
                <td><button class="btn btn-primary">Save Changes</button></td>
            @else
                <td><button class="btn btn-primary">Save Activity</button>
            @endif
            </tr>
            
        </table>
        <br> -->