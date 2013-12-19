<!doctype html>

<html>
<head>
    <title>{{ $instance->setting->title }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <meta http-Equiv="Cache-Control" Content="no-cache">
    <meta http-Equiv="Pragma" Content="no-cache">
    <meta http-Equiv="Expires" Content="0">
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&amp;subset=latin,latin-ext,cyrillic" rel="stylesheet" type="text/css">
    {{ HTML::style('css/jquery-ui.css') }}
    {{ HTML::style('css/bootstrap.css') }}
    {{ HTML::style('css/jquery.fancybox.css') }}
    {{ HTML::style('css/farbtastic.css') }}
    {{ HTML::style('css/style.css') }}
    {{ HTML::style('css/glyphicons.css') }}
    
    <!--[if !IE]><!-->
        {{ HTML::style('css/bootstrap-responsive.css') }}
    <!--<![endif]-->
    
    {{ HTML::script('js/modernizr.custom.28468.js') }}
    <!--[if lte IE 9]>
        {{ HTML::style('css/ie.css') }}
        <script src="//ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]-->
    <style type="text/css">{{ $instance->setting->css }}</style>
    <script>
        var APP_URL = "{{ APPSOLUTE_FOLDER }}";
        var APP_ID = "{{ $instance->instance }}";
        var APP_PAGE = "{{ $page }}";
        var APP_LANG = "{{ $target_id }}";
        var TEMPLATE = "{{ $template }}";
        var FIRST_TIME = "{{ Session::get('first_time', '0') }}";
    </script>

    
</head>

<body class="multitargeting" style="background-color: transparent;">
    <div id="outer-wrap">
        <div id="inner-wrap" class="inner-right">
            @if(!empty($message))
            <div class="innerLR">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{ $message }}
                </div>
            </div>
            <div class="separator"></div>
            @endif

            <div class="container row-fluid targeting">
                <div class="row-fluid application span9 ">
                    <h4>
                        Review targeted applications
                    </h4>
                    <p>
                        Below you may find different versions of your application based on target audiences you’ve defined. Just click below on the edit button of each target audience and edit that version of your application. 
                    </p>
                    <div id="accordion-targets">
                        <ul class="nav">
                            @foreach($targets as $target)
                                <li class="{{ ($target->id == $target_id ) ? 'current_target' : '' }}">
                                    @if($target->default)
                                        <a class="explain"  data-placement="bottom" data-content="This is the default version of your application that will be visible to all your fans. You can edit the application content by clicking on the Edit Default application version button. It's not allowed to change the targeting settings for the Default version. If you want to make custom target groups by defining the target age, country and language, you can do that by creating a new target group." data-original-title="Default target group">{{ $target->title }} <span>?</span></a>
                                    @else 
                                        <a>{{ $target->title }}</a>
                                    @endif
                                   <div class="targeting_body default">

                                        @if($target->default)
                                            <p>The settings for the default target can not be edited.</p>
                                            <div data-target="1" id="drag-drop-go-back" class="explain" data-placement="bottom" data-content="This feature allows you to edit the default version of your application, that will be visible to everyone, except to the specific targets you define." data-original-title="Edit default application version"><a href="" class="btn explain-btn" >Edit <i>{{ $target->title }}</i> application version <span >?</span></a></div>
                                            <br />
                                            {{ Form::open(URL::to_route('app_update_target', array ($instance->instance, $target->id)), 'PUT', array ('class' => 'localization')) }}
                                            {{-- Form::label('active','Enabled') --}}
                                            <div class="control-group">
                                                {{Form::radio('active', 1, $target->active, array('id' => 'target_'.$target->id.'_active_yes'))}}
                                                {{ Form::label('target_'.$target->id.'_active_yes', 'Enabled') }}
                                            </div>
                                            <!--<select class="selectpicker">
                                                <option>Enabled</option>
                                                <option>Disabled</option>
                                              </select>-->
                                            {{ Form::label('title', 'Title') }}
                                            {{ Form::text('title', $target->title, array ('disabled' => 'disabled')) }}

                                            {{ Form::label('age', 'Target age') }}
                                            {{ Form::select('age', $ages, $target->age_id, array ('disabled' => 'disabled')) }}

                                            {{ Form::label('country', 'Target country') }}
                                            {{ Form::select('country', $countries, $target->country_id, array ('disabled' => 'disabled')) }}

                                            {{ Form::label('language', 'Target language') }}
                                            {{ Form::select('language', $languages, $target->language_id, array ('disabled' => 'disabled')) }}
                                            <div class="clear"></div>
                                            {{-- Form::submit('Show', array ('class' => 'modal-button btn')) --}}
                                            {{ Form::close() }}

                                        @else
                                        <p>Click on "Edit {{ $target->title }} application version" and set new features you want this app version to have.</p>
                                            <div data-target="{{$target->id}}" id="drag-drop-go-back"><a href="" class="btn">Edit <i>{{ $target->title }}</i> application version</a></div>
                                            <br />
                                            {{ Form::open(URL::to_route('app_update_target', array ($instance->instance, $target->id)), 'PUT', array ('class' => 'localization')) }}
                                            {{-- Form::label('active','Enabled') --}}
                                            <div class="control-group">
                                                {{Form::radio('active', 1, $target->active, array('id' => 'target_'.$target->id.'_active_yes'))}}
                                                {{ Form::label('target_'.$target->id.'_active_yes', 'Enabled') }}
                                                {{Form::radio('active', 0, !$target->active, array('id' => 'target_'.$target->id.'_active_no'))}}
                                                {{ Form::label('target_'.$target->id.'_active_no', 'Disabled') }}
                                            </div>
                                            <!--<select class="selectpicker">
                                                <option>Enabled</option>
                                                <option>Disabled</option>
                                              </select>-->

                                            {{ Form::label('title', 'Title') }}
                                            {{ Form::text('title', $target->title, array ('maxlength' => '17')) }}

                                            {{ Form::label('age', 'Target age') }}
                                            {{ Form::select('age', $ages, $target->age_id) }}

                                            {{ Form::label('country', 'Target country') }}
                                            {{ Form::select('country', $countries, $target->country_id) }}

                                            {{ Form::label('language', 'Target language') }}
                                            {{ Form::select('language', $languages, $target->language_id) }}

                                            {{ Form::submit('Save', array ('class' => 'modal-button btn')) }}
                                            {{ Form::close() }}
                                        @endif

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="span3 store">
                    <h4 class="explain" data-placement="bottom" data-content="This feature allows you to design different versions of one application to different target audiences. You can create new target groups by defining the group age, country and language." data-original-title="Create target group">Create target group for your application <span>?</span></h4>
                    <div id="accordion-create-target" >
                        
                        <div class="">
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

                            {{-- Form::label('active','Enabled') --}}
                            <div class="control-group">
                                {{Form::radio('active', 1, 1, array('id' => 'active_yes'))}}
                                {{ Form::label('active_yes', 'Enable') }}
                                {{Form::radio('active', 0, 0, array('id' => 'active_no'))}}
                                {{ Form::label('active_no', 'Disable') }}
                            </div>

                            {{ Form::submit('Create', array ('class' => 'modal-button btn')) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                    <div id="drag-drop-go-back"><a href="#" class="btn back">Back to Settings</a></div>
                </div>
            </div>
        </div>

    </div>
    <a class="inline_content" href="#inline"></a>
    <div id="inline">
        This section allows you to design and publish different versions of one application to different target audiences. For example, you may want to define different language versions of your application for different geographical areas. You can do it by setting as many target groups as you want in the menu, at the right side of your screen. Each new target group will appear in your working area. Just click edit, and you’ll be able to design and set different versions of your application. Note that default version of application will be visible to everyone, except to the specific targets you define.
    </div>

    {{ HTML::script('js/jquery.js') }}
    {{ HTML::script('js/jquery-ui.min.js') }}
    {{ HTML::script('js/jquery.showLoading.js') }}
    {{ HTML::script('js/dragdrop.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/jquery.fancybox.pack.js') }}
    <script>
        $(document).ready(function() {
            $(".various").fancybox({
                width       : '85%',
                height      : '85%',
                autoSize    : false,
                closeClick  : false,
                openEffect  : 'none',
                closeEffect : 'none'
            });
        });
        if (FIRST_TIME != 0 && $('.inline_content').length){
            $(".inline_content").fancybox({width : '55%',height : 'auto', autoSize : false, wrapCSS : 'fancybox-multitargeting'}).trigger('click');
        }
    
    </script>
</body>
</html>