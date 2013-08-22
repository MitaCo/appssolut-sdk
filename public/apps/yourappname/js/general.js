window.Appssolut = {};

(function(Appssolut){
    //---------------
    // MODEL Classes
    //---------------
    Appssolut.Model = {

        
    }

    //--------------
    // VIEW Classes
    //--------------
    

    //--------------
    // CONTROLLER
    //--------------
    
    Appssolut.FrontController = {

        $tab : $('#myTab'),
        $tabLink : $('#myTab a'),
        $sliderContainer : $('#da-slider'),
        $star : $('.star'),
        bootstrap : function(){
            //When page loads...
            Appssolut.FrontController.runMenu();
            if (this.$sliderContainer.length) Appssolut.FrontController.runSlider();
            if (this.$tab.length) Appssolut.FrontController.runTabs();  
            if (this.$star.length) Appssolut.FrontController.runRating();  
            //Appssolut.FrontController.runSorter();
        },
        runMenu : function(){
             // helper functions

            var trim = function(str)
            {
                return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
            };

            var hasClass = function(el, cn)
            {
                return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
            };

            var addClass = function(el, cn)
            {   //console.log("add",el, cn)
                if (!hasClass(el, cn)) {
                    el.className = (el.className === '') ? cn : el.className + ' ' + cn;
                }
            };

            var removeClass = function(el, cn)
            {   //console.log("remove",el, cn)
                el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
            };

            var hasParent = function(el, id)
            {
                if (el) {
                    do {
                        if (el.id === id) {
                            return true;
                        }
                        if (el.nodeType === 9) {
                            break;
                        }
                    }
                    while((el = el.parentNode));
                }
                return false;
            };

            // normalize vendor prefixes

            var doc = document.documentElement;

            var transform_prop = window.Modernizr.prefixed('transform'),
                transition_prop = window.Modernizr.prefixed('transition'),
                transition_end = (function() {
                    var props = {
                        'WebkitTransition' : 'webkitTransitionEnd',
                        'MozTransition'    : 'transitionend',
                        'OTransition'      : 'oTransitionEnd otransitionend',
                        'msTransition'     : 'MSTransitionEnd',
                        'transition'       : 'transitionend'
                    };
                    return props.hasOwnProperty(transition_prop) ? props[transition_prop] : false;
                })();

            App = (function()
            {

                var _init = false, app = { };

                var inner = document.getElementById('inner-wrap'),

                    nav_open = false,

                    nav_class = 'js-nav'

                    nav_right_class = 'js-right-nav';


                app.init = function()
                {
                    if (_init) {
                        return;
                    }
                    _init = true;

                    var closeNavEnd = function(e)
                    {   //console.log("inner", e, e.target)
                        if (e && e.target === inner) {//console.log("dddd");
                            document.removeEventListener(transition_end, closeNavEnd, false);
                        }
                        nav_open = false;
                    };

                    app.closeNav =function()
                    {  
                        if (nav_open) {
                            // close navigation after transition or immediately
                            var duration = (transition_end && transition_prop) ? parseFloat(window.getComputedStyle(inner, '')[transition_prop + 'Duration']) : 0;
                            if (duration > 0) {
                                document.addEventListener(transition_end, closeNavEnd, false);
                            } else {
                                closeNavEnd(null);
                            }
                        }
                        removeClass(doc, nav_class);
                    };

                    app.openNav = function()
                    {   
                        if (nav_open) {
                            return;
                        }
                        addClass(doc, nav_class);
                        nav_open = true;
                    };

                    app.toggleNav = function(e, t)
                    {  //console.log("togglenav", t, $(t))
                        if (hasClass(t, 'right')) {
                            nav_class = nav_right_class;
                        }
                        else{
                            nav_class = 'js-nav';
                        }

                        if (nav_open && hasClass(doc, nav_class)) { 
                            app.closeNav();
                        } else {
                            app.openNav();
                        }
                        if (e) {
                            e.preventDefault();
                        }
                    };

                    // open nav with main "nav" button
                    $('#nav-open-btn, #nav-close-btn').on('click', function(e) {
                        app.toggleNav(e, this);
                    });
                    //document.getElementById('nav-open-btn').addEventListener('click', app.toggleNav, false);

                    // close nav with main "close" button
                    //document.getElementById('nav-close-btn').addEventListener('click', app.toggleNav, false);

                    // open category-nav with main "nav" button
                    if($('#category-nav-open-btn').length){
                        $('#category-nav-open-btn, #category-close-btn').on('click', function(e) {
                            //console.log("q", $(this), this);
                            app.toggleNav(e, this);
                        }); 
                    }
                    //if(document.getElementById('category-nav-open-btn') != null)
                    //document.getElementById('category-nav-open-btn').addEventListener('click', app.toggleNav, false);

                    // close category-nav with main "close" button
                    //if(document.getElementById('category-close-btn') != null)
                    //document.getElementById('category-close-btn').addEventListener('click', app.toggleNav, false);

                    // close nav by touching the partial off-screen content
                   
                    /*$(document).on('click', function(e) {console.log("prevent", hasParent(e.target, 'nav'), e.target, nav_open, hasParent(e.target, 'accordion'))
                         if (nav_open && !(hasParent(e.target, 'nav') || hasParent(e.target, 'accordion'))) {
                            e.preventDefault();
                            app.closeNav();
                        }
                    });*/
                    document.addEventListener('click', function(e)
                    {
                        //console.log("prevent", hasParent(e.target, 'nav'), e.target, nav_open, hasParent(e.target, 'accordion'))
                        if (nav_open && !(hasParent(e.target, 'nav') || hasParent(e.target, 'accordion'))) {
                            e.preventDefault();
                            app.closeNav();
                        }
                        
                    },
                    true);

                    addClass(doc, 'js-ready');

                };

                return app;

            })();
            App.init();
        },
        runSlider : function(){
            this.$sliderContainer.cslider({
                autoplay    : true,
                bgincrement : 450
            });
        },
        runTabs : function(){
            this.$tabLink.click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            })
        },
        runRating : function(){
            $('.sidebar_description .star').on('click', function() {
                //console.log($(this).find('a').text(), $(this));
                var postdata = {
                    rate_value      :  $(this).find('a').text(),
                    app_app_id      :  $('.sidebar_description input.star').data('appid')
                };
                Appssolut.FrontController.sendAjax(JSON.stringify(postdata),  $('.sidebar_description input.star').data('type') == 'packages' ? APP_URL+"/appstore/json/packages/rating" : APP_URL+"/appstore/json/apps/rating", function(data){
                    //console.log("data",data, Math.round(data[0].rate).toFixed(0));
                    if (data[0].rate){
                        $('.bd input.star').rating('readOnly',false).rating('select',Math.round(data[0].rate).toFixed(0)-1).rating('disable');
                        $('.sidebar_description input').rating('select',Math.round(data[0].rate).toFixed(0)-1); 
                        $('.message').text('Thanks for voting').fadeIn();
                    }
                    else{
                        $('.message').text(data).fadeIn();
                    }
                    
                }, 'POST');
            })
        },
        sendAjax : function (postdata, url, callback, type){
            $.ajax({
                url: url,
                type: (type.length>0 ? type : "GET"),
                data: postdata,
                dataType: "json",
                cache: false,
                success: function(html) {
                    callback(html);
                }
            });
        }

    }

})(window.Appssolut);

$(document).ready(function(){
    //setTimeout(function() {
        Appssolut.FrontController.bootstrap();
    //}, 100);
});

/*(function(window, document, undefined){

   

    if (window.addEventListener) {
        window.addEventListener('DOMContentLoaded', window.App.init, false);
    }

})(window, window.document);*/