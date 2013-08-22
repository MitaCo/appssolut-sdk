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

        $items = Item::forResults($instance->id);
        $all_items = Item::where_instance_id($instance->id)->get();
        $votes = array ();
        foreach($all_items as $item) {
            $votes[$item->id] = Vote::where_instance_id($instance->id)->where_item_id($item->id)->count();
        }
        $last_vote = array ();
        foreach($all_items as $item) {
            $vote = Vote::where_instance_id($instance->id)->where_item_id($item->id)->order_by('created_at', 'desc')->first();
            if (empty($vote)) {
                $last_vote[$item->id] = '';
            } else {
                $last_vote[$item->id] = $vote->created_at;
            }

        }

        $this->data['instance'] = $instance;
        $this->data['items'] = $items;
        $this->data['votes'] = $votes;
        $this->data['last_vote'] = $last_vote;

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