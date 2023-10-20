<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/login', [App\Http\Controllers\UserLoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserLoginController::class, 'postLogin'])->name('post_login');
Route::get('/signout', [App\Http\Controllers\UserLoginController::class, 'signout'])->name('signout');

Route::prefix('/')->middleware('user')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('/', 'App\Http\Controllers\UserController@index');
    Route::get('profile', 'App\Http\Controllers\UserController@profile')->name('profile');
    Route::resource('messages', App\Http\Controllers\MessagesController::class);
    Route::resource('assignments', App\Http\Controllers\AssignmentController::class);
    Route::resource('submissions', App\Http\Controllers\SubmissionController::class);
    Route::resource('challenges', App\Http\Controllers\ChallengeController::class);
    Route::resource('handles', App\Http\Controllers\HandleController::class);

});