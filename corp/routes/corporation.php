<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    #jobs
    Route::get('jobs', 'App\Http\Controllers\Corporation\JobsController@index')->name('jobs.index');
    Route::match(['get', 'post'], 'jobs/add', 'App\Http\Controllers\Corporation\JobsController@add')->name('jobs.add');
    Route::match(['get', 'post'], 'jobs/edit', 'App\Http\Controllers\Corporation\JobsController@edit')->name('jobs.edit');
    Route::get('jobs/view', 'App\Http\Controllers\Corporation\JobsController@view')->name('jobs.view');
    Route::delete('jobs/delete', 'App\Http\Controllers\Corporation\JobsController@delete')->name('jobs.delete');
});
