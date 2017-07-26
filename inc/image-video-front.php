<?php

class Image_Video_Front {

    public function __construct() {
        add_filter('get_the_archive_description', array($this, 'show_image'), 11);
    }

    public function show_image($description) {
        if (is_category()) {
            $image_id = get_term_meta(get_query_var('cat'), 'category-image-id', true);
            $video_url = get_term_meta(get_query_var('cat'), 'category-video-url', true);
            if ($image_id !== '') {
                echo wp_get_attachment_image($image_id, "full", "");
            }
            if ($video_url !== '') {
                echo '<iframe width="100%" height="481" src="'.Image_Video_Form::parse_url_to_video_id($video_url).'" frameborder="0" allowfullscreen></iframe>';
            }
        }

        return $description;
    }

//    public function show_video($description)
//    {
//        if(is_category())
//        {            
//            $image_id = get_term_meta(get_query_var('cat'),'category-image-id',true);
//            if($image_id !=='' )
//            {
//               echo wp_get_attachment_image($image_id, "full", ""); 
//            }
////           
//        }
//        
//        return $description;
//    }
}
