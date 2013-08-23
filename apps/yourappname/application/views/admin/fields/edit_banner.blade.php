{{ Form::open_for_files(URL::to_route('app_update_field', array($instance->instance, $page, $field->id, $target_id)), 'PUT', array('class' => 'navbar-form', 'id' => 'upload')) }}
    <h4>{{ $field->label }}</h4>
    <div class="modal-body">
        <p>Upload an image from your computer.</p>
        <p>Recommended maximum width: 810 pixels</p>
       
        @if(!empty($field->value))
        <p>{{ HTML::image(URL::to($field->value)) }}</p>
        @endif
        <ul>
            <!-- The file uploads will be shown here -->
        </ul>
        <div id="drop">
            Upload image
            <a>Choose from your computer</a>
            <input type="file" name="value"/>
        </div>
    </div>       
    <div class="modal-footer">
        <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
        <button class="modal-button btn">Save</button>
    </div>

{{ Form::close() }}
    
@if($page == 3)
    {{ Form::open(URL::to_route('app_delete_field', array ($instance->instance, $page, $target_id)), 'DELETE') }}
    {{ Form::hidden('field_id', $field->id) }}
    {{ Form::button('Delete', array('class' => 'btn delete_button btn-danger')) }}
    {{ Form::close() }}
@endif
