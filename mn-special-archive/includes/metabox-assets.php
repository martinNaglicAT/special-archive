<?php 

if (!defined('ABSPATH')) {
    exit;
}



function mn_special_assets_meta_box() {
    // Add the metabox for the 'special' post type
    add_meta_box('logo_asset', 'Logo', 'mn_special_logo_callback', 'special-archive', 'normal', 'low');
    add_meta_box('custom_assets', 'Assets', 'mn_special_assets_callback', 'special-archive', 'normal', 'low');
}
add_action('add_meta_boxes_special-archive', 'mn_special_assets_meta_box', 0);

function mn_special_logo_callback($post) {
	// Use nonces for verification
    wp_nonce_field(basename(__FILE__), 'assets_logo');

    $logo = get_post_meta($post->ID, '_logo_asset', true);


    echo '<div class="special_logo_wrapper">';
    echo '<label for="logo_url">Client Logo</label>';
    echo '<button id="upload_logo_button" data-for="logo_url">Upload logo</button>';
	echo '<input type="text" id="logo_url" name="logo_url" value="' . esc_attr($logo) . '">';
    echo '</div>';
}

function mn_special_assets_callback($post) {
	// Use nonces for verification
    wp_nonce_field(basename(__FILE__), 'assets_nonce');

    $post_id = $post->ID;

    $current_meta = array(
	    'title_asset' => array(
	        'options' => get_post_meta($post_id, '_title_asset_options', true),
	        'asset' => get_post_meta($post_id, '_title_asset', true)
	    ),
	    'main_asset' => array(
	        'options' => get_post_meta($post_id, '_main_asset_options', true),
	        'asset' => get_post_meta($post_id, '_main_asset', true),
	        'animated' => get_post_meta($post_id, '_main_asset_animated', true),
	        'mirror' => get_post_meta($post_id, '_main_asset_mirror', true),
	        'variable' => get_post_meta($post_id, '_main_asset_variable', true),
	        'shadow' => get_post_meta($post_id, '_main_asset_shadow', true),
	    ),
	    'static_asset_1' => array(
	        'options' => get_post_meta($post_id, '_static_asset_1_options', true),
	        'asset' => get_post_meta($post_id, '_static_asset_1', true)
	    ),
	    'static_asset_2' => array(
	        'options' => get_post_meta($post_id, '_static_asset_2_options', true),
	        'asset' => get_post_meta($post_id, '_static_asset_2', true)
	    ),
	    'added_asset_1' => array(
	        'options' => get_post_meta($post_id, '_added_asset_1_options', true),
	        'asset' => get_post_meta($post_id, '_added_asset_1', true)
	    ),
	    'added_asset_2' => array(
	        'options' => get_post_meta($post_id, '_added_asset_2_options', true),
	        'asset' => get_post_meta($post_id, '_added_asset_2', true)
	    ),
	    'added_asset_3' => array(
	        'options' => get_post_meta($post_id, '_added_asset_3_options', true),
	        'asset' => get_post_meta($post_id, '_added_asset_3', true)
	    ),
	    'asset_top' => array(
	    	'options' => get_post_meta($post_id, '_asset_top_options', true),
	    	'asset' => get_post_meta($post_id, '_asset_top', true)
	    ),
	    'asset_bot' => array(
	    	'options' => get_post_meta($post_id, '_asset_bot_options', true),
	    	'asset' => get_post_meta($post_id, '_asset_bot', true)
	    )
	);


	echo '<div class="special_assets_wrapper">';

	foreach($current_meta as $asset_name => $asset) {
        // Set defaults
        if($asset_name !== 'asset_top' && $asset_name !== 'asset_bot'){
        	$asset['options'] = empty($asset['options']) ? 'default' : $asset['options'];
        } else {
        	$asset['options'] = empty($asset['options']) ? 'none' : $asset['options'];
        }

        // Options
		echo '<h4>' . $asset_name . '</h4>';
		echo '<div class="special_styling_wrapper">';
		echo '<label for="' . $asset_name . '_options">Options</label>';
		echo '<select id="' . $asset_name . '_options" name="_' . $asset_name . '_options" data-option-type data-associated-field="' . $asset_name . '_custom">';

		if($asset_name !== 'asset_top' && $asset_name !== 'asset_bot'){
			echo '<option value="default"' . selected($asset['options'], 'default', false) . '>Default</option>';
		}

		echo '<option value="custom"' . selected($asset['options'], 'custom', false) . '>Custom</option>';
		echo '<option value="none"' . selected($asset['options'], 'none', false) . '>None</option>';
		echo '</select>';
		echo '</div>';

		// Media Uploader
		echo '<div class="special_styling_wrapper">';
		echo '<div id="' . $asset_name . '_custom" style="display: ' . ($asset['options'] == 'custom' ? 'block' : 'none') . ';">';
		echo '<span id="' . $asset_name . '_filename"></span>';
		echo '<button id="upload_'.$asset_name.'_button" data-uploader-button data-for="'.$asset_name.'">Upload '.$asset_name.'</button>';
		echo '<input type="text" id="'.$asset_name.'"" name="_'.$asset_name.'" value="' . esc_attr($asset['asset']) . '">';
		echo '</div>';
		echo '</div>';


        // Animated checkbox for 'main_asset'
        if ($asset_name === 'main_asset') {

		    $asset['animated'] = empty($asset['animated']) ? 'on' : $asset['animated'];
		    $asset['mirror'] = isset($asset['mirror']) ? $asset['mirror'] : 'off';
		    $asset['variable'] = empty($asset['variable']) ? 'on' : $asset['variable'];
		    $asset['shadow'] = isset($asset['shadow']) ? $asset['shadow'] : 'off';
            
            echo '<label for="main_asset_animated">Animated</label>';
            echo '<input type="checkbox" id="main_asset_animated" name="_main_asset_animated" value="on" ' . checked($asset['animated'], 'on', false) . ' />';
            
            echo '<label for="main_asset_mirror">Mirror</label>';
            echo '<input type="checkbox" id="main_asset_mirror" name="_main_asset_mirror" value="on" ' . checked($asset['mirror'], 'on', false) . ' />';
            
            echo '<label for="main_asset_variable">Variable size</label>';
            echo '<input type="checkbox" id="main_asset_variable" name="_main_asset_variable" value="on" ' . checked($asset['variable'], 'on', false) . ' />';
            
            echo '<label for="main_asset_shadow">Shadow</label>';
            echo '<input type="checkbox" id="main_asset_shadow" name="_main_asset_shadow" value="on" ' . checked($asset['shadow'], 'on', false) . ' />';
        }
    }

	echo '</div>';



}

