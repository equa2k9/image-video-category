<?php

class Image_Video_Form {

    public function __construct() {
        add_action('category_add_form_fields', array($this, 'add_image_form'), 10, 2);
        add_action('category_edit_form', array($this, 'add_image_form'), 10, 2);
        add_action('category_add_form_fields', array($this, 'add_video_form'), 11, 2);
        add_action('category_edit_form', array($this, 'add_video_form'), 11, 2);
        add_action('current_screen', array($this, 'is_category_edit'));
        add_action('created_category', array($this, 'save_image_form'), 10, 2);
        add_action('edited_category', array($this, 'save_image_form'), 10, 2);
        add_action('created_category', array($this, 'save_video_form'), 11, 2);
        add_action('edited_category', array($this, 'save_video_form'), 11, 2);
    }

    public function add_image_form($term) {
        ?>
        <?php if (is_object($term)): ?>
            <?php $image = get_term_meta($term->term_id, 'category-image-id', true); ?>
        <?php else: ?>
            <?php $image = false; ?>
        <?php endif; ?>

        <table class="form-table">
            <tbody>
                <tr class="form-field form-required term-name-wrap">
                    <th scope="row">
                        <label for="category-image-id"><?php _e('Image'); ?></label>
                        <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo ($image) ?: '' ?>">
                    </th>
                    <td>
                        <div id="category-image-wrapper">
                            <?php if ($image): ?>
                                <?php echo wp_get_attachment_image($image, "thumbnail", "", array("class" => "custom_media_image")); ?>
                            <?php endif; ?>
                        </div>
                        <p>
                            <input type="button" class="button button-secondary category_tax_media_button" id="category_tax_media_button" name="category_tax_media_button" value="<?php _e('Add Image'); ?>" />
                            <input type="button" class="button button-secondary category_tax_media_remove" id="category_tax_media_remove" name="category_tax_media_remove" value="<?php _e('Remove Image'); ?>" />
                        </p>
                        <p class="description">Please, choose picture</p>
                    </td>
                </tr>
                <?php
            }

            public function add_video_form($term) {
                ?>
                <?php if (is_object($term)): ?>
                    <?php $video = get_term_meta($term->term_id, 'category-video-url', true); ?>
                <?php else: ?>
                    <?php $video = false; ?>
                <?php endif; ?>

                <tr class="form-field term-name-wrap">
                    <th scope="row">
                        <label for="category-video-url"><?php _e('Video url'); ?></label>
                    </th>
                    <td>
                        <div class="video-preview">
                            <img id="video-thumbnail" width="100%" src="<?php echo self::parse_url_to_video_id($video,false) ?>">
                        </div>
                        <input name="category-video-url" id="category-video-url" type="text" value="<?php echo ($video) ?: '' ?>" size="200" >
                        <p class="description">Please, insert here video url example:<br>Youtube(https://www.youtube.com/watch?v=pja5h8t-x3Y) or Vimeo(https://vimeo.com/118040232)</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    }

    public function is_category_edit() {
        $screen = get_current_screen();

        if ($screen->id === 'edit-category') {
            wp_enqueue_media();
            wp_enqueue_script('new-image-upload', dirname(plugin_dir_url(__FILE__)) . '/js/image-upload.js', array('jquery'), null, true);
            wp_enqueue_script('video-link', dirname(plugin_dir_url(__FILE__)) . '/js/video-link.js', array('jquery'), null, true);
        }
    }

    public function save_image_form($term, $taxonomy) {
        if (isset($_POST['category-image-id']) && $_POST['category-image-id'] !== '') {
            $image = (int) $_POST['category-image-id'];
            update_term_meta($term, 'category-image-id', $image);
        } else {
            update_term_meta($term, 'category-image-id', '');
        }
    }

    public function save_video_form($term, $taxonomy) {
        if (isset($_POST['category-video-url']) && $_POST['category-video-url'] !== '') {
            $video = $_POST['category-video-url'];
            update_term_meta($term, 'category-video-url', $video);
        } else {
            update_term_meta($term, 'category-video-url', '');
        }
    }

    public static function parse_url_to_video_id($url, $video = true) {
        if ($url) {
            if (($id = substr(parse_url($url, PHP_URL_PATH), 1)) && stripos($url, 'vimeo')) {

                $thumbnail = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $id . '.php'));
                if($video)
                {
                    return "https://player.vimeo.com/video/{$id}";
                }
                else
                {
                    return $thumbnail[0]['thumbnail_large'];
                }
                
            } else {
                $video_id = str_replace('/', '', substr($url, stripos($url, '=') + 1));
                if($video)
                {
                    return "https://www.youtube.com/embed/{$video_id}";
                }
                else
                {
                    return "http://i1.ytimg.com/vi/{$video_id}/maxresdefault.jpg";
                }
            }
        }
        return '';
    }

}
