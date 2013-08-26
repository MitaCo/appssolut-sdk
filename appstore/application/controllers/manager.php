<?php

class Manager_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index() {
        
        $applist = App::order_by('app_package_id', 'ASC')->get();
        
        $this->data['applist'] = $applist;
        return View::make('applist', $this->data);
    }

    public function get_add($id, $sure = true) {
        
        $input = array(
            'app_user_id' => 1,
            'app_app_id' => $id,
            'app_user_apps_publish_date' => date('Y-m-d H:i:s'),
            'app_user_apps_publish_page_id' => time() . 1 . $id,
            'app_apps_application_id' => $app->app_apps_application()->first()->id,
            'tab_title' => $app->app_apps_name,
        );
        $element = new App($input);
        $element->save();

        // dd($element);
        return Redirect::to_route('edit_manager', array($element->app_user_apps_publish_page_id, 1))->with('message', 'App added');
    }

    public function get_edit($id = NULL, $page = 3, $target = 1) {
        
        $element = App::where('app_user_apps_publish_page_id', '=', $id)->first();
        if (empty($element->app_user_id))
            return Redirect::to_route('manage_apps')->with('message', 'no app foud');
        
        $app = $element->app_app()->first();
        
        // dd($app);
        $this->data['app_name'] = $app->app_folder;
        $this->data['app_template'] = 1;
        $this->data['app_page'] = $page;
        $this->data['element'] = $element;
        $this->data['app_istance'] = $element->app_user_apps_publish_page_id;
        $this->data['app_lang'] = $target;
        return View::make('edit', $this->data);
    }

    public function get_detail($id = 1) {
        $element = App::where('app_user_apps_publish_page_id', '=', $id)->first();
        if (empty($element->app_user_id) || $element->app_user_id <> Auth::user()->id)
            return Redirect::to_route('manage_apps')->with('message', 'no app foud');
        // dd($element);
        
        $app = $element->app_app()->first();
        $this->data['app_istance'] = $element->app_user_apps_publish_page_id;
        $this->data['app'] = $app;
        $this->data['element'] = $element;
        // dd($app);
        $this->data['app_name'] = $app->app_apps_application()->first()->app_folder;
        return View::make('detail', $this->data);
    }

}