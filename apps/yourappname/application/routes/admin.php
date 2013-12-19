<?php

// Instance
Route::get('admin/(:any)/(:num)/preview/(:num)/(:num?)', array('as' => 'app_preview', 'uses' => 'admin@preview'));
Route::get('admin/(:any)/(:num)/export', array('as' => 'app_export', 'uses' => 'admin@export'));
Route::get('admin/(:any)/(:num)/restore/(:num)/(:num?)', array('as' => 'app_restore', 'uses' => 'admin@restore'));
Route::get('admin/pages', array('as' => 'app_pages', 'uses' => 'admin@pages'));

// Fields
Route::get('admin/(:any)/(:num)/fields/(:num?)', array('as' => 'app_list_fields', 'uses' => 'admin@fields'));
Route::get('admin/(:any)/(:num)/fields/(:num)/edit/(:num)', array('as' => 'app_edit_field', 'uses' => 'admin@edit_field'));
Route::get('admin/(:any)/(:num)/dragdrop/(:num)/(:num?)', array('as' => 'app_dragdrop', 'uses' => 'admin@drag_drop'));
Route::get('admin/(:any)/(:num)/multitargeting/(:num)/(:num?)', array('as' => 'app_multitarget', 'uses' => 'admin@multitargeting'));

//
Route::post('admin/(:any)/(:num)/fields/draggable/(:num)', array('as' => 'app_create_draggable_field', 'uses' => 'admin@create_draggable_field'));
//
Route::put('admin/(:any)/(:num)/fields/(:num)/(:num?)', array('as' => 'app_update_field', 'uses' => 'admin@update_field'));
Route::put('admin/(:any)/(:num)/fields/position/(:num)', array('as' => 'app_update_field_position', 'uses' => 'admin@update_field_position'));
//
Route::delete('admin/(:any)/(:num)/fields/(:num?)', array('as' => 'app_delete_field', 'uses' => 'admin@destroy_field'));

// Settings
Route::get('admin/(:any)/(:num)/info/(:any)', array('as' => 'app_info', 'uses' => 'admin@info'));
Route::get('admin/(:any)/(:num)/settings/(:any)/(:num)', array('as' => 'app_edit_settings', 'uses' => 'admin@edit_setting'));
//
Route::put('admin/(:any)/(:num)/settings', array('as' => 'app_save_settings', 'uses' => 'admin@update_setting'));
Route::put('admin/(:any)/target/(:num)', array('as' => 'app_update_target', 'uses' => 'admin@update_target'));

// get_active_target
Route::get('admin/(:any)/gettarget/(:num?)', array('as' => 'app_get_target', 'uses' => 'admin@active_target'));