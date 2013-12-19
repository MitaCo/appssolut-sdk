
@if($page == 1)
<h4>
    Fan Gate Settings
    <a class="explain" data-content="When you turn ON the Fan Gate option, users who hadn’t like your page can’t access the application. Fan Gate is a great way to increase the number of likes on your Page. A fan Gate image should attract users to like your page and to get the full access to the page." data-original-title="Fan Gate Settings">?</a>
</h4>
<ul>
    <li class="glyphicons thumbs_up">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'fangate', $target_id)) }}"><i></i><span>Fan Gate ON/OFF</span></a>
        <a class="explain" data-content="Use this feature to enable or disable the Fan Gate option on your application." data-original-title="Fan Gate ON/OFF">?</a>
    </li>
</ul>
@endif

@if($page == 2)
<h4>Entry Form Settings</h4>
<ul>
    <li class="glyphicons notes">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'entry_form', $target_id)) }}"><i></i><span>Entry Form ON/OFF</span></a>
        <a class="explain" data-content="Use this feature to enable or disable the Entry Form option on your application." data-original-title="Entry Form ON/OFF">?</a>
    </li>
</ul>
@endif

@if($page > 2)
<h4>
    Fields Settings
    <a class="explain"  data-content="Is a group of features that allows you to edit predefined fields in your application. To edit a specific field click and editing field will open." data-original-title="Application Fields Settings">?</a>
</h4>
@endif

@if(($page == 1 and $instance->setting->fangate) or ($page == 2 and $instance->setting->entry_form) or ($page > 2))
<ul>
    @foreach($fields as $field)
    <li class="glyphicons app-{{$field->Type->type}}" id="field_{{$field->id}}">
        <a href="{{ URL::to_route('app_edit_field', array ($instance->instance, $page, $field->id, $target_id)) }}"><i></i><span>{{ $field->label}}</span></a>
        @if(!empty($field->info))
        <a class="explain" data-content="{{ $field->info }}" data-original-title="{{ $field->label }}">?</a>
        @endif
    </li>
    @endforeach
</ul>
@endif

@if($page == 2 and $instance->setting->entry_form)
<h4>
    Add/Remove fields
    <a class="explain" data-content="Use this feature to add new fields to your application or to remove existing ones." data-original-title="Add/Remove fields">?</a>
</h4>
<ul>
    <li class="glyphicons circle_plus">
        <a class="dragdrop" href=""><i></i><span>Create & Move Fields</span></a>
        <a class="explain" data-content="If you need more fields in your application, use this feature to add new fields with the drag and drop system. Use this feature also to move existing fields to the desired position on your application, or to remove application fields." data-original-title="Create & Move Fields">?</a>
    </li>
</ul>
@endif

@if(($page == 2 and $instance->setting->entry_form) or ($page > 2))
<h4>
    General Settings
    <a class="explain" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Use the following group of options to edit the general features for your application, like the time when your application starts and ends, the background image etc." data-original-title="General Settings">?</a>
</h4>
<ul>
    <li class="glyphicons circle_plus">
        <a class="multitargeting" href="{{ URL::to_route('app_edit_settings', array ($instance->instance, $page, 'localization', $target_id)) }}"><i></i><span>Targeting</span></a>
        <a class="explain" data-content="Use this feature to make custom previews of your application for different users groups. You can target different groups by choosing the users age, country or language." data-original-title="Targeting">?</a>
    </li>
    <li class="glyphicons circle_plus">
        <a href="{{ URL::to_route('app_edit_settings', array ($instance->instance, $page, 'eligibility', $target_id)) }}"><i></i><span>Campaign Eligibility</span></a>
        <a class="explain" data-content="Use this feature to choose who can access your application, by deciding the age of the user and the country in which your application will be available." data-original-title="Campaign Eligibility">?</a>
    </li>
    <li class="glyphicons picture">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'background', $target_id)) }}"><i></i><span>Edit Background</span></a>
        <a class="explain" data-content="This feature allows you to edit your background by uploading a background image from your computer, or by using the color picker to set a background color." data-original-title="Edit Background">?</a>
    </li>
    <li class="glyphicons notes_2">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'privacy', $target_id)) }}"><i></i><span>Privacy</span></a>
        <a class="explain" data-content="Use this field to enter the value of the link where users can see your Privacy Policy.." data-original-title="Privacy">?</a>
    </li>
    <li class="glyphicons notes_2">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'terms', $target_id)) }}"><i></i><span>Terms</span></a>
        <a class="explain" data-content="Use this field to enter the value of the link where users can see your Terms of service." data-original-title="Terms">?</a>
    </li>
    <li class="glyphicons warning_sign">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'roles', $target_id)) }}"><i></i><span>Rules</span></a>
        <a class="explain" data-content="Use this field to enter the value of the link where users can see your competition rules." data-original-title="Rules">?</a>
    </li>
</ul>

<h4>Custom Made Application</h4>
<ul>
    <li class="glyphicons edit">
        <a href="{{ URL::to_route('app_edit_settings',array ($instance->instance, $page, 'css', $target_id)) }}"><i></i><span>CSS</span></a>
        <a class="explain" data-content="If you are not satisfied whit the offered elements and fields in your application, use CSS to create your own design. To do that you have to know how to use HTML code." data-original-title="CSS">?</a>
    </li>
</ul>
@endif
