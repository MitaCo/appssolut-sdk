{{ Form::open(URL::to_route('app_update_field', array($instance->instance, $page, $field->id, $target_id)), 'PUT') }}
    <h4>{{ $field->label }}</h4>
    <div class="modal-body">
        @if($terms_msg)
            <p>To enter your content go to the General settings and click on the related Button.</p>
            <br />
        @endif
        @if($label)
            {{ Form::label('label', 'Label') }}
            {{ Form::text('label', $field->label) }}
            <br />
        @endif

        @if($value)
            {{ Form::label('value', 'Value') }}
        {{ Form::textarea('value', preg_replace('/<br(\s+)?\/?>/i', '', $field->value)) }}
            <br />
        @endif

        @if($options)
        <?php $options = explode(',', $field->property); ?>
        {{ Form::label('options', 'Male') }}
        {{ Form::text('options', $options[0]) }}
        <br />
        {{ Form::label('options2', 'Female') }}
        {{ Form::text('options2', $options[1]) }}
        <br />
        @endif

        @if($required)
            {{ Form::label('required_field','Required field') }}
            <div class="control-group">
                {{Form::radio('required', 1, $field->required, array('id' => 'required_yes'))}}
                {{ Form::label('required_yes','Yes') }}
                {{Form::radio('required', 0, !$field->required, array('id' => 'required_no'))}}
                {{ Form::label('required_no','No') }}
            </div>
            <br />
        @endif

        @if($colorpicker)
            {{ render('admin.settings.colorpicker', array('color' => is_null($field->property) ? '#93A6C2' :  $field->property)) }}
        @endif
    </div>
    <div class="modal-footer"> 
        <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
        <button class="modal-button btn ">Save</button>
    </div>
{{ Form::close() }}

@if($page == 2)
    {{ Form::open(URL::to_route('app_delete_field', array ($instance->instance, $page, $target_id)), 'DELETE') }}
    {{ Form::hidden('field_id', $field->id) }}
    {{ Form::button('Delete', array('class' => 'btn delete_button btn-danger')) }}
    {{ Form::close() }}
@endif