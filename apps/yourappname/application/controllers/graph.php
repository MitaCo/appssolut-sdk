<?php
class Graph_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index($hash) {
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        $this->data['table_data'] = Myapp_Graph_Controller::get_graph_data($instance->id);

        return View::make('myapp::graph.index', $this->data);
    }

    public function get_visitors($hash) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        return View::make('graph.visitors', $this->data);
    }

    public function get_participants($hash) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        $this->data['participants'] = Entry::where_instance_id($instance->id)->distinct('uid')->count('uid');

        return View::make('graph.participants', $this->data);
    }
}