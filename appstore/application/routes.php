<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::any('/', 'page@index');
Route::get('m', 'page@m');
Route::get(array('(:any)/detail/(:num)', 'application/(:num)/(:any)'), 'page@application');
Route::get('applications/category/(:num)/all', 'page@all_applications');
Route::get(array('applications/category/(:num)/(:any)', 'design-your-page/category/(:num)/(:any)', 'build-fan-base/category/(:num)/(:any)', 'engage/category/(:num)/(:any)', 'search/category/(:num)'), 'page@category');
Route::get('applications/package/(:num)', 'page@package');
Route::get('applications/(:any)', 'page@promo');
Route::get('successful-stories/(:num)/(:any)', 'page@stories');
Route::get('blog/(:num)/(:any)', 'page@blog_detail');
Route::get(array('(:any)/package/(:num)', 'package/(:num)/(:any)'), 'page@package_without_sidebar');

Route::get('blog/search/(:any?)', array('as' => 'search_blog', 'uses' => 'page@blog'));
Route::get('blog/category/(:num)/(:any)', 'page@blog');

Route::get('applications/search', array('as' => 'search_all', 'uses' => 'page@search'));
Route::post('thank-you-contact-us', array('as' => 'contact_us', 'uses' => 'page@thank_you_contact_us'));
Route::post('thank-you-newsletter', array('as' => 'newsletter', 'uses' => 'page@thank_you_newsletter'));


Route::any('(.*)?', 'page@page');


//composers
View::composer(array('page.home'), function($view)
{ 
    //$view->nest('header', 'partials._header');
    // $view->nest('slider', 'modules.slider', array('slides' => array('img' => URL::base().'/img/slider.png')));
    $view->nest('footer', 'partials._footer');
});
View::composer(
    array(
        'page.home',
        'page.page', 
        'page.contact', 
        'page.stories',
        'page.application', 
        'page.package-detail', 
        'page.application-detail', 
        'page.design', 
        'page.build', 
        'page.package-with-price',
        'page.engage', 
        'page.newsletter',
        'page.blog', 
        'page.thank-you-contact-us', 
        'page.thank-you-newsletter',
        'page.stories-detail', 
        'page.promo', 
        'page.blog-detail', 
        'page.search-results', 
        'page.all-applications',
        'page.package_without_sidebar' 
    ), 
    function($view){
       $view->nest('header', 'partials._header');
    }
);
View::composer(
    array(
        'page.home',
        'page.page', 
        'page.contact', 
        'page.stories',
        //'page.application', 
        //'page.package-detail', 
        //'page.application-detail', 
        //'page.design', 
        //'page.build', 
        //'page.package-with-price',
        //'page.engage', 
        'page.newsletter',
        'page.blog', 
        'page.thank-you-contact-us', 
        //'page.stories-detail', 
        'page.promo', 
        //'page.blog-detail', 
        'page.search-results', 
        'page.all-applications'
        //'page.package_without_sidebar' 
    ), 
    function($view){
        Base_Controller::getSeoDataFromSitePages();
    }
);
View::composer(
    array(
        'page.application-detail',
        'page.package-detail' ,
        'page.package-with-price',
        'page.package_without_sidebar',
        'page.application',  
        'page.design',
        'page.build', 
        'page.engage', 
        'page.blog-detail',
        'page.stories-detail', 
    ), 
    function($view){
        Base_Controller::getSeoData(URI::segment(2) == 'category' ? URI::segment(2) : URI::segment(1), 
                                    URI::segment(2) == 'category' ? URI::segment(3) : URI::segment(2));
    }
);

View::composer(array('page.blog'), function($view){ 
    
    
    if (URI::segment(2) == 'search') {

        $pages = Site_News_Content::select('*');
        foreach(explode(' ', Input::get('search')) as $key => $value) {
            $pages = Site_News_Content::where(DB::raw('lower("content")'), 'like', '%'.Str::lower($value).'%');
        }
        
        if ($pages->lists('site_news_id')){
           
            $news = Site_News_Group::where_slug(URI::segment(1))
                                    ->first()
                                    ->site_news()
                                    ->order_by('created_at')
                                    ->where_in('id', $pages->lists('site_news_id')
                                                            //where(DB::raw('lower("content")'), 'like', '%'.Str::lower(Input::get('search')).'%')
                                                            //->lists('site_news_id')  
                                                                        
                                                )
                                    ->with('site_news_contents')
                                    ->paginate(3);
        } else {
            $news = null;
        }
    }
    else if (!is_null(URI::segment(3)) && URI::segment(2)!="search") {
        Base_Controller::getSeoData(URI::segment(2) == 'category' ? URI::segment(2) : URI::segment(1), 
                                    URI::segment(2) == 'category' ? URI::segment(3) : URI::segment(2));
        // dd(App_Category::where_id(URI::segment(3))->first()->site_news()->lists('id'));
        $catlist = App_Category::where_id(URI::segment(3))->first()->site_news()->lists('id');
        if (!empty($catlist)) {
            $news = Site_News_Group::where_slug(URI::segment(1))->first()->site_news()->order_by('created_at')->where_in('id', $catlist)->with('site_news_contents')->paginate(3);
        } 
    }
    else {
        $news = Site_News_Group::where_slug(URI::segment(1))->first()->site_news()->order_by('created_at')->with('site_news_contents')->paginate(3);
        // dd($news);
    }
   
    $view->nest('news', 'page.blog-list', 
        array(  'news'          => @$news,
                //'news_list'     => Site_News_Group::where_slug(URI::segment(1))->first()->site_news()->with(array('site_news_categories'))->take(3)->get(),
                //'category_list' => Site_News_Category::all()
            )
    );
   
});
View::composer(array('page.stories'), function($view){ 
    $view->nest('news', 'page.stories-list', array('news' => Site_News_Group::where_slug(URI::segment(1))->first()->site_news()->with('site_news_contents')->paginate(4)));
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});
Event::listen('laravel.query', function($sql) {
	var_dump($sql);
});
/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
    
    xssClean::globalXssClean();
    /*
    *   Track a user's visit
    */
    /*
    // Create the browser object
    Bundle::start('Browser');
    $browser = IoC::resolve('Browser');
    //dd($browser);
    // Create the Eloquent object Visit
    $visit = new Visit;

    // Obviously for illegal purposes only
    $visit->location = Locate::get( 'city' ) . ', ' . Locate::get( 'state' ) . ', ' . Locate::get( 'country' );
    $visit->ip_address = Request::ip();

    $visit->request = URI::current();
    if( Auth::check() )
        $visit->user_id = Auth::user()->id;

    // Browser stats
    $visit->browser = $browser->getBrowser();
    $visit->browser_version = $browser->getVersion();
    $visit->platform = $browser->getPlatform();
    $visit->mobile = $browser->isMobile();
    $visit->robot = $browser->isRobot();
    $visit->save();*/

});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});
/*
Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});*/