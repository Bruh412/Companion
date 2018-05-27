<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use DB;
use App\SystemUser;
use App\PostStatus;
use App\MatchQuote;
use App\Keywords;
use App\Quote;
use App\EmptyMuch;
use App\Category;
use Auth;
use Validator;

class QuotesController extends Controller
{
    private $messages = [
        'text.required'=>'Please enter a new quote.',
        'text.unique'=>'Please enter a new quote.',
        'author.required'=>'Please enter the author of the quote.',
    ];

    public function dashboard(){
        $list = Quote::paginate(7);
        return view("quoteDash")->with(["list"=>$list]);
    }

    public function addQuote(){
        $mode = 'add';
        $categories = Category::get();
        return view("editQuote",compact('mode','categories'));
    }

    public function saveQuote(Request $req){
        $quote = new Quote;
        $db_quotes = Quote::get();
        $rules = [
            'text'=>'required|unique:quotes,quoteText',
            'author'=>'required',
        ];

        $validation = Validator::make($req->all(), $rules, $this->messages);
        $count = 0;
        
        if($validation->passes()){
            if(Quote::get() == EmptyMuch::get()){
                $quote->quoteID = "Q00001";
                $quote->quoteText = $req->text;
                $quote->quoteAuthor = $req->author;
                $quote->save();
            }
            else{
                foreach($db_quotes as $row){
                    if ($row['quoteText'] == $req->text){
                        $count++;
                    }
                }
                if ($count == 0){
                    $row = Quote::orderby('quoteID','desc')->first();
                    $temp = substr($row["quoteID"],1);
                    // dd($temp);
                    $temp = (int)$temp + 1;
                    $newQuoteID = "Q".(string)str_pad($temp,5,"0",STR_PAD_LEFT);
                    Quote::create([
                        'quoteID' => $newQuoteID,
                        'quoteText' => $req['text'],
                        'quoteAuthor' => $req['author'],
                    ]);
                }
                foreach($req->categories as $row){
                    $categoryID = Category::where('categoryName',$row)->value('categoryID');
                    MatchQuote::create([
                        'categoryID' => $categoryID,
                        'quoteID' => $newQuoteID,
                    ]);
                }
            }

            return redirect(url('/quotes'));
        }
        else{
            return redirect()->back()->withInput()->withErrors($validation);
        }

    }

    public function editQuote($quoteID){
        $mode = 'edit';
        $quote = Quote::findOrfail($quoteID);
        $categories = Category::get();
        // $result = MatchQuote::where('quoteID',$quote['quoteID'])->get();
        // return $result;
        // if($result){
        //     return view('editQuote',compact("quote","categories","result"));
        // } else{
            return view('editQuote',compact("quote","categories","mode"));
        // }
    }

    public function saveUpdate(Request $request){
        // if (){
            $record = Quote::findOrfail($request->quoteid);
            $record->quoteText = $request->text;
            $record->quoteAuthor = $request->author;
            $record->save();
            $count = 0;
            $results = DB::table('quotes')
                ->join('matchquote','quotes.quoteID','=','matchquote.quoteID')
                ->select('matchquote.categoryID')
                ->where('matchquote.quoteID',$request->quoteid)
                ->get();

            foreach($request->categories as $row){
                $categoryID = Category::where('categoryName',$row)->value('categoryID');
                foreach($results as $res){
                    if ($categoryID == $res->categoryID){
                        $count++;
                    }
                }
                if ($count == 0){
                    MatchQuote::create([
                        'categoryID' => $categoryID,
                        'quoteID' => $request->quoteid,
                    ]);
                }
            }
            return redirect(url('/quotes'));
        // } else{
        //     return redirect()->back()->withInput()->withErrors($validation);
        // }
    }

    public function delete($quoteID){
        $record = Quote::findOrfail($quoteID);
        $record->delete();
        return redirect()->back();
    }
    
    //-------------------------------------
    // public function saveQuote(){
    //     $client = new GuzzleHttp\Client();
    //     $res = $client->request('GET', 'https://api.forismatic.com/api/1.0/?method=getQuote&key=happy&format=json&lang=en');
    //     $data = $res->getBody()->getContents();
    //     $newData = json_decode($data, true);
    //     $quote = new Quote();
    //     if (Quote::get() == EmptyMuch::get()){
    //         $quote->quoteID = "Q00001";
    //         $quote->quoteText = $newData['quoteText'];
    //         $quote->quoteAuthor = $newData['quoteAuthor'];
    //         $quote->save();
    //         return $quote;
    //     }
    //     else {
    //         $counter = 0;
    //         $quotes = Quote::get();
    //         foreach($quotes as $quote){
    //             if (strcmp($quote['quoteText'],$newData['quoteText']) == 0){
    //                 $counter++;
    //             }
    //         }
    //         if ($counter == 0){
    //             $row = Quote::orderby('quoteID','desc')->first();
    //             $temp = substr($row["quoteID"],1);
    //             $temp = (int)$temp + 1;
    //             $newQuoteID = "Q".(string)str_pad($temp,5,"0",STR_PAD_LEFT);
    //             return Quote::create([
    //                 'quoteID' => $newQuoteID,
    //                 'quoteText' => $newData['quoteText'],
    //                 'quoteAuthor' => $newData['quoteAuthor'],
    //             ]);
    //         }
    //     }
    //     return $quote;
    // }

