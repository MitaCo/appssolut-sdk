<?php

class Home_Controller extends Sdk_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function post_index($hash = null) {
        return $this->get_index($hash);
    }

    public function get_index($hash = null) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($this->getinstance($hash))->first();
        if (empty($instance)) {
            return View::make('notactive');
        }

        // Get facebook profile from user
        $fbuser = new Fbdata_Controller;

        // Get the most fitting target for user's age, country, and language
        $target = $this->find_target_for($instance, $fbuser);

        // Check if user is eligible for the campaign
        if (!$this->is_eligible($instance, $fbuser)) {
            return View::make('noteligible')->with('eligibility_message', Session::get('eligibility_message'));
        }

        // Show fangate if it is enabled but the user did not like the facebook page
        if ($instance->setting->fangate and !$fbuser->liked()) {
            $page = 1;
        } else {
            // Show entry form if it is enabled but the user has not filled it out before
            if ($instance->setting->entry_form) {
                // Get facebook user id
                $uid = $fbuser->getid();
                if (empty($uid)) {
                    // Force user to authenticate to the application
                    //return $fbuser->makelogin();
                }
                // Check if the user has already filled out the entry form
                $has_entered = Entry::where_instance_id($instance->id)->where_page_id(2)->where_uid($uid)->count();
                // Show entry form if the user did not fi
                if (!$has_entered) {
                    $page = 2;
                } else {
                    return Redirect::to_route('app_show', array($instance->instance, 3));
                }
            } else {
                return Redirect::to_route('app_show', array($instance->instance, 3));
            }
        }

        $fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_target_id($target->id)
            ->where_page_id($page)
            ->order_by('position', 'asc')
            ->get();

        $this->data['instance'] = $instance;
        $this->data['page'] = $page;
        $this->data['fields'] = $fields;
        $this->data['invitelink'] = $fbuser->getInviteLink('You are invited to #yourappname#');

        return View::make('home.index', $this->data);
    }

    public function post_send($hash = null) {
        // Verify application instance
        $instance = Instance::with('setting')->where_instance($this->getinstance($hash))->first();
        if (empty($instance)) {
            return View::make('notactive');
        }

        // Get facebook profile from user
        $fbuser = new Fbdata_Controller;

        // Make sure to get facebook user id
        $uid = $fbuser->getid();
        if (empty($uid)) {
            // return $fbuser->makelogin();
        }

        // Get the most fitting target for user's age, country, and language
        $target = $this->find_target_for($instance, $fbuser);

        // Check if user is eligible for the campaign
        if (!$this->is_eligible($instance, $fbuser)) {
            return View::make('noteligible')->with('eligibility_message', Session::get('eligibility_message'));
        }

        $postdata = Input::all();
        if (isset($postdata['csrf_token'])) {
            unset($postdata['csrf_token']);
        }

        /*
         * ENTRY FORM VALIDATION
         */

        // Get all input type fields (form fields)
        $expected_fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_page_id(3)
            ->where_target_id($target->id)
            ->where_required(1)
            ->where_in('type_id', array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 19, 20, 21))
            ->get();

        // Generate validation rules for entry form fields
        $rules = array();
        foreach ($expected_fields as $field) {
            $rule = array();
            switch ($field->type->id) {
                case 7: // input-number
                    $rule[] = 'numeric';
                    if ($field->required) {
                        $rule[] = 'required';
                    }
                    break;
                case 8: // input-email
                    $rule[] = 'email';
                    if ($field->required) {
                        $rule[] = 'required';
                    }
                    if (empty($first_email)) {
                        $first_email = Str::slug($field->label, '-').'_'.$field->id;
                    } else {
                        $rule[] = 'same:'.$first_email;
                        $first_email = null;
                    }
                    break;
                case 9: // input-url
                    $rule[] = 'url';
                    if ($field->required) {
                        $rule[] = 'required';
                    }
                    break;
                case 12: // input-checkbox
                case 19: // input-accept-privacy
                case 20: // input-accept-terms
                case 21: // input-accept-rules
                    if ($field->required) {
                        $rule[] = 'accepted';
                        $rule[] = 'required';
                    }
                    break;
                default:
                    if ($field->required) {
                        $rule[] = 'required';
                    }
                    break;
            }
            if (!empty($rule)) {
                $rules[Str::slug($field->label, '-').'_'.$field->id] = implode('|', $rule);
            }
        }

        // Validate data
        $validation = Validator::make($postdata, $rules);
        if ($validation->fails()) {
            return Redirect::to_route('app_load', $instance->instance)->with_errors($validation->errors)->with_input();
        }
        /*
         * ENTRY FORM VALIDATION END
         */

        // Save data
        $this->save_results($postdata, $instance->id, 2, $uid, $target->id);

        return Redirect::to_route('app_load', $instance->instance);
    }

    private function save_results($results, $instance_id, $page, $uid, $target_id) {
        // Create new entry
        $entry = new Entry();
        $entry->instance_id = $instance_id;
        $entry->page_id = $page;
        $entry->target_id = $target_id;
        $entry->uid = $uid;
        $entry->save();

        // Save content entered by the user
        foreach ($results as $key => $result) {
            $field_id = explode('_', $key);
            $storage = new Storage();
            $storage->entry_id = $entry->id;
            $storage->field_id = end($field_id);
            $storage->label = ucfirst(str_replace('-', ' ', $field_id[0]));
            $storage->value = $result;
            $storage->save();
        }
    }
}