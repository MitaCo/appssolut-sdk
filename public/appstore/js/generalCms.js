
window.AppssolutCms = {};

(function(AppssolutCms){
	//---------------
	// MODEL Classes
	//---------------
	AppssolutCms.Model = {

		
	}

	//--------------
	// VIEW Classes
	//--------------
	

	//--------------
	// CONTROLLER
	//--------------
	
	AppssolutCms.FrontController = {

		sortSettings : {
			
			$sortContainer : $('ol.sortable'),
			maxLevel : 2
		},
		$tabLink : $('#myTab a'),
		$tab : $('#myTab'),
		bootstrap : function(){
			//When page loads...
			
			//AppssolutCms.FrontController.runSorter(this.sortSettings);
			if (this.$tab.length) AppssolutCms.FrontController.runTabs();  
			if ($('.fancybox').length) AppssolutCms.FrontController.runfancyBox(); 
		},
		
		runfancyBox : function(){
            $('.fancybox').fancybox();

            if ($('.image_wrapper').length) {
				$('.image_wrapper img').load(function(){
					
					var heights = $(".image_wrapper > div").map(function (){
                                    return $(this).height();
                                }).get();
					$(".image_wrapper").css({'height' : Math.max.apply(null, heights)});
				}).attr('src', $('this').attr('src'));
            }   

            $(document).on("click", ".slider_nav a", function(event) {
                event.preventDefault();                
                //console.log($('div.'+$(this).attr('class')).siblings('div')); 
                if ($(this).hasClass('active')) return;
                $('div.'+$(this).attr('class')).siblings('div').hide('fast');     
                //$('div.'+$(this).attr('class')).fadeIn('slow');
                $('div.'+$(this).attr('class')).animate({left:0}, 500).fadeIn('slow');
                $(this).addClass('active').siblings('a').removeClass('active');
                var className = $(this).attr('class'); 
                
                $(this).siblings('.slider_arrow').stop().animate({left: className.indexOf('first_box') != -1 ? 0 : 100}, 500);
                
            });

        },
		runTabs : function(){
            this.$tabLink.click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            })
        },
		runSorter : function(s){
			
			s.$sortContainer.nestedSortable({
				forcePlaceholderSize: true,
				handle: 'div',
				helper:	'clone',
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 250,
				tabSize: 25,
				tolerance: 'pointer',
				toleranceElement: '> div',
				maxLevels: $('#modelPages').length > 0 ? 1 : s.maxLevel,

				isTree: true,
				expandOnHover: 700,
				startCollapsed: false,
				stop: function(event, ui) {
						
					AppssolutCms.FrontController.sendList(event.target.attributes['id'].nodeValue);
				}
			});

			$('.disclose').on('click', function() {
				$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
			})
		
		},
		sendList : function(target){
			console.log("target", target, "path", $('ol.sortable#'+target).data('url'));
			var postdata = {
				keys : $('ol.sortable#'+target).nestedSortable('toHierarchy', {startDepthCount: 0}),
				site_menu_id :  $('ol.sortable#'+target).data('menuid')
				 	
			};
			
			AppssolutCms.FrontController.sendAjax(postdata,  APP_URL+"/"+$('ol.sortable#'+target).data('url'), function(data){}, 'POST');
			
			//this.$spanButton.fadeOut('fast')
		},
		sendAjax : function (postdata, url, callback, type){
			$.ajax({
				url: url,
				type: (type.length>0 ? type : "GET"),
				data: postdata,
				cache: false,
				success: function(html) {
					callback(html);
				}
			});
		}

	}

})(window.AppssolutCms);

$(document).ready(function(){
	$('.textarea').wysihtml5();
	
	//setTimeout(function() {
		AppssolutCms.FrontController.bootstrap();
	//}, 100);
	$("#pay").on('click', function(){
		$('#myModal').modal('hide');
		$('#payed').modal('show');
	})
	
});