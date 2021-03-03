<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::get('posts', 'App\Http\Controllers\PostController@index')->name('api.v1.posts');
    Route::get('authors', 'App\Http\Controllers\AuthorController@index')->name('api.v1.authors');
});