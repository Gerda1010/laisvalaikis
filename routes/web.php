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


Route::get('/dashboard', 'homeController@index')->middleware(['auth'])->name('dashboard');
Route::get('/', 'homeController@guest');



require __DIR__.'/auth.php';


//Route::get('send-email', [SendEmailController::class, 'index']);
//Route::get('/email', 'SendEmailController@create');
//Route::post('/email', 'SendEmailController@sendEmail')->name('send.email');
//Route::get('/demoMail', 'teamsController@index')->middleware(['auth']);



//Teams
Route::get('/teams', 'teamsController@index')->middleware(['auth']);
Route::get('/teamsRegistration', 'teamsController@teamsRegistration')->middleware(['auth'])->name('teamsRegistration');
Route::post('/insertTeam', 'teamsController@insertTeam')->middleware(['auth']);

Route::resource('appointments', 'AppointmentsController');
//Tournaments
Route::get('/tournaments', 'tournamentsController@index')->middleware(['auth']);

//Route::get('/tournaments', 'tournamentsController@index');
Route::get('/createTournament', 'tournamentsController@createTournament')->middleware(['auth']);
Route::post('/insertTournament', 'tournamentsController@insertTournament')->middleware(['auth'])->name('insertTournament');
Route::get('/tournament/{id}', 'tournamentsController@openTournament')->middleware(['auth']);
//Route::get('/registerToTournament', 'tournamentsController@registerToTournament');
Route::post('/createTournamentTeam/{id}', 'tournamentsController@createTournamentTeam')->middleware(['auth'])->name('createTournamentTeam');
Route::get('/createTournamentTeam/{id}', 'tournamentsController@createTournamentTeam')->middleware(['auth']);

Route::post('/createTournamentUser/{id}', 'tournamentsController@createTournamentUser')->middleware(['auth'])->name('createTournamentUser');
Route::get('/createTournamentUser/{id}', 'tournamentsController@createTournamentUser')->middleware(['auth']);

Route::post('/comment/{id}', 'tournamentsController@insertComment')->middleware(['auth'])->name('insertComment');

//Route::get('/startTournament/{id}', 'tournamentsController@startTournament')->name('startTournament');
Route::post('/startTournament/{id}', 'tournamentsController@startTournament')->middleware(['auth'])->name('startTournament');
Route::post('/startTournamentUsers/{id}', 'tournamentsController@startTournamentUsers')->middleware(['auth'])->name('startTournamentUsers');

Route::post('/insertResult/{id}','tournamentsController@insertResult')->middleware(['auth'])->name('insertResult');
Route::post('/insertResultUsers/{id}','tournamentsController@insertResultUsers')->middleware(['auth'])->name('insertResultUsers');

Route::post('/tournamentReservation/{id}', 'scheduleController@tournamentReservation')->middleware(['auth'])->name('tournamentReservation');
Route::get('/tournamentReservation/{id}', 'scheduleController@tournamentReservation')->middleware(['auth']);



//Profile
Route::get('/profile', 'profileController@index')->middleware(['auth']);
Route::get('/reservations/{id}', 'profileController@cancelReservation')->middleware(['auth'])->name('cancelReservation');

Route::get('change-password', 'profileController@changePassword')->middleware(['auth']);

Route::post('change-password', 'profileController@store')->middleware(['auth'])->name('change.password');



//Schedule
Route::get('/schedule', 'scheduleController@index');
//Route::post('/makeReservation', 'scheduleController@makeReservation')->middleware(['auth']);
//Route::get('/makeReservation', 'scheduleController@makeReservation')->middleware(['auth']);

Route::post('/makeReservation{time}/object{obj}/date{mytime}', 'scheduleController@makeReservation')->middleware(['auth']);
Route::get('/makeReservation{time}/object{obj}/date{mytime}', 'scheduleController@makeReservation')->middleware(['auth']);

Route::post('/byDate', 'scheduleController@byDate')->name('byDate');
Route::get('/byDate', 'scheduleController@byDate')->name('byDate');
Route::post('/byDateGuest', 'scheduleController@byDateGuest')->name('byDateGuest');
Route::get('/byDateGuest', 'scheduleController@byDateGuest')->name('byDateGuest');

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
