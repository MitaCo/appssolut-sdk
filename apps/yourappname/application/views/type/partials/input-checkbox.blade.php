<!--<div class="control-group">-->
{{ Form::checkbox(Str::slug($field->label, '-').'_'.$field->id, 'yes', ((Input::old(Str::slug($field->label, '-').'_'.$field->id) == 'yes') ? TRUE : FALSE)) }}
@if($field->required)
{{ d(Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value.'<span>*</span>', array('required' => 'required', 'class' => 'required'))) }}
@else
{{ Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value) }}
@endif

@if($errors->has(Str::slug($field->label, '-').'_'.$field->id))
<div>{{ $errors->first(Str::slug($field->label, '-').'_'.$field->id) }}</div>
@endif
<!--</div>-->