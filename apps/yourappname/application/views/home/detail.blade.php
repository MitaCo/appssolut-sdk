<div class="detail-media">
    @if (File::extension($item->image) == 'mp4')
    <!-- VIDEO -->
    <div id="video_container" title="{{ URL::to($item->image) }}">Loading video... </div>
    @else
    <!-- PHOTO -->
    {{ HTML::image(URL::to($item->image)) }}
    @endif
</div>

<div class="detail-info">
    <h2>{{ $item->title }}</h2>
    <p>{{ $item->description }}</p>
</div>