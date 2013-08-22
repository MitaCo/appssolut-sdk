<?php
/**
 * @author Han Lin Yap < http://yap.nu/ >
 * @copyright 2013 yap.nu
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 * @package Facebook SDK (Laravel Bundle)
 * @version 1.1 - 2013-01-22
 */

Autoloader::map(array(
	'Facebook' => Bundle::path('facebook-sdk').'facebook/facebook.php',
));

Laravel\IoC::singleton('facebook-sdk', function()
{
	$config = array();
	$config['appId'] =	APPSSOLUT_FB_APPID;
	$config['secret'] = APPSSOLUT_FB_SECRET;
	$config['fileUpload'] = true; // optional

	return new Facebook($config);
});
