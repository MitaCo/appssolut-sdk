<!doctype html>

<html>
    <head>
        <title>Appssolut Contact app</title>
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
        <script type="text/javascript">
            window.top.location = "{{ $url }}";
        </script>

    </head>
    <body>
        <div id="outer-wrap">
            <div id="inner-wrap" class="inner-right">
                <div class="container row-fluid">
                    <div class="row-fluid">
                        <div class="login span10 offset1">
                            <h2 class="login_title">
                                Redirect to application
                            </h2>

                            <a href="{{ $url }}" target="_top">Redirect</a>


                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </body>
</html>
