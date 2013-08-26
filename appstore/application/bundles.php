<?php

/*
  |--------------------------------------------------------------------------
  | Bundle Configuration
  |--------------------------------------------------------------------------
  |
  | Bundles allow you to conveniently extend and organize your application.
  | Think of bundles as self-contained applications. They can have routes,
  | controllers, models, views, configuration, etc. You can even create
  | your own bundles to share with the Laravel community.
  |
  | This is a list of the bundles installed for your application and tells
  | Laravel the location of the bundle's root directory, as well as the
  | root URI the bundle responds to.
  |
  | For example, if you have an "admin" bundle located in "bundles/admin"
  | that you want to handle requests with URIs that begin with "admin",
  | simply add it to the array like this:
  |
  |		'admin' => array(
  |			'location' => 'admin',
  |			'handles'  => 'admin',
  |		),
  |
  | Note that the "location" is relative to the "bundles" directory.
  | Now the bundle will be recognized by Laravel and will be able
  | to respond to requests beginning with "admin"!
  |
  | Have a bundle that lives in the root of the bundle directory
  | and doesn't respond to any requests? Just add the bundle
  | name to the array and we'll take care of the rest.
  |
 */

return array(
    'bob',
    /*
      'docs' => array(
      'handles' => 'docs'
      ),
     */
    'swiftmailer' => array('auto' => true),
    's3' => array('auto' => true),
    'oauth2' => array(
        'auto' => true,
        'handles' => 'oauth2',
        'autoloads' => array(
            'directories' => array(
                '(:bundle)/models'
            )
        ),
    ),
    'facebook-sdk' => array('auto' => true),
    'cms' => array(
        'auto' => true,
        'handles' => 'cms',
        'autoloads' => array(
            'directories' => array(
                '(:bundle)/models'
            )
        ),
    ),
    'finance' => array(
        'auto' => true,
        'handles' => 'finance'
    ),
    'html2pdf' => array(
        'auto' => true,
    ),
    'appstore' => array(
        'auto' => true,
        'handles' => 'appstore',
        'autoloads' => array(
            'directories' => array(
                '(:bundle)/models'
            )
        ),
    ),
    'support' => array(
        'auto' => true,
        'handles' => 'support',
    ),
    'devcenter' => array(
        'auto' => true,
        'handles' => 'devcenter',
    ),
    'browser' => array(
        'auto' => true
    ),
    'locate' => array(
        'auto' => true
    ),
    'httpful' => array(
        'auto' => true,
    )
);