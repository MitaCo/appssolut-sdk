<?php
class Admin_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_index($hash = null, $page = 1) {
        //
    }

    // Appstore manager iFrame preview
    public function get_preview($hash = null, $page = 1, $template_id = 1, $target_id = 1) {
        // Verify application instance
        if (empty($hash)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }
        $instance = Instance::with('setting')->where_instance($hash)->first();

        // Create new instance if it does not exist
        if (empty($instance)) {
            $this->initialize_instance($hash, $template_id);
            $instance = Instance::with('setting')->where_instance($hash)->first();
        }

        // Show message if fangate and/or entry form is disabled
        if ($page == 1 and !$instance->setting->fangate) {
            $this->data['msg'] = 'Fan gate page is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }
        if ($page == 2 and !$instance->setting->entry_form) {
            $this->data['msg'] = 'Entry form is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }

        // Get target(ing)
        $target = $this->get_target($instance->id, $target_id);

        if ($page > 2) {
            return Myapp_Admin_Controller::get_preview($instance, $page, $template_id, $target->id);
        }

        // Get application fields
        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->order_by('position', 'asc')
            ->get();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['template_id'] = $template_id;
        $this->data['target_id'] = $target->id;
        $this->data['fields'] = $fields;

        return View::make('admin.preview', $this->data);
    }

    // Export button
    public function get_export($hash = null, $page = 1) {
        // Verify application instance
        if (empty($hash)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $this->data['table_data'] = Myapp_Admin_Controller::get_export_data($instance->id);

        $table = View::make('myapp::admin.export', $this->data);
        $filename = $hash . '_' . date('Y-m-d-H-i-s') . '.xls';
        header("Content-type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$filename");

        // Download .xls file
        return $table;
    }

    // Restore application to original settings
    public function get_restore($hash = null, $page = 1, $template_id = 1, $target_id = 1) {
        // Verify application instance
        $instance = Instance::where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $fields = Field::where_instance_id($instance->id)->get();
        foreach ($fields as $field) {
            $field->storages()->delete();
            $field->delete();
        }
        $instance->allowedcountries()->delete();
        $instance->targets()->delete();
        $instance->entries()->delete();
        $instance->setting()->delete();
        $instance->delete();

        Session::flash('message', 'Application restored.');

        return Response::json(array('message' => 'Application restored.'), 200);
    }

    // Get application pages for appstore
    public function get_pages() {
        $pages = Page::order_by('id')->lists('name', 'id');

        return Response::json(array('pages' => $pages), 200);
    }



    /*******************************************************************************************************************
     * APPLICATION FIELDS
     ******************************************************************************************************************/

    // Application field list in manager right sidebar
    public function get_fields($hash, $page, $target_id = 1) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $target = $this->get_target($instance->id, $target_id);

        if ($page > 2) {
            $fields = Myapp_Admin_Controller::get_fields($instance, $page, $target->id);
        } else {
            $fields = Field::with('type')
                ->where_instance_id($instance->id)
                ->where_page_id($page)
                ->where_target_id($target->id)
                ->order_by('position', 'asc')
                ->get();
        }

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['target_id'] = $target->id;
        $this->data['fields'] = $fields;

        return View::make('admin.fields.list', $this->data);
    }

    // Edit field
    public function get_edit_field($hash, $page, $field_id, $target_id) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $target = $this->get_target($instance->id, $target_id);

        // Find field to edit
        $field = Field::with('type')->where_instance_id($instance->id)->where_id($field_id)->order_by('position', 'asc')->first();
        if (empty($field)) {
            return Response::json(array('message' => 'Field not found.'), 400);
        }

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['target_id'] = $target->id;
        $this->data['field'] = $field;
        // Enable editing options based on field type
        $this->data['terms_msg'] = false;
        $this->data['label'] = false;
        $this->data['value'] = false;
        $this->data['required'] = false;
        $this->data['colorpicker'] = false;

        switch($field->type->id) {
            case 1: // header-banner
                // Images have a special edit-view
                return View::make('admin.fields.edit_banner', $this->data);
                break;
            case 2: // text-header-2
            case 3: // text-header-3
            case 4: // text-paragraph
                $this->data['value'] = true;
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
            case 18: // submit-button
                $this->data['value'] = true;
                $this->data['colorpicker'] = true;
                break;
            case 19: // input-accept-privacy
            case 20: // input-accept-terms
            case 21: // input-accept-rules
                $this->data['terms_msg'] = true;
                $this->data['value'] = true;
                $this->data['required'] = true;
                break;
            default:
                break;
        }

        return View::make('admin.fields.edit', $this->data);
    }

    // Update field
    public function put_update_field($hash, $page, $field_id, $target_id = 1) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $field = Field::where_instance_id($instance->id)->find($field_id);
        if (empty($field)) {
            return Response::json(array('message' => 'Field not found.'), 400);
        }

        $postdata = Input::all();

        // Check if data contains an image and save it
        foreach ($postdata as $input) {
            if (is_array($input)) {
                $url = Helper::upload('value', $input, 'IMAGE');
                if (empty($url)) {
                    return Response::json(array('message' => 'Upload failed. Try another format.'), 400);
                }
                $field->value = $url;
                unset($postdata['value']);
            }
        }

        // Save button color
        if (!empty($postdata['property'])){
            $field->property = $postdata['colorpicker'];
            unset($postdata['colorpicker']);
            unset($postdata['property']);
        }

        // Save rest of data
        $field->fill($postdata);
        if ($field->save()) {
            Session::flash('message', $field->label.' updated.');
            return Response::json(array('message' => $field->label.' updated.'), 200);
        }
        else {
            Session::flash('message', 'Error occurred, please try again.');
            return Response::json(array('message' => 'Error occurred, please try again.'), 400);
        }
    }

    // Delete field
    public function delete_destroy_field($hash, $page, $target_id = 1) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $target = $this->get_target($instance->id, $target_id);

        $postdata = Input::all();

        // Make sure the field belongs to this application
        $field = Field::where_instance_id($instance->id)->find($postdata['field_id']);
        if (empty($field)) {
            return Response::json(array('message' => 'Field not found'), 400);
        }

        // Delete field
        if ($field->delete()) {
            Session::flash('message', $field->label.' deleted.');

            // Update positions of the remaining fields
            $fields = Field::where_instance_id($instance->id)->where_page_id($page)->where_target_id($target->id)->order_by('position', 'asc')->get();
            $i = 1;
            foreach ($fields as $field) {
                $field->position = $i++;
                $field->save();
            }

            return Response::json(array('message' => $field->label.' deleted.'), 200);
        }
        else {
            return Response::json(array('message' => $field->label.' not deleted.'), 400);
        }
    }

    // Drag and drop fields
    public function get_drag_drop($hash = null, $page = 1, $template_id = 1, $target_id = 1) {
        // Verify application instance
        if (empty($hash)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        // Show message if fangate and/or entry form is disabled
        if ($page == 1 and !$instance->setting->fangate) {
            $this->data['msg'] = 'Fan gate page is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }
        if ($page == 2 and !$instance->setting->entry_form) {
            $this->data['msg'] = 'Entry form is disabled in settings';
            return View::make('admin.disabled', $this->data);
        }

        $target = $this->get_target($instance->id, $target_id);

        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->order_by('position', 'asc')
            ->get();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['template_id'] = $template_id;
        $this->data['target_id'] = $target->id;
        $this->data['fields'] = $fields;
        $this->data['types'] = Type::all(); // No countdown timer and accept rules

        return View::make('admin.fields.manage', $this->data);
    }

    // Create new field
    public function post_create_draggable_field($hash, $page, $target_id = 1) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $target = $this->get_target($instance->id, $target_id);

        $postdata = Input::all();

        // Get type of new field
        $type = Type::where_id($postdata['type_id'])->first();

        // Set default field value based the type
        $label = $type->name;
        $value = $type->name;
        $property = NULL;

        switch($type->id) {
            case 1: // header-banner
                $value = 'img/default_banner.jpg';
                break;
            case 2: // text-header-2
            case 3: // text-header-3
                $value = 'Lorem ipsum dolor sit amet';
                break;
            case 4: // text-paragraph
                $value = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
                break;
            case 18: // submit-button
                $value = 'Submit';
                $property = '#A1BF2E';
                break;
            case 19: // input-accept-privacy
                $value = 'I have read and accept the Privacy Policy';
                break;
            case 20: // input-accept-terms
                $value = 'I have read and accept the Terms and Conditions';
                break;
            case 21: // input-accept-rules
                $value = 'I have read and agree to the Official Rules';
                break;
            default:
                break;
        }

        // Update positions of other fields to make space for the new field
        $fields = Field::where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->where('position', '>=', $postdata['position'])
            ->get();

        foreach ($fields as $field) {
            $field->position = $field->position + 1;
            $field->save();
        }

        // Create new field
        $field = new Field();
        $field->instance_id = $instance->id;
        $field->type_id = $type->id;
        $field->template_id = $instance->setting->template_id;
        $field->page_id = $page;
        $field->target_id = $target->id;
        $field->label = $label;
        $field->value = $value;
        $field->position = $postdata['position'];
        $field->property = $property;
        $field->fangate = 0;
        $field->visible = 1;
        $field->editable = 1;
        $field->required = 1;

        if ($field->save()) {
            return Response::json(array('message' => $type->name.' created.', 'field_id' => $field->id), 200);
        }
        else {
            return Response::json(array('message' => $type->name.' not created.'), 400);
        }
    }

    // Move field
    public function put_update_field_position($hash, $page, $target_id = 1) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $target = $this->get_target($instance->id, $target_id);

        // Get old and new position of the field
        $postdata = Input::all();
        $old_pos = $postdata['old_position'];
        $new_pos = $postdata['new_position'];

        // Update positions of other fields
        if ($old_pos > $new_pos) {
            $fields = Field::where_instance_id($instance->id)
                ->where_target_id($target->id)
                ->where_page_id($page)
                ->where('position', '>=', $new_pos)
                ->where('position', '<', $old_pos)
                ->get();

            foreach ($fields as $field) {
                $field->position = $field->position + 1;
                $field->save();
            }
        } else {
            $fields = Field::where_instance_id($instance->id)
                ->where_target_id($target->id)
                ->where_page_id($page)
                ->where('position', '<=', $new_pos)
                ->where('position', '>', $old_pos)
                ->get();

            foreach ($fields as $field) {
                $field->position = $field->position - 1;
                $field->save();
            }
        }

        // Update position of seleted field
        $field = Field::find($postdata['field_id']);
        $field->position = $new_pos;

        if ($field->save()) {
            return Response::json(array('message' => 'Field position updated.'), 200);
        }
        else {
            return Response::json(array('message' => 'Field position updated.'), 400);
        }
    }
    /*******************************************************************************************************************
     * APPLICATION FIELDS END
     ******************************************************************************************************************/



    /*******************************************************************************************************************
     * SETTINGS
     ******************************************************************************************************************/

    // Get privacy, terms, or rules
    public function get_info($hash, $page, $setting_type) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        // Get content for type of info
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

    // Edit settings
    public function get_edit_setting($hash, $page, $type, $target_id) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $target = $this->get_target($instance->id, $target_id);

        // Load additional data for some settings
        switch($type) {
            // Targeting
            case 'localization':
                $this->data['ages'] = Age::order_by('value')->lists('name', 'id');
                $this->data['countries'] = Country::order_by('id')->lists('name', 'id');
                $this->data['languages'] = Language::order_by('id')->lists('name', 'id');
                $this->data['targets'] = Target::where_instance_id($instance->id)->order_by('id')->get();
                $this->data['current_target_id'] = $target->id;
                break;
            // Campaign eligibility
            case 'eligibility':
                $this->data['ages'] = Age::order_by('value')->lists('name', 'id');
                $this->data['countries'] = Country::order_by('id')->lists('name', 'id');
                $this->data['allowedcountries'] = Allowedcountry::where_instance_id($instance->id)->order_by('country_id')->lists('country_id', 'country_id');
                break;
            default:
                break;
        }

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['target_id'] = $target;

        return View::make('admin.settings.'.$type, $this->data);
    }

    // Update settings
    public function put_update_setting($hash, $page) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $postdata = Input::all();
        if (empty($postdata)) {
            return;
        }
        $success = false;
        $message = 'An error occurred, please try again.';
        $returnval = null;
        foreach ($postdata as $key => $input) {

            switch($key) {
                // Enable/disable fan gate
                case 'fangate':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = $input;

                    if ($setting->save()) {
                        $success = true;
                        $message = 'Fangate settings updated.';
                    } else {
                        $success = false;
                        $message = 'Fangate settings not updated.';
                    }
                    break;
                // Enable/disable entry form
                case 'entry_form':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = $input;

                    if ($setting->save()) {
                        $success = true;
                        $message = 'Entry form settings updated.';
                    } else {
                        $success = false;
                        $message = 'Entry form settings not updated.';
                    }
                    break;
                // Edit custom CSS
                case 'css':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);

                    if ($setting->save()) {
                        $success = true;
                        $message = 'CSS updated.';
                    } else {
                        $success = false;
                        $message = 'CSS not updated.';
                    }
                    break;
                // Background image
                case 'value':
                    if (!empty($input['name'])) {
                        $setting = Setting::where_instance_id($instance->id)->first();
                        $url = Helper::upload('value', $input, 'IMAGE');
                        if (empty($url)) {
                            $success = false;
                            $message = 'Upload failed. Try another format.';
                            break;
                        }
                        $setting->background = $url;
                        unset($postdata['value']);

                        if ($setting->save()) {
                            unset($postdata['value']);
                            $success = true;
                            $message = 'Background image saved.';
                        } else {
                            $success = false;
                            $message = 'Background image not saved.';
                        }
                    }
                    break;
                // Background color
                case 'property':
                        $setting = Setting::where_instance_id($instance->id)->first();
                        $setting->background = $postdata['colorpicker'];

                        if ($setting->save()) {
                            unset($input);
                            $success = true;
                            $message = 'Background color saved.';
                        } else {
                            $success = false;
                            $message = 'Background color not saved.';
                        }
                    break;
                // Create new target
                case 'age': // Includes country and language
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
                        $message = 'This targeting combination already exists.';
                        break;
                    }

                    // Get fields from default target
                    $default_target = Target::where_instance_id($instance->id)
                        ->where_language_id(1)
                        ->where_country_id(1)
                        ->where_age_id(1)
                        ->first();
                    $original_fields = Field::where_instance_id($instance->id)->where_target_id($default_target->id)->get();

                    // Create fields for new target
                    $new_target = $this->create_instance_localization($original_fields, $instance->id, $postdata);

                    unset($postdata['language']);
                    unset($postdata['country']);
                    unset($postdata['age']);
                    unset($postdata['title']);
                    unset($postdata['active']);

                    $returnval = $new_target->id;
                    $success = true;
                    $message = 'Target created. Showing target group: '.$new_target->title;
                    break;
                // Campaign eligibility
                case 'min_age': // Includes country
                    $success = true;
                    $message = 'Campaign eligibility updated.';

                    // Minimum age
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->age_id = $postdata['min_age'];

                    if (!$setting->save()) {
                        $success = false;
                        $message = 'Campaign eligibility not updated.';
                    }

                    // Allowed countries
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
                            $message = 'Campaign eligibility not updated.';
                        }
                    }

                    unset($postdata['min_age']);
                    unset($postdata['allowedcountries']);
                    break;
                // Edit privacy
                case 'privacy':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);

                    if ($setting->save()) {
                        $success = true;
                        $message = 'Privacy updated.';
                    } else {
                        $success = false;
                        $message = 'Privacy not updated.';
                    }
                    break;
                // Edit terms
                case 'terms':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Terms updated.';
                    } else {
                        $success = false;
                        $message = 'Terms not updated.';
                    }
                    break;
                // Edit rules
                case 'roles':
                    $setting = Setting::where_instance_id($instance->id)->first();
                    $setting->$key = nl2br($input);
                    if ($setting->save()) {
                        $success = true;
                        $message = 'Rules updated.';
                    } else {
                        $success = false;
                        $message = 'Rules not updated.';
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

    // Update existing target
    public function put_update_target($hash, $target_id) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($hash)->first();
        if (empty($instance)) {
            return Response::json(array('message' => 'Instance not found.'), 400);
        }

        $postdata = Input::all();

        // Verify target exists and that it is not the default target (can not be edited)
        $target = Target::where_instance_id($instance->id)->where_id($target_id)->first();
        if (empty($target)) {
            $message = 'Target group not found.';
            $returnval = null;
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 400);
        } else if ($target->default) {
            $message = 'Showing target group: '.$target->title;
            $returnval = $target->id;
            Session::flash('message', $message);
            return Response::json(array('message' => $message, 'val' => $returnval), 200);
        }

        // Make sure the new combination does not already exist
        $active_targets = Target::where_instance_id($instance->id)->where_not_in('id', array($target->id))->get();
        foreach ($active_targets as $active_target) {
            if ($active_target->language_id == $postdata['language']
                && $active_target->country_id == $postdata['country']
                && $active_target->age_id == $postdata['age']) {

                $message = 'This targeting combination already exists. Try a different combination.';
                $returnval = null;
                Session::flash('message', $message);
                return Response::json(array('message' => $message, 'val' => $returnval), 400);
            }
        }

        // Update target
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
    /*******************************************************************************************************************
     * SETTINGS END
     ******************************************************************************************************************/



    private function initialize_instance($hash, $template_id) {
        // Create instance
        $instance = new Instance();
        $instance->instance = $hash;
        $instance->save();

        // Set default country eligibility to all countries
        $allowedcountry = new Allowedcountry();
        $allowedcountry->instance_id = $instance->id;
        $allowedcountry->country_id = 1;
        $allowedcountry->save();

        // Create default target (all ages, all countries, and all languages)
        $target = new Target();
        $target->instance_id = $instance->id;
        $target->age_id = 1; // Target all ages
        $target->country_id = 1; // Target all countries
        $target->language_id = 1; // Target all languages
        $target->title = 'Default';
        $target->active = 1;
        $target->default = 1;
        $target->save();

        // Create default instance settings
        $setting = new Setting();
        $setting->instance_id = $instance->id;
        $setting->title = Template::find($template_id)->name;
        $setting->css = '';
        $setting->fangate = 1; // Enable fan gate
        $setting->entry_form = 1; // Enable entry form
        $setting->background = URL::to('templates/'.$template_id.'/background.jpg');
        $setting->template_id = $template_id;
        $setting->age_id = 1; // Set default age eligibility to all ages
        $setting->save();

        // Get application pages and create fields from fakes
        $pages = Page::with('fakes')->get();
        foreach ($pages as $page) {
            $this->create_fields_from_fakes($page, $instance->id, $template_id, $target->id);
        }
    }

    private function create_fields_from_fakes($page, $instance_id, $template_id, $target_id) {
        $i = 1;
        foreach ($page->fakes as $fake) {
            $field = new Field();
            $field->instance_id = $instance_id;
            $field->type_id = $fake->type_id;
            $field->template_id = $fake->template_id;
            $field->page_id = $fake->page_id;
            $field->target_id = $target_id;
            $field->label = $fake->label;
            if ($i == 1 and !empty($page->image)) {
                $field->value = URL::to('templates/'.$template_id.'/'.$page->image);
            } else {
                $field->value = $fake->value;
            }
            $field->info = $fake->info;
            $field->position = $i++;
            $field->button = $fake->button;
            $field->property = $fake->property;
            $field->fangate = 0;
            $field->visible = 1;
            $field->editable = 1;
            $field->required = 1;
            $field->save();
        }
    }

    private function create_instance_localization($original_fields, $instance_id, $postdata) {
        // Create new target
        $target = new Target();
        $target->instance_id = $instance_id;
        $target->language_id = $postdata['language'];
        $target->country_id = $postdata['country'];
        $target->age_id = $postdata['age'];
        $target->title = $postdata['title'];
        $target->active = $postdata['active'];
        $target->default = 0;
        $target->save();

        // Duplicate original fields and add new target id
        foreach ($original_fields as $original_field) {
            $field = new Field();
            $field->instance_id = $original_field->instance_id;
            $field->type_id = $original_field->type_id;
            $field->fangate = $original_field->fangate;
            $field->button = $original_field->button;
            $field->label = $original_field->label;
            $field->value = $original_field->value;
            $field->position = $original_field->position;
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

    private function get_target($instance_id, $target_id) {
        $target = Target::where_instance_id($instance_id)->where_id($target_id)->first();
        if (empty($target)) {
            $target = Target::where_instance_id($instance_id)->order_by('id')->first();
        }
        return $target;
    }
}