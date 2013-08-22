@if(!empty($end))
<div class="horizontal-zigzag"><hr class="zigzag"></div>
<div class="voting_time">
    <ul id="countdown">
        <li><span class="days">00</span>&nbsp;</li>:
        <li><span class="hours">00</span>&nbsp;</li>:
        <li><span class="minutes">00</span>&nbsp;</li>:
        <li><span class="seconds">00</span>&nbsp;</li>
    </ul>
    {{ HTML::image("img/voting_time.png") }}
</div>
<div class="horizontal-zigzag"><hr class="zigzag"></div>
@endif