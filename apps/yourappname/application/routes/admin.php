<?php

// Instance
Route::get('admin/(:any)/(:num)/export', array('as' => 'app_export', 'uses' => 'admin@export'));
Route::get('admin/(:any)/(:num)/preview/(:num)/(:num?)', array('as' => 'app_preview', 'uses' => 'admin@preview'));
Route::get('admin/(:any)/(:num)/dragdrop/(:num)/(:num?)', array('as' => 'app_dragdrop', 'uses' => 'admin@drag_drop'));
Route::get('admin/(:any)/(:num)/info/(:any)', array('as' => 'app_info', 'uses' => 'admin@info'));
Route::get('admin/(:any)/product/(:num)/detail', array('as' => 'app_detail', 'uses' => 'admin@detail'));
Route::get('admin/(:any)/(:num)/restore/(:num)/(:num?)', array('as' => 'app_restore', 'uses' => 'admin@restore'));


// Settings
Route::get('admin/(:any)/(:num)/settings/(:any)/(:num)', array('as' => 'app_edit_settings', 'uses' => 'admin@edit_setting'));
//
Route::put('admin/(:any)/(:num)/settings', array('as' => 'app_save_settings', 'uses' => 'admin@update_setting'));
Route::put('admin/(:any)/target/(:num)', array('as' => 'app_update_target', 'uses' => 'admin@update_target'));


// Fields
Route::get('admin/(:any)/(:num)/fields/(:num?)', array('as' => 'app_list_fields', 'uses' => 'admin@fields'));
Route::get('admin/(:any)/(:num)/fields/(:num)/edit/(:num)', array('as' => 'app_edit_field', 'uses' => 'admin@edit_field'));
//
Route::post('admin/(:any)/(:num)/fields/draggable/(:num)', array('as' => 'app_create_draggable_field', 'uses' => 'admin@create_draggable_field'));
//
Route::put('admin/(:any)/(:num)/fields/(:num)/(:num?)', array('as' => 'app_update_field', 'uses' => 'admin@update_field'));
Route::put('admin/(:any)/(:num)/fields/reorder', array('as' => 'app_reorder_fields', 'uses' => 'admin@reorder_fields'));
Route::put('admin/(:any)/(:num)/fields/position/(:num)', array('as' => 'app_update_field_position', 'uses' => 'admin@update_field_position'));
//
Route::delete('admin/(:any)/(:num)/fields/(:num?)', array('as' => 'app_delete_field', 'uses' => 'admin@destroy_field'));

// Items
Route::get('admin/(:any)/items/new', array('as' => 'app_new_item', 'uses' => 'admin@new_item'));
Route::get('admin/(:any)/items/(:num)/edit', array('as' => 'app_edit_item', 'uses' => 'admin@edit_item'));
Route::get('admin/(:any)/results/(:num)/(:num)/(:num)', array('as' => 'app_preview_item_result', 'uses' => 'admin@results'));
//
Route::post('admin/(:any)/items', array('as' => 'app_create_item', 'uses' => 'admin@create_item'));
//
Route::put('admin/(:any)/items/(:num)', array('as' => 'app_update_item', 'uses' => 'admin@update_item'));
//
Route::delete('admin/(:any)/items/(:num)', array('as' => 'app_delete_item', 'uses' => 'admin@destroy_item'));