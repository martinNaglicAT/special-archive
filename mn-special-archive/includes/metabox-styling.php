<?php

if (!defined('ABSPATH')) {
    exit;
}

function styling_meta_box() {
    // Add the metabox for the 'special' post type
    add_meta_box('styling_assets', 'Styling', 'mn_special_styling_callback', 'special-archive', 'side', 'low');
}
add_action('add_meta_boxes_special-archive', 'styling_meta_box', 0);

function mn_special_styling_callback($post) {
    // Use nonces for verification
    wp_nonce_field(basename(__FILE__), 'styling_nonce');


    
    // Fetch saved values:

	$current_meta = array(
        'title_color' => get_post_meta($post->ID, '_title_color', true),
        'primary_color' => get_post_meta($post->ID, '_primary_color', true),
        'secondary_color' => get_post_meta($post->ID, '_secondary_color', true),
        'slider_color' => get_post_meta($post->ID, '_slider_color', true),
        'slider_bg' => get_post_meta($post->ID, '_slider_bg', true),
        'text_color' => get_post_meta($post->ID, '_text_color', true),
        'text_bg_option' => get_post_meta($post->ID, '_text_bg_option', true),
        'text_bg_color' => get_post_meta($post->ID, '_text_bg_color', true),
        'video_bg_option' => get_post_meta($post->ID, '_video_bg_option', true),
        'video_bg_url' => get_post_meta($post->ID, '_video_bg_url', true),
        'fallback_bg_option' => get_post_meta($post->ID, '_fallback_bg_option', true),
        'fallback_bg_image' => get_post_meta($post->ID, '_fallback_bg_image', true),
        'fallback_bg_color' => get_post_meta($post->ID, '_fallback_bg_color', true)
        // ... other fields ...
    );


	//setting defaults 
	$current_meta['title_color'] = empty($current_meta['title_color']) ? '#000000' : $current_meta['title_color']; 
	$current_meta['primary_color'] = empty($current_meta['primary_color']) ? '#874500' : $current_meta['primary_color']; 
	$current_meta['secondary_color'] = empty($current_meta['secondary_color']) ? '#EFEDD4' : $current_meta['secondary_color'];
	$current_meta['slider_color'] = empty($current_meta['slider_color']) ? $current_meta['secondary_color'] : $current_meta['slider_color']; 
	$current_meta['slider_bg'] = empty($current_meta['slider_bg']) ? $current_meta['primary_color'] : $current_meta['slider_bg']; 
	$current_meta['video_bg_option'] = empty($current_meta['video_bg_option']) ? 'default' : $current_meta['video_bg_option'];
	$current_meta['fallback_bg_option'] = empty($current_meta['fallback_bg_option']) ? 'default' : $current_meta['fallback_bg_option'];
	$current_meta['fallback_bg_color'] = empty($current_meta['fallback_bg_color']) 
		? $current_meta['secondary_color'] 
		: $current_meta['fallback_bg_color'];
	$current_meta['text_color'] = empty($current_meta['text_color']) ? '#874500' : $current_meta['text_color'];
	$current_meta['text_bg_option'] = empty($current_meta['text_bg_option']) ? 'none' : $current_meta['text_bg_option'];
	$current_meta['text_bg_color'] = empty($current_meta['text_bg_color']) ? '#EFEDD4' : $current_meta['text_bg_color'];

    


    echo '<div id="styling_assets_content">'; //wrapper start


    /*-------RENDER FIELDS START---------*/

    //Title color
    echo '<div class="special_styling_wrapper">';
    echo '<label for="title_color">Title Color:</label>';
    echo '<div>';
	echo '<input type="text" id="title_color" name="title_color" value="' . esc_attr($current_meta['title_color']) . '" data-default-color="#000000">';
	echo '</div>';
	echo '</div>';

	//Primary color
	echo '<div class="special_styling_wrapper">';
	echo '<label for="primary_color">Primary Color:</label>';
    echo '<div>';
	echo '<input type="text" id="primary_color" name="primary_color" value="' . esc_attr($current_meta['primary_color']) . '" data-default-color="#874500">';
	echo '</div>';
	echo '</div>';

	//Secondary color
	echo '<div class="special_styling_wrapper">';
	echo '<label for="secondary_color">Secondary Color:</label>';
    echo '<div>';
	echo '<input type="text" id="secondary_color" name="secondary_color" value="' . esc_attr($current_meta['secondary_color']) . '" data-default-color="#EFEDD4">';
	echo '</div>';
	echo '</div>';

	//Slider color
	echo '<div class="special_styling_wrapper">';
	echo '<label for="primary_color">Slider Color:</label>';
    echo '<div>';
	echo '<input type="text" id="slider_color" name="slider_color" value="' . esc_attr($current_meta['slider_color']) . '" data-default-color="#EFEDD4">';
	echo '</div>';
	echo '</div>';

	//Slider BG
	echo '<div class="special_styling_wrapper">';
	echo '<label for="slider_bg">Slider BG:</label>';
    echo '<div>';
	echo '<input type="text" id="slider_bg" name="slider_bg" value="' . esc_attr($current_meta['slider_bg']) . '" data-default-color="#874500">';
	echo '</div>';
	echo '</div>';

	//Text color
	echo '<div class="special_styling_wrapper">';
	echo '<label for="text_color">Text Color</label>';
	echo '<div>';
	echo '<input type="text" id="text_color" name="text_color" value="' . esc_attr($current_meta['text_color']) . '" data-default-color="#874500">';
	echo '</div>';
	echo '</div>';

	//Text background option
	echo '<div class="special_styling_wrapper">';
	echo '<label for="text_bg_option">Text Background:</label><br>';
	echo '<select id="text_bg_option" name="text_bg_option">';
	echo '<option value="none"' . selected($current_meta['text_bg_option'], 'none', false) . '>None</option>';
	echo '<option value="color"' . selected($current_meta['text_bg_option'], 'color', false) . '>Color</option>';
	echo '</select>';
	echo '</div>';

	//Text background color picker
	echo '<div class="special_styling_wrapper">';
	echo '<div>';
	echo '<div id="text_bg" style="display: ' . ($current_meta['text_bg_option'] == 'color' ? 'block' : 'none') . ';">';
	echo '</div>';
	echo '<input type="text" id="text_bg_color" name="text_bg_color" value="' . esc_attr($current_meta['text_bg_color']) . '" data-default-color="#EFEDD4">';
	echo '</div>';
	echo '</div>';



	// Video BG
	echo '<div class="special_styling_wrapper">';
	echo '<label for="video_bg_option">Video Background:</label>';
	echo '<div>';
	echo '<select id="video_bg_option" name="video_bg_option">';
	echo '<option value="default"' . selected($current_meta['video_bg_option'], 'default', false) . '>Default</option>';
	echo '<option value="custom"' . selected($current_meta['video_bg_option'], 'custom', false) . '>Custom</option>';
	echo '<option value="none"' . selected($current_meta['video_bg_option'], 'none', false) . '>None</option>';
	echo '</select>';
	echo '</div>';
	echo '</div>';

	// Media Uploader for Video bg (shown when custom is selected)
	echo '<div class="special_styling_wrapper">';
	echo '<div id="video_bg_custom" style="display: ' . ($current_meta['video_bg_option'] == 'custom' ? 'block' : 'none') . ';">';
	echo '<input type="text" id="video_bg_url" name="video_bg_url" value="' . esc_attr($current_meta['video_bg_url']) . '">';
	echo '<button id="upload_video_button">Upload Video</button>';
	echo '</div>';
	echo '</div>';



    // Fallback BG
    echo '<div class="special_styling_wrapper">';
	echo '<label for="fallback_bg_option">Secondary Background:</label><br>';
	echo '<select id="fallback_bg_option" name="fallback_bg_option">';
	echo '<option value="default"' . selected($current_meta['fallback_bg_option'], 'default', false) . '>Default</option>';
	echo '<option value="custom"' . selected($current_meta['fallback_bg_option'], 'custom', false) . '>Custom</option>';
	echo '</select>';
	echo '</div>';


	// Media Uploader for fallback bg (shown when custom is selected)
	echo '<div class="special_styling_wrapper">';
	echo '<div id="fallback_bg_custom" style="display: ' . ($current_meta['fallback_bg_option'] == 'custom' ? 'block' : 'none') . ';">';
	echo '<input type="text" id="fallback_bg_image" name="fallback_bg_image" value="' . esc_attr($current_meta['fallback_bg_image']) . '">';
	echo '</div>';
	echo '<button id="upload_image_button">Upload Image</button>';
	echo '<input type="text" id="fallback_bg_color" name="fallback_bg_color" value="' . esc_attr($current_meta['fallback_bg_color']) . '" data-default-color="'.$current_meta['secondary_color'].'">';
	echo '</div>';





    /*-------RENDER FIELDS END-------*/


    echo '</div>'; //wrapper end
}





function mn_special_save_styling($post_id) {
    // Verify the nonce
    if (!isset($_POST['styling_nonce']) || !wp_verify_nonce($_POST['styling_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check for autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    //fetch current data to avoid unnecessary rewrites
    $current_meta = array(
        'title_color' => get_post_meta($post_id, '_title_color', true),
        'primary_color' => get_post_meta($post_id, '_primary_color', true),
        'secondary_color' => get_post_meta($post_id, '_secondary_color', true),
        'slider_color' => get_post_meta($post_id, '_slider_color', true),
        'slider_bg' => get_post_meta($post_id, '_slider_bg', true),
        'text_color' => get_post_meta($post_id, '_text_color', true),
        'text_bg_option' => get_post_meta($post_id, '_text_bg_option', true),
        'text_bg_color' => get_post_meta($post_id, '_text_bg_color', true),
        'video_bg_option' => get_post_meta($post_id, '_video_bg_option', true),
        'video_bg_url' => get_post_meta($post_id, '_video_bg_url', true),
        'fallback_bg_option' => get_post_meta($post_id, '_fallback_bg_option', true),
        'fallback_bg_image' => get_post_meta($post_id, '_fallback_bg_image', true),
        'fallback_bg_color' => get_post_meta($post_id, '_fallback_bg_color', true)
        // ... other fields ...
    );

    //error_log($current_meta['fallback_bg_image']);

    // Save each of the fields
	if ( isset($_POST['title_color']) && $_POST['title_color'] !== $current_meta['title_color'] ) {
	    update_post_meta($post_id, '_title_color', sanitize_text_field($_POST['title_color']));
	}

	if ( isset($_POST['primary_color']) && $_POST['primary_color'] !== $current_meta['primary_color'] ) {
	    update_post_meta($post_id, '_primary_color', sanitize_text_field($_POST['primary_color']));
	}

	if ( isset($_POST['secondary_color']) && $_POST['secondary_color'] !== $current_meta['secondary_color'] ) {
	    update_post_meta($post_id, '_secondary_color', sanitize_text_field($_POST['secondary_color']));
	}

	if ( isset($_POST['slider_color']) && $_POST['slider_color'] !== $current_meta['slider_color'] ) {
	    update_post_meta($post_id, '_slider_color', sanitize_text_field($_POST['slider_color']));
	}

	if ( isset($_POST['slider_bg']) && $_POST['slider_bg'] !== $current_meta['slider_bg'] ) {
	    update_post_meta($post_id, '_slider_bg', sanitize_text_field($_POST['slider_bg']));
	}

	if ( isset($_POST['text_color']) && $_POST['text_color'] !== $current_meta['text_color'] ) {
	    update_post_meta($post_id, '_text_color', sanitize_text_field($_POST['text_color']));
	}

	if ( isset($_POST['text_bg_option']) && $_POST['text_bg_option'] !== $current_meta['text_bg_option'] ) {
	    update_post_meta($post_id, '_text_bg_option', sanitize_text_field($_POST['text_bg_option']));
	}

	if ( isset($_POST['text_bg_color']) && $_POST['text_bg_color'] !== $current_meta['text_bg_color'] ) {
	    update_post_meta($post_id, '_text_bg_color', sanitize_text_field($_POST['text_bg_color']));
	}

	if ( isset($_POST['video_bg_option']) && $_POST['video_bg_option'] !== $current_meta['video_bg_option'] ) {
	    update_post_meta($post_id, '_video_bg_option', sanitize_text_field($_POST['video_bg_option']));
	}

	if (
	    isset($_POST['video_bg_url']) 
	    && $_POST['video_bg_url'] !== $current_meta['video_bg_url']
	    && isset($_POST['video_bg_option']) 
	    && $_POST['video_bg_option'] !== 'default' 
	    && $_POST['video_bg_option'] !== 'none'
	) {
	    update_post_meta($post_id, '_video_bg_url', esc_url_raw($_POST['video_bg_url']));
	}

	if ( isset($_POST['fallback_bg_option']) && $_POST['fallback_bg_option'] !== $current_meta['fallback_bg_option'] ) {
	    update_post_meta($post_id, '_fallback_bg_option', sanitize_text_field($_POST['fallback_bg_option']));
	}

	if (
	    isset($_POST['fallback_bg_image']) 
	    && $_POST['fallback_bg_image'] !== $current_meta['fallback_bg_image']
	    && isset($_POST['fallback_bg_option']) 
	    && $_POST['fallback_bg_option'] !== 'default' 
	) {
	    update_post_meta($post_id, '_fallback_bg_image', esc_url_raw($_POST['fallback_bg_image']));
	}

	if ( isset($_POST['falback_bg_color']) && $_POST['fallback_bg_color'] !== $current_meta['fallback_bg_color'] ) {
	    update_post_meta($post_id, '_fallback_bg_color', sanitize_text_field($_POST['fallback_bg_color']));
	}


	//error_log(get_post_meta($post->ID, '_slider_bg', true));
    
}

add_action('save_post_special-archive', 'mn_special_save_styling');

