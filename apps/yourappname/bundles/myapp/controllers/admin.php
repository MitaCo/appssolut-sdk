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
        // Get application fields
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
}