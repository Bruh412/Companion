<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('specs');
});

// Route::get('/register','SystemUsersController@registerPage');
Route::post('/register','SystemUsersController@register')->name('register');


Route::get('/interests/get','InterestController@getInterests');
Route::get('/specialization/get','SystemUsersController@getSpecsFromDB');
// Route::get('/specialization/get','SystemUsersController@try');


Route::view('/login', 'login')->name('login');
Route::post('/login','SystemUsersController@userAuthentication')->name('login');
Route::get('/logout','SystemUsersController@logout')->name('logout');
// Route::get('/logout','AdminController@logout')->name('logout');


Route::middleware(['auth'])->group(function(){
    Route::get('/home','AdminController@adminHome');

    Route::get('/posts/display','PostStatusController@displayPosts');
    Route::get('/post/{postid}/display','PostStatusController@displayPost');
    Route::get('/posts/create','PostStatusController@addPost');
    Route::post('/posts/save','PostStatusController@savePost');
    Route::get('/post/{postid}/edit','PostStatusController@update');
    Route::post('/posts/update','PostStatusController@saveupdate');
    Route::get('/post/{postid}/delete','PostStatusController@deletePost');

    Route::get('/quotes/save','QuotesController@saveQuote');
    Route::get('/categorize','QuotesController@categorizeQuotes');
    Route::get('/displayPost','QuotesController@displayQuotes');

    //---------------------------------------------------------------
    Route::get('/problems/get','ProblemController@getProblems');
    Route::get('/feelings/get','PostStatusController@getFeelings');
     // ---------------------------- ACTIVITIES
    Route::get('/activities', 'ActivityController@dashboard');
    Route::get('/addAct', 'ActivityController@addAct');
    Route::post('/saveAct', 'ActivityController@saveAct');
    Route::get('/editAct/{id}', 'ActivityController@editAct');
    Route::post('/saveAct/edit', 'ActivityController@saveActEdit');
    Route::get('/deleteAct/{id}', 'ActivityController@deleteAct');
    Route::get('/viewAct/{id}', 'ActivityController@viewAct');

    // --- INTERESTS -X
    Route::get('/interests', 'InterestController@dashboard');
    Route::get('/addInt', 'InterestController@addInt');
    Route::post('/addInt', 'InterestController@saveInt');
    Route::get('/deleteInt/{id}', 'InterestController@deleteInt');

    // --- CATEGORIES -X
    Route::get('/categories', 'CategoryController@dashboard');
    Route::get('/addCat', 'CategoryController@addCat');
    Route::post('/addCat', 'CategoryController@saveCat');
    Route::get('/deleteCat/{id}', 'CategoryController@deleteCat');
    Route::get('/viewCat/{id}', 'CategoryController@viewCat');
            // --- KEYWORDS -X
    Route::get('/deleteKeyword/{catID}/{id}', 'KeywordController@deleteKeyword');
    Route::get('/addKeyword/{catID}', 'KeywordController@addKeyword');
    Route::post('/addKeyword/{catID}', 'KeywordController@saveKeyword');

    // --- QUOTES -X
    Route::get('/quotes', 'QuotesController@dashboard');
    Route::get('/addQuote', 'QuotesController@addQuote');
    Route::post('/addQuote', 'QuotesController@saveQuote');

    // --- FEELINGS -X
    Route::get('/feelings', 'FeelingsController@dashboard');
    Route::get('/addFeeling', 'FeelingsController@addFeeling');
    Route::post('/addFeeling', 'FeelingsController@saveFeeling');
    Route::get('/deleteFeeling/{id}', 'FeelingsController@deleteFeeling');
});

// --- GROUPING

// - Add to queue
// temp feeling
Route::get('/groupUser/{id}/{feeling}', 'SystemController@addUserToTalkCircleQueue');
// - Check queue
Route::get('/checkQueue/{id}', 'SystemController@checkQueue1');