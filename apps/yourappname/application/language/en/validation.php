<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used
    | by the validator class. Some of the rules contain multiple versions,
    | such as the size (max, min, between) rules. These versions are used
    | for different input types such as strings and files.
    |
    | These language lines may be easily changed to provide custom error
    | messages in your application. Error messages for custom validation
    | rules may also be added to this file.
    |
    */

    "accepted"       => "This field must be accepted.",
    "active_url"     => "This field is not a valid URL.",
    "after"          => "This field must be a date after :date.",
    "alpha"          => "This field may only contain letters.",
    "alpha_dash"     => "This field may only contain letters, numbers, and dashes.",
    "alpha_num"      => "This field may only contain letters and numbers.",
    "array"          => "This field must have selected elements.",
    "before"         => "This field must be a date before :date.",
    "between"        => array(
        "numeric" => "This field must be between :min - :max.",
        "file"    => "This field must be between :min - :max kilobytes.",
        "string"  => "This field must be between :min - :max characters.",
    ),
    "confirmed"      => "This field confirmation does not match.",
    "count"          => "This field must have exactly :count selected elements.",
    "countbetween"   => "This field must have between :min and :max selected elements.",
    "countmax"       => "This field must have less than :max selected elements.",
    "countmin"       => "This field must have at least :min selected elements.",
    "date_format"	 => "This field must have a valid date format.",
    "different"      => "This field must be different.",
    "email"          => "This field format is invalid.",
    "exists"         => "The selected value is invalid.",
    "image"          => "This field must be an image.",
    "in"             => "The selected value is invalid.",
    "integer"        => "This field must be an integer.",
    "ip"             => "This field must be a valid IP address.",
    "match"          => "This field format is invalid.",
    "max"            => array(
        "numeric" => "This field must be less than :max.",
        "file"    => "This field must be less than :max kilobytes.",
        "string"  => "This field must be less than :max characters.",
    ),
    "mimes"          => "This field must be a file of type: :values.",
    "min"            => array(
        "numeric" => "This field must be at least :min.",
        "file"    => "This field must be at least :min kilobytes.",
        "string"  => "This field must be at least :min characters.",
    ),
    "not_in"         => "The selected value is invalid.",
    "numeric"        => "This field must be a number.",
    "required"       => "This field is required.",
    "required_with"  => "This field is required",
    "same"           => "The confirmation does not match.",
    "size"           => array(
        "numeric" => "This field must be :size.",
        "file"    => "This field must be :size kilobyte.",
        "string"  => "This field must be :size characters.",
    ),
    "unique"         => "This value has already been taken.",
    "url"            => "This url format is invalid.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute_rule" to name the lines. This helps keep your
    | custom validation clean and tidy.
    |
    | So, say you want to use a custom validation message when validating that
    | the "email" attribute is unique. Just add "email_unique" to this array
    | with your custom message. The Validator will handle the rest!
    |
    */

    'custom' => array(),

    /*
    |--------------------------------------------------------------------------
    | Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". Your users will thank you.
    |
    | The Validator class will automatically search this array of lines it
    | is attempting to replace the :attribute place-holder in messages.
    | It's pretty slick. We think you'll like it.
    |
    */

    'attributes' => array(),

);
