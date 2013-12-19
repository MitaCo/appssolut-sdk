@layout('cms::layouts.template')

@section('content')
   	<div class="">
        {{render('cms::partials._error')}}
    	  {{ Form::open(URL::to_action('cms::types@update'), 'POST', array('class' => 'form-horizontal')) }}
            <div class="control-group">
                {{ Form::label('name', 'Name:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('name', Input::old('name'), array('class' => 'span12', 'id' => 'name', 'placeholder' => 'Enter name')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('type', 'Type:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('type', Input::old('type'), array('class' => 'span12', 'id' => 'type', 'placeholder' => 'Enter type')) }}
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ URL::to_action('cms::types@index') }}" class="btn">Cancel</a>
            </div>
                      
        {{ Form::close() }}
  	</div>
@endsection