@if($field->required)
    <p class="required">{{$field->value}}{{ d('<span>*</span>') }}</p>
@else
    <p>{{$field->value}}</p>
@endif
{{ Form::radio(Str::slug($field->label, '-').'_'.$field->id, 'Male', ((Input::old(Str::slug($field->label, '-').'_'.$field->id) == 'Male') ? TRUE : FALSE), array('id'=>'male')) }}
{{ Form::label('male','Male') }}
{{ Form::radio(Str::slug($field->label, '-').'_'.$field->id, 'Female', ((Input::old(Str::slug($field->label, '-').'_'.$field->id) == 'Female') ? TRUE : FALSE), array('id'=>'female')) }}
{{ Form::label('female','Female') }}

@if($errors->has(Str::slug($field->label, '-').'_'.$field->id))
<div>{{ $errors->first(Str::slug($field->label, '-').'_'.$field->id) }}</div>
@endif