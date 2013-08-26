<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="shortcut icon" href="/favicon.ico">
        <meta name="viewport" content="width=device-width">
        <link href='//fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/bootstrapSwitch.css') }}
        {{ HTML::style('css/jquery-ui.css') }}
        {{ HTML::style('css/farbtastic.css') }}
        {{ HTML::style('css/bootstrap-wysihtml5.css') }}
        {{ HTML::style('css/style.css') }}
        {{ HTML::style('css/bootstrap-responsive.css') }}
        {{ HTML::style('css/jquery.fancybox.css') }}
        <!-- Glyphicons -->
        {{ HTML::style('theme/css/glyphicons.css') }}
        {{ HTML::style('css/chosen.css') }}

        {{ HTML::style('css/appstore.css') }}



        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          {{ HTML::script('js/html5.js') }}
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="/favicon.ico">
        <script type="text/javascript">
            var APP_URL = "{{ URL::base() }}";
        </script>


    </head>

    <body id="appstore">
        <div id="outer-wrap">
            <div id="inner-wrap" class="inner-right">
                <div class="navbar navbar-inverse nav_store">
                    <div class="navbar-inner">
                        <div class="container">
                            <div class="row-fluid">
                                <div>
                                    <a class="brand" href="http://appssolut.com">
                                        <img src="{{URL::base()}}/img/logo.png"/>
                                    </a>
                                </div>
                                <div>
                                    <div class="store top">
                                        <ul class="nav menu">
                                            <li class="campaign">
                                                <a href="{{URL::base()}}">My Campaigns</a> 
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    @if(!empty($message))
                    <div class="innerLR">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ $message }}
                        </div>
                    </div>
                    <div class="separator"></div>
                    @endif
                    <div class="row-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>

            <footer>
                    <div class="navbar-inverse info-container">
                    <div class="navbar-inner">
                        <div class="container">
                            <p>Copyright ©<span> 2013 APPSSOLUT</span></p>
                        </div>
                    </div>
                    </div>
                </footer>
        </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    {{ HTML::script('js/wysihtml5-0.3.0.js') }}
    {{ HTML::script('js/jquery.js') }}
    {{ HTML::script('js/jquery-ui.min.js') }}
    {{ HTML::script('js/jquery-ui-timepicker-addon.js') }}
   
    {{ HTML::script('js/farbtastic.js') }}
    
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/jquery.rating.pack.js') }}
    {{ HTML::script('js/jquery.fancybox.pack.js') }}
    {{ HTML::script('js/jquery.mjs.nestedSortable.js') }}
    {{ HTML::script('js/bootstrap-wysihtml5.js') }}
    {{ HTML::script('js/generalCms.js') }}

    <!--File upload files-->
    {{ HTML::script('js/jquery.knob.js') }}
    {{ HTML::script('js/jquery.ui.widget.js') }}
    {{ HTML::script('js/jquery.iframe-transport.js') }}
    {{ HTML::script('js/jquery.fileupload.js') }}
    {{ HTML::script('js/chosen.jquery.min.js') }}

    {{ HTML::script('js/app-comunication.js') }}
</body>
</html>
