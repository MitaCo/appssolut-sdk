{{ Form::submit($field->value, !empty($disabled) ? array('class' => 'item-disabled', 'style' => 'background:'.(!empty($field->property) ? $field->property : '#93A6C2')) : array('style' => 'background:'.(!empty($field->property) ? $field->property : '#93A6C2'))) }}