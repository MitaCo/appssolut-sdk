$(document).ready(function() {

    $(".various").fancybox( {
        width		: '85%',
        height		: '85%',
        autoSize	: false,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });

    $(".item-result-detail").fancybox( {
        autoSize	: true,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });

    $("a.fancybox-image").fancybox( {
        autoSize	: true,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });

    $("a.fancybox-video").fancybox( {
        autoSize	: true,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none',
        afterShow: function(){
            jwplayer("video_container").setup({
                file : $('#video_container').attr('title'),
                autostart : 'true',
                events : {
                    onError : function(event){
                        $('.fancybox-outer').hide();
                        $('.fancybox-outer').after("<h2 align='center'>Your video is being processed, it will be available soon!</h2>")
                    }
                }
            });
        }
    });

    $('.item-disabled').click(function(event) {
        event.preventDefault();
        $('#info-msg').modal('show');
    });

    $('.datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd.mm.yy",
        yearRange: "-99:-0",
        defaultDate: '-18Y'
    });
});