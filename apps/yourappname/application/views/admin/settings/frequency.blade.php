{{ Form::open(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT') }}
<h4>Edit No. of votes per user</h4>
<div class="modal-body">
    {{ Form::label('max_votes', 'No. of votes per user') }}
    {{ Form::number('max_votes', $instance->setting->max_votes) }}
    <br />
    {{ Form::label('frequency', 'Voting frequency for each user') }}
    {{ Form::select('frequency', array('COMPETITION' => 'For this competition', 'WEEK' => 'Per week', 'DAY' => 'Per day'), $instance->setting->frequency) }}
</div>
<div class="modal-footer">
    <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
    <button class="modal-button btn ">Save</button>
</div>
{{ Form::close() }}