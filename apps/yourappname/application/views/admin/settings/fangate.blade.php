{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT') }}
<h4>Fan Gate ON/OFF</h4>
<div class="modal-body">
    {{ Form::label('fangate','Enable Fan Gate') }}
    <div class="control-group">
        {{Form::radio('fangate', 1, $instance->setting->fangate, array('id' => 'required_yes'))}}
        {{ Form::label('required_yes','Yes') }}
        {{Form::radio('fangate', 0, !$instance->setting->fangate, array('id' => 'required_no'))}}
        {{ Form::label('required_no','No') }}
    </div>
    <br />
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}