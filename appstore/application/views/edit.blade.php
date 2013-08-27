@layout('layouts.template')


@section('content')
<div class="row-fluid appstore-header">
    <div class="span5 app_name">
        <!--<h5>You are editing:</h5>-->
    </div>
    <!--button publish-->


    <div class="span3">
        <div class="button_store text">View as:</div>
        <div class="btn-group button_store view_select">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                Select format
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu iframe_size">
                <li><a href="" data-width="810">Facebook Tab - 810px</a> </li>
                <li><a href="" data-width="320">Facebook Mobile - 320px </a></li>
                <li><a href="" data-width="800">Minisite - 800px</a> </li>
            </ul>
        </div>
    </div>


    <!--button view on end-->

    
    <div class="row-fluid store-border">
        <div class="span12 ">
            <ul class="nav nav-tabs store" id="myTabed"> 
                <li class="" >{{ HTML::link_to_route('edit_manager', 'Fan Gate', array($app_istance , 1, $app_lang)) }}</li>
                
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span9">

            <!--fb preview image-->
            <div class="fb_preview" id="app_preview">            
                <h1>Loading..</h1>
            </div>
        </div>
        <!--fb preview image end-->

        <!--page properties-->        
        <div class="span3 properties" >
            <div class="store" id="app_commands">
                <ul class="nav">
                    <li class="nav_title">
                        <a href="">Loading properties</a>    
                    </li>
                </ul>
            </div>
            <!-- Modal -->
            <div id="myModal" class="hide store">
                <div id="myModal_content" class="span12">
                    <p>Loading content</p>
                </div>    
            </div>

        </div>
        <!--page properties end-->
    </div>
</div>
<div class="row-fluid">    
    <div class="span4 pull-right">
        <div class="button_store btn-group pull-right">
            <a class="btn btn-group btn-danger" id="restore_button" href="#">
                Restore original settings
            </a>
        </div>
    </div>
</div>
<script type="text/javascript">
    var APP_URL = '{{ $app_name}}';
    var APP_ID = '{{ $app_istance }}';
    var APP_PAGE = '{{ $app_page }}';
    var APP_LANG = '{{ $app_lang }}';
    var FANGATE = '1';
    var TEMPLATE = '{{ $app_template }}';
</script>

@endsection
