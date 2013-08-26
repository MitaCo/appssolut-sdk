<?php

class Myapp_Home_Controller extends Sdk_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index($hash = null, $page_id = 3) {
        $instance = Instance::with('setting')->where_instance($this->getinstance($hash))->first();
        if (empty($instance)) {
            return View::make('notactive');
        }

        // Get current facebook user
        $fbuser = new Fbdata_Controller;

        if (empty($uid)) {
            return $fbuser->makelogin();
        }
        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page_id)
            ->where_null('button')
            ->order_by('position', 'asc')
            ->get();

        
        

        $this->data['instance'] = $instance;
        $this->data['page'] = $page_id;
        $this->data['fields'] = $fields;
        $this->data['invitelink'] = $fbuser->getInviteLink('You are invited for the voting');

        return View::make('home.index', $this->data);
    }
    

}