<!doctype html>
<html>
<head>
    <title>Appssolut application</title>
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
</head>
<body>
<div id="outer-wrap">
    <div id="inner-wrap" class="inner-right">
        <div class="container row-fluid">
            
            <h1>{{ $msg }}</h1>
        </div>
    </div>
</div>
{{ HTML::script('js/jquery.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
</body>
</html>