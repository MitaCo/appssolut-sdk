<div class="control-group">
	<label class="control-label">Color picker for background</label>
	<div class="controls">
		{{ Form::hidden('property', (!is_null($color) && str_contains($color, '#') ? $color : '#93A6C2')) }}
		{{ Form::text('colorpicker', (!is_null($color) && str_contains($color, '#') ? $color : '#93A6C2')  , array('class' => 'span12', 'id' => 'colorpickerColor')) }}<br/><br/>
		<div id="colorpicker"></div>
	</div>
</div>