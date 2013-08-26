<div class="wrapper">
    <div class="img_container">
        @if (File::extension($item->image) == 'mp4')
            @if(is_array(@getimagesize(URL::to(str_replace('.mp4', '-00001.png', $item->image)))))
            {{ HTML::image(URL::to(str_replace('.mp4', '-00001.png', $item->image))) }}
            @else
            {{ HTML::image(URL::to('img/transcoding.jpg')) }}
            @endif
        @else
        {{ HTML::image(URL::to($item->image)) }}
        @endif
    </div>
	<div class="vote_box">
		<p class="votes_text">{{ $sort_buttons[2]->value }}: </p>
		<p class="votes_number">{{ $item_votes }}/{{ $total_votes }}</p>
	</div>
    <div <?php if(!empty($sort_buttons[1]->property)) echo 'style="background:'.$sort_buttons[1]->property.';"' ?> class="voted_button">
        {{ View::make('type.partials.'.$sort_buttons[1]->type->type)->with('field', $sort_buttons[1])->with('link', URL::to_route('app_show', array ($instance->instance)).'?show=9&sort=votes') }}
    </div>
</div>