@layout('layouts.template')


@section('content')
    <div class="row-fluid appstore_detail" >
		
        <!--button upgrade end-->
        <div class="row-fluid">
            
          
        <!--<div class="span4 fb_view pull-right">
                <a class="view_fb erase" href="#">View on Facebook</a>-->
            
            <div class="row-fluid ">
                <div class="span12 buyed_app" id="no-more-tables">
                	<div class="span4 giveaway st">
               			<span >Review application analytics</span>
                	</div>
                    <div class="span11 no-space">
                        <table class="table table-condensed cf give_table">
                            <thead class="cf">
                                <tr>
                                    <th scope="col">NUMBER OF PARTICIPANTS</th>
                                    <th scope="col">INITIAL N. LIKE</th>
                                    <th scope="col">ACTUAL N. LIKE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-title="NUMBER OF PARTICIPANTS"><span class="participants">0</span></td>
                                    <td data-title="INITIAL N. LIKE">{{ (!empty($element->fblikes) ? $element->fblikes : '0') }}</td>
                                    <td data-title="UNIQUE VISITORS"  class="visitors" id="actuallikes">loading</td>
                                </tr>
                            </tbody>    
                        </table>
                    </div>
                    <div class="button_store btn-group pull-right export">
                    	<a href="{{ URL::base() }}/apps/{{ $app_name }}/admin/{{ $app_istance }}/1/export" class="give_export">Export</a>
                    </div>   
                </div>
                
            </div>

            <hr class="dashed" />

            <div class="row-fluid">
               
                <div class="span12 table_2" id="more-tables">
                    
                </div>
                
            </div>

            <!--<div class="load_more">Load more</div>-->
        </div>
    </div>
    
    <script>
        var APP_ID = '{{ $app_istance }}';
        var APP_URL = '{{ $app_name}}';
        var FB_PAGE_ID = '{{ $element->app_user_apps_publish_fbpage_id }}';
    </script>
@endsection
