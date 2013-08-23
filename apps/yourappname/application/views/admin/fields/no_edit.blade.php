<h4>{{ $field->label }}</h4>

<div class="modal-body">
    <p>{{ $info_msg }}</p>
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel">Back</a>
</div>