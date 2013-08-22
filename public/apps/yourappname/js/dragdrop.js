$(document).ready(function(){
    //$(function() {
    $( "#sortable" ).sortable({
        revert: true,
        cursor: 'pointer',
        placeholder: "ui-state-highlight",
        start: function(event, ui) {
            // Not a new field, get initial position
            $(this).data('newelement', 0);
            $(this).data('old_position', ui.item.index());
            
        },
        receive: function(event, ui) {
            // Get type id from new field and set flag
            $(this).data('id', ui.item[0].id);
            $(this).data('newelement', 1);
            
            },
        update: function(event, ui) {
            //show loading icon
            $('#inner-wrap').showLoading();
            
            if ($(this).data('newelement') == 1) {
            var $url = '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/draggable/' + APP_LANG; // POST
            var $type_id = $(this).data('id').replace('type_', '');
            var $position = ui.item.index() + 1;
            $.ajax({
                url: $url,
                type: 'POST',
                data: {
                type_id: $type_id,
                position: $position
                },
                success: function(data) {
                    // Save returned field_id
                    var $field_id = 'field_' + data.field_id;
                    ui.item.attr('id', $field_id);
                    // Reload preview
                    location.reload();
                    //$('#appframepreview').attr('src', $('#appframepreview').attr("src"));
                }
            });
            } else {
                var $url = '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/position/' + APP_LANG; // PUT
                var $field_id = ui.item[0].id.replace('field_', '');
                var $old_position = $(this).data('old_position') + 1;
                var $new_position = ui.item.index() + 1;
                $.ajax({
                        url: $url,
                        type: 'PUT',
                        data: {
                        field_id: $field_id,
                        old_position: $old_position,
                        new_position: $new_position
                    },
                    success: function(data) {
                        // reload preview
                        location.reload();
                        //$('#appframepreview').attr('src', $('#appframepreview').attr("src"));
                    }
                });
            }
        }
    });
    $( ".draggable li" ).draggable({
        connectToSortable: "#sortable",
        cursor: "move",
        revert: "invalid",
        /*appendTo: 'body',
        containment: 'window',
        scroll: false,*/
        helper: 'clone'
        
        });
    $( "ul, li" ).disableSelection();


    $(document).on("click", ".delete-field", function(event) {
        var ok = confirm('Are you sure you want to delete this item?');
        if (!ok) {
            return;
        }
        event.preventDefault();
        $('#inner-wrap').showLoading();
        var $url = '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/' + APP_LANG; // DELETE
        var $field_id = $(this).parent().attr('id').replace('field_', '');
        console.log("field", $field_id)
        $.ajax({
            url: $url,
            type: 'DELETE',
            data: {
                field_id: $field_id
            },
            success: function(data) {
               
                //console.log("success", data);
                // reload preview
                location.reload();
                
            },
            error : function(data){
                
                //console.log("error", data);
            }
        });
    });

    $(document).on("click", "#sortable .edit-field", function(event) {
        event.preventDefault();
        $('#myModal_content').load( $(this).attr("href") );
        $('#myModal').modal('show');

    });
    $('#myModal').on('shown', function () {
        upload();
        if ($('#colorpicker').size() > 0){
            $('#colorpicker').farbtastic('#colorpickerColor');
        }
    })
    $(document).on("click", "#myModal_content a.cancel", function(event) {
        event.preventDefault();
        $('#myModal').hide();
       // $('#inner-wrap').hideLoading();
        //$('#app_commands').show();
        //if($('#drop').length) $('#appframepreview').attr('src', $('#appframepreview').attr("src"));

    });

    $(document).on("submit", "#myModal form", function(e) {
        e.preventDefault();
        //show loading icon
        $('#inner-wrap').showLoading();
        $.ajax({
            url: $(this).attr( 'action' ),
            type: 'post',
            data: $(this).serialize(),
            success: function(data) {
                    // alert(data.message);
                    // reload preview
                    location.reload();
                    $('#myModal').modal('hide');
                }
        });
        
    });

});
/*File upload*/
function upload() {
    //upload();
    var ul = $('#upload ul');

    $('#drop a').click(function() {
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({
        // This element will accept file drag/drop uploading
        //dropZone: $('#drop'),
        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function(e, data) {

            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"' +
                    ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                    .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul.html(''));

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function() {

                if (tpl.hasClass('working')) {
                    jqXHR.abort();
                }

                tpl.fadeOut(function() {
                    tpl.remove();
                });

            });

            // Automatically upload the file once it is added to the queue
            //var jqXHR = data.submit();
           
            if($('#drop').length)
                //unbind existing submit triggers, because we only use the file that was selected last 
                $('#upload').find('.modal-button').unbind('click');
                
                //bind submit to start button
                $('#upload').find('.modal-button').on('click', function (e) {
                    e.preventDefault();
                    data.submit();
                    
                });
           
        },
        done : function(e, data){
            if($('#drop').length){
                $(".btn[data-dismiss='modal'], .btn.cancel").trigger('click');
                location.reload();
                //console.log($(".btn[data-dismiss='modal'], .btn.cancel"));
            }   
        },
        progress: function(e, data) {

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if (progress == 100) {
                data.context.removeClass('working');
            }
        },
        fail: function(e, data) {
            // Something has gone wrong!
            data.context.addClass('error');
        },
        error: function(data){
            console.log(data);
            if ($.parseJSON(data.responseText).message)
                alert($.parseJSON(data.responseText).message)
        }

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function(e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }
};

