@layout('cms::layouts.template')

@section('content')
   	<div class="">
        {{render('cms::partials._error')}}
    	  {{ Form::open_for_files(URL::to_action('cms::pages@create'), 'POST', array('class' => 'form-horizontal')) }}
            <div class="control-group">
                {{ Form::label('name', 'Name:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('name', Input::old('name'), array('class' => 'span12', 'id' => 'name', 'placeholder' => 'Enter name')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('image', 'Image:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('image', Input::old('image'), array('class' => 'span12', 'id' => 'image', 'placeholder' => 'Enter image')) }}
                </div>
            </div>

            <div class="control-group">
                {{ Form::label('visible', 'Visible:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('visible', Input::old('visible'), array('class' => 'span12', 'id' => 'visible', 'placeholder' => 'Enter visible')) }}
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ URL::to_action('cms::pages@index') }}" class="btn">Cancel</a>
            </div>
                      
        {{ Form::close() }}
  	</div>
@endsection