@if($field->required)
{{ d(Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value.'<span>*</span>', array('required' => 'required', 'class' => 'required'))) }}
@else
{{ Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value) }}
@endif
{{ Form::text(Str::slug($field->label, '-').'_'.$field->id, Input::old(Str::slug($field->label, '-').'_'.$field->id), array('class' => 'datepicker')) }}

@if($errors->has(Str::slug($field->label, '-').'_'.$field->id))
<div>{{ $errors->first(Str::slug($field->label, '-').'_'.$field->id) }}</div>
@endif