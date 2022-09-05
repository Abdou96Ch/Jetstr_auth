<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {
Route::get('/dashboard', function () {return redirect('/'); });

Route::resource('post', 'PostController');
Route::delete('/post/delete/{slug}', 'PostController@delete')->name('post.delete');
Route::get('/post/restore/{slug}', 'PostController@restore')->name('post.restore');

});
