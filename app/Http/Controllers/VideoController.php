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
    private $count = 0;
    public function storeVideo(){
        $vid_categories = [];
        $stream_opts = [
                            "ssl" => [
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ]
                        ];
        $api = new YoutubeAPIKey;
        $db_category = Category::get();
        if (YoutubeAPIKey::get() == EmptyMuch::get()){
            foreach($db_category as $row){
                $res = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&q=inspirational+videos+about+'.$row['categoryName'].'&type=video&key='.$api->api_key;
                $json = file_get_contents($res,false, stream_context_create($stream_opts));
                $json_data = json_decode($json);

                $catID = $row['categoryID'];
                $countReturnVidoes = count($json_data->items);
                foreach($json_data->items as $item){
                    $vid = new YoutubeAPIKey();
                    $videoID = ' ';
                    $vidId = ' ';
                    if (YoutubeAPIKey::get() == EmptyMuch::get()){
                        $vid->videoID = "V00000000001";
                        $vidId = "V00000000001";
                        $vid->videoApi_id = $item->id->videoId;
                        $vid->video_title = $item->snippet->title;
                        $vid->video_desc = $item->snippet->description;
                        $vid->nextPageToken = $json_data->nextPageToken;
                        $vid->save();

                        $match = new MatchVideo;
                        $match->videoID = $vidId;
                        $match->categoryID = $catID;
                        $match->save();
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
                            $temp = substr($row["videoID"],1);
                            $temp = (int)$temp + 1;
                            $videoID = "V".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                            $vid->videoID = $videoID;
                            $vidId = $videoID;
                            $vid->videoApi_id = $item->id->videoId;
                            $vid->video_title = $item->snippet->title;
                            $vid->video_desc = $item->snippet->description;
                            $vid->nextPageToken = $json_data->nextPageToken;
                            $vid->save();

                            $match = new MatchVideo;
                            $match->videoID = $vidId;
                            $match->categoryID = $catID;
                            $match->save();
                        }
                    }
                }
            }
        } else {
            foreach($db_category as $row){
                // $matchVideoTableVid = MatchVideo::where('categoryID',$row['categoryID'])->orderBy('id','desc')->value('videoID');
                // $nextPageToken = YoutubeAPIKey::where('videoID',$matchVideoTableVid)->value('nextPageToken');
                $nextPageToken = YoutubeAPIKey::orderBy('videoID','desc')->value('nextPageToken');
                $res = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&pageToken='.$nextPageToken.'&q=inspirational+videos+about+'.$row['categoryName'].'&type=video&key='.$api->api_key;
                $json = file_get_contents($res,false, stream_context_create($stream_opts));
                $json_data = json_decode($json);

                $catID = $row['categoryID'];
                $countReturnVidoes = count($json_data->items);
                foreach($json_data->items as $item){
                    $vid = new YoutubeAPIKey();
                    $videoID = ' ';
                    $vidId = ' ';
                    $counter = 0;
                    $videos = YoutubeAPIKey::get();
                    foreach($videos as $row){
                        if ($row['videoApi_id'] == $item->id->videoId){
                            $counter++;
                        }
                    }
                    if ($counter == 0){
                        $row = YoutubeAPIKey::orderBy('videoID','desc')->first();
                        $temp = substr($row["videoID"],1);
                        $temp = (int)$temp + 1;
                        $videoID = "V".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                        $vid->videoID = $videoID;
                        $vidId = $videoID;
                        $vid->videoApi_id = $item->id->videoId;
                        $vid->video_title = $item->snippet->title;
                        $vid->video_desc = $item->snippet->description;
                        $vid->prevPageToken = $json_data->prevPageToken;
                        $vid->nextPageToken = $json_data->nextPageToken;
                        $vid->save();

                        $match = new MatchVideo;
                        $match->videoID = $vidId;
                        $match->categoryID = $catID;
                        $match->save();
                    }
                }
            }
        }
    }

    public function video(){
        $vid_categories = [];
        $stream_opts = [
                            "ssl" => [
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ]
                        ];
        $api = new YoutubeAPIKey;
        $db_category = Category::get();
        foreach($db_category as $row){
            $res = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&q=inspirational+videos+about+'.$row['categoryName'].'&type=video&key='.$api->api_key;
            // $res = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=10&q=inspirational+videos+about+Family&type=video&key='.$api->api_key;
            $json = file_get_contents($res,false, stream_context_create($stream_opts));
            $json_data = json_decode($json);

            $catID = $row['categoryID'];
            // $catID = 'C0001';
            $countReturnVidoes = count($json_data->items);
            $countCurrentVideo = 0;
            $pageToken = '';
            $countSimilarVideos = 0;
            foreach($json_data->items as $item){
                $vid = new YoutubeAPIKey();
                $videoID = ' ';
                $vidId = ' ';
                if (YoutubeAPIKey::get() == EmptyMuch::get()){
                    $vid->videoID = "V00000000001";
                    $vidId = "V00000000001";
                    $vid->videoApi_id = $item->id->videoId;
                    $vid->video_title = $item->snippet->title;
                    $vid->video_desc = $item->snippet->description;
                    $vid->save();

                    $match = new MatchVideo;
                    $match->videoID = $vidId;
                    $match->categoryID = $catID;
                    $match->save();
                }
                else {
                    $counter = 0;
                    $videos = YoutubeAPIKey::get();
                    foreach($videos as $row){
                        if ($row['videoApi_id'] == $item->id->videoId){
                            $counter++;
                            $countSimilarVideos++;
                        }
                    }
                    if ($counter == 0){
                        $row = YoutubeAPIKey::orderBy('videoID','desc')->first();
                        $temp = substr($row["videoID"],1);
                        $temp = (int)$temp + 1;
                        $videoID = "V".(string)str_pad($temp,11,"0",STR_PAD_LEFT);
                        $vid->videoID = $videoID;
                        $vidId = $videoID;
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
            }
        }
        // return redirect(url('/videos'));  
        return $countCurrentVideo;
    }

    public function getVideo(){
        $last = YoutubeAPIKey::orderBy('videoID','desc')->first();
        date_default_timezone_set('Asia/Manila');
        foreach($last['created_at'] as $row => $value){
            if ($row == "date")
                $ant = $value;
        }
        //kwaon ang giset sa admin sa config table
        //add pila ka days sa $ant
        //get total date
        //check always sa total date if true fetch data from utube
        

        //subtracting days
        $date = strtotime($ant);
        // $now = strtotime('June 06 2018 12:00:00am');
        $date_created = date('Y-m-d:h:i:sa', $date);
        $date_curr = date('Y-m-d:h:i:sa');
        $datetime1 = strtotime($date_created);
        $datetime2 = strtotime($date_curr);
        // return round(($now - $date)/86400);

        //pag add sa date_created
        // echo date('Y-m-d:h:i:sa',strtotime($ant. ' + 5 Days'));
    }

    public function dashboard(){
        $list = YoutubeAPIKey::paginate(7);
        return view("admin.videoDash")->with(["list"=>$list]);
    }

    public function display($videoID){
        $video = YoutubeAPIKey::where("videoID",$videoID)->first();
        return view('admin.viewVideo',compact('video'));
    }
}
