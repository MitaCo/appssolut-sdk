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
        var END_DATE = "{{ $end }}";
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
                <div class="voting_app span12" {{ (($page == 1) or ($page == 4)) ? '' : 'style="background:'.$back.'"' }}>

                <!-- FIELDS -->
                @foreach($fields as $field)
                <div class="{{ $field->type->type }}" id="field_{{ $field->id }}">
                    {{ View::make('type.partials.'.$field->type->type)->with('field', $field)->with('disabled', array('disabled' => 'disabled'))->with('instance', $instance)->with('page', $page)->with('end', $end) }}
                </div>
                @endforeach

                <!-- BACK BUTTON FOR THANK YOU PAGE -->
                @if($page == 4)
                <div <?php if(!empty($sort_buttons[0]->property)) echo 'style="background:'.$sort_buttons[0]->property.';"' ?> class="sort_items_4">{{ View::make('type.partials.'.$sort_buttons[0]->type->type)->with('field', $sort_buttons[0])->with('link', URL::to_route('app_preview', array ($instance->instance, '3', $fangate, $target_id)).'?show=9&sort=votes') }}</div>
                @endif

                <!-- ITEMS FOR VOTING -->
                @if(!empty($items))
                <!-- SORT BUTTONS -->
                <div <?php if(!empty($sort_buttons[0]->property)) echo 'style="background:'.$sort_buttons[0]->property.';"' ?> class="sort_items_{{$sort_buttons[0]->order}}">{{ View::make('type.partials.'.$sort_buttons[0]->type->type)->with('field', $sort_buttons[0])->with('link', URL::to_route('app_preview', array ($instance->instance, $page, $fangate, $target_id)).'?show=9') }}</div>
                <div <?php if(!empty($sort_buttons[1]->property)) echo 'style="background:'.$sort_buttons[1]->property.';"' ?> class="sort_items_{{$sort_buttons[1]->order}}">{{ View::make('type.partials.'.$sort_buttons[1]->type->type)->with('field', $sort_buttons[1])->with('link', URL::to_route('app_preview', array ($instance->instance, $page, $fangate, $target_id)).'?show=9&sort=votes') }}</div>

                <div class="span12 no-space">
                    @foreach($items->results as $item)

                    <!-- ITEM -->
                    <div class="span4">

                        <!-- IMAGE -->
                        <div class="img_container">
                            @if (File::extension($item->image) == 'mp4')
                            <!-- VIDEO -->
                            <a href="{{ URL::to_route('app_detail', array($instance->instance, $item->id)) }}" class="fancybox-video fancybox.ajax" title="{{ $item->title }}" >
                                <div class="overlay-video"></div>
                                @if(is_array(@getimagesize(URL::to(str_replace('.mp4', '-00002.png', $item->image)))))
                                {{ HTML::image(URL::to(str_replace('.mp4', '-00002.png', $item->image))) }}
                                @else
                                {{ HTML::image(URL::to(str_replace('.mp4', '-00001.png', $item->image))) }}
                                @endif
                            </a>
                            @else
                            <!-- PHOTO -->
                            <a href="{{ URL::to_route('app_detail', array($instance->instance, $item->id)) }}" class="fancybox-image fancybox.ajax" title="{{ $item->title }}" >
                                <div class="overlay-photo"></div>
                                {{ HTML::image(URL::to($item->image)) }}
                            </a>
                            @endif
                            <div class="title">{{$item->title}}</div>
                        </div>

                        <!-- ITEM BUTTONS -->
                        <div class="voting_detail">

                            <!-- FACEBOOK LIKE AND SHARE -->
                            <div class="share_like">
                                <div class="fb-like" data-href="{{ empty($item->url) ? URL::to_route('app_item_detail', array($instance->instance, $item->id)) : $item->url }}" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ empty($item->url) ? URL::to_route('app_item_detail', array($instance->instance, $item->id)) : $item->url }}" target="_blank">Share</a>
                            </div>

                            <!-- VOTE BUTTON -->
                            <div class="vote">
                                {{ Form::open(null, 'POST', array ()) }}
                                {{ View::make('type.partials.'.$item_buttons[0]->type->type)->with('field', $item_buttons[0])->with('disabled', array ('disabled' => 'disabled')) }}
                                {{ Form::close() }}
                            </div>

                            <!-- VIEW RESULTS BUTTON AND NUMBER OF VOTES-->
                            <div <?php if(!empty($item_buttons[1]->property)) echo 'style="background:'.$item_buttons[1]->property.';"' ?> class="check_results">{{ View::make('type.partials.'.$item_buttons[1]->type->type)->with('field', $item_buttons[1])->with('link', URL::to_route('app_preview_item_result', array ($instance->instance, $item->id, $template_id, $target_id)))->with('options', array ('class' => 'item-result-detail fancybox.ajax')) }}</div>
                            <div <?php if(!empty($item_buttons[2]->property)) echo 'style="background:'.$item_buttons[2]->property.';"' ?> class="voting_results"><span>{{ $votes[$item->id] }}</span>{{ View::make('type.partials.'.$item_buttons[2]->type->type)->with('field', $item_buttons[2]) }}</div>

                            <!-- ENLARGE PHOTO/VIDEO -->
                            @if (File::extension($item->image) == 'mp4')
                            <div <?php if(!empty($item_buttons[3]->property)) echo 'style="background:'.$item_buttons[3]->property.';"' ?> class="enlarge">{{ View::make('type.partials.'.$item_buttons[3]->type->type)->with('field', $item_buttons[3])->with('link', URL::to_route('app_detail', array($instance->instance, $item->id)))->with('options', array ('class' => 'fancybox-video fancybox.ajax', 'title' => $item->title)) }}</div>
                            @else
                            <div <?php if(!empty($item_buttons[3]->property)) echo 'style="background:'.$item_buttons[3]->property.';"' ?> class="enlarge">{{ View::make('type.partials.'.$item_buttons[3]->type->type)->with('field', $item_buttons[3])->with('link', URL::to_route('app_detail', array($instance->instance, $item->id)))->with('options', array ('class' => 'fancybox-image fancybox.ajax', 'title' => $item->title)) }}</div>
                            @endif

                            <!-- ITEM PRICES -->
                            <div class="price">
                                @if(!empty($item->regular_price))
                                <div class="reg_price">{{ str_replace('</p>', ': '.$item->regular_price.'</p>', View::make('type.partials.'.$item_buttons[4]->type->type)->with('field', $item_buttons[4])) }}</div>
                                @endif
                                @if(!empty($item->discounted_price))
                                <div class="dis_price">{{ str_replace('</p>', ': '.$item->discounted_price.'</p>', View::make('type.partials.'.$item_buttons[5]->type->type)->with('field', $item_buttons[5])) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- ITEM PAGINATION -->
                <div class="span12 no-space row-fluid">
                    @if($sort == 'votes')
                    {{ $items->appends(array('sort' => 'votes'))->links() }}
                    @else
                    {{ $items->links() }}
                    @endif
                </div>

                <!-- BACK AND INVITE BUTTONS -->
                @if(!empty($show) && ($page == 3))
                <div <?php if(!empty($sort_buttons[3]->property)) echo 'style="background:'.$sort_buttons[3]->property.';"' ?> class="sort_items_{{$sort_buttons[3]->order}}">{{ View::make('type.partials.'.$sort_buttons[3]->type->type)->with('field', $sort_buttons[3])->with('link', URL::to_route('app_preview', array ($instance->instance, $page, $fangate, $target_id))) }}</div>
                @endif
                <div <?php if(!empty($sort_buttons[4]->property)) echo 'style="background:'.$sort_buttons[4]->property.';"' ?> class="sort_items_{{$sort_buttons[4]->order}}">{{ View::make('type.partials.'.$sort_buttons[4]->type->type)->with('field', $sort_buttons[4])->with('link', '#') }}</div>

                <!-- END ITEMS -->
                @endif

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

<!-- NOTIFICATION -->
<div id="info-msg" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">{{ $instance->setting->title }}</h3>
    </div>
    <div class="modal-body">
        <p>{{ $app_message }}</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

{{ HTML::script('js/jquery.js') }}
{{ HTML::script('js/jquery-ui.min.js') }}
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/countdown.js') }}
{{ HTML::script('js/counter.js') }}
{{ HTML::script('js/jquery.fancybox.pack.js') }}
{{ HTML::script('js/jwplayer.js') }}
{{ HTML::script('js/jwplayer.html5.js') }}
{{ HTML::script('js/custom.js') }}
</body>
</html>
