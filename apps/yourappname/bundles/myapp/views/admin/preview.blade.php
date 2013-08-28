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
    {{ HTML::style('css/style.css') }}
    <!--[if !IE]><!-->
    {{ HTML::style('css/bootstrap-responsive.css') }}
    <!--<![endif]-->
    <!--[if lte IE 9]>
    {{ HTML::style('css/ie.css') }}
    {{ HTML::script('js/IE9.js') }}
    <![endif]-->
    <style type="text/css">{{ $instance->setting->css }}</style>

    <script>
        var APP_URL = "{{ URL::base() }}";
    </script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="outer-wrap">
    <div id="inner-wrap" class="inner-right">
        <div class="container row-fluid">

            <!-- NOTIFICATION MESSAGE -->
            @if(!empty($message))
            <div class="innerLR"><div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button>{{ $message }}</div></div>
            <div class="separator"></div>
            @endif

            <!-- APPLICATION -->
            <div class="row-fluid application">
                <?php $back = str_contains(@$instance->setting->background, '#') ? (!empty($instance->setting->background) ? $instance->setting->background : '#FFFFFF') : "url(".URL::to(@$instance->setting->background).")"; ?>
                <div class="voting_app span12" {{ ($page == 1) ? '' : 'style="background:'.$back.'"' }}>

                <!-- FIELDS -->
                @foreach($fields as $field)
                <div class="{{ $field->type->type }}" id="field_{{ $field->id }}">
                    {{ View::make('type.partials.'.$field->type->type)->with('field', $field)->with('disabled', array('disabled' => 'disabled'))->with('instance', $instance)->with('page', $page) }}
                </div>
                @endforeach

                <div class="line">&nbsp;</div>

                <!-- PRIVACY LINKS -->
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
    </div>
</div>
</div>
{{ HTML::script('js/jquery.js') }}
{{ HTML::script('js/jquery-ui.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/jquery.fancybox.pack.js') }}
{{ HTML::script('js/custom.js') }}
</body>
</html>
