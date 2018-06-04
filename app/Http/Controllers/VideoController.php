<?php

namespace App\Http\Controllers;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Request;
use App\YoutubeAPIKey;
use App\Category;
use App\MatchVideo;
use App\EmptyMuch;
use GuzzleHttp;

class VideoController extends Controller
{
    private $id = ' ';
    public function video(){
        $vid_categories = [];
        $stream_opts = [
                            "ssl" => [
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ]
                        ];
        // $vid_categories[$row['categoryName']] = 0;
        $api = new YoutubeAPIKey;
        $db_category = Category::get();
        foreach($db_category as $row){
            $res = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=5&q='.$row['categoryName'].'+videos&type=video&key='.$api->api_key;
            $json = file_get_contents($res,false, stream_context_create($stream_opts));
            $json_data = json_decode($json);
            $count = 0;
            $huhu = [];
            $catID = $row['categoryID'];
            foreach($json_data->items as $item){
                $vid = new YoutubeAPIKey();
                $videoID = ' ';
                $vidId = ' ';
                if (YoutubeAPIKey::get() == EmptyMuch::get()){
                    $vid->videoID = "V00000000001";
                    $vidId = "V00000000001";
                }
                else {
                    $counter = 0;
                    $videos = YoutubeAPIKey::get();
                    foreach($videos as $row){
                        if ($row['videoApi_id'] == $item->id->videoId){
                            $counter++;
                        }
                    }
                    if ($counter == 0){
                        $row = YoutubeAPIKey::orderBy('videoID','desc')->first();
                        // return $row['videoID'];
                        $temp = substr($row["videoID"],1);
                        $temp = (int)$temp + 1;
                        $videoID = "V".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                        $vid->videoID = $videoID;
                        $vidId = $videoID;
                    }
                }
                $vid->videoApi_id = $item->id->videoId;
                $vid->video_title = $item->snippet->title;
                $vid->video_desc = $item->snippet->description;
                $vid->save();

                $match = new MatchVideo;
                $match->videoID = $vidId;
                $match->categoryID = $catID;
                $match->save();
            }
        }
        // $stream_opts = [
        //                     "ssl" => [
        //                         "verify_peer"=>false,
        //                         "verify_peer_name"=>false,
        //                     ]
        //                 ];
        // $api = new YoutubeAPIKey;
        // $res = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=happy&key='.$api->api_key;
        // $json = file_get_contents($res,false, stream_context_create($stream_opts));
        // $json_data = json_decode($json, false);
        // $count = 0;
        // $id = [];
        // $des = [];
        // foreach($json_data->items as $item){
        //     array_push($id,$item->id->videoId);
        //     array_push($des,$item->snippet->title);
        // }
        // return $des;
    }

    public function getVideo(){
        $id = YoutubeAPIKey::orderBy('videoID','desc')->first();
        date_default_timezone_set('Asia/Manila');
        foreach($id['created_at'] as $row => $value){
            if ($row == "date")
                $ant = $value;
        }   
        //subtracting days
        $date = strtotime($ant);
        // $now = strtotime('now');
        $now = strtotime('June 06 2018 12:00:00am');
        $date_created = date('Y-m-d:h:i:sa', $date);
        $date_curr = date('Y-m-d:h:i:sa');

        $datetime1 = strtotime($date_created);
        $datetime2 = strtotime($date_curr);
        return round(($now - $date)/86400);

        //pag add sa date_created
        // echo date('Y-m-d:h:i:sa',strtotime($ant. ' + 5 Days'));
    }
}
