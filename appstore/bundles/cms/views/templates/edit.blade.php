@layout('cms::layouts.template')

@section('content')
   	<div class="">
        {{render('cms::partials._error')}}
    	  {{ Form::open_for_files(URL::to_action('cms::templates@update', array($data->id)), 'PUT', array('class' => 'form-horizontal')) }}
            <div class="control-group">
                {{ Form::label('name', 'Name:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('name', (!is_null(Input::old('name')) ? Input::old('name') : $data->name), array('class' => 'span12', 'id' => 'name', 'placeholder' => 'Enter name')) }}
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ URL::to_action('cms::templates@index') }}" class="btn">Cancel</a>
                <a href="{{ URL::to_action('cms::templates@new') }}" class="btn btn-success pull-right">Add new resource</a>
            </div>
                      
        {{ Form::close() }}
  	</div>
@endsection