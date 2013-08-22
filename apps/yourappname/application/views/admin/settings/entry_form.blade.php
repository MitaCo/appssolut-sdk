{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT') }}
<h4>Entry Form ON/OFF</h4>
<div class="modal-body">
    {{ Form::label('entry_form','Enable Entry Form') }}
    <div class="control-group">
        {{Form::radio('entry_form', 1, $instance->setting->entry_form, array('id' => 'required_yes'))}}
        {{ Form::label('required_yes','Yes') }}
        {{Form::radio('entry_form', 0, !$instance->setting->entry_form, array('id' => 'required_no'))}}
        {{ Form::label('required_no','No') }}
    </div>
    <br />
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}