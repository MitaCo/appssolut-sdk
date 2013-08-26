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
        $instance = Instance::with('setting')->where_instance($this->getinstance($hash))->first();
        if (empty($instance)) {
            return View::make('notactive');
        }

        // Get current facebook user
        $fbuser = new Fbdata_Controller;
        // Check if there is a localization for the current user's language settings
        $fbuser_age_id = Age::where_value($fbuser->getAge())->first()->id;
        $fbuser_country_id = Country::where_code(strtoupper($fbuser->getCountry()))->first()->id;
        $fbuser_language_id = Language::where_langcode($fbuser->getlocale())->first()->id;
        $target = $this->find_target_for($instance, $fbuser_age_id, $fbuser_country_id, $fbuser_language_id);

        // Check if user is eligible for the campaign
        $is_eligible = $this->check_eligibility($instance, $fbuser_age_id, $fbuser_country_id);
        if (!$is_eligible) {
            return View::make('noteligible')->with('eligibility_message', Session::get('eligibility_message'));
        }

        $uid = $fbuser->getid();
        if (!($instance->setting->fangate and !$fbuser->liked())) {
            if (empty($uid)) {
                return $fbuser->makelogin();
            }
        }

        $this->data['app_message'] = array();
        $this->data['notification'] = Session::get('notification', '');

        $has_entered = Entry::where_instance_id($instance->id)->where_page_id(2)->where_uid($uid)->count();
        if ($instance->setting->fangate and !$fbuser->liked()) {
            $page_id = 1;
        } else if ($instance->setting->entry_form and !$has_entered and !empty($end)) {
            $page_id = 2;
        } else {
            $page_id = 3;

            if (empty($uid)) {
                return $fbuser->makelogin();
            }
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
    public function post_send($hash = null) {
        $instance = Instance::with('setting')->where_instance($this->getinstance($hash))->first();
        if (empty($instance)) {
            return View::make('notactive');
        }

        $fbuser = new Fbdata_Controller;
        $uid = $fbuser->getid();
        if (empty($uid)) {
            return $fbuser->makelogin();
        }
        // Check if there is a localization for the current user's language settings
        $fbuser_age_id = Age::where_value($fbuser->getAge())->first()->id;
        $fbuser_country_id = Country::where_code(strtoupper($fbuser->getCountry()))->first()->id;
        $fbuser_language_id = Language::where_langcode($fbuser->getlocale())->first()->id;
        $target = $this->find_target_for($instance, $fbuser_age_id, $fbuser_country_id, $fbuser_language_id);

        $page_id = 3;
        $target_id = $target->id;

        // Validate required fields
        $postdata = Input::all();
        if (isset($postdata['csrf_token'])) {
            unset($postdata['csrf_token']);
        }
        $expected_fields = Field::with('type')
            ->where_instance_id($instance->id)
            ->where_page_id($page_id)
            ->where_target_id($target_id)
            ->where_required(1)
            ->where_in('type_id', array(6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 21, 22, 23)) // Get only input type fields
            ->get();
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
                case 21: // input-accept-privacy
                case 22: // input-accept-terms
                case 23: // input-accept-rules
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
        $validation = Validator::make($postdata, $rules);
        if ($validation->fails()) {
            return Redirect::to_route('app_show', $instance->instance)->with_errors($validation->errors)->with_input();
        }

        $this->save_results($postdata, $instance, 2, $uid, $target_id);

        return Redirect::to_route('app_show', $instance->instance);
    }

    private function save_results($results, $instance, $page_id, $uid, $target_id = 1) {
        $entry = new Entry();
        $entry->instance_id = $instance->id;
        $entry->uid = $uid;//json_decode(file_get_contents('http://graph.facebook.com/'.$uid))->name;
        $entry->page_id = $page_id;
        $entry->target_id = $target_id;
        $entry->save();

        foreach($results as $key => $result) {
            $field_id = explode('_', $key);
            $storage = new Storage();
            $storage->entry_id = $entry->id;
            $storage->field_id = end($field_id);

            if(is_array($result)) {
                $folder = 'uploads/'.$instance->instance.'/';
                if(!is_dir($folder)) {
                    mkdir($folder);
                }
                Input::upload($key, $folder , $result['name']);
                $storage->value = $folder.$result['name'];
            } else {
                $storage->value = $result;
            }

            $storage->label = ucfirst(str_replace('-', ' ', $field_id[0]));
            $storage->save();
        }
    }

    // Find most suitable target based on users input
    private function find_target_for($instance, $fbuser_age_id, $fbuser_country_id, $fbuser_language_id) {
        // Get all targets based on the user's age
        $targets = Target::where_instance_id($instance->id)->where('age_id', '<=', $fbuser_age_id)->where_active(1)->order_by('age_id', 'desc')->get();
        // Get targets based on country
        $country_targets = array ();
        $all_countries_targets = array ();
        foreach ($targets as $target) {
            if ($fbuser_country_id == $target->country_id) {
                // Keep targets that match the user's country
                $country_targets[] = $target;
            } else if ($target->country_id == 1) {
                // Keep targets that allow any country
                $all_countries_targets[] = $target;
            }
        }
        if (!empty($country_targets)) {
            $targets = $country_targets;
        } else {
            $targets = $all_countries_targets;
        }
        // Get targets based on language
        $language_targets = array ();
        $all_languages_targets = array ();
        foreach ($targets as $target) {
            if ($fbuser_language_id == $target->language_id) {
                // Keep targets that match the user's language
                $language_targets[] = $target;
            } else if ($target->language_id == 1) {
                // Keep targets that allow any language
                $all_languages_targets[] = $target;
            }
        }
        if (!empty($language_targets)) {
            $targets = $language_targets;
        } else {
            $targets = $all_languages_targets;
        }
        // Final target
        if (empty($targets)) {
            $targets[] = Target::where_instance_id($instance->id)->where_age_id(1)->where_country_id(1)->where_language_id(1)->first();
        }
        return $targets[0];
    }

    private function check_eligibility($instance, $fbuser_age_id, $fbuser_country_id) {
        $min_age_id = $instance->setting->age_id;
        if ($fbuser_age_id < $min_age_id) {
            $age_value = Age::find($min_age_id)->value;
            Session::flash('eligibility_message', 'You must have '.$age_value.'+ years to participate.');
            return FALSE;
        }
        $allowed_countries = Allowedcountry::where_instance_id($instance->id)->order_by('country_id')->lists('country_id', 'country_id');
        if (isset($allowed_countries[1]) || isset($allowed_countries[$fbuser_country_id])) {
            return TRUE;
        }
        Session::flash('eligibility_message', 'You are not allowed to participate from this country.');
        return FALSE;
    }

}