{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT') }}
<h4>CSS</h4>
<div class="modal-body">
    {{ Form::label('css', 'CSS') }}
    {{ Form::textarea('css', preg_replace('/<br(\s+)?\/?>/i', '', $instance->setting->css)) }}
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}