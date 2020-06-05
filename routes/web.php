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

Route::post('/books', 'BookController@store');
Route::patch('/books/{book}', 'BookController@update');
Route::delete('/books/{book}', 'BookController@destroy');
Route::post('/checkout/{book}', 'CheckoutBookController@store');
Route::post('/checkin/{book}', 'CheckinBookController@store');

Route::post('author', 'AuthorController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
