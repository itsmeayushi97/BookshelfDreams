/*
 **
 ** @author: TechArise Team
 ** @author URI: http://techarise.com
 ** File Name : custom.tinymce.js
 **
 */

function tinyMCEEditor(id) {
    tinymce.init({
        selector: 'textarea#'+id,
        width:'100%',
        height: 250,
        plugins: 'paste code',
        browser_spellcheck : true,
        menu: {
            file: { 
                title: 'File', 
                items: 'newdocument restoredraft | preview | print' 
            },
            edit: { 
                title: 'Edit', 
                items: 'undo redo | cut copy paste | selectall | searchreplace' 
            },
            view: { 
                title: 'View', 
                items: 'code | visualaid visualchars visualblocks | preview fullscreen' 
            },
            format: { 
                title: 'Format', 
                items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' 
            },
            tools: { 
                title: 'Tools', 
                items: 'code wordcount' 
            },
            table: { 
                title: 'Table', 
                items: 'inserttable | cell row column | tableprops deletetable' 
            },
            help: { 
                title: 'Help', items: 'help' 
            }
        },
        branding: false,
        mobile: {
            menubar: true
        }
    });
}

// insert record in database
jQuery(document).ready(function() {
    tinyMCEEditor('event-content');   
    jQuery(document).on('click','#save-event', function(e) {
        e.preventDefault();
        tinyMCE.triggerSave(true, true);
        jQuery.ajax({
                url: "action.php",
                method: "POST",              
                data:jQuery("form#dynamic-post").serialize(),
                dataType:"html",
                success: function(html) {     
                    jQuery("#render-event-data").append(html).fadeIn('slow');
                    tinyMCE.get('event-content').setContent('');
                    jQuery('input#event-title').val('');
                    jQuery('input#event-location').val('');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        }); 
    });

    // update record in database
    jQuery(document).on('click','.update-event', function(e) {
        e.preventDefault();
        var event_id = jQuery(this).data('ueventid');
        var edtor_id = 'event-content'+event_id;
        //tinyMCE.EditorManager.execCommand('mceFocus', false, edtor_id);
        //tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, edtor_id);
        tinyMCEEditor(edtor_id);
        var action ='fetch_event';
        jQuery.ajax({
                url: "action.php",
                method: "POST",              
                data:{action:action, event_id:event_id},
                dataType:"html",
                success: function(html) {     
                    jQuery("#dyn-"+event_id).html(html).fadeIn('slow');
                    //tinyMCE.activeEditor.setContent();
                    tinyMCE.EditorManager.execCommand('mceAddEditor', false, edtor_id);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        }); 
    });

    // update record in database
    jQuery(document).on('click','.save-update', function(e) {
        e.preventDefault();
        tinyMCE.triggerSave(true, true);
        var event_id = jQuery(this).data('seventid');
        var edtor_id = 'event-content'+event_id;
        tinyMCE.EditorManager.execCommand('mceFocus', false, edtor_id);
        tinyMCE.EditorManager.execCommand('mceRemoveEditor', true, edtor_id);
        jQuery.ajax({
                url: "action.php",
                method: "POST",              
                data:jQuery("form#dynamic-post-"+event_id).serialize(),
                dataType:"html",
                success: function(html) {     
                    jQuery("#dyn-"+event_id).html(html).fadeIn('slow');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        }); 
    });


    // update record in database
    jQuery(document).on('click','.delete-event', function(e) {
        e.preventDefault();
        var event_id = jQuery(this).data('deventid');
        var action = 'delete';
        jQuery.ajax({
                url: "action.php",
                method: "POST",              
                data:{event_id:event_id, action:action},
                dataType:"json",
                success: function(json) {     
                    jQuery("#dyn-"+event_id).empty('').fadeIn('slow');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        }); 
    });
});