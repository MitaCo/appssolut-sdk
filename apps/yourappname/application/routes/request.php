<?php

// Instance
Route::get('app/request/(:any)/invite/(:any?)', array('as' => 'invite_request', 'uses' => 'request@invite'));
Route::any('app', array('as' => 'response_request', 'uses' => 'request@response'));

Route::get('app/refresh', array('as' => 'app_refresh', 'uses' => 'request@refresh'));
