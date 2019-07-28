<?php

Route::get('/', 'IndexController@index');

Route::group(['middleware'=>'auth'],function () {
    Route::get('/projects' , 'ProjectsController@index');
    Route::get('/projects/create/' , 'ProjectsController@create');
    Route::get('/projects/{id}' , 'ProjectsController@show');

    Route::post('/projects' , 'ProjectsController@store');

    Route::patch('/projects/{project}' , 'ProjectsController@update');

    Route::post('/projects/{project}/tasks' , 'ProjectTasksController@store');
    Route::patch('/projects/{project}/tasks/{task}' , 'ProjectTasksController@update');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
