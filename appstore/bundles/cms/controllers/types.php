<?php

/**
 * Author: Muhamed Didovic
 * Date: 12/11/13
 */

class Cms_Types_Controller extends Cms_Admin_Controller {
	public $restful = true;

	public function __construct() {
        parent::__construct();
    }
    
    // List all resources
    public function get_index() {
        $data = json_decode(Response::eloquent(Type::order_by('id')->get()));
        return View::make('cms::types.index', compact('data'));
    }

    // Get update form for resource
    public function get_edit($id) {
        $data = json_decode(Response::eloquent(Type::find($id)));
        return View::make('cms::types.edit', compact('data'));
    }

    // Update resource
    public function put_update($id) {
        $postdata = Input::all();
        
        $validation = Type::validate($postdata);
        if ($validation->fails()) return Redirect::back()->with_errors($validation);
        
        $resource = Type::find($id);
        $resource->name = $postdata['name'];
        $resource->type = $postdata['type'];

        if (!$resource->save()) {
            return Redirect::back()->with_errors($validation)->with('message', 'Something went wrong try again!')->with_input();;
        }

        return Redirect::to_action('cms::type')->with('message', 'Resource has been updated');
    }

    // Get new form for resource
    public function get_new() {
        return View::make('cms::types.new');
    }

    // insert resource
    public function post_create() {
        $postdata = Input::all();
        
        $validation = Type::validate($postdata);
        if ($validation->fails()) return Redirect::back()->with_errors($validation);

        Type::create($postdata);

        return Redirect::to_action('cms::type')->with('message', 'Resource has been updated');
    }

    // Delete resource
    public function delete_destroy($id) {
        Type::find($id)->delete();
        return Redirect::to_action('cms::type')->with('message', 'Resource has been deleted');
    }

    
}