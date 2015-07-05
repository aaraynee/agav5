<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PagesController@index');
Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');


Route::get('rankings', 'PagesController@rankings');

/*
|--------------------------------------------------------------------------
| Player Routes
|--------------------------------------------------------------------------
*/
Route::get('players', 'PlayerController@all');
Route::get('player/{slug}', ['uses' => 'PlayerController@single', 'as' => 'player']);


/*
|--------------------------------------------------------------------------
| Season Routes
|--------------------------------------------------------------------------
*/
Route::get('seasons', 'SeasonController@all');
Route::get('season/{slug}', ['uses' => 'SeasonController@single', 'as' => 'season']);


/*
|--------------------------------------------------------------------------
| Tournament Routes
|--------------------------------------------------------------------------
*/
Route::get('schedule', 'TournamentController@all');
Route::get('tournament/{slug}', ['uses' => 'TournamentController@single', 'as' => 'tournament']);


/*
|--------------------------------------------------------------------------
| Course Routes
|--------------------------------------------------------------------------
*/
Route::get('courses', 'CourseController@all');
Route::get('course/{slug}', ['uses' => 'CourseController@single', 'as' => 'course']);


Route::get('{slug}', ['uses' => 'SeasonController@single', 'as' => 'season']);
