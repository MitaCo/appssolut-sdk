<!doctype html>

<html>
<head>
    <title>{{ $instance->setting->title }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
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
        var END_DATE = "{{ $end }}";
    </script>
</head>

<body class="manage">
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

        <div class="container row-fluid">
            <div class="row-fluid application span9">
                <?php $back = str_contains(@$instance->setting->background, '#') ? (!empty($instance->setting->background) ? $instance->setting->background : '#FFFFFF') : "url(".URL::to(@$instance->setting->background).")"; ?>
                <div class="wrapper" style="background:{{$back}} ">
                    <ul id="sortable">

                        @foreach($fields as $field)
                        <li id="field_{{$field->id}}" class="glyphicons bin pencil">
                            <div class="{{ $field->type->type }}" id="field_{{ $field->id }}">
                                {{ View::make('type.partials.'.$field->type->type)->with('field', $field)->with('disabled', array('disabled' => 'disabled'))->with('instance', $instance)->with('page', $page)->with('end', $end) }}
                            </div>
                            <a href="{{ URL::to_route('app_edit_field', array ($instance->instance, $page, $field->id, $target_id)) }}" class="edit-field"><i class="editItem"></i></a>
                            <a href="" class="delete-field"><i class="deleteItem"></i></a>
                        </li>
                        @endforeach

                    </ul>
                    <div class="line">&nbsp;</div>

                    <ul class="footer_list">
                        @if (!empty($instance->setting->privacy))
                        <li>
                            @if (filter_var($instance->setting->privacy, FILTER_VALIDATE_URL))
                            {{ HTML::link($instance->setting->privacy, 'Privacy', array ('class' => 'footerlink', 'target' => '_blank')) }}
                            @else
                            {{ HTML::link(URL::to_route('app_info', array($instance->instance, $page, 'privacy')), 'Privacy', array ('class' => 'various fancybox.ajax')) }}
                            @endif
                        </li>
                        @endif
                        @if (!empty($instance->setting->terms))
                        <li>
                            @if (filter_var($instance->setting->terms, FILTER_VALIDATE_URL))
                            {{ HTML::link($instance->setting->terms, 'Terms', array ('class' => 'footerlink', 'target' => '_blank')) }}
                            @else
                            {{ HTML::link(URL::to_route('app_info', array($instance->instance, $page, 'terms')), 'Terms', array ('class' => 'various fancybox.ajax')) }}
                            @endif
                        </li>
                        @endif
                        @if (!empty($instance->setting->roles))
                        <li>
                            @if (filter_var($instance->setting->roles, FILTER_VALIDATE_URL))
                            {{ HTML::link($instance->setting->roles, 'Rules', array ('class' => 'footerlink', 'target' => '_blank')) }}
                            @else
                            {{ HTML::link(URL::to_route('app_info', array($instance->instance, $page, 'roles')), 'Rules', array ('class' => 'various fancybox.ajax')) }}
                            @endif
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="span3">
                <h5>Types</h5>
                <ul class="draggable">
                    @foreach ($types as $type)
                    <li id="type_{{$type->id}}" class="glyphicons app-{{$type->type}}"><a><i></i><span>{{ $type->name }}</span></a></li>
                    @endforeach
                </ul>
                <div id="drag-drop-go-back" class="glyphicons left_arrow"><a href="#"><i></i><span>Back to Settings</span></a></div>
            </div>
        </div>

        <!-- Modal -->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div id="myModal_content" class="modal_popup">
            </div>
        </div>

    </div>

</div>


{{ HTML::script('//'.Request::server('HTTP_HOST').'/js/jquery-1.8.2.min.js') }}
{{ HTML::script('//'.Request::server('HTTP_HOST').'/js/jquery-ui.min.js') }}
{{ HTML::script('js/jquery.showLoading.js') }}
<!--File upload files-->
{{ HTML::script('js/jquery.knob.js') }}
{{ HTML::script('js/jquery.ui.widget.js') }}
{{ HTML::script('js/jquery.iframe-transport.js') }}
{{ HTML::script('js/jquery.fileupload.js') }}

{{ HTML::script('js/countdown.js') }}
{{ HTML::script('js/counter.js') }}

{{ HTML::script('js/dragdrop.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/jquery.fancybox.pack.js') }}
{{ HTML::script('js/farbtastic.js') }}
<script>
    $(document).ready(function() {
        $(".various").fancybox({
            width		: '60%',
            height		: '60%',
            autoSize	: false,
            closeClick	: false,
            openEffect	: 'none',
            closeEffect	: 'none'
        });
    });
</script>
</body>
</html>