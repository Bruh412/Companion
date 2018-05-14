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

// Route::get('/userType','SystemUsersController@chooseUser')->name('userType');
// Route::post('/register','SystemUsersController@registerSeeker')->name('registerSeeker');
Route::post('/registerseeker','SystemUsersController@registerSeeker')->name('registerSeeker');
Route::post('/registerfacilitator','SystemUsersController@registerFacilitator')->name('registerFacilitator');

Route::get('/interests/get','InterestController@getInterests');
Route::view('/login', 'login')->name('login');
Route::post('/login','SystemUsersController@userAuthentication')->name('login');
Route::get('/logout','SystemUsersController@logout')->name('logout');

// Route::post('/json','SystemUsersController@json')->name('json');

Route::middleware(['auth'])->group(function(){
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
});