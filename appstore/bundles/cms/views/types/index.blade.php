@layout('cms::layouts.template')

@section('content')
   	<div class="table-list">
   		<a href="{{ URL::to_action('cms::types@new') }}" class="btn btn-success pull-right">Add new resource</a>
    	<table class="table table-striped table-hover">
            <thead>
              	<tr>
                  	@foreach($data[0] as $key => $value)
                    	<th>{{$key}}</th>
                	@endforeach
                	<th>Actions</th>
                </tr>
            </thead>
            <tbody>
	            @foreach($data  as $k => $v)
	            	<tr>
	            		@foreach($v as $key => $value)
	            			<td>{{$value}}</td>
	                	@endforeach
	                	<td>
	                		<a href="{{ URL::to_action('cms::types@edit', array($v->id)) }}"><i class="icon-edit"></i></a>
	                		{{ Form::open(URL::to_action('cms::types@destroy', array($v->id)), 'DELETE', array('style' => 'display:inline;')) }}
                                <button class="btn btn-link" onclick="return confirm('Are you sure?');"><i class="icon-remove"></i></button>
                            {{ Form::close() }}
	                	</td>
	                </tr>
	            @endforeach
               	</tr>
            </tbody>
        </table>
  	</div>
@endsection