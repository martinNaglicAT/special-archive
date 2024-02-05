<?php

if (!defined('ABSPATH')) {
    exit;
}


function mn_special_meta_boxes() {
    add_meta_box('mn_title_parts', 'Title Parts', 'mn_title_parts_callback', 'special-archive', 'normal', 'high');
    add_meta_box('mn_text_1', 'Text Top', 'mn_text_top_callback', 'special-archive', 'normal', 'high');
}

add_action('add_meta_boxes_special-archive', 'mn_special_meta_boxes', 1);  // Ensuring it only applies to 'special-archive' post type


function mn_title_parts_callback($post) {
    // Nonce field for security
    wp_nonce_field(basename(__FILE__), 'mn_special_nonce');
    
    // Get values from post meta
    $value1 = get_post_meta($post->ID, '_title_part_1', true);
    $value2 = get_post_meta($post->ID, '_title_part_2', true);
    $value3 = get_post_meta($post->ID, '_title_part_3', true);
    
    // Display inputs
    echo '<label for="title_part_1">Title Part 1:</label>';
    echo '<input type="text" name="title_part_1" value="' . esc_attr($value1) . '" default="Style."><br>';

    echo '<label for="title_part_2">Title Part 2:</label>';
    echo '<input type="text" name="title_part_2" value="' . esc_attr($value2) . '"><br>';

    echo '<label for="title_part_3">Title Part 3:</label>';
    echo '<input type="text" name="title_part_3" value="' . esc_attr($value3) . '">';
}



function mn_text_top_callback($post) {
    // Nonce field for security
    wp_nonce_field(basename(__FILE__), 'mn_special_nonce');
    
    // Get values from post meta
    $value = get_post_meta($post->ID, '_text_top', true);
        
    // Display inputs
    echo '<label for="text_top">Text top:</label>';
    echo '<textarea name="text_top" id="text_top" rows="5" cols="50">'. esc_attr($value) .'</textarea><br>';

}

//Text values save
function special_save_post($post_id) {
    // Check nonce for security
    if (!isset($_POST['mn_special_nonce']) || !wp_verify_nonce($_POST['mn_special_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // Check if autosave
    /*if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }*/

    // Check if it's a revision or autosave
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return $post_id;
    }


    // Get the title parts from $_POST, sanitized
    $title_part_1 = isset($_POST['title_part_1']) ? sanitize_text_field($_POST['title_part_1']) : '';
    $title_part_2 = isset($_POST['title_part_2']) ? sanitize_text_field($_POST['title_part_2']) : '';
    $title_part_3 = isset($_POST['title_part_3']) ? sanitize_text_field($_POST['title_part_3']) : '';
    $text_top = isset($_POST['text_top']) ? sanitize_text_field($_POST['text_top']) : '';

    $new_title_parts = array_filter([$title_part_1, $title_part_2, $title_part_3]);
    $new_title = implode(' ', $new_title_parts);


    // If the title hasn't changed, no need to update it.
    if ($new_title !== get_the_title($post_id)) {
        // Update the post title
        wp_update_post(array('ID' => $post_id, 'post_title' => $new_title));

        // Prevent infinite loop
        remove_action('save_post', 'special_save_post');
    }
    
    // Save or update the meta fields
    update_post_meta($post_id, '_title_part_1', $title_part_1);
    update_post_meta($post_id, '_title_part_2', $title_part_2);
    update_post_meta($post_id, '_title_part_3', $title_part_3);

    if( $text_top !== get_post_meta($post_id, '_text_top', true) ){
        update_post_meta($post_id, '_text_top', $text_top);
    }
}

add_action('save_post_special-archive', 'special_save_post'); 



//slug default
function update_special_post_slug( $post_id ) {
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check if the saved post is of the type "special"
    if ( get_post_type( $post_id ) !== 'special-archive' ) {
        return;
    }

    // Check if the slug has been set for this post
    $slug_set = get_post_meta( $post_id, '_slug_set', true );
    if ( $slug_set ) {
        return;
    }

    // Get the values of title_part_2 and title_part_3
    $title_part_2 = get_post_meta( $post_id, '_title_part_2', true );
    $title_part_3 = get_post_meta( $post_id, '_title_part_3', true );

    // If both values are present, update the slug
    if ( $title_part_2 && $title_part_3 ) {
        $new_slug = sanitize_title( strtolower( $title_part_2 ) . '-' . strtolower( $title_part_3 ) );
        $new_slug = wp_unique_post_slug( $new_slug, $post_id, get_post_status( $post_id ), get_post_type( $post_id ), 0 );
        
        // Check if the new slug is different from the current slug to avoid unnecessary updates
        if ( $new_slug !== get_post_field( 'post_name', $post_id ) ) {
            // Temporarily remove the action to prevent an infinite loop
            remove_action( 'save_post', 'update_special_post_slug' );

            // Update the post slug
            wp_update_post( array(
                'ID'        => $post_id,
                'post_name' => $new_slug  // the slug
            ));

            // Mark the slug as set for this post
            update_post_meta( $post_id, '_slug_set', true ); //update the post meta so that the slug doesn't change with every title change

            // Re-add the action
            add_action( 'save_post', 'update_special_post_slug', 12 );
        }
    }
}
add_action( 'save_post_special-archive', 'update_special_post_slug', 12 );