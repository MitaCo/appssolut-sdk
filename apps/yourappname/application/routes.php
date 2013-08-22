<?php

require 'routes/admin.php';
require 'routes/home.php';
require 'routes/graph.php';
require 'routes/request.php';

Route::controller(Controller::detect());


Route::filter('before', function()
{
  	header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
  	xssClean::globalXssClean();
});


Route::filter('after', function($response)
{
    //
});


Route::filter('csrf', function()
{
    if (Request::forged()) return Response::error('500');
});


Event::listen('404', function()
{
    return Response::error('404');
});


Event::listen('500', function()
{
    return Response::error('500');
});