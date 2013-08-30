@if($field->required)
<p class="required">{{$field->value}}{{ d('<span>*</span>') }}</p>
@else
<p>{{$field->value}}</p>
@endif

<?php $options = explode(',', $field->property); ?>

@if (isset($options[0]))
{{ Form::radio(Str::slug($field->label, '-').'_'.$field->id, $options[0], ((Input::old(Str::slug($field->label, '-').'_'.$field->id) == $options[0]) ? TRUE : FALSE), array('id'=>'male')) }}
{{ Form::label('male',$options[0]) }}
@endif

@if (isset($options[1]))
{{ Form::radio(Str::slug($field->label, '-').'_'.$field->id, $options[1], ((Input::old(Str::slug($field->label, '-').'_'.$field->id) == $options[1]) ? TRUE : FALSE), array('id'=>'female')) }}
{{ Form::label('female', $options[1]) }}
@endif

@if($errors->has(Str::slug($field->label, '-').'_'.$field->id))
<div>{{ $errors->first(Str::slug($field->label, '-').'_'.$field->id) }}</div>
@endif