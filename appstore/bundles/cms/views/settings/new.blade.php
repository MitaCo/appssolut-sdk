@layout('cms::layouts.template')

@section('content')
   	<div class="">
        {{render('cms::partials._error')}}
    	  {{ Form::open_for_files(URL::to_action('cms::settings@create'), 'POST', array('class' => 'form-horizontal')) }}
            <div class="control-group">
                {{ Form::label('title', 'Title:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('title', Input::old('title'), array('class' => 'span12', 'id' => 'title', 'placeholder' => 'Enter title')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('fangate', 'Fangate:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('fangate', Input::old('fangate'), array('class' => 'span12', 'id' => 'fangate', 'placeholder' => 'Enter fangate')) }}
                </div>
            </div>

            <div class="control-group">
                {{ Form::label('instance_id', 'Instance id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('instance_id', Input::old('instance_id'), array('class' => 'span12', 'id' => 'instance_id', 'placeholder' => 'Enter label')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('template_id', 'Template id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('template_id', Input::old('template_id'), array('class' => 'span12', 'id' => 'template_id', 'placeholder' => 'Enter template_id')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('age_id', 'Age id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('age_id', Input::old('age_id'), array('class' => 'span12', 'id' => 'age_id', 'placeholder' => 'Enter age_id')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('entry_form', 'Entry form:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('entry_form', Input::old('entry_form'), array('class' => 'span12', 'id' => 'entry_form', 'placeholder' => 'Enter entry_form')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('css', 'Css:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('css', Input::old('css'), array('class' => 'span12', 'id' => 'css', 'placeholder' => 'Enter css')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('background', 'Background:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('background', Input::old('background'), array('class' => 'span12', 'id' => 'background', 'placeholder' => 'Enter background')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('privacy', 'Privacy:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('privacy', Input::old('privacy'), array('class' => 'span12', 'id' => 'privacy', 'placeholder' => 'Enter privacy')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('terms', 'Terms:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('terms', Input::old('terms'), array('class' => 'span12', 'id' => 'terms', 'placeholder' => 'Enter terms')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('roles', 'Roles:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('roles', Input::old('roles'), array('class' => 'span12', 'id' => 'roles', 'placeholder' => 'Enter roles')) }}
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ URL::to_action('cms::settings@index') }}" class="btn">Cancel</a>
            </div>
                      
        {{ Form::close() }}
  	</div>
@endsection