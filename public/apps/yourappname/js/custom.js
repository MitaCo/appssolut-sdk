$(document).ready(function() {

    $(".various").fancybox( {
        width		: '85%',
        height		: '85%',
        autoSize	: false,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
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