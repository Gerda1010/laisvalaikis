<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\SendEmailController;
use App\Models\State;
use App\Models\Game;
use App\Models\Tournament;
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

//Route::get('/', function () {
//    $allTourn = Tournament::where('State','=',3)
//        ->orWhere('State','=', 5)
//        ->get();
//
//    $allGames = Game::all();
//    $allStates = State::all();
//
//    return view('welcome', compact('allTourn', 'allGames', 'allStates'));
//});

//Route::get('/dashboard', function () {
////    $allTourn = Tournament::where('State','=',3)->orWhere('State','=', 5)->get();
////    $allGames = Game::all();
////    $allStates = State::all();
//    return view('dashboard', compact('allTourn', 'allGames', 'allStates'));
//})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', 'homeController@index')->middleware(['auth'])->name('dashboard');
Route::get('/', 'homeController@guest');



require __DIR__.'/auth.php';


Route::get('send-email', [SendEmailController::class, 'index']);



//Teams
Route::get('/teams', 'teamsController@index');
Route::get('/teamsRegistration', 'teamsController@teamsRegistration')->name('teamsRegistration');
Route::post('/insertTeam', 'teamsController@insertTeam');

Route::resource('appointments', 'AppointmentsController');
//Tournaments
Route::get('/tournaments', 'tournamentsController@index');
Route::get('/createTournament', 'tournamentsController@createTournament');
Route::post('/insertTournament', 'tournamentsController@insertTournament')->name('insertTournament');
Route::get('/tournament/{id}', 'tournamentsController@openTournament');
//Route::get('/registerToTournament', 'tournamentsController@registerToTournament');
Route::post('/createTournamentTeam/{id}', 'tournamentsController@createTournamentTeam')->name('createTournamentTeam');
Route::get('/createTournamentTeam/{id}', 'tournamentsController@createTournamentTeam');
Route::post('/comment/{id}', 'tournamentsController@insertComment')->name('insertComment');

//Route::get('/startTournament/{id}', 'tournamentsController@startTournament')->name('startTournament');
Route::post('/startTournament/{id}', 'tournamentsController@startTournament')->name('startTournament');
Route::post('/insertResult/{id}','tournamentsController@insertResult')->name('insertResult');




//Profile
Route::get('/profile', 'profileController@index');
Route::get('/reservations/{id}', 'profileController@cancelReservation')->name('cancelReservation');

Route::get('change-password', 'profileController@changePassword');

Route::post('change-password', 'profileController@store')->name('change.password');



//Schedule
Route::get('/schedule', 'scheduleController@index');
Route::post('/makeReservation', 'scheduleController@makeReservation');


//Admino useriams
Route::get('/userList', 'adminUsersController@index');
Route::get('/users/{id}', 'adminUsersController@deleteUser')->name('deleteUser');
//Route::post('/usersList', 'adminUsersController@users');
Route::get('/users/editUser/{id}', 'adminUsersController@editUser')->name('editUser');
Route::post('/confirmEditedUser/{id}', 'adminUsersController@confirmEditedUser')->name('confirmEditedUser');


Route::post('/insertUser', 'adminUsersController@insertUser')->name('insertUser');
Route::get('/addUser', 'adminUsersController@addUser')->name('addUser');

//Admino objektams
Route::get('/objectList', 'adminObjectsController@index')->name('objectList');
Route::get('/objects/{id}', 'adminObjectsController@deleteObject')->name('deleteObject');
Route::get('/editObject/{id}',  'adminObjectsController@editObject')->name('editObject');
Route::post('/confirmEditedObject/{id}', 'adminObjectsController@confirmEditedObject')->name('confirmEditedObject');
Route::post('/insertObject', 'adminObjectsController@insertObject')->name('insertObject');
Route::get('/addObject', 'adminObjectsController@addObject')->name('addObject');

//Admino zaidimams
Route::get('/games/{id}', 'adminObjectsController@deleteGame')->name('deleteGame');
Route::post('/insertGame', 'adminObjectsController@insertGame')->name('insertGame');
Route::get('/addGame', 'adminObjectsController@addGame')->name('addGame');
