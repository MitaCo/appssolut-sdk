$(document).ready(function() {
    if (typeof FB_PAGE_ID != "undefined") {
            $.ajax({
                    url: 'https://graph.facebook.com/' + FB_PAGE_ID + '?fields=likes',
                    type: 'GET',
                    success: function(data) {
                        // alert(data['likes']);
                        $('#actuallikes').html(data['likes']);
                    },
                    error: function(data){
                        console.log(data);
                        if ($.parseJSON(data.responseText).message)
                            alert($.parseJSON(data.responseText).message)
                    }
                });
        };
   if (typeof APP_ID != "undefined") {
        
        if ($('#app_preview').length) {
            $('#app_preview').html('<iframe id="appframepreview" width="821" height="800" src="/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/preview/' + TEMPLATE + '/' + APP_LANG + '">');
            $('#appframepreview').load(function(){
                $('#app_commands').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/' + APP_LANG , function() {
                    $('#app_commands ul').addClass("nav");
                    $('.explain').popover({
                        placement:'left', 
                        trigger: 'hover'
                    });
                    //$('#app_commands li').addClass("bg-con");
                    // $('#app_commands ul').prepend('<li class="nav_title"><a href="">Page properties</a></li>');
                    // alert('Load was performed.');
                
                   

                });
            });
            $('#app_lang').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/languages', function() {

            });
            $(document).on("click", "#restore_button", function(event) {
                event.preventDefault();
                var sure = confirm('By using this button you will return to original settings of your application!\n All modifications you entered, editing actions and data that your users entered will be lost! \n Are You sure You want to reset your application to original settings?');
                if (sure) {
                $.ajax({
                    url: '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/restore/' + TEMPLATE + '/' + APP_LANG,
                    type: 'GET',
                    success: function(data) {
                        window.location = '/appstore/manager/' + APP_ID + '/edit/1/1';
                    },
                    error: function(data){
                        console.log(data);
                        if ($.parseJSON(data.responseText).message)
                            alert($.parseJSON(data.responseText).message)
                    }
                });
                }
            });
            $(document).on("click", "#app_lang a", function(event) {
                event.preventDefault();
                APP_LANG = $(this).data('lang');
                
                window.location('/appstore/manager/' + APP_ID + '/edit/' + APP_PAGE + '/' + APP_LANG);
            });
            

            $(document).on('mouseover', '#app_commands li', function() {
                //console.log($('#appframepreview').contents().find("#"+$(this).attr('id')));
                if( $('#appframepreview').contents().find("#"+$(this).attr('id')))
                    $('#appframepreview').contents().find("#"+$(this).attr('id')).addClass("active");
            });
            $(document).on('mouseout', '#app_commands li', function() {
                if( $('#appframepreview').contents().find("#"+$(this).attr('id')))
                    $('#appframepreview').contents().find("#"+$(this).attr('id')).removeClass("active");
            });

            $(document).on("click", "#app_commands a", function(event) {
                event.preventDefault();
                if ($(this).attr('class') == 'drag-drop-fields') {
                    $('#app_commands').hide();
                    $('#app_preview').html('<iframe id="appframepreview" width="1170" height="800" src="/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/dragdrop/' + TEMPLATE + '/' + APP_LANG + '">');
                    $('#appframepreview').load(function(){
                        frame = $('#appframepreview');
                        var frameBody = frame.contents().find('body');
                        frameBody.find('#drag-drop-go-back').click(function(){
                            location.reload();
                        });
                        
                    });
                } else {
                    $('#myModal_content').load($(this).attr("href"), function() {
                        upload();
                        deleteform = $('.delete_button ').closest("form");
                        deleteform.submit(function() {
                            return confirm('By choosing to delete this item, you will be deleting it from your application and from application fields settings. You can always add it back, by selecting Add/Remove fields in editing menu. \n\n Are you sure?');
                        });

                        // colorpicker
                        if ($('#colorpicker').size() > 0)
                        {
                            $('#colorpicker').farbtastic('#colorpickerColor');
                        }
                        
                        if ($('.chzn-select').length){
                            var config = {
                              '.chzn-select'           : {},
                              '.chzn-select-deselect'  : {allow_single_deselect:true},
                              '.chzn-select-no-single' : {disable_search_threshold:10},
                              '.chzn-select-no-results': {no_results_text:'Nothing found!'},
                              '.chzn-select-width'     : {width:"240px"}
                            }
                            for (var selector in config) {
                              $(selector).chosen(config[selector]);
                            }
                            $('.chzn-container').attr("style","width: 240px;");
                        }
                        
                        if ($('.datetimepicker').length){
                            $('.datetimepicker').datetimepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "dd.mm.yy"
                            });
                        }
                        // Position fields
                        originalItems = $("#app_commands #list-box option");
                        $("#move-up").click(moveUp);
                        $("#move-down").click(moveDown);

                        $('#myModal').show();
                        $('#app_commands').hide();

                        // TARGETING
                        $('#accordion-create-target').accordion({
                            collapsible: true,
                            header: "li",
                            active: false,
                            icons: null,
                            heightStyle: "content"
                        });
                        $('#accordion-targets').accordion({
                            collapsible: true,
                            header: "li",
                            active: false,
                            icons: null,
                            heightStyle: "content"
                        });
                    });
                }
            });

            $(document).on("click", "#myModal_content a.cancel", function(event) {
                event.preventDefault();
                $('#myModal').hide();
                $('#app_commands').show();
                if($('#drop').length) $('#appframepreview').attr('src', $('#appframepreview').attr("src"));

            });

            $(document).on("click", ".iframe_size a", function(event) {
                event.preventDefault();
                $("#appframepreview").width($(this).data('width'));

            });

            $(document).on("click", ".load-language a", function(event) {
                event.preventDefault();
                APP_LANG = $(this).data('lang');
                // alert('here');
                window.location = '/appstore/manager/' + APP_ID + '/edit/' + APP_PAGE + '/' + APP_LANG ;
                /*$('#app_preview').html('<iframe id="appframepreview" width="721" height="800" src="/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/preview/' + TEMPLATE + '/' + APP_LANG + '">');
                $('#app_commands').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/' + APP_LANG, function() {
                    $('#app_commands ul').addClass("nav");
                    $('.explain').popover();
                });
                $('#myModal').hide();
                $('#app_commands').show();*/
            });
            $(document).on("click", ".btn[data-dismiss='modal']", function(e) {
                e.preventDefault();
                $('#appframepreview').attr('src', $('#appframepreview').attr("src"));
                $('#app_commands').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields', function() {
                    $('#app_commands ul').addClass("nav");
                    $('.explain').popover({
                        placement:'left',
                        trigger: 'hover'
                    });
                    //$('#app_commands li').addClass("bg-con");
                    // $('#app_commands ul').prepend('<li class="nav_title"><a href="">Page properties</a></li>');
                    // alert('Load was performed.');
                });
                $('#myModal').hide();
                $('#app_commands').show();
            });

            $(document).on("submit", "#myModal_content form", function(e) {
                e.preventDefault();
                var $form = $(this);
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(data) {

                        // alert(data.message);
                        // reload preview
                        
                        if($form.attr('class') == 'localization') {
                            /* ehre i am */
                            APP_LANG = data.val;
                            // window.location = '/appstore/manager/' + APP_ID + '/edit/' + APP_PAGE + '/' + data.val ;
                            src = '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/preview/' + TEMPLATE + '/' + APP_LANG;
                            $('#appframepreview').attr('src', src);
                            $('#myModal_content').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/settings/localization/'+ APP_LANG, function() {
                                $('#accordion-create-target').accordion({
                                    collapsible: true,
                                    header: "li",
                                    active: false,
                                    icons: null,
                                    heightStyle: "content"
                                });
                                $('#accordion-targets').accordion({
                                    collapsible: true,
                                    header: "li",
                                    active: false,
                                    icons: null,
                                    heightStyle: "content"
                                });
                                //current_target ui-state-active
                                $('.current_target').addClass( "ui-state-active" );
                            }); 
                            $('#app_commands').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields', function() {
                                $('#app_commands ul').addClass("nav");
                                $('.explain').popover({
                                    placement:'left',
                                    trigger: 'hover'
                                });
                            });
                        } else {
                            $('#appframepreview').attr('src', $('#appframepreview').attr("src"));
                            $('#app_commands').load('/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields', function() {
                                $('#app_commands ul').addClass("nav");
                                $('.explain').popover({
                                    placement:'left',
                                    trigger: 'hover'
                                });
                                //$('#app_commands li').addClass("bg-con");
                                // $('#app_commands ul').prepend('<li class="nav_title"><a href="">Page properties</a></li>');
                                // alert('Load was performed.');
                            });
                            $('#myModal').hide();
                            $('#app_commands').show();
                        }
                    },
                    error: function(data){
                        console.log(data);
                        if ($.parseJSON(data.responseText).message)
                            alert($.parseJSON(data.responseText).message)
                    }
                });

            });

            $(document).on("click", "#app_lang a", function(event) {
                event.preventDefault();
                $('#myModal').hide();
                $('#app_commands').show();

            });


            /* $('#isfangate').on('switch-change', function () {
             var $isfangate = 2;
             if ($('#isfangate').bootstrapSwitch('status')) 
             $isfangate = 1;            
             // alert($isfangate);
             $('#appframepreview').attr('src', '/apps/'+APP_URL+'/admin/'+APP_ID+'/'+APP_PAGE+'/preview/'+$isfangate+'/'+APP_LANG);
             });*/

            /*$('#isfangate button').on('click', function() {
                // alert($(this).attr('value'));
                $('#appframepreview').attr('src', '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/preview/' + $(this).attr('value') + '/' + APP_LANG);
            });*/
        }
        if ($('#more-tables').length) {
            $('#more-tables').load('/apps/' + APP_URL + '/graph/' + APP_ID);

            // $('.visitors').load('/apps/' + APP_URL + '/graph/' + APP_ID + '/visitors');

            $('.participants').load('/apps/' + APP_URL + '/graph/' + APP_ID + '/participants');

            $(document).on("click", ".appstore_detail #more-tables button", function(event) {
                event.preventDefault();
                var $self = $(this);
                /*var sure = confirm('Are you sure you want to delete this item?');
                if (sure) {*/
                $.ajax({
                    url: $self.closest('form').attr('action'),
                    type: 'POST',
                    success: function(data) {
                        location.reload();
                        //window.location = '/appstore/manager/' + APP_ID + '/edit/1/1';
                    }/*,
                    error: function(data){
                        console.log(data);
                        if ($.parseJSON(data.responseText).message)
                            alert($.parseJSON(data.responseText).message)
                    }*/
                });
                //}
               

            });
        }

        $(document).on("click","#upgrade_btn a.bgcolor",function(e) {
            e.preventDefault();
            //$("#upgrade_form a.submit").text("Upgrade");
            $("#sidebar").removeClass("reverse").addClass("upgrade");
            $(window).scrollTop(0);
            return false
        });
        $(document).on("click","#upgrade_btn a.bgimage",function(e) {
            e.preventDefault();
            //$("#sidebar").removeClass("upgrade update");
            $(window).scrollTop(0);
            return false
        });
        $(document).on("click","#restore_btn a.bgcolor",function(e) {
            e.preventDefault();
            var $self = $(this);
            $(window).scrollTop(0);
            $.ajax({
                    url: $self.closest('form').attr('action'),
                    type: 'PUT',
                    data : {
                        property: '#FFFFFF',
                        colorpicker: '#FFFFFF'
                    },
                    success: function(data) {
                        location.reload();
                        //window.location = '/appstore/manager/' + APP_ID + '/edit/1/1';
                    }
                    
                });
            return false
        });



    };

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
            //maxNumberOfFiles: 1,
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

                    /*if (tpl.hasClass('working')) {
                        jqXHR.abort();
                    }*/

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
                
               /* if (data.status != 500 && $.parseJSON(data.responseText).message)
                    alert($.parseJSON(data.responseText).message)
                else {*/
                    alert('There is a problem with your media file, try different media format or size');
                    ul.html('');
                    $('#upload').find('.modal-button').unbind('click');
               // }
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
    }
    ;

    // Position fields
    function moveUp() {
        $("#list-box option:selected").each(function() {
            var listItem = $(this);
            var listItemPosition = $("#list-box option").index(listItem) + 1;

            if (listItemPosition == 1)
                return false;

            // Save new order in db
            var selectedField = this.id.replace("field_", "");
            var upperField = this.previousElementSibling.id.replace("field_", "");
            $.ajax({
                url: '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/reorder',
                data: {
                    id_1: selectedField,
                    id_2: upperField
                },
                type: "PUT",
                success: function() {
                    listItem.insertBefore(listItem.prev());
                    // Reload preview
                    $('#appframepreview').attr('src', $('#appframepreview').attr("src"));
                }
            });
        });
    }
    function moveDown() {
        var itemsCount = $("#list-box option").length;

        $($("#list-box option:selected").get().reverse()).each(function() {
            var listItem = $(this);
            var listItemPosition = $("#list-box option").index(listItem) + 1;

            if (listItemPosition == itemsCount)
                return false;

            var selectedField = this.id.replace("field_", "");
            var upperField = this.nextElementSibling.id.replace("field_", "");
            $.ajax({
                url: '/apps/' + APP_URL + '/admin/' + APP_ID + '/' + APP_PAGE + '/fields/reorder',
                data: {
                    id_1: selectedField,
                    id_2: upperField
                },
                type: "PUT",
                success: function() {
                    listItem.insertAfter(listItem.next());
                    $('#appframepreview').attr('src', $('#appframepreview').attr("src"));
                }
            });

        });
    }


});