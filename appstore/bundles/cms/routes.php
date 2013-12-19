<?php

//require path('bundle').'cms/routes/types.php';

// Forms
Route::get('cms/(:any)', 'cms::(:1)@index');
Route::get('cms/(:any)/(:num)/edit', 'cms::(:1)@edit');
Route::get('cms/(:any)/new', 'cms::(:1)@new');
// Actions
Route::post('cms/(:any)', 'cms::(:1)@create');
Route::put('cms/(:any)/(:num)', 'cms::(:1)@update');
Route::delete('cms/(:any)/(:num)', 'cms::(:1)@destroy');


Route::controller(Controller::detect('cms'));
