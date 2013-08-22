<!doctype html>

<html>
    <head>
        <title>Appssolut APP 2</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        {{ HTML::style('css/bootstrap.css') }}

        <!--[if !IE]><!-->
        {{-- HTML::style('css/bootstrap-responsive.css') --}}
        <!--<![endif]-->

        {{ HTML::script('js/modernizr.custom.28468.js') }}
        <!--[if lte IE 9]>
        {{ HTML::style('css/ie.css') }}
        {{ HTML::script('js/IE9.js') }}
        <![endif]-->

        {{ HTML::style('css/style.css') }}
        <!--[if !IE]><!-->
        {{ HTML::style('css/bootstrap-responsive.css') }}
        <!--<![endif]-->

        <script>
            var APP_URL = "{{ URL::base() }}";
        </script>

        {{ HTML::style('css/jquery.fancybox.css') }}
        
    </head>
    <body>
        <div id="outer-wrap">
            <div id="inner-wrap" class="inner-right">
				<div class="container row-fluid">
                                        <div class="row-fluid">
						<div class="login span10 offset1">
							<h2 class="login_title">
							Connect to proceed
							</h2>
							<p class="login_text">
                                                            Application need access to your basic data in order to proceed, please connect with our Application.
							</p>						
							<div class="separator"></div>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <div class="facebook no-space">
                                                                    <a href="{{ @$url }}" target="_top">Connect</a>
                                                                </div>
                                                            </div>
                                                        </div>
							
						</div>
					</div>
				</div> 
            </div>
        </div>
        {{ HTML::script('js/jquery.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
    </body>
</html>
