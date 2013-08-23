{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT') }}
<h4>Define application start and stop</h4>
<div class="modal-body">
    {{ Form::label('start', 'Start date and time') }}
    {{ Form::text('start', date('d.m.Y H:i', strtotime($instance->setting->start)), array ('class' => 'datetimepicker')) }}
    <br />
    {{ Form::label('end', 'End date and time') }}
    {{ Form::text('end', date('d.m.Y H:i', strtotime($instance->setting->end)), array ('class' => 'datetimepicker')) }}
    <br />
    {{ Form::label('timezone', 'Time zone') }}
    {{ Form::select('timezone', $timezones, $instance->setting->timezone) }}
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}