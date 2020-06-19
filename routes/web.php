<?php

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Auth;
\Imtigger\LaravelJobStatus\ProgressController::routes();

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
//use \App\{Post, PostImage};

Route::get('/', function() {
    return view('welcome');
});

Route::get('/tela', function(){
    return view('tailwind');
});
// TODO: Remove - test de jobs
Route::get('/test', function () {
    TestJob::dispatch(12);
});

Route::group(['middleware' => 'auth.is_admin'], function($router) {
    $router->get('/chart', 'ChartController@index')->name('chart');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::group(['middleware'=>['web', 'auth']], function (){
    Route::resource('logs', 'JobLogController')->only(['index', 'show', 'destroy']);
    Route::get('/logs/{type}/{id}', 'JobLogController@showGroup');
    Route::get('/jobs', 'JobController@index')->name('jobs.index');
    Route::get('/jobs/watch', 'JobController@watch')->name('jobs.watch');
    Route::get('/job/{job}/show', 'JobController@show')->name('jobs.show');
    Route::get('/job/{job}', 'JobController@create')->name('jobs.create');
    Route::post('/job/{job}', 'JobController@store');

    Route::get('/dummyJob', 'JobController@dummyJob')->name('dummyJob');
});*/
//Route::resource('logs', 'JobLogController')->middleware('role:admin')->only(['index', 'show', 'destroy']);

//Route::resource('progress', 'ProgressController');