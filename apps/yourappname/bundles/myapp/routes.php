<?php

$fbapps = array('01','02', '03', '04', '05');
$fbid = URI::segment(1);
// dd(URI);
if(in_array($fbid, $fbapps)){
	Route::group(array('prefix' => $fbid), function()
	{
		// fb route
		define('FB_NAMESPACE', URI::segment(1));
		Route::any(FB_NAMESPACE.'/(:num)', array('as' => 'app_show', 'uses' => 'myapp::home@index'));

	});
}else{
	// minisite or mobile access
	// Home
	Route::any('(:num)/(:num)', array('as' => 'app_show', 'uses' => 'myapp::home@index'));
}

Route::controller(Controller::detect('myapp'));