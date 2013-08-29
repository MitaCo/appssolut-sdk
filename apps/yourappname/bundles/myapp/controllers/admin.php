<?php
class Myapp_Admin_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index($hash = null, $page = 1) {
        //
    }

    // Appstore manager iFrame preview
    public static function get_preview($instance, $page, $template_id, $target_id) {
        // Get application fields for the preview
        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target_id)
            ->where_page_id($page)
            ->order_by('position', 'asc')
            ->get();

        $data['instance'] = $instance;
        $data['page'] = $page;
        $data['template_id'] = $template_id;
        $data['target_id'] = $target_id;
        $data['fields'] = $fields;

        return View::make('myapp::admin.preview', $data);
    }

    // Application field list in manager right sidebar
    public static function get_fields($instance, $page, $target_id) {
        // Get application fields
        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_page_id($page)
            ->where_target_id($target_id)
            ->order_by('position', 'asc')
            ->get();

        return $fields;
    }

    // Export data to .xls in appstore detail
    public static function get_export_data($instance_id) {
        // Prepare entry form data for table
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
        // This data will be displayed in views/admin/export.blade.php
        return $data;
    }
}