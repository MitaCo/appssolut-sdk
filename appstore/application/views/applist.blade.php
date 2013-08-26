@layout('layouts.template')
@section('content')
<div class="buyed_app" id="no-more-tables">
    @if($applist)
    <table class="cf">
        <thead class="cf">
            <tr>
                <th scope="col">Application</th>
                <th scope="col">Facebook link</th>
                <th scope="col">Link to Mobile</th>
                <th scope="col">Preview/Edit</th>
                <th scope="col">Campaign Details</th>
            </tr>
        </thead>
        <tbody>
            <?php $pack = 0; ?>
            @foreach ($applist as $key => $app)
            <tr>                
                <td >{{ (!empty($app->tab_title) ? $app->tab_title : $app->app_app->app_apps_name)  }}</td>
                
                @if(!empty($app->fblink))
                <td ><a href="{{ $app->fblink }}" class="detail" target="_blank">View on <b>{{ $app->fbpage_name}}</b></a></td>
                @else
                <td ><a href="{{ URL::to_route('man_getpages', array($app->app_user_apps_publish_page_id )) }}" class="preview">Publish Now</a></td>
                @endif
                @if ($app->status == 'A')
                <td><a href="{{ URL::base() }}/apps/{{ $app->app_app->app_apps_application()->first()->app_folder }}/{{ $app->app_user_apps_publish_page_id }}" class="detail" target="_blank" >Link to Mobile</a></td>
                @else
                    <td >Buy to get Link</td>
                @endif
                
                <td ><a href="{{ URL::to_route('edit_manager', array($app->app_user_apps_publish_page_id)) }}" class="preview">Preview/Edit</a></td>
                <td ><a href="{{ URL::to_route('detail_manager', array($app->app_user_apps_publish_page_id)) }}" class="detail">Detail</a></td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <h2>You don't have any applications yet!</h2>
    @endif
</div>
@endsection
