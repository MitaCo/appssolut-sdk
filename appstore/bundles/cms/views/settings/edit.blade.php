@layout('cms::layouts.template')

@section('content')
   	<div class="">
        {{render('cms::partials._error')}}
    	  {{ Form::open_for_files(URL::to_action('cms::settings@update', array($data->id)), 'PUT', array('class' => 'form-horizontal')) }}
            <div class="control-group">
                {{ Form::label('title', 'Title:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('title', (!is_null(Input::old('title')) ? Input::old('title') : $data->title), array('class' => 'span12', 'id' => 'title', 'placeholder' => 'Enter title')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('fangate', 'Fangate:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('fangate', (!is_null(Input::old('fangate')) ? Input::old('fangate') : $data->fangate), array('class' => 'span12', 'id' => 'fangate', 'placeholder' => 'Enter fangate')) }}
                </div>
            </div>

            <div class="control-group">
                {{ Form::label('instance_id', 'Instance id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('instance_id', (!is_null(Input::old('instance_id')) ? Input::old('instance_id') : $data->instance_id), array('class' => 'span12', 'id' => 'instance_id', 'placeholder' => 'Enter label')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('template_id', 'Template id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('template_id', (!is_null(Input::old('template_id')) ? Input::old('template_id') : $data->template_id), array('class' => 'span12', 'id' => 'template_id', 'placeholder' => 'Enter template_id')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('age_id', 'Age id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('age_id', (!is_null(Input::old('age_id')) ? Input::old('age_id') : $data->age_id), array('class' => 'span12', 'id' => 'age_id', 'placeholder' => 'Enter age_id')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('entry_form', 'Entry form:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('entry_form', (!is_null(Input::old('entry_form')) ? Input::old('entry_form') : $data->entry_form), array('class' => 'span12', 'id' => 'entry_form', 'placeholder' => 'Enter entry_form')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('css', 'Css:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('css', (!is_null(Input::old('css')) ? Input::old('css') : $data->css), array('class' => 'span12', 'id' => 'css', 'placeholder' => 'Enter css')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('background', 'Background:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('background', (!is_null(Input::old('background')) ? Input::old('background') : $data->background), array('class' => 'span12', 'id' => 'background', 'placeholder' => 'Enter background')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('privacy', 'Privacy:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('privacy', (!is_null(Input::old('privacy')) ? Input::old('privacy') : $data->privacy), array('class' => 'span12', 'id' => 'privacy', 'placeholder' => 'Enter privacy')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('terms', 'Terms:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('terms', (!is_null(Input::old('terms')) ? Input::old('terms') : $data->terms), array('class' => 'span12', 'id' => 'terms', 'placeholder' => 'Enter terms')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('roles', 'Roles:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('roles', (!is_null(Input::old('roles')) ? Input::old('roles') : $data->roles), array('class' => 'span12', 'id' => 'roles', 'placeholder' => 'Enter roles')) }}
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ URL::to_action('cms::settings@index') }}" class="btn">Cancel</a>
                <a href="{{ URL::to_action('cms::settings@new') }}" class="btn btn-success pull-right">Add new resource</a>
            </div>
                      
        {{ Form::close() }}
  	</div>
@endsection