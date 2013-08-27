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

        $data = array();
        $targets = Target::with('age')->with('country')->with('language')->where_instance_id($instance->id)->order_by('id')->get();
        foreach($targets as $target) {
            $data[$target->id]['target'] = $target;
            $data[$target->id]['entries'] = Entry::with('storages')->where_instance_id($instance->id)->where_page_id(3)->where_target_id($target->id)->get();
            $data[$target->id]['labels'] = array ();
            $data[$target->id]['values'] = array ();
            foreach($data[$target->id]['entries'] as $entry) {
                foreach($entry->storages as $storage) {
                    $data[$target->id]['labels'][$storage->field_id] = $storage->label;
                    $data[$target->id]['values'][$entry->id][$storage->field_id] = $storage->value;
                }
            }
        }

        $this->data['instance'] = $instance;
        $this->data['table_data'] = $data;

        return View::make('graph.index', $this->data);
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

        $this->data['participants'] = Vote::where_instance_id($instance->id)->distinct('uid')->count('uid');

        return View::make('graph.participants', $this->data);
    }
}