jQuery(document).ready(function ($) {
    $('#category-video-url').on('change', function (e) {
        var video_thumbnail = $("#video-thumbnail");
        if (this.value.length > 0)
        {
            video_thumbnail.attr('src', getVideoThumbnail(this.value));
        } else
        {
            video_thumbnail.removeAttr('src');
        }
    });

    function parseVideo(url) {

        url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

        if (RegExp.$3.indexOf('youtu') > -1) {
            var type = 'youtube';
        } else if (RegExp.$3.indexOf('vimeo') > -1) {
            var type = 'vimeo';
        }

        return {
            type: type,
            id: RegExp.$6
        };
    }

    function getVideoThumbnail(url) {
        var videoObj = parseVideo(url);
        if (videoObj.type == 'youtube') {
            return ('//img.youtube.com/vi/' + videoObj.id + '/maxresdefault.jpg');
        } else if (videoObj.type == 'vimeo') {
            $.ajax({
                type: 'GET',
                url: 'http://vimeo.com/api/v2/video/' + videoObj.id + '.json',
                dataType: 'jsonp',
                success: function (data) {
                    $("#video-thumbnail").attr('src', data[0].thumbnail_large);
                }
            });

        }
    }
});


