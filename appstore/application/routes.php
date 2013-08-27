<?php

Route::get('/', array('as' => 'manage_apps', 'uses' => 'manager@index'));
Route::get('manager/(:num)/edit/(:num?)/(:num?)', array('as' => 'edit_manager', 'uses' => 'manager@edit'));
Route::get('manager/(:num)/detail', array('as' => 'detail_manager', 'uses' => 'manager@detail'));
Route::get('manager/(:num)/add/(:any?)', array('as' => 'try_app', 'uses' => 'manager@add'));

Route::filter('before', function()
{    
    xssClean::globalXssClean();
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});
/*
Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});*/