@layout('cms::layouts.template')

@section('content')
   	<div class="">
        {{render('cms::partials._error')}}
    	  {{ Form::open_for_files(URL::to_action('cms::fakes@update', array($data->id)), 'PUT', array('class' => 'form-horizontal')) }}
            <div class="control-group">
                {{ Form::label('label', 'Label:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('label', (!is_null(Input::old('label')) ? Input::old('label') : $data->label), array('class' => 'span12', 'id' => 'label', 'placeholder' => 'Enter label')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('value', 'Value:',  array('class' => 'control-label')) }}
                <div class="controls">
                    <!--
                        if (str_contains($data->value,'img/') || str_contains($data->value,'.jpg') || str_contains($data->value,'.png') || str_contains($data->value,'.gif'))
                            {{-- Form::file('value', array('class' => 'span12', 'id' => 'value', 'placeholder' => 'Upload image')) --}}
                            <img src="{{ URL::to($data->value) }}"/>
                        endif
                    -->
                        {{ Form::text('value', (!is_null(Input::old('value')) ? Input::old('value') : $data->value), array('class' => 'span12', 'id' => 'value', 'placeholder' => 'Enter value')) }}
                        
                </div>
            </div>

            <div class="control-group">
                {{ Form::label('type_id', 'Type id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('type_id', (!is_null(Input::old('type_id')) ? Input::old('type_id') : $data->type_id), array('class' => 'span12', 'id' => 'type_id', 'placeholder' => 'Enter label')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('template_id', 'Template id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('template_id', (!is_null(Input::old('template_id')) ? Input::old('template_id') : $data->template_id), array('class' => 'span12', 'id' => 'template_id', 'placeholder' => 'Enter template_id')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('page_id', 'Page id:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('page_id', (!is_null(Input::old('page_id')) ? Input::old('page_id') : $data->page_id), array('class' => 'span12', 'id' => 'page_id', 'placeholder' => 'Enter page_id')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('info', 'Info:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::textarea('info', (!is_null(Input::old('info')) ? Input::old('info') : $data->info), array('class' => 'span12', 'id' => 'info', 'placeholder' => 'Enter info')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('position', 'Position:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('position', (!is_null(Input::old('position')) ? Input::old('position') : $data->position), array('class' => 'span12', 'id' => 'position', 'placeholder' => 'Enter position')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('required', 'Required:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('required', (!is_null(Input::old('required')) ? Input::old('required') : $data->required), array('class' => 'span12', 'id' => 'required', 'placeholder' => 'Enter required')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('button', 'Button:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('button', (!is_null(Input::old('button')) ? Input::old('button') : $data->button), array('class' => 'span12', 'id' => 'button', 'placeholder' => 'Enter button')) }}
                </div>
            </div>
            <div class="control-group">
                {{ Form::label('property', 'Property:',  array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('property', (!is_null(Input::old('property')) ? Input::old('property') : $data->property), array('class' => 'span12', 'id' => 'property', 'placeholder' => 'Enter property')) }}
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ URL::to_action('cms::fakes@index') }}" class="btn">Cancel</a>
                <a href="{{ URL::to_action('cms::fakes@new') }}" class="btn btn-success pull-right">Add new resource</a>
            </div>
                      
        {{ Form::close() }}
  	</div>
@endsection