<?php

// Entries
Route::get('graph/(:any)', array('as' => 'app_show_results', 'uses' => 'graph@index'));
Route::get('graph/(:any)/visitors', array('as' => 'app_show_visitors', 'uses' => 'graph@visitors'));
Route::get('graph/(:any)/participants', array('as' => 'app_show_participants', 'uses' => 'graph@participants'));