    public function display(Request $request){
        $id = Auth::id();
        $post = DB::table('systemusers')
            ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
            ->select('poststatus.post_content','poststatus.post_id')
            ->orderBy('post_id','desc')
            ->where('user_id',$request->header('Authorization'))
            ->first();
        $words = explode(' ',$post->post_content);
        $similar = [];
        for( $i = 0 ; $i < count($words) ; $i++ ){
            $ss = DB::table('keywords')
                    ->select('categoryID',DB::raw('COUNT(keywordName) as cnt_keyword'))
                    ->where('keywordName',$words[$i])
                    ->groupBy('categoryID')
                    ->get();
            if (!empty($ss)){
                $temp = json_decode($ss);
                array_push($similar,$temp);
            }
        }
        $temp = [];
        $total = [];
        $final = [];
        $temp2 = [];
        $quotes = [];
        $s = [];
        $count = 0;
        foreach($similar as $row){
            foreach($row as $details => $value){
                $false = 0;
                if (empty($total)){
                    $temp = [
                                'category' => $value->categoryID,
                                'counter' => $value->cnt_keyword,
                            ];
                    array_push($total,$temp);
                } 
                else {
                    foreach($total as $index => $value1){
                        if ($value1['category'] == $value->categoryID){
                            $value1['counter'] = $value1['counter'] + $value->cnt_keyword;
                            $temp2 = $value1;
                            $false++;
                        }
                    }
                    if ($false == 0){
                        $temp = [
                                    'category' => $value->categoryID,
                                    'counter' => $value->cnt_keyword,
                                ];
                        array_push($total,$temp);
                    }
                    for($i  = 0 ; $i < count($total); $i++){
                        if ($total[$i]['category'] == $temp2['category']){
                            $total[$i]['counter'] = $temp2['counter'];
                        }
                    }
                }
            }
        }

        usort($total, function($a, $b){
            return strcmp($b['counter'], $a['counter']);
        });
        foreach(array_splice($total,0,3) as $value){
            $quotes = DB::table('matchquote')
                    ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
                    ->select('quotes.*')
                    ->where('matchquote.categoryID',$value['category'])
                    ->get();
        }
        return response()->json([
            'quotes' => $quotes
        ]);
    }

    // public function displayQuotes(){
    //     $id = Auth::id();
    //     $post = DB::table('systemusers')
    //         ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
    //         ->select('poststatus.post_content','poststatus.post_id')
    //         ->orderBy('post_id','desc')
    //         ->where('user_id',$id)
    //         ->first();
    //     // $post = PostStatus::where('user_id',$id)->get();
    //     $words = explode(' ',$post->post_content);   
    //     $db_words = Keywords::get();
    //     $db_category = Category::get();
    //     $quoteCategories = [];
        // $categoryIDS = [];
        // foreach($db_category as $category){
        //     array_push($categoryIDS,$category['categoryID']);
        // }
        // $family = 0;
        // $friends = 0;
        // $relationship = 0;
        // $health = 0; 
        // $academic = 0;
        // $work = 0;
        // $financial = 0;
        // $personal = 0;

        // $categoriesCount = [];

        // foreach($db_category as $row){
        //     $categoriesCount[$row['categoryName']] = 0;
        // }   

        // foreach($categoriesCount as $index => $value){
        //     $hi = $value+2;
        //     echo $hi.'<br>';
        // }

        // return $categoriesCount['Family'];

        // dd($categoriesCount);
        // $row['']
        //checking sa keywords then compare sa words sa post
        // foreach($db_words as $row){
        //     for( $i = 0 ; $i < count($words) ; $i++ ){
                // if (strcasecmp($row['keywordName'],$words[$i]) == 0){
                //     $id = $row['categoryID'];
                //     switch($id){
                //         case "C0001": $family++;
                //         break;
                //         case "C0002": $friends++;
                //         break;
                //         case "C0003": $relationship++;
                //         break;
                //         case "C0004": $health++;
                //         break;
                //         case "C0005": $academic++;
                //         break;
                //         case "C0006": $work++;
                //         break;
                //         case "C0007": $financial++;
                //         break;
                //         case "C0008": $personal++;
                //         break;
                //     }
                // }
        //     }
        // }

    //     foreach($db_category as $category){
    //         foreach($db_words as $word){
    //             for( $i = 0 ; $i < count($words) ; $i++ ){
    //                 if ($word['categoryID'] == $category['categoryID']){
    //                     if (strcasecmp($word['keywordName'],$words[$i]) == 0){
    //                         foreach($categoriesCount as $index => $value){
    //                             if ($category['categoryName'] == $index){
    //                                 $value = $value + 1;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    // }
}
