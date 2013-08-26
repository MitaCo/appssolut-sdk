<?php
require_once('bundles/appstore/controllers/search.php');

class Index_task {

  public function run(){

  }

  public function reindex(){
    $apps = App_App::where('status','=','A')->get();
    Bundle::start('httpful');
    echo "Indexing apps:\n";
    foreach($apps as $app){
      echo "Indexing app {$app->attributes['app_apps_name']}\n";
      Appstore_Search_Controller::addIndex($app->attributes['id'], 'app');
    }
    $packs = App_Package::all();
    echo "Indexing packages:\n";
    foreach($packs as $pkg){
      echo "Indexing package {$pkg->attributes['app_package_name']}\n";
      Appstore_Search_Controller::addIndex($pkg->attributes['id'], 'pkg');
    }
  }

  public function app($arguments){
    if ($arguments[0]){
      Bundle::start('httpful');
      $id = (int)$arguments[0];
      echo Appstore_Search_Controller::addIndex($id, 'app');
    } else die("Enter id of application i.e. \"php artisan index:app 1\" or use reindex\n");
  }

  public function package($arguments){
    if ($arguments[0]){
      Bundle::start('httpful');
      $id = (int)$arguments[0];
      echo Appstore_Search_Controller::addIndex($id, 'pkg');
    } else die("Enter id of package i.e. \"php artisan index:package 1\" or use reindex\n");
  }
}