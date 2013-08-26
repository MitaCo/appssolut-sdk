<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>{{@$seo_title}}</title>
        <link rel="shortcut icon" href="/favicon.ico">
        <meta name="viewport" content="width=device-width">
        <link href='//fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('bundles/appstore/css/bootstrapSwitch.css') }}
        {{ HTML::style('css/jquery-ui.css') }}
        {{ HTML::style('bundles/appstore/css/farbtastic.css') }}
        {{ HTML::style('bundles/appstore/css/bootstrap-wysihtml5.css') }}
        {{-- HTML::style('bundles/appstore/css/cms.css') --}}
        {{ HTML::style('css/style.css') }}
        {{ HTML::style('css/bootstrap-responsive.css') }}
        {{ HTML::style('css/jquery.fancybox.css') }}
        <!-- Glyphicons -->
        {{ HTML::style('bundles/cms/theme/css/glyphicons.css') }}
        {{ HTML::style('bundles/appstore/css/chosen.css') }}

        {{ HTML::style('bundles/appstore/css/appstore.css') }}



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
                                    <a class="brand" href="{{URL::base()}}">
                                        <img src="{{URL::base()}}/img/logo.png"/>
                                    </a>
                                </div>
                                <div>
                                    <div class="store top">
                                        <ul class="nav menu">
                                            <li class="start">
                                                <a href="{{URL::base()}}/appstore/applist">Start New</a>    
                                            </li>
                                            <li class="campaign">
                                                <a href="{{URL::base()}}/appstore">My Campaigns</a> 
                                            </li>
                                            
                                            @if (!empty($pagelist)) 
                                                <li class="dropdown camp_active">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Edit Active </a>
                                                    <ul class="dropdown-menu">  
                                                        <?php $lastpage = 0; ?>
                                                        @foreach ($pagelist as $fbpage)
                                                            @if($lastpage != $fbpage->app_user_apps_publish_fbpage_id)
                                                                <li class="nav-header">{{ $fbpage->fbpage_name }}</li>
                                                                <?php $lastpage = $fbpage->app_user_apps_publish_fbpage_id; ?>
                                                            @endif
                                                            <li><a href="{{ URL::to_route('edit_manager', array($fbpage->app_user_apps_publish_page_id)) }}">{{ (!empty($fbpage->tab_title) ? $fbpage->tab_title : $fbpage->app_app->app_apps_name)  }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else                                               
                                                <li class="camp_active">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Edit Active</a>
                                                </li>
                                            @endif
                                            <!--<li class="camp_analitics">
                                                 <a href="{{URL::to_route('analytics_manager')}}">Campaign Analytics</a>   
                                            </li>-->
                                            @if (!empty($pagelist)) 
                                                <li class="dropdown camp_analitics">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campaign Analytics </a>
                                                    <ul class="dropdown-menu">  
                                                        <?php $lastpage = 0; ?>
                                                        @foreach ($pagelist as $fbpage)
                                                            @if($lastpage != $fbpage->app_user_apps_publish_fbpage_id)
                                                                <li class="nav-header">{{ $fbpage->fbpage_name }}</li>
                                                                <?php $lastpage = $fbpage->app_user_apps_publish_fbpage_id; ?>
                                                            @endif
                                                            <li><a href="{{ URL::to_route('detail_manager', array($fbpage->app_user_apps_publish_page_id)) }}">{{ (!empty($fbpage->tab_title) ? $fbpage->tab_title : $fbpage->app_app->app_apps_name)  }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else                                               
                                                <li class="camp_analitics">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Campaign Analytics</a>
                                                </li>
                                            @endif
                                            <li class="camp_support">
                                                <a href="{{URL::to_route('home_support')}}">Support</a>   
                                            </li>
                                        </ul>
                                        <ul class="nav menu pull-right">
                                            
                                            <li class="camp_logout">
                                                <a href="{{URL::to_route('do_logout')}}">Logout</a>    
                                            </li>
                                            <li class="store-login btn-group">
                                                    <div class="pix" >
                                                        @if (!empty($user->facebook_uid)) 
                                                        <img width="40" src="https://graph.facebook.com/{{ $user->facebook_uid }}/picture"/>                                            
                                                        @else
                                                        <img width="40" src="{{URL::base()}}/img/anonymous_user_icon.jpg"/>
                                                        @endif
                                                    </div>
                                                    <div class="log dropdown-toggle" data-toggle="dropdown">
                                                    {{ $user->app_user_username }}
                                                        <b class="caret"></b>
                                                        <span>{{ $user->app_user_first_name }} {{ $user->app_user_last_name }}</span>
                                                        
                                                    </div>
                                                    <ul class="dropdown-menu store_drop camp_analitics" role="menu" aria-labelledby="dLabel">
                                                        <li class="nav-header"><a href="{{URL::to_route('get_change_password')}}">Change password</a></li>
                                                        <!--<li>{{ HTML::link_to_route('do_logout', 'Logout');}}</li>-->
                                                    </ul>
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
                            {{-- Module_Controller::load('footer-menu') --}}
                        </div>
                    </div>
                    </div>
                </footer>
        </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    {{ HTML::script('bundles/appstore/js/wysihtml5-0.3.0.js') }}
    {{ HTML::script('js/jquery.js') }}
    {{ HTML::script('js/jquery-ui.min.js') }}
    {{ HTML::script('bundles/appstore/js/jquery-ui-timepicker-addon.js') }}
   
    {{ HTML::script('bundles/appstore/js/farbtastic.js') }}
    
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/jquery.rating.pack.js') }}
    {{ HTML::script('js/jquery.fancybox.pack.js') }}
    {{-- HTML::script('bundles/appstore/js/bootstrapSwitch.js') --}}
    {{ HTML::script('bundles/appstore/js/jquery.mjs.nestedSortable.js') }}
    {{ HTML::script('bundles/appstore/js/bootstrap-wysihtml5.js') }}
    {{ HTML::script('bundles/appstore/js/generalCms.js') }}

    <!--File upload files-->
    {{ HTML::script('bundles/appstore/js/jquery.knob.js') }}
    {{ HTML::script('bundles/appstore/js/jquery.ui.widget.js') }}
    {{ HTML::script('bundles/appstore/js/jquery.iframe-transport.js') }}
    {{ HTML::script('bundles/appstore/js/jquery.fileupload.js') }}
    {{ HTML::script('bundles/appstore/js/chosen.jquery.min.js') }}

    {{ HTML::script('bundles/appstore/js/app-comunication.js') }}
    {{ View::make('partials/_ga')->render() }}
</body>
</html>
