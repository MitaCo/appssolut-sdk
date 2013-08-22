<?php

$appssolute = array(
    'APPSOLUTE_FOLDER' => 'yourappname',
    'APPSOLUTE_APPID' => '1',    
);
foreach ($appssolute as $key => $value) {
	if (!defined($key)) 
		define($key, $value);
}
