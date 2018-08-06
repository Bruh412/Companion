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
    return view('homepage');
});

Route::get('/register','SystemUsersController@registerPage');
Route::post('/register','SystemUsersController@register')->name('register');


Route::get('/interests/get','InterestController@getInterests');
Route::get('/specialization/get','SpecializationController@getSpecsFromDB');
// Route::get('/specialization/get','SystemUsersController@try');
// Route::post('/posts/char','PostStatusController@char')->name('huhu');

Route::get('/login', 'SystemUsersController@loginPage');
Route::post('/login','SystemUsersController@userAuthentication')->name('login');
Route::get('/logout','SystemUsersController@logout')->name('logout');
// Route::get('/logout','AdminController@logout')->name('logout');
Route::get('/quotes/save','QuotesController@saveQuote');
Route::get('/quotes/save','QuotesController@saveQuote');
//----------------------------------------------------------
Route::view('/loginService','loginService');
Route::view('/userType','userType');
Route::view('/register/seeker','registerSeeker');
Route::view('/register/facilitator','registerFacilitator');
Route::post('/userType','SystemUsersController@userType');
Route::post('/register/seeker','SystemUsersController@registerSeeker');
Route::post('/register/facilitator','SystemUsersController@registerFacilitator');
    Route::get('/video','VideoController@video');
//----------------------------------------------------------

Route::middleware(['auth'])->group(function(){
    Route::get('/wall','SystemUsersController@wall');
    Route::get('/facilitator/home','SystemUsersController@facHome');
    Route::post('/mediawall','QuotesController@display');

    Route::get('/comment/{postid}/add','PostStatusController@addComment');
    Route::post('/comment/save','PostStatusController@saveComment');
    Route::get('/video/get','VideoController@getVideo');
    Route::get('/post/{postid}/view','PostStatusController@displayPost');






    Route::get('/home','AdminController@adminHome');

    Route::get('/posts/display','PostStatusController@displayPosts');
    Route::get('/post/{postid}/display','PostStatusController@displayPost');
    Route::get('/posts/create','PostStatusController@addPost');
    Route::post('/posts/save','PostStatusController@savePost');
    Route::get('/post/{postid}/edit','PostStatusController@update');
    Route::post('/posts/update','PostStatusController@saveupdate');
    Route::get('/post/{postid}/delete','PostStatusController@deletePost');

    // Route::get('/quotes/save','QuotesController@saveQuote');
    Route::get('/categorize','QuotesController@categorizeQuotes');
    Route::get('/displayPost','QuotesController@displayQuotes');
    // Route::get('/display','QuotesController@display');

    //---------------------------------------------------------------
    Route::get('/problems/get','ProblemController@getProblems');
    Route::get('/feelings/get','PostStatusController@getFeelings');
    // ---------------------------- ACTIVITIES----------------------
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
    Route::post('/addImage/{id}', 'CategoryController@addImageCategory');
    Route::get('/viewCategoryImages/{id}', 'CategoryController@viewCategoryImages');
    Route::get('/deleteImg/{id}', 'CategoryController@deleteImg');
            // --- KEYWORDS -X
    Route::get('/deleteKeyword/{catID}/{id}', 'KeywordController@deleteKeyword');
    Route::get('/addKeyword/{catID}', 'KeywordController@addKeyword');
    Route::post('/addKeyword/{catID}', 'KeywordController@saveKeyword');

    // --- QUOTES -X
    Route::get('/quotes', 'QuotesController@dashboard');
    Route::get('/addQuote', 'QuotesController@addQuote');
    Route::post('/addQuote', 'QuotesController@saveQuote');
    Route::get('/quote/{quoteID}/edit', 'QuotesController@editQuote');
    Route::post('/quote/edit', 'QuotesController@saveUpdate');
    Route::get('/quote/{quoteID}/delete', 'QuotesController@delete');

    // --- FEELINGS -X
    Route::get('/feelings', 'FeelingsController@dashboard');
    Route::get('/addFeeling', 'FeelingsController@addFeeling');
    Route::post('/addFeeling', 'FeelingsController@saveFeeling');
    Route::get('/deleteFeeling/{id}', 'FeelingsController@deleteFeeling');

    // --- CONFIGURATION -X
    Route::get('/systemConfig', 'SystemController@viewConfig');
    Route::get('/editConfig/{field}', 'SystemController@editConfig');
    Route::post('/editConfig/{field}', 'SystemController@saveEditConfig');

    // --- ADD PLACE -X
    Route::get('/venueDash', 'VenueController@showAll');
    Route::get('/addVenue', 'VenueController@testgmap');
    Route::post('/saveVenue', 'VenueController@saveVenue');

    // --- GROUPING

    // - Add to queue
    // temp feeling
    Route::post('/groupUser/{id}', 'SystemController@addUserToTalkCircleQueue');
    // - Check queue
    Route::get('/checkQueue/{id}', 'SystemController@checkQueue3');

    Route::post('/groupFaci/{id}', 'SystemController@addFaciToTalkCircleQueue');

    // --- ONCE GROUPED
    Route::get('/selectActivities/{id}', 'SystemController@recommendActivities');
    Route::post('/submitActs/{id}', 'SystemController@saveActivities');
});
// });


