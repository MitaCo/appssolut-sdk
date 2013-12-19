@if($errors->messages)
  <div class="innerLR">
    <div class="row-fluid">
      <div class="span12">
        @if($errors->messages)
            @foreach($errors->messages as $e)
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Error: </strong> {{ $e[0] }}.
                </div>
            @endforeach
        
        @endif
        <?php $error = Session::get('error'); ?> 
        @if(!empty($error))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>Error: </strong> {{ $error }}.
            </div>
        @endif
      </div>
    </div>
  </div>
@endif