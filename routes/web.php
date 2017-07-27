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

Route::get('/', 'CoachesController@dashboard');

Route::get('/coaches', 'CoachesController@index');

Route::get('/coaches/create', 'CoachesController@create');

Route::get('/coaches/{user}/edit', 'CoachesController@edit');

Route::patch('/coaches/{user}', 'CoachesController@update');

Route::post('/coaches', 'CoachesController@store');

/**
 * TEAMS
 */

Route::get('/teams', 'TeamsController@index');

Route::get('/teams/create', 'TeamsController@create');

Route::post('/teams', 'TeamsController@store');

Route::get('/teams/{team}/edit', 'TeamsController@edit');

Route::patch('/teams/{team}', 'TeamsController@update');

/**
 * MEMBERS
 */

Route::get('/members', 'MembersController@index');

Route::get('/members/create', 'MembersController@create');

Route::post('/members', 'MembersController@store');

Route::get('/members/{member}/edit', 'MembersController@edit');

Route::patch('/members/{member}', 'MembersController@update');

/**
 * MEETINGS
 */

Route::get('/meetings', 'MeetingsController@index');

Route::get('/meetings/create', 'MeetingsController@create');

Route::post('/meetings', 'MeetingsController@store');

Route::get('/meetings/{meeting}/edit', 'MeetingsController@edit');

Route::patch('/meetings/{meeting}', 'MeetingsController@update');

/**
 * Authentication
 */

Route::get('/logout', function(){
    Auth::logout();
    return back();
});

Auth::routes();

/**
 * iCal
 */

Route::get('/ical/{meeting}', function(\App\Meeting $meeting){
    date_default_timezone_set('Europe/Berlin');

    $cal = new \Eluceo\iCal\Component\Calendar('acb.martinlehmann.com');

    $evt = new \Eluceo\iCal\Component\Event();

    $evt->setDtStart($meeting->date);
    $evt->setDtEnd($meeting->date->addMinutes(30));
    $evt->setSummary("Feedback Meeting " . $meeting->member->firstname . " + " . $meeting->user->name);
    $evt->setUseTimezone(true);
    $cal->addComponent($evt);

    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename="cal.ics"');

    echo $cal->render();
});