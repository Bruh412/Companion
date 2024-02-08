@extends('layouts.admin')

@section('content')

@include('admin.navbackAct')
    <h1>{{ $act['title'] }}</h1>
    <div class="card mb-3" style="background:rgba(255,255,255,0.2);">
        <div class="card-header" style="background:rgba(255,255,255,0.65);">
            <i class="fas fa-exclamation"></i>
            Information about "{{ $act['title'] }}"
        </div>
        <div class="card-body">
            <div class="table-responsive">
    <table  class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <tr>
            <td><h5>Details: </h5></td>
            <td><ul><p>{{ $act['details'] }}</p></ul></td>
        </tr>

        @if(!is_null($act->steps))
        <tr>
            <td><h5>Steps:</h5></td>
            <td>
                <ol>
                    @foreach($act->steps as $row)
                    <li>{{ $row['stepDesc'] }}</li>
                    @endforeach
                </ol>
            </td>
        </tr>
        @endif
        
        <tr>
            <td><h5>Participants needed:</h5></td>
            <td><ul><p>{{ $act['participants'] }}</p></ul></td>
        </tr>

        @if(!is_null($act->equipments))
        <tr>
            <td><h5>Equipment needed:</h5></td>
            <td>
                <ul type="none">
                    @foreach($act->equipments as $row)
                    <li>{{ $row['equipmentName'] }} - {{ $row['quantity'] }}pc.</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif

        <tr>
            <td><h5>Time duration: </h5></td>
            <!-- <td>{{ $act['time'] }}</td> -->
            @if($act['time']=="None")
                <td><ul><p>Indefinite</p></ul></td>
            @else 
                <td><ul><p>{{ $act['time'] }}</p></ul></td>
            @endif
        </tr>

        <tr>
            <td><h5>The activity is good for: </h5></td>
            @if($act['gender']=="Both")
                <td><ul><p>Both men and women</p></ul></td>
            @elseif($act['gender']=="Female") 
                <td><ul><p>Women</p></ul></td>
            @else
                <td><ul><p>Male</p></ul></td>
            @endif
        </tr>
    
       @if(!empty($act->media['0']))
            <tr>
                <td><h5>Additional Media: </h5></td>
                <td>
                    <ul type="none">
                        @foreach($act->media as $file)
                            @if($file['fileExt'] == 'png'||'jpg'||'gif'||'bmp'||'dds'||'psd'||'pspimage'||'tga'||'thm'||'tif'||'tiff'||'yuv')
                                <li><img src="{{ $file['fileContent'] }}"></li>
                            @elseif($file['fileExt'] == 'avi'||'flv'||'wmv'||'mov'||'mp4')
                                <li>
                                    <video width="320" height="240" controls>
                                        <source src="{{ $file['fileContent'] }}" type="video/{{$file['fileExt']}}">
                                    </video>
                                </li>
                            @else
                                <li>{{ $file['fileContent'] }}</li>
                            @endif
                        @endforeach
                    </ul>
                </td>
            </tr>
       @endif

       <tr>
            <td><h5>Activity Interests: </h5></td>
            <td>
                <ul type="none">
                    @foreach($act->activityTags as $tag)
                    <li>{{ $tag->interest['interestName'] }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>

        <tr>
            <td><h5>This activity helps the following problems: </h5></td>
            <td>
                <ul type="none">
                    @foreach($act->problems as $prob)
                    <li>{{ $prob->problem['problem_name'] }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>

    </table>
    </div>
    </div>
    </div>
@endsection