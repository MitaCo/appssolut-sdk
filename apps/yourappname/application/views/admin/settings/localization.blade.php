<h4>Create target group</h4>
<div id="accordion-create-target">
    <ul class="nav">
        <li class="glyphicons circle_plus"><a ><i></i><span>Create target group</span></a></li>
        <div class="modal-body">
            <p>Target your application based on age, country, and language.</p>
            <br />
            {{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT', array ('class' => 'localization')) }}

            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', 'New target group', array ('maxlength' => '17')) }}

            {{ Form::label('age', 'Target age') }}
            {{ Form::select('age', $ages) }}

            {{ Form::label('country', 'Target country') }}
            {{ Form::select('country', $countries) }}

            {{ Form::label('language', 'Target language') }}
            {{ Form::select('language', $languages) }}

            {{ Form::label('active','Enabled') }}
            <div class="control-group">
                {{Form::radio('active', 1, 1, array('id' => 'active_yes'))}}
                {{ Form::label('active_yes', 'Yes') }}
                {{Form::radio('active', 0, 0, array('id' => 'active_no'))}}
                {{ Form::label('active_no', 'No') }}
            </div>

            {{ Form::submit('Create and show', array ('class' => 'modal-button btn')) }}
            {{ Form::close() }}
        </div>
    </ul>
</div>

<h4>Review targeted applications</h4>
<div id="accordion-targets">
    <ul class="nav">
        @foreach($targets as $target)
        <li class="glyphicons globe {{ ($target->id == $current_target_id ) ? 'current_target' : '' }}"><a ><i></i><span>{{ $target->title }} | {{ $target->active ? 'enabled' : 'disabled' }}</span></a></li>
        <div class="modal-body">

            @if($target->default)
            <p>The settings for the default target can not be edited.</p>
            <br />

            {{ Form::open(URL::to_route('app_update_target', array ($instance->instance, $target->id)), 'PUT', array ('class' => 'localization')) }}

            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', $target->title, array ('disabled' => 'disabled')) }}

            {{ Form::label('age', 'Target age') }}
            {{ Form::select('age', $ages, $target->age_id, array ('disabled' => 'disabled')) }}

            {{ Form::label('country', 'Target country') }}
            {{ Form::select('country', $countries, $target->country_id, array ('disabled' => 'disabled')) }}

            {{ Form::label('language', 'Target language') }}
            {{ Form::select('language', $languages, $target->language_id, array ('disabled' => 'disabled')) }}

            {{ Form::submit('Show', array ('class' => 'modal-button btn')) }}
            {{ Form::close() }}

            @else
            <p>Edit settings for this target group and show the targeted application in the preview.</p>
            <br />

            {{ Form::open(URL::to_route('app_update_target', array ($instance->instance, $target->id)), 'PUT', array ('class' => 'localization')) }}

            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', $target->title, array ('maxlength' => '17')) }}

            {{ Form::label('age', 'Target age') }}
            {{ Form::select('age', $ages, $target->age_id) }}

            {{ Form::label('country', 'Target country') }}
            {{ Form::select('country', $countries, $target->country_id) }}

            {{ Form::label('language', 'Target language') }}
            {{ Form::select('language', $languages, $target->language_id) }}

            {{ Form::label('active','Enabled') }}
            <div class="control-group">
                {{Form::radio('active', 1, $target->active, array('id' => 'target_'.$target->id.'_active_yes'))}}
                {{ Form::label('target_'.$target->id.'_active_yes', 'Yes') }}
                {{Form::radio('active', 0, !$target->active, array('id' => 'target_'.$target->id.'_active_no'))}}
                {{ Form::label('target_'.$target->id.'_active_no', 'No') }}
            </div>

            {{ Form::submit('Save and show', array ('class' => 'modal-button btn')) }}
            {{ Form::close() }}
            @endif

        </div>
        @endforeach
    </ul>
</div>

<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Back</a>
</div>