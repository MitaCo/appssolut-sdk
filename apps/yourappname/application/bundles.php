<?php

return array(
    'facebook-sdk' => array('auto' => true),
    's3' => array('auto' => true),
    
    'myapp' => array('auto' => true,
        'autoloads' => array(
            'directories' => array(
                '(:bundle)/models'
            )
        ),
    ), 
);