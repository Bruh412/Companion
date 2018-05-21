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

    public function displayQuotes(){
        $id = Auth::id();
        $post = DB::table('systemusers')
            ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
            ->select('poststatus.post_content','poststatus.post_id')
            ->orderBy('post_id','desc')
            ->where('user_id',$id)
            ->first();
        // $post = PostStatus::where('user_id',$id)->get();
        $words = explode(' ',$post->post_content);   
        $db_words = Keywords::get();
        $db_category = Category::get();
        $quoteCategories = [];
        // $categoryIDS = [];
        // foreach($db_category as $category){
        //     array_push($categoryIDS,$category['categoryID']);
        // }
        $family = 0;
        $friends = 0;
        $relationship = 0;
        $health = 0; 
        $academic = 0;
        $work = 0;
        $financial = 0;
        $personal = 0;
        //checking sa keywords then compare sa words sa post
        foreach($db_words as $row){
            for( $i = 0 ; $i < count($words) ; $i++ ){
                if (strcasecmp($row['keywordName'],$words[$i]) == 0){
                    $id = $row['categoryID'];
                    switch($id){
                        case "C0001": $family++;
                        break;
                        case "C0002": $friends++;
                        break;
                        case "C0003": $relationship++;
                        break;
                        case "C0004": $health++;
                        break;
                        case "C0005": $academic++;
                        break;
                        case "C0006": $work++;
                        break;
                        case "C0007": $financial++;
                        break;
                        case "C0008": $personal++;
                        break;
                    }
                }
            }
        }
        $result = array(
            "Family" => $family,
            "Friends" => $friends,
            "Relationship" => $relationship,
            "Health" => $health,
            "Academic" => $academic,
            "Work" => $work,
            "Financial" => $financial,
            "Personal" => $personal,
        );
        arsort($result);
        $firstThreeElements = array_slice($result, 0, 3,true);

        $quotes = [];
        foreach($firstThreeElements as $index => $value){
            $quotes = DB::table('categories')
            ->join('matchquote','categories.categoryID','=','matchquote.categoryID')
            ->join('quotes','matchquote.quoteID','=','quotes.quoteID')
            ->select('quotes.*')
            ->where('categoryName',$index)
            ->get();
        }

        return rand(json_encode($quotes));

        // if (strcasecmp($word['keywordName'],$words[$i]) == 0){
        //     if (!in_array($word['categoryID'],$quoteCategories)){
        //         array_push($quoteCategories,$word['categoryID']);
        //     } else 
        //         continue;
        // }

        //getting the quote's id by category id
        // $quoteIDS = [];
        // foreach($quoteCategories as $category){
        //     $quoteIDS = MatchQuote::where('categoryID',$category)->value('quoteID');
        // }
        // //getting quotes by quoteID
        // $quotes = [];
        // foreach($quotes as $quote){
        //     $quotes = Quote::where('quoteID',$quote)->get(['quoteText','quoteAuthor']);
        // }

        // return $quoteCategories;

    }

    // public function categorizeQuotes(){
    //     $quotes = Quote::get();
    //     // $keywords = Keywords::get();
    //     foreach($quotes as $quote){
    //         echo $quote['id'];
    //         $words = explode(' ', $quotes[0]['quoteText']);
    //         var_dump($words);
    //         foreach($keywords as $key){
    //             // var_dump($key['keyword_name']);
    //             for($i = 0 ; $i < count($words); $i++){
                
    //             }
    //         }
    //         for($i = 0 ; $i < count($words); $i++){
                
    //         }
    //     }
        // $post = DB::table('systemusers')
        //     ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
        //     ->select('poststatus.post_content','poststatus.post_id')
        //     ->orderBy('post_id','desc')
        //     ->first();
        // $post_words = explode(' ', $post->post_content);
    // }
}
