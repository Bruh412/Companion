<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use DB;
use App\SystemUser;
use App\PostStatus;
use App\Keywords;
use App\Quote;
use App\EmptyMuch;
use Auth;

class QuotesController extends Controller
{
    public function saveQuote(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.forismatic.com/api/1.0/?method=getQuote&key=happy&format=json&lang=en');
        $data = $res->getBody()->getContents();
        $newData = json_decode($data, true);
        $quote = new Quote();
        if (Quote::get() == EmptyMuch::get()){
            $quote->quoteID = "Q00001";
            $quote->quoteText = $newData['quoteText'];
            $quote->quoteAuthor = $newData['quoteAuthor'];
            $quote->save();
            return $quote;
        }
        else {
            $counter = 0;
            $quotes = Quote::get();
            foreach($quotes as $quote){
                if (strcmp($quote['quoteText'],$newData['quoteText']) == 0){
                    $counter++;
                }
            }
            if ($counter == 0){
                $row = Quote::orderby('quoteID','desc')->first();
                $temp = substr($row["quoteID"],1);
                $temp = (int)$temp + 1;
                $newQuoteID = "Q".(string)str_pad($temp,5,"0",STR_PAD_LEFT);
                return Quote::create([
                    'quoteID' => $newQuoteID,
                    'quoteText' => $newData['quoteText'],
                    'quoteAuthor' => $newData['quoteAuthor'],
                ]);
            }
        }
        // return $quote;
    }

    public function displayQuotes(){
        $id = Auth::id();
        $post = DB::table('systemusers')
            ->join('poststatus',$id,'=','poststatus.post_user_id')
            ->select('poststatus.post_content','poststatus.post_id')
            ->orderBy('post_id','desc')
            ->first();
        // dd($post->post_content);
        $words = explode(' ',$post->post_content);

        $db_words = Keywords::get();
        $quoteCategories = [];
        //checking sa keywords then compare sa words sa post
        foreach($db_words as $word){
            for( $i = 0 ; $i < count($words) ; $i++ ){
                if (strcasecmp($word['keyword_name'],$words[$i]) == 0){
                    if (!in_array($word['categoryID'],$quoteCategories)){
                        array_push($quoteCategories,$word['categoryID']);
                    } else 
                        continue;
                }
            }
        }
        //getting the quote's id by category id
        $quoteIDS = [];
        foreach($quoteCategories as $category){
            $quoteIDS = MatchQuote::where('categoryID',$category)->value('quoteID');
        }
        //getting quotes by quoteID
        $quotes = [];
        foreach($quotes as $quote){
            $quotes = Quote::where('quoteID',$quote)->get(['quoteText','quoteAuthor']);
        }

        return $quotes;

    }

    public function categorizeQuotes(){
        $quotes = Quote::get();
        // $keywords = Keywords::get();
        foreach($quotes as $quote){
            echo $quote['id'];
            $words = explode(' ', $quotes[0]['quoteText']);
            var_dump($words);
            foreach($keywords as $key){
                // var_dump($key['keyword_name']);
                for($i = 0 ; $i < count($words); $i++){
                
                }
            }
            for($i = 0 ; $i < count($words); $i++){
                
            }
        }
        // $post = DB::table('systemusers')
        //     ->join('poststatus','systemusers.user_id','=','poststatus.post_user_id')
        //     ->select('poststatus.post_content','poststatus.post_id')
        //     ->orderBy('post_id','desc')
        //     ->first();
        // $post_words = explode(' ', $post->post_content);
    }
}
