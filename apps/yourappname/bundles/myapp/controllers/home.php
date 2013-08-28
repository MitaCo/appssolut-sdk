<?php

class Myapp_Home_Controller extends Sdk_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index($hash, $page_id) {
        $instance = Instance::with('setting')->where_instance($this->getinstance($hash))->first();
        if (empty($instance)) {
            return View::make('notactive');
        }

        $fbuser = new Fbdata_Controller;
        $target = $this->find_target_for($instance, $fbuser);

        if (empty($uid)) {
            //return $fbuser->makelogin();
        }

        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page_id)
            ->order_by('position', 'asc')
            ->get();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page_id;
        $this->data['fields'] = $fields;

        return View::make('myapp::home.index', $this->data);
    }
}