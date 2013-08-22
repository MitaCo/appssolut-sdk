<?php

class App extends Eloquent {

    public static $timestamps = true;
    public static $table = 'app_user_apps_publishes';
    public static $connection = 'sdk';

}