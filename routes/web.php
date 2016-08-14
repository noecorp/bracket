<?php

// Authentication Routes
Route::auth();

// Admin "ANY" routes for the React application.
Route::group([
	'namespace' => 'Admin', 
	'prefix' => 'admin', 
	'middleware' => 'auth'], 
function() {
    Route::get('/', 'DashboardController@index');
	Route::get('/{any}', 'DashboardController@index')->where('any', '.*');
});

// The main site routes
Route::group(['namespace' => 'Site'], function() {
	Route::get('/', 'HomeController@index');

	Route::get('/teams', 'TeamController@index');
	Route::get('/teams/{id}', 'TeamController@show');

	Route::get('/players', 'PlayerController@index');
	Route::get('/players/{username}', 'PlayerController@show');

    Route::group(['prefix' => 'settings'], function() {
        Route::group(['prefix' => 'teams'], function() {
            Route::get('/', 'TeamController@index')->name('teams.index');
            Route::get('create', 'TeamController@create')->name('teams.create');
            Route::post('teams', 'TeamController@store')->name('teams.store');
            Route::get('edit/{id}', 'TeamController@edit')->name('teams.edit');
            Route::put('edit/{id}', 'TeamController@update')->name('teams.update');
            Route::delete('destroy/{id}', 'TeamController@destroy')->name('teams.destroy');
            Route::get('switch/{id}', 'TeamController@switchTeam')->name('teams.switch');

            Route::get('members/{id}', 'TeamMemberController@show')->name('teams.members.show');
            Route::get('members/resend/{invite_id}', 'TeamMemberController@resendInvite')->name('teams.members.resend_invite');
            Route::post('members/{id}', 'TeamMemberController@invite')->name('teams.members.invite');
            Route::delete('members/{id}/{user_id}', 'TeamMemberController@destroy')->name('teams.members.destroy');

            Route::get('accept/{token}', 'AuthController@acceptInvite')->name('teams.accept_invite');
        });
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index');