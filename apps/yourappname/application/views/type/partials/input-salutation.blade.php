@if($field->required)
{{ d(Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value.'<span>*</span>', array('required' => 'required', 'class' => 'required'))) }}
@else
{{ Form::label(Str::slug($field->label, '-').'_'.$field->id, $field->value) }}
@endif
{{ Form::select(Str::slug($field->label, '-').'_'.$field->id, array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Ms.'=>'Ms.','Dr.'=>'Dr.'), Input::old(Str::slug($field->label, '-').'_'.$field->id)) }}

@if($errors->has(Str::slug($field->label, '-').'_'.$field->id))
<div>{{ $errors->first(Str::slug($field->label, '-').'_'.$field->id) }}</div>
@endif