<?php

Route::get('/', 'IndexController@index');

Route::group(['middleware' => 'auth'], function () {

    Route::resource('projects', 'ProjectsController');

    Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}', 'ProjectTasksController@update');

    Route::post( '/projects/{project}/invitations' , 'ProjectInvitationsController@store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
