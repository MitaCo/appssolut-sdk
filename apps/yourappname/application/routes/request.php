<?php

// Instance
Route::get('app/request/(:any)/invite', array('as' => 'invite_request', 'uses' => 'request@invite'));
Route::any('app', array('as' => 'response_request', 'uses' => 'request@response'));
