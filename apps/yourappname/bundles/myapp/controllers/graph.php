<?php
class Myapp_Graph_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    // Entry form data displayed in appstore detail
    public static  function get_graph_data($instance_id) {
        $data = array();
        $targets = Target::with('age')->with('country')->with('language')->where_instance_id($instance_id)->order_by('id')->get();
        foreach($targets as $target) {
            $data[$target->id]['target'] = $target;
            $data[$target->id]['entries'] = Entry::with('storages')->where_instance_id($instance_id)->where_page_id(2)->where_target_id($target->id)->get();
            $data[$target->id]['labels'] = array ();
            $data[$target->id]['values'] = array ();
            foreach($data[$target->id]['entries'] as $entry) {
                foreach($entry->storages as $storage) {
                    $data[$target->id]['labels'][$storage->field_id] = $storage->label;
                    $data[$target->id]['values'][$entry->id][$storage->field_id] = $storage->value;
                }
            }
        }
        // This data will be loaded in views/graph/index.blade.php
        return $data;
    }
}