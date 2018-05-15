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
    return view('welcome');
});
Route::get('/register','SystemUsersController@registerPage');

// Route::get('/userType/{userType}','SystemUsersController@chooseUser')->name('userType');
Route::post('/register','SystemUsersController@register')->name('register');
// Route::post('/registerseeker','SystemUsersController@registerSeeker')->name('seeker');
// Route::post('/registerfacilitator','SystemUsersController@registerFacilitator')->name('facilitator');

Route::get('/interests/get','InterestController@getInterests');
Route::view('/login', 'login')->name('login');
Route::post('/login','SystemUsersController@userAuthentication')->name('login');
Route::get('/logout','SystemUsersController@logout')->name('logout');
// Route::get('/logout','AdminController@logout')->name('logout');


Route::middleware(['auth'])->group(function(){
    Route::get('/home','AdminController@adminHome');


    Route::get('/posts/display','PostStatusController@displayPosts');
    // Route::get('/post/{postid}/display','PostStatusController@displayPost');
    Route::get('/posts/create','PostStatusController@addPost');
    Route::post('/posts/save','PostStatusController@savePost');
    
    // Route::get('/post/{postid}/edit','PostStatusController@update');
    Route::post('/posts/update','PostStatusController@saveupdate');

    Route::get('/post/{postid}/delete','PostStatusController@deletePost');


    Route::get('/quotes/save','QuotesController@saveQuote');
    Route::get('/categorize','QuotesController@categorizeQuotes');
    Route::get('/displayPost','QuotesController@displayQuotes');

     // ---------------------------- ACTIVITIES
    Route::get('/activities', 'ActivityController@dashboard');
    Route::get('/addAct', 'ActivityController@addAct');
    Route::post('/saveAct', 'ActivityController@saveAct');
    Route::get('/editAct/{id}', 'ActivityController@editAct');
    Route::post('/saveAct/edit', 'ActivityController@saveActEdit');
    Route::get('/deleteAct/{id}', 'ActivityController@deleteAct');
    Route::get('/viewAct/{id}', 'ActivityController@viewAct');

    // --- INTERESTS
    Route::get('/interests', 'InterestController@dashboard');
    Route::get('/addInt', 'InterestController@addInt');
    Route::post('/addInt', 'InterestController@saveInt');
    Route::get('/deleteInt/{id}', 'InterestController@deleteInt');

    // --- CATEGORIES
    Route::get('/categories', 'CategoryController@dashboard');
    Route::get('/addCat', 'CategoryController@addCat');
    Route::post('/addCat', 'CategoryController@saveCat');
    Route::get('/deleteCat/{id}', 'CategoryController@deleteCat');
    Route::get('/viewCat/{id}', 'CategoryController@viewCat');
            // --- KEYWORDS
    Route::get('/deleteKeyword/{catID}/{id}', 'KeywordController@deleteKeyword');
    Route::get('/addKeyword/{catID}', 'KeywordController@addKeyword');
    Route::post('/addKeyword/{catID}', 'KeywordController@saveKeyword');

    // --- QUOTES
    Route::get('/quotes', 'QuotesController@dashboard');
    Route::get('/addQuote', 'QuotesController@addQuote');
    Route::post('/addQuote', 'QuotesController@saveQuote');
});

// --- GROUPING

// - Add to queue
Route::get('/groupUser/{id}', 'SystemController@addUserToTalkCircleQueue');
// - Check queue
Route::get('/checkQueue', 'SystemController@checkQueue');