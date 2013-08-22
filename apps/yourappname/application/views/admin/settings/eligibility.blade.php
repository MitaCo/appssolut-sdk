{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT', array('id' => 'eligibility')) }}
<h4>Campaign Eligibility</h4>
<div class="modal-body">
    {{ Form::label('min_age', 'Select min. age') }}
    {{ Form::select('min_age', $ages, $instance->setting->age_id) }}

    {{ Form::label('allowedcountries', 'Select countries') }}
    {{ Form::select('allowedcountries[]', $countries, $allowedcountries, array ('multiple' => 'multiple', 'size' => '15', 'class' => 'chzn-select')) }}
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}