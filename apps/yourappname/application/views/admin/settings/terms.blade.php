{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT') }}
<h4>Terms</h4>
<div class="modal-body">
    {{ Form::label('terms', 'Terms') }}
    {{ Form::textarea('terms', preg_replace('/<br(\s+)?\/?>/i', '', $instance->setting->terms)) }}
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}