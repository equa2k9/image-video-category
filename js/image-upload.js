jQuery(document).ready(function ($) {
    $('#category_tax_media_button').click(function (e) {
        var send_attachment_backup = wp.media.editor.send.attachment;

        wp.media.editor.send.attachment = function (props, attachment) {
            $('#category-image-id').val(attachment.id);
            $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:150px;float:none;" />');
            var src = attachment.url;

            if (attachment.sizes.thumbnail) {
                src = attachment.sizes.thumbnail.url;
            }
            $('#category-image-wrapper .custom_media_image').attr('src', src).css('display', 'block');
            wp.media.editor.send.attachment = send_attachment_backup;
        }

        wp.media.editor.open();
        return false;

    });

    $('#category_tax_media_remove').click(function () {
        $('#category-image-id').val('');
        $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:150px;float:none;" />');
    });
    
     $(document).ajaxComplete(function(event, xhr, settings) {
            var queryStringArr = settings.data.split('&');
            if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                var xml = xhr.responseXML;
                $response = $(xml).find('term_id').text();
                if ($response != "") {
                    // Clear the thumb image
                    $('#category-image-wrapper').html('');
                    $('#video-thumbnail').removeAttr('src');
                }
            }
     });
});