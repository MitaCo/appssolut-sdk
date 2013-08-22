<h4>Position Fields</h4>
<div class="modal-body">
    <select id="list-box" multiple="multiple" size="{{ sizeof($fields) }}">
        @foreach($fields as $field)
        <option id="field_{{ $field->id }}">{{ $field->label }}</option>
        @endforeach
    </select>
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel">Back</a>
    <button id="move-up" class="modal-button btn">&#9650;</button>
    <button id="move-down"class="modal-button btn">&#9660;</button>
</div>