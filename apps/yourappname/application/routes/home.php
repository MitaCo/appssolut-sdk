<?php


$fbapps = array('01','02', '03', '04', '05');
$fbid = URI::segment(1);
// dd(URI);
if(in_array($fbid, $fbapps)){
	Route::group(array('prefix' => $fbid), function()
	{
		// fb route
		define('FB_NAMESPACE', URI::segment(1));
		//
		Route::any(FB_NAMESPACE.'/(:any?)', array('as' => 'app_load', 'uses' => 'home@index'));
		Route::post(FB_NAMESPACE.'/(:any)/send', array('before' => 'csrf', 'as' => 'app_create_entry', 'uses' => 'home@send'));

	});
}else{
	// minisite or mobile access
	// Home
	Route::any('(:any)', array('as' => 'app_load', 'uses' => 'home@index'));
	// Entries
	Route::post('(:any)/send', array('before' => 'csrf', 'as' => 'app_create_entry', 'uses' => 'home@send'));
}