<?php

use Illuminate\Support\Facades\Route;



Route::group(['as'=>'web-client.','middleware'=>'auth'], function(){

    Route::get('/','WebClientController@index')->name('home'); 
    Route::get('/change-password','WebClientController@changePasswordForm')->name('change-password'); 
    Route::post('/change-password','WebClientController@changePassword')->name('store-new-password'); 
    Route::get('/user-logout','WebClientController@logout')->name('user-logout'); 
    

    Route::group(['prefix' => 'books'], function () {
        Route::get('/','WebClientController@books')->name('books');
        Route::get('/view/{id}','WebClientController@viewBook')->name('books.view');
        Route::get('/download/{id}','WebClientController@download')->name('books.download');
        Route::get('/author/{id}','WebClientController@author')->name('author');
        Route::get('/authors','WebClientController@authors')->name('authors');
        Route::get('/read/{id}','WebClientController@read')->name('books.read');
        Route::get('/recommended','WebClientController@recommended')->name('books.recommended');
        Route::get('/search','WebClientController@search')->name('books.search');

        Route::get('/terms-and-contitions','WebClientController@tac')->name('tac');
        Route::get('/privacy-policy','WebClientController@pp')->name('pp');
    });

    Route::get('home',function(){return redirect('/');});
});

Auth::routes(['verify' => true]);