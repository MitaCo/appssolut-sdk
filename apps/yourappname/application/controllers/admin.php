<?php
class Admin_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index($hash = null, $page = 1) {
        //
    }

    // Preview in manager
    public function get_preview($hash = null, $page = 1, $template_id = 1, $target = 1) {
        if (empty($hash)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if(empty($instance)) {
            $this->initialize_instance($hash, $template_id);
            $instance = Instance::with('setting')->where_instance($hash)->first();
        }
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        // Disable pages according to instance settings
        if($page == 1 and !$instance->setting->fangate) {
            $this->data['msg'] = 'Fangate page is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }
        if($page == 2 and !$instance->setting->entry_form) {
            $this->data['msg'] = 'Entry form is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }
        // Get fields

        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->order_by('order', 'asc')
            ->get();
        

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['fangate'] = 0;
        $this->data['target_id'] = $target->id;
        $this->data['template_id'] = $template_id;
        $this->data['fields'] = $fields;

        return View::make('admin.preview', $this->data);
    }

    public function get_restore($hash = null, $page = 1, $template_id = 1, $target_id = 1) {
        $instance = Instance::where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $instance->fields()->storages()->delete();
        $instance->fields()->delete();
        $instance->allowedcountries()->delete();
        $instance->targets()->delete();
        $instance->entries()->delete();
        $instance->setting()->delete();
        $instance->delete();

        Session::flash('message', 'Application restored. ');
        return Response::json(array('message' => 'Application restored.'), 200);
    }

    public function get_drag_drop($hash = null, $page = 1, $template_id = 1, $target = 1) {
        if (empty($hash)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        // Disable pages according to instance settings
        if($page == 1 and !$instance->setting->fangate) {
            $this->data['msg'] = 'Fangate page is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }

        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->where_null('button')
            ->order_by('order', 'asc')
            ->get();

        // Exclude developer anchor and button
        $this->data['types'] = Type::where_not_in('id', array(19, 20))->get();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['target_id'] = $target->id;
        $this->data['fields'] = $fields;

        return View::make('admin.fields.manage', $this->data);
    }

    // Export results as .xls
    public function get_export($hash = null, $page = 1) {
        if (empty($hash)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $instance = Instance::where_instance($hash)->first();
        if (empty($instance)) {
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

        $table = View::make('admin.export', $this->data);
        $filename = $hash . '_' . date('Y-m-d-H-i-s') . '.xls';
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$filename");

        return $table;
    }

    public function get_info($hash, $page, $setting_type) {
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        switch ($setting_type) {

            case 'privacy':
                $this->data['title'] = 'Privacy';
                $this->data['text'] = $instance->setting->privacy;
                break;

            case 'terms':
                $this->data['title'] = 'Terms';
                $this->data['text'] = $instance->setting->terms;
                break;

            case 'roles':
                $this->data['title'] = 'Rules';
                $this->data['text'] = $instance->setting->roles;
                break;

            default:
                return Response::error(404);
                break;
        }

        return View::make('showinfo', $this->data);
    }


    /******************************************************** FIELDS ********************************************************/
    // Right side bar in manager
    public function get_fields($hash, $page, $target = 1) {
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }

        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_page_id($page)
            ->where_target_id($target->id)
            ->order_by('order', 'asc')
            ->get();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['fields'] = $fields;
        $this->data['target_id'] = $target->id;

        return View::make('admin.fields.list', $this->data);
    }

    public function get_edit_field($hash, $page, $field_id, $target) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        $field = Field::with('type')->where_instance_id($instance->id)->where_id($field_id)->order_by('order', 'asc')->first();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['field'] = $field;
        $this->data['target_id'] = $target->id;


        $this->data['terms_msg'] = false;
        $this->data['label'] = false;
        $this->data['value'] = false;
        $this->data['required'] = false;
        $this->data['colorpicker'] = false;
        switch($field->type->id) {

            case 1: // header-banner
                return View::make('admin.fields.edit_banner', $this->data);
                break;

            case 2: // text-header-2
            case 3: // text-header-3
            case 4: // text-paragraph
                $this->data['value'] = true;
                break;
            case 18: // submit-button
            case 19: // developer-anchor
            case 20: // developer-button
                $this->data['value'] = true;
                $this->data['colorpicker'] = true;
                break;

            case 6: // input-string
            case 7: // input-number
            case 8: // input-email
            case 9: // input-url
            case 10: // input-data
            case 11: // input-phone
            case 12: // input-checkbox
            case 13: // input-country
            case 14: // input-state-us
            case 15: // input-salutation
            case 16: // input-gender
            case 17: // input-textarea
                $this->data['value'] = true;
                $this->data['required'] = true;
                break;
            case 21: // input-accept-privacy
            case 22: // input-accept-terms
            case 23: // input-accept-rules
                $this->data['terms_msg'] = true;
                $this->data['value'] = true;
                $this->data['required'] = true;
                break;

            default:
                break;
        }

        return View::make('admin.fields.edit', $this->data);
    }

    public function put_update_field($hash, $page, $field_id, $target = 1) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        $field = Field::where_instance_id($instance->id)->find($field_id);
        if(empty($field)) {
            return Response::json(array('message' => 'Field not found'), 400);
        }

        $postdata = Input::all();
        foreach($postdata as $input) {
            if(is_array($input)) {
                $url = Helper::upload('value', $input, 'IMAGE');
                if (empty($url)) {
                    return Response::json(array('message' => 'Upload failed. Try another format. '), 400);
                }
                $field->value = $url;
                unset($postdata['value']);
            }
        }

        //update color of "button"
        if (!empty($postdata['property'])){
            $field->property = $postdata['colorpicker'];
            unset($postdata['colorpicker']);
            unset($postdata['property']);
        }

        $field->fill($postdata);
        //$field->target_id = $target->id;
        $field->page_id = $page;

        if ($field->save()) {
            Session::flash('message', $field->label.' updated. ');
            return Response::json(array('message' => $field->label.' updated. '), 200);
        }
        else {
            Session::flash('message', 'Error occurred, please try again. ');
            return Response::json(array('message' => 'Error occurred, please try again. '), 400);
        }
    }

    public function put_reorder_fields($hash, $page) {
        $postdata = Input::all();

        $field_1 = Field::find($postdata['id_1']);
        $field_2 = Field::find($postdata['id_2']);

        $temp_order = $field_1->order;
        $field_1->order = $field_2->order;
        $field_2->order = $temp_order;

        $field_1->save();
        $field_2->save();
    }

    // ****************************** DRAG AND DROP CREATE FIELD ****************************** \\
    public function post_create_draggable_field($hash, $page, $target = 1) {
        $instance = Instance::where_instance($hash)->first();
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        $postdata = Input::all();
        $type = Type::where_id($postdata['type_id'])->first();

        $label = $type->name;
        $value = $type->name;
        $property = NULL;

        switch($type->id) {

            case 1: // header-banner
                $value = 'img/default_banner.jpg';
                break;

            case 2: // text-header-2
            case 3: // text-header-3
                $value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
                break;
            case 4: // text-paragraph
                $value = 'Lorem ipsum dolor sit amet';
                break;

            case 18: // submit-button
                $value = 'Submit';
                break;

            case 19: // developer-anchor
                $value = '#';
                break;

            case 20: // developer-button
                $value = 'Click';
                break;

            case 21: // input-accept-privacy
                $value = 'I have read and accept the Privacy Policy';
                break;

            case 22: // input-accept-terms
                $value = 'I have read and accept the Terms and Conditions';
                break;

            case 23: // input-accept-rules
                $value = 'I have read and agree to the Official Rules';
                break;

            default:
                break;
        }

        // Update positions for fields to make space for the new field
        $fields = Field::where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->where('order', '>=', $postdata['position'])
            ->get();

        foreach($fields as $field) {
            $field->order = $field->order + 1;
            $field->save();
        }

        // Create new field
        $field = new Field();
        $field->instance_id = $instance->id;
        $field->type_id = $type->id;
        $field->fangate = 0;
        $field->label = $label;
        $field->value = $value;
        $field->order = $postdata['position'];
        $field->visible = 1;
        $field->editable = 1;
        $field->required = 1;
        $field->page_id = $page;
        $field->property = $property;
        $field->template_id = $instance->template_id;
        $field->target_id = $target->id;

        if ($field->save()) {
            return Response::json(array('message' => 'Field created', 'field_id' => $field->id), 200);
        }
        else {
            return Response::json(array('message' => 'Field not created'), 400);
        }
    }

    // ****************************** DRAG AND DROP UPDATE POSITION ****************************** \\
    public function put_update_field_position($hash, $page, $target = 1) {
        $instance = Instance::where_instance($hash)->first();
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        $postdata = Input::all();
        $old_pos = $postdata['old_position'];
        $new_pos = $postdata['new_position'];

        if ($old_pos > $new_pos) {
            $fields = Field::where_instance_id($instance->id)
                ->where_target_id($target->id)
                ->where_page_id($page)
                ->where('order', '>=', $new_pos)
                ->where('order', '<', $old_pos)
                ->get();

            foreach($fields as $field) {
                $field->order = $field->order + 1;
                $field->save();
            }
        } else {
            $fields = Field::where_instance_id($instance->id)
                ->where_target_id($target->id)
                ->where_page_id($page)
                ->where('order', '<=', $new_pos)
                ->where('order', '>', $old_pos)
                ->get();

            foreach($fields as $field) {
                $field->order = $field->order - 1;
                $field->save();
            }
        }

        $field = Field::find($postdata['field_id']);
        $field->order = $new_pos;

        if ($field->save()) {
            return Response::json(array('message' => 'Position updated'), 200);
        }
        else {
            return Response::json(array('message' => 'Position updated'), 400);
        }
    }

    public function delete_destroy_field($hash, $page, $target = 1) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }
        $target = Target::where_instance_id($instance->id)->where_id($target)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance->id)->order_by('id')->first();
        }
        $postdata = Input::all();
        $field = Field::where_instance_id($instance->id)->find($postdata['field_id']);

        if(empty($field)) {
            return Response::json(array('message' => 'Field not found'), 400);
        }

        if($field->delete()) {
            Session::flash('message', 'Field deleted. ');

            $fields = Field::where_instance_id($instance->id)->where_page_id($page)->where_target_id($target->id)->order_by('order', 'asc')->get();
            $i = 1;
            foreach ($fields as $field) {
                $field->order = $i++;
                $field->save();
            }

            return Response::json(array('message' => 'Field deleted'), 200);
        }
        else {
            return Response::json(array('message' => 'Field not deleted'), 400);
        }
    }
    /******************************************************** END FIELDS ****************************************************/


    /******************************************************** SETTINGS ******************************************************/
    public function get_edit_setting($hash, $page, $type, $target) {
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        switch($type) {

            case 'localization':
                $this->data['ages'] = Age::order_by('value')->lists('name', 'id');
                $this->data['countries'] = Country::order_by('id')->lists('name', 'id');
                $this->data['languages'] = Language::order_by('id')->lists('name', 'id');
                $this->data['targets'] = Target::where_instance_id($instance->id)->order_by('id')->get();
                $this->data['current_target_id'] = $target;
                break;

            case 'eligibility':
                $this->data['ages'] = Age::order_by('value')->lists('name', 'id');
                $this->data['countries'] = Country::order_by('id')->lists('name', 'id');
                $this->data['allowedcountries'] = Allowedcountry::where_instance_id($instance->id)->order_by('country_id')->lists('country_id', 'country_id');
                break;

            case 'date':
                $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                foreach($tzlist as $tz) {
                    $timezones[$tz] = $tz;
                }
                $this->data['timezones'] = $timezones;
                break;

            default:
                break;
        }

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['target_id'] = $target;

        return View::make('admin.settings.'.$type, $this->data);
    }

    public function put_update_setting($hash, $page) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        $postdata = Input::all();
        if(empty($postdata)) return;
        $success = false;
        $message = 'An error occurred, please try again. ';
        $returnval = null;
        foreach($postdata as $key => $input) {

            switch($key) {

                case 'fangate':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = $input;
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Fangate settings updated. ';
                    } else {
                        $success = false;
                        $message = 'Fangate settings not updated. ';
                    }
                    break;

                case 'entry_form':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = $input;
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Entry form settings updated. ';
                    } else {
                        $success = false;
                        $message = 'Entry form settings not updated. ';
                    }
                    break;

                case 'css':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);
                    if ($setting->save()) {
                        $success = true;
                        $message = 'CSS updated. ';
                    } else {
                        $success = false;
                        $message = 'CSS not updated. ';
                    }
                    break;
                case 'value': // Background image
                    if (!empty($input['name'])) {
                        $setting = Setting::where_instance_id($instance->id)->first();
                        $url = Helper::upload('value', $input, 'IMAGE');
                        if (empty($url)) {
                            $success = false;
                            $message = 'Upload failed. Try another format. ';
                            break;
                        }
                        $setting->background = $url;
                        unset($postdata['value']);

                        if ($setting->save()) {
                            unset($postdata['value']);
                            $success = true;
                            $message = 'Background image saved. ';
                        } else {
                            $success = false;
                            $message = 'Background image not saved. ';
                        }
                    }
                    break;
                case 'property':
                        $setting = Setting::where_instance_id($instance->id)->first();
                        $setting->background = $postdata['colorpicker'];
                        //unset($postdata['value']);

                        if ($setting->save()) {
                            unset($input);
                            $success = true;
                            $message = 'Background color saved. ';
                        } else {
                            $success = false;
                            $message = 'Background color not saved. ';
                        }
                    break;

                case 'age': // Advanced targeting
                    // Check if target combination exists
                    $active_targets = Target::where_instance_id($instance->id)->get();
                    $target_exists = FALSE;
                    foreach ($active_targets as $active_target) {
                        if ($active_target->language_id == $postdata['language']
                            && $active_target->country_id == $postdata['country']
                            && $active_target->age_id == $postdata['age']) {
                            $target_exists = TRUE;
                            $returnval = $active_target->id;
                            break;
                        }
                    }

                    if ($target_exists) {
                        $success = false;
                        $message = 'This targeting combination already exists. ';
                        break;
                    }

                    $default_target = Target::where_instance_id($instance->id)
                        ->where_language_id(1)
                        ->where_country_id(1)
                        ->where_age_id(1)
                        ->first();

                    $original_fields = Field::where_instance_id($instance->id)->where_target_id($default_target->id)->get();
                    $new_target = $this->create_instance_localization($original_fields, $instance->id, $postdata);

                    unset($postdata['language']);
                    unset($postdata['country']);
                    unset($postdata['age']);
                    unset($postdata['title']);
                    unset($postdata['active']);

                    $returnval = $new_target->id;
                    $success = true; // assuming
                    $message = 'Target created. Showing target group: '.$new_target->title;
                    break;

                case 'min_age': // Campaign eligibility minimum age
                    $success = true;
                    $message = 'Campaign eligibility updated. ';

                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->age_id = $postdata['min_age'];

                    if (!$setting->save()) {
                        $success = false;
                        $message = 'Campaign eligibility not updated. ';
                    }

                    // Campaign eligibility allowed countries
                    Allowedcountry::where_instance_id($instance->id)->delete();
                    if (!isset($postdata['allowedcountries'])) {
                        $postdata['allowedcountries'][0] = 1;
                    }
                    foreach ($postdata['allowedcountries'] as $country_id) {
                        $allowedcountry = new Allowedcountry();
                        $allowedcountry->instance_id = $instance->id;
                        $allowedcountry->country_id = $country_id;
                        if (!$allowedcountry->save()) {
                            $success = false;
                            $message = 'Campaign eligibility not updated. ';
                        }
                    }

                    unset($postdata['min_age']);
                    unset($postdata['allowedcountries']);

                    break;

                case 'privacy':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Privacy updated. ';
                    } else {
                        $success = false;
                        $message = 'Privacy not updated. ';
                    }
                    break;
                case 'terms':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Terms updated. ';
                    } else {
                        $success = false;
                        $message = 'Terms not updated. ';
                    }
                    break;
                case 'roles':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Rules updated. ';
                    } else {
                        $success = false;
                        $message = 'Rules not updated. ';
                    }
                    break;

                default:
                    break;
            }
        }

        if ($success) {
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 200);
        }
        else {
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 400);
        }
    }

    public function put_update_target($hash, $target_id) {
        $instance = Instance::where_instance($hash)->first();
        if(empty($instance)) {
            return Response::json(array('message' => 'Instance not found'), 400);
        }

        $postdata = Input::all();

        $target = Target::where_instance_id($instance->id)->where_id($target_id)->first();
        if (empty($target)) {
            $message = 'Target group not found. ';
            $returnval = null;
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 400);
        } else if ($target->default) {
            $message = 'Showing target group: '.$target->title;
            $returnval = $target->id;
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 200);
        }

        $active_targets = Target::where_instance_id($instance->id)->where_not_in('id', array($target->id))->get();
        foreach ($active_targets as $active_target) {
            if ($active_target->language_id == $postdata['language']
                && $active_target->country_id == $postdata['country']
                && $active_target->age_id == $postdata['age']) {

                $message = 'This targeting combination already exists. Try a different combination. ';
                $returnval = null;
                Session::flash('message', $message);
                return Response::json(array('message' => $message, 'val' => $returnval), 400);
            }
        }

        $target->language_id = $postdata['language'];
        $target->country_id = $postdata['country'];
        $target->age_id = $postdata['age'];
        $target->title = $postdata['title'];
        $target->active = $postdata['active'];

        if ($target->save()) {
            $message = 'Target updated. Showing target group: '.$target->title;
            $returnval = $target->id;
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 200);
        }
        else {
            $message = 'Target not updated. Showing target group: '.$target->title;
            $returnval = null;
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 400);
        }
    }
    /******************************************************** END SETTINGS **************************************************/



    private function initialize_instance($hash, $template_id) {

        // Create instance
        $instance = new Instance();
        $instance->instance = $hash;
        $instance->save();

        $allowedcountry = new Allowedcountry();
        $allowedcountry->instance_id = $instance->id;
        $allowedcountry->country_id = 1;
        $allowedcountry->save();

        $target = new Target();
        $target->instance_id = $instance->id;
        $target->title = 'Default';
        $target->active = 1;
        $target->default = 1;
        $target->save();

        // Create instance settings
        $setting = new Setting();
        $setting->instance_id = $instance->id;
        $setting->title = Template::find($template_id)->name;
        $setting->css = '';
        $setting->fangate = 1;
        $setting->entry_form = 1;
        $setting->background = URL::to('templates/'.$template_id.'/background.jpg');
        $setting->template_id = $template_id;
        $setting->age_id = 1;
        $setting->save();

        // Fangate
        $fakes = DB::table('fakes')->where_in('id', array (1))->order_by('order')->get();
        $this->create_fields_from_fakes($fakes, $instance->id, 1, $template_id, 'fangate.jpg', $target->id);

        // Entry-form
        $fakes = DB::table('fakes')->where_in('id', array (2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14))->order_by('order')->get();
        // $this->create_fields_from_fakes($fakes, $instance->id, 2);
        $this->create_fields_from_fakes($fakes, $instance->id, 2, $template_id, 'header.jpg', $target->id);

        // Application fields
        $fakes = DB::table('fakes')->where_in('id', array (15, 16, 17))->order_by('order')->get();
        //$this->create_fields_from_fakes($fakes, $instance->id, 3);
        $this->create_fields_from_fakes($fakes, $instance->id, 3, $template_id, 'header.jpg', $target->id);
        // Sort buttons
        $fakes = DB::table('fakes')->where_in('id', array (18, 19, 20, 21, 22))->order_by('order')->get();
        //$this->create_fields_from_fakes($fakes, $instance->id, 3, 0);
        $this->create_fields_from_fakes($fakes, $instance->id, 3, $template_id, '', $target->id, 0);
        // Item buttons
        $fakes = DB::table('fakes')->where_in('id', array (23, 24, 25, 26, 27, 28))->order_by('order')->get();
        //  $this->create_fields_from_fakes($fakes, $instance->id, 3, 0);
        $this->create_fields_from_fakes($fakes, $instance->id, 3, $template_id, '', $target->id, 0);

        // Thank you
        $fakes = DB::table('fakes')->where_in('id', array (29, 30))->order_by('order')->get();
        //$this->create_fields_from_fakes($fakes, $instance->id, 4);
        $this->create_fields_from_fakes($fakes, $instance->id, 4, $template_id, 'thankyou.jpg', $target->id);

        
    }

    private function create_fields_from_fakes($fakes, $instance_id, $page_id, $template_id, $image, $target_id, $editable = 1) {
        $i = 1;
        foreach ($fakes as $fake) {
            $field = new Field();
            $field->instance_id = $instance_id;
            $field->type_id = $fake->type_id;
            $field->fangate = 0;
            $field->label = $fake->label;
            $field->button = $fake->button;
            if ($i == 1 and !empty($image)) {
                $field->value = URL::to('templates/'.$template_id.'/'.$image);
            } else {
                $field->value = $fake->value;
            }

            $field->order = $i++;
            $field->visible = 1;
            $field->editable = $editable;
            $field->required = 1;
            $field->page_id = $page_id;
            $field->property = $fake->property;
            $field->template_id = $fake->template_id;
            $field->target_id = $target_id;
            $field->info = $fake->info;
            $field->save();
        }
    }

    private function create_instance_localization($original_fields, $instance_id, $postdata) {
        $target = new Target();
        $target->instance_id = $instance_id;
        $target->language_id = $postdata['language'];
        $target->country_id = $postdata['country'];
        $target->age_id = $postdata['age'];
        $target->title = $postdata['title'];
        $target->active = $postdata['active'];
        $target->default = 0;
        $target->save();

        foreach ($original_fields as $original_field) {
            $field = new Field();
            $field->instance_id = $original_field->instance_id;
            $field->type_id = $original_field->type_id;
            $field->fangate = $original_field->fangate;
            $field->button = $original_field->button;
            $field->label = $original_field->label;
            $field->value = $original_field->value;
            $field->order = $original_field->order;
            $field->visible = $original_field->visible;
            $field->editable = $original_field->editable;
            $field->required = $original_field->required;
            $field->page_id = $original_field->page_id;
            $field->property = $original_field->property;
            $field->template_id = $original_field->template_id;
            $field->target_id = $target->id;
            $field->info = $target->info;
            $field->save();
        }

        return $target;
    }
}