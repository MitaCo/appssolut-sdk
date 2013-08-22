{{ Form::checkbox(Str::slug($field->label, '-').'_'.$field->id, 'yes') }}
@if($field->required)
@if (filter_var($instance->setting->roles, FILTER_VALIDATE_URL))
{{ d(HTML::link($instance->setting->roles, Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value.'<span>*</span>', array('required' => 'required', 'class' => 'required')), array ('class' => 'footerlink', 'target' => '_blank'))) }}
@else
{{ d(HTML::link(URL::to_route('app_info', array($instance->instance, $page, 'roles')), Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value.'<span>*</span>', array('required' => 'required', 'class' => 'required')), array ('class' => 'various fancybox.ajax'))) }}
@endif
@else
@if (filter_var($instance->setting->roles, FILTER_VALIDATE_URL))
{{ HTML::link($instance->setting->roles, Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value), array ('class' => 'footerlink', 'target' => '_blank')) }}
@else
{{ HTML::link(URL::to_route('app_info', array($instance->instance, $page, 'roles')), Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value), array ('class' => 'various fancybox.ajax')) }}
@endif
@endif

@if($errors->has(Str::slug($field->label, '-').'_'.$field->id))
<div>{{ $errors->first(Str::slug($field->label, '-').'_'.$field->id) }}</div>
@endif