function mn_special_save_logo($post_id) {
	// Check nonce for security
    if (!isset($_POST['logo_url']) || !wp_verify_nonce($_POST['assets_logo'], basename(__FILE__))) {
        return $post_id;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    $logo = get_post_meta($post_id, '_logo_asset', true);

    if ( isset($_POST['logo_url']) && $_POST['logo_url'] !== $logo ) {
	    update_post_meta($post_id, '_logo_asset', esc_url_raw($_POST['logo_url']));
	}
}

add_action('save_post_special-archive', 'mn_special_save_logo');



function mn_special_save_assets($post_id) {
    // Check nonce for security
    if (!isset($_POST['assets_nonce']) || !wp_verify_nonce($_POST['assets_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check permissions
    if ('special-archive' == $_POST['post_type'] && current_user_can('edit_post', $post_id)) {
    	

        // Define our meta keys and their default values
        $meta_keys = array(
            '_title_asset_options' => 'default',
            '_title_asset' => '',
            '_main_asset_options' => 'default',
            '_main_asset' => '',
            '_main_asset_animated' => 'off', 
            '_main_asset_mirror' => 'off',
            '_main_asset_variable' => 'off',
            '_main_asset_shadow' => 'off',
            '_static_asset_1_options' => 'default',
            '_static_asset_1' => '',
            '_static_asset_2_options' => 'default',
            '_static_asset_2' => '',
            '_added_asset_1_options' => 'default',
            '_added_asset_1' => '',
            '_added_asset_2_options' => 'default',
            '_added_asset_2' => '',
            '_added_asset_3_options' => 'default',
            '_added_asset_3' => '',
            '_asset_top_options' => 'none',
            '_asset_top' => '',
            '_asset_bot_options' => 'none',
            '_asset_bot' => ''
        );


        foreach ($meta_keys as $meta_key => $default_value) {
		    // Get the current meta value
		    $current_value = get_post_meta($post_id, $meta_key, true);


		    // Check if the new key is set in $_POST
		    $new_value = isset($_POST[$meta_key]) ? $_POST[$meta_key] : $default_value;


		    // If the new value is different from the current value, then update or delete
		    if ($new_value != $current_value) {
		        update_post_meta($post_id, $meta_key, $new_value);
		    } elseif ('' === $new_value && $current_value) {
		        delete_post_meta($post_id, $meta_key);
		    }
		}


    } else {
        return $post_id;
    }
}

add_action('save_post_special-archive', 'mn_special_save_assets');
