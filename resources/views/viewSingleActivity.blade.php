@extends('layouts.app')

@section('content')
@include('navbackAct') 
    <table>
        <tr>
            <td><h1>{{ $act['title'] }}</h1></td>
        </tr>

        <tr>
            <td><h5>Details: </h5></td>
            <td><p>{{ $act['details'] }}</p></td>
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
            <td><h5>{{ $act['participants'] }}</h5></td>
        </tr>

        @if(!is_null($act->equipments))
        <tr>
            <td><h5>Equipment needed:</h5></td>
            <td>
                <ul>
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
                <td><p>Indefinite</p></td>
            @else 
                <td><p>{{ $act['time'] }}</p></td>
            @endif
        </tr>

        <tr>
            <td><h5>The activity is good for: </h5></td>
            @if($act['gender']=="Both")
                <td><p>Both men and women</p></td>
            @elseif($act['gender']=="Female") 
                <td><p>Women</p></td>
            @else
                <td><p>Male</p></td>
            @endif
        </tr>
    
       @if(!empty($act->media['0']))
            <tr>
                <td><h5>Additional Media: </h5></td>
                <td>
                    <ul>
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
                <ul>
                    @foreach($act->activityTags as $tag)
                    <li>{{ $tag->interest['interestName'] }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>

    </table>
    @endsection