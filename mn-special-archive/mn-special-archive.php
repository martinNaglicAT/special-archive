<?php

/*
Plugin Name: MN Special Archive
Description: A custom post type and related functionalities for special archives.
Version: 1.13
Author: Martin Naglič
*/

if (!defined('ABSPATH')) {
    exit;
}

define('MN_SPECIAL_PLUGIN_VER', '1.14');



//import custom post types and taxonomies
require plugin_dir_path( __FILE__ ) . 'custom/special.php';

//include metaboxes from a separate file
require_once plugin_dir_path(__FILE__) . 'includes/metabox-text.php';
require_once plugin_dir_path(__FILE__) . 'includes/metabox-styling.php';
require_once plugin_dir_path(__FILE__) . 'includes/metabox-assets.php';

//Registering special post type
add_action('init', 'mn_register_special_post_type');

//Enqueue assets
function mn_enqueue_special_assets() {

    // If it's the frontend and is the special post type/homepage, enqueue the styles/scripts
    if ( !is_admin() && (is_post_type_archive('special-archive') || is_singular('special-archive') || is_front_page()) ) {

        wp_enqueue_script('mn-special-script', plugins_url('js/scripts.js', __FILE__), array('jquery'), MN_SPECIAL_PLUGIN_VER, true);

    }

    if ( !is_admin() && (is_post_type_archive('special-archive') || is_singular('special-archive')) ) {

        wp_enqueue_style('mn-special-style', plugins_url('css/style.css', __FILE__), MN_SPECIAL_PLUGIN_VER);

    } else if ( !is_admin() && is_front_page() ) {

        wp_enqueue_style('mn-special-style', plugins_url('css/homepage.css', __FILE__), MN_SPECIAL_PLUGIN_VER);

    } else if (isset($_GET['special_iframe']) && $_GET['special_iframe'] === 'true') {
        
        // Enqueue the scripts and styles specifically for the iframe here
        wp_enqueue_script('mn-special-script', plugins_url('js/scripts.js', __FILE__), array('jquery'), MN_SPECIAL_PLUGIN_VER, true);
        wp_enqueue_style('mn-special-homepage-style', plugins_url('css/iframe.css', __FILE__), MN_SPECIAL_PLUGIN_VER);
        
    
    }
}
add_action('wp_enqueue_scripts', 'mn_enqueue_special_assets');


// Enqueue Admin assets
function mn_special_enqueue_admin_assets($hook) {
    global $post;  // Make the $post variable globally accessible

    if ('post.php' != $hook && 'post-new.php' != $hook) {
        return;
    }

    if (isset($post) && 'special-archive' === $post->post_type) {
        wp_enqueue_script('admin-script', plugins_url('js/admin.js', __FILE__), array('jquery'), MN_SPECIAL_PLUGIN_VER, true);

        wp_enqueue_style('admin-style', plugins_url('css/admin.css', __FILE__), MN_SPECIAL_PLUGIN_VER);

        //color picker
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        //media uploader
        wp_enqueue_media();
    }
}

add_action('admin_enqueue_scripts', 'mn_special_enqueue_admin_assets');




//Defining post template to be included in the theme
function mn_special_template($template) {
    if (is_singular('special-archive')) {
        $template = plugin_dir_path( __FILE__ ) . 'single-special.php';
    }
    return $template;
}

add_filter('template_include', 'mn_special_template');


//defining function for homepage element to be added in the main theme
function mn_get_homepage_special() {
    include plugin_dir_path(__FILE__) . 'partials/homepage-special.php';
}

//define and register page for an iframe cross-ptomotion

function custom_query_vars_filter($vars) {
    $vars[] .= 'special_iframe';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars_filter');

function add_iframe_template() {
    if (get_query_var('special_iframe')) {
        include plugin_dir_path(__FILE__) . 'partials/iframe-special.php';
        exit;
    }
}
add_action('template_redirect', 'add_iframe_template');

/*________Third party dependencies________*/


/*ACF START*/

//Register relationship field as an article picker on the archive editor page
if( function_exists('acf_add_local_field_group') ):

    // Fetch all categories
    $categories = get_categories(array('hide_empty' => true));

    // Format categories for ACF
    $acf_taxonomies = array();
    foreach ($categories as $category) {
        $acf_taxonomies[] = 'category:' . $category->slug;
    }

    acf_add_local_field_group(array(
        'key' => 'group_651dcecb3c141',
        'title' => 'Handpicked Articles Special',
        'fields' => array(
            array(
                'key' => 'field_651dcf55e9a18',
                'label' => 'Articles',
                'name' => 'articles',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'post',
                ),
                'taxonomy' => $acf_taxonomies,
                'filters' => array(
                    0 => 'search',
                    1 => 'taxonomy',
                ),
                'elements' => array(
                    0 => 'featured_image',
                ),
                'min' => '',
                'max' => '',
                'return_format' => 'id',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'special-archive',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;


//Adjusting ACF metabox priority
function adjust_acf_priority( $priority, $field_group ) {

    global $post;

    if ($post && $post->post_type == 'special-archive') {
        return 'low'; // or 'default', or 'high'
    }

    return $priority; // Return the original priority for other post types.
}


add_filter('acf/input/meta_box_priority', 'adjust_acf_priority', 10, 2);


/*ACF END*/





//Moving Yoast SEO metabox to the bottom
function custom_move_yoast_to_bottom() {
    global $wp_meta_boxes;

    $post_type = 'special-archive'; // or set to your post type
    $yoast_meta_box = $wp_meta_boxes[$post_type]['normal']['high']['wpseo_meta'];

    // Remove the original metabox from its current position
    unset($wp_meta_boxes[$post_type]['normal']['high']['wpseo_meta']);

    // Add it back at a different priority or context
    $wp_meta_boxes[$post_type]['normal']['low']['wpseo_meta'] = $yoast_meta_box;
}
add_action('add_meta_boxes_special-archive', 'custom_move_yoast_to_bottom', 999); // 999 means do it very late, after all others


//Default all meta boxes on the "special" post type to be shown, regardless of previous user choice
function custom_default_hidden_meta_boxes( $hidden, $screen ) {
    if ( 'special-archive' == $screen->post_type ) {
        return array(); // Empty array means show all metaboxes
    }
    
    return $hidden; // Return default for other post types
}
add_filter( 'default_hidden_meta_boxes', 'custom_default_hidden_meta_boxes', 10, 2 );


/*----------Third Party End----------*/



/*---------RETRIEVE VALUES TO FRONTEND-----------*/

function mn_special_retrieve_assets($post_id) {
    global $post;
    // Fetch all meta data
    $current_meta = array(
        'title_part_1' => get_post_meta($post_id, '_title_part_1', true),
        'title_part_2' => get_post_meta($post_id, '_title_part_2', true),
        'title_part_3' => get_post_meta($post_id, '_title_part_3', true),
        'text_top' => get_post_meta($post_id, '_text_top', true),
        'text_color' => get_post_meta($post_id, '_text_color', true),
        'text_bg_option' => get_post_meta($post_id, '_text_bg_option', true),
        'text_bg_color' => get_post_meta($post_id, '_text_bg_color', true),
        'title_color' => get_post_meta($post_id, '_title_color', true),
        'primary_color' => get_post_meta($post_id, '_primary_color', true),
        'secondary_color' => get_post_meta($post_id, '_secondary_color', true),
        'slider_color' => get_post_meta($post_id, '_slider_color', true),
        'slider_bg' => get_post_meta($post_id, '_slider_bg', true),
        'video_bg_option' => get_post_meta($post_id, '_video_bg_option', true),
        'video_bg_url' => get_post_meta($post_id, '_video_bg_url', true),
        'fallback_bg_option' => get_post_meta($post_id, '_fallback_bg_option', true),
        'fallback_bg_image' => get_post_meta($post_id, '_fallback_bg_image', true),
        'fallback_bg_color' => get_post_meta($post_id, '_fallback_bg_color', true),
        'title_asset_options' => get_post_meta($post_id, '_title_asset_options', true),
        'title_asset' => get_post_meta($post_id, '_title_asset', true),
        'main_asset_options' => get_post_meta($post_id, '_main_asset_options', true),
        'main_asset' => get_post_meta($post_id, '_main_asset', true),
        'main_asset_animated' => get_post_meta($post_id, '_main_asset_animated', true),
        'main_asset_mirror' => get_post_meta($post_id, '_main_asset_mirror', true),
        'main_asset_variable' => get_post_meta($post_id, '_main_asset_variable', true),
        'main_asset_shadow' => get_post_meta($post_id, '_main_asset_shadow', true),
        'static_asset_1_options' => get_post_meta($post_id, '_static_asset_1_options', true),
        'static_asset_1' => get_post_meta($post_id, '_static_asset_1', true),
        'static_asset_2_options' => get_post_meta($post_id, '_static_asset_2_options', true),
        'static_asset_2' => get_post_meta($post_id, '_static_asset_2', true),
        'added_asset_1_options' => get_post_meta($post_id, '_added_asset_1_options', true),
        'added_asset_1' => get_post_meta($post_id, '_added_asset_1', true),
        'added_asset_2_options' => get_post_meta($post_id, '_added_asset_2_options', true),
        'added_asset_2' => get_post_meta($post_id, '_added_asset_2', true),
        'added_asset_3_options' => get_post_meta($post_id, '_added_asset_3_options', true),
        'added_asset_3' => get_post_meta($post_id, '_added_asset_3', true),
        'asset_top_options' => get_post_meta($post_id, '_asset_top_options', true),
        'asset_top' => get_post_meta($post_id, '_asset_top', true),
        'asset_bot_options' => get_post_meta($post_id, '_asset_bot_options', true),
        'asset_bot' => get_post_meta($post_id, '_asset_bot', true),
        'logo_asset' => get_post_meta($post_id, '_logo_asset', true)
    );

    //defining fallback vars:

    $formats = ['webp', 'png'];
    $sizes = ['small', 'mid', 'big'];



    // Construct the assets array based on meta values
    $assets_array = [
        'title_part_1' => $current_meta['title_part_1'],
        'title_part_2' => $current_meta['title_part_2'],
        'title_part_3' => $current_meta['title_part_3'],
        'text_top' => $current_meta['text_top'] !== '' ? $current_meta['text_top'] : false,
        'text_color' => $current_meta['text_color'],
        'text_bg_option' => $current_meta['text_bg_option'] === 'color',
        'text_bg_color' => $current_meta['text_bg_color'],
        'title_color' => $current_meta['title_color'],
        'primary_color' => $current_meta['primary_color'],
        'secondary_color' => $current_meta['secondary_color'],
        'slider_color' => $current_meta['slider_color'],
        'slider_bg' => $current_meta['slider_bg'],
        'is_video' => $current_meta['video_bg_option'] !== 'none',
        'video_bg' => $current_meta['video_bg_option'] === 'default' || empty($current_meta['video_bg_option'])
            ? plugins_url().'/mn-special-archive/fallback-assets/style-beauty-bg-landing.mp4'
            : $current_meta['video_bg_url'],
        'no_fallback_bg_img' => $current_meta['fallback_bg_image'] === '' && $current_meta['fallback_bg_option'] === 'custom',
        'fallback_bg_color' => $current_meta['fallback_bg_color'] !== '' ? $current_meta['fallback_bg_color'] : '#e8dace',
        'is_title_asset' => $current_meta['title_asset_options'] !== 'none',
        'is_main_asset' => $current_meta['main_asset_options'] !== 'none',
        'is_main_animated' => $current_meta['main_asset_animated'] === 'on',
        'is_main_mirror' => $current_meta['main_asset_mirror'] === 'on',
        'is_main_variable' => $current_meta['main_asset_variable'] === 'on',
        'is_main_shadow' => $current_meta['main_asset_shadow'] === 'on',
        'is_static_asset_1' => $current_meta['static_asset_1_options'] !== 'none',
        'is_static_asset_2' => $current_meta['static_asset_2_options'] !== 'none',
        'is_added_asset_1' => $current_meta['added_asset_1_options'] !== 'none',
        'is_added_asset_2' => $current_meta['added_asset_2_options'] !== 'none',
        'is_added_asset_3' => $current_meta['added_asset_3_options'] !== 'none',
        'is_asset_top' => $current_meta['asset_top_options'] !== 'none',
        'asset_top_options' => $current_meta['asset_top_options'],
        'asset_top' => $current_meta['asset_top'],
        'is_asset_bot' => $current_meta['asset_bot_options'] !== 'none',
        'asset_bot_options' => $current_meta['asset_bot_options'],
        'asset_bot' => $current_meta['asset_bot'],
        'logo_asset' => $current_meta['logo_asset'] !== '' ? $current_meta['logo_asset'] : false

    ];

    // Multi-dimensional assets (only for those that need it)
    foreach ($formats as $format) {

        $assets_array['fallback_bg_image'][$format] = $current_meta['fallback_bg_option'] !== 'default' 
            ? $current_meta['fallback_bg_image'] 
            : plugins_url().'/mn-special-archive/fallback-assets/asset-bg-fallback.'.$format;

        $assets_array['title_asset'][$format] = $current_meta['title_asset_options'] === 'default' || empty($current_meta['title_asset_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-middle-landing.'.$format
                : $current_meta['title_asset'];

        $assets_array['static_asset_1'][$format] = $current_meta['static_asset_1_options'] === 'default' || empty($current_meta['static_asset_1_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-stick-1.'.$format
                : $current_meta['static_asset_1'];

        $assets_array['static_asset_2'][$format] = $current_meta['static_asset_2_options'] === 'default' || empty($current_meta['static_asset_2_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-stick-2.'.$format
                : $current_meta['static_asset_2'];

        $assets_array['added_asset_1'][$format] = $current_meta['added_asset_1_options'] === 'default' || empty($current_meta['added_asset_1_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-hoop.'.$format
                : $current_meta['added_asset_1'];

        $assets_array['added_asset_2'][$format] = $current_meta['added_asset_2_options'] === 'default' || empty($current_meta['added_asset_2_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-brush-up.'.$format
                : $current_meta['added_asset_2'];

        $assets_array['added_asset_3'][$format] = $current_meta['added_asset_3_options'] === 'default' || empty($current_meta['added_asset_3_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-brush-down.'.$format
                : $current_meta['added_asset_3'];


        foreach ($sizes as $size) {
            $assets_array['main_asset'][$format][$size] = $current_meta['main_asset_options'] === 'default' || empty($current_meta['main_asset_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-ball-'.$size.'.'.$format
                : $current_meta['main_asset'];
        }


        

    }

    return $assets_array;
}



function mn_special_retrieve_assets_homepage($post_id) {
    global $post;
    // Fetch all meta data
    $current_meta = array(
        'slug' => get_post_field('post_name', $post_id),
        'title_part_1' => get_post_meta($post_id, '_title_part_1', true),
        'title_part_2' => get_post_meta($post_id, '_title_part_2', true),
        'title_part_3' => get_post_meta($post_id, '_title_part_3', true),
        'title_color' => get_post_meta($post_id, '_title_color', true),
        'primary_color' => get_post_meta($post_id, '_primary_color', true),
        'secondary_color' => get_post_meta($post_id, '_secondary_color', true),
        'slider_color' => get_post_meta($post_id, '_slider_color', true),
        'slider_bg' => get_post_meta($post_id, '_slider_bg', true),
        'video_bg_option' => get_post_meta($post_id, '_video_bg_option', true),
        'video_bg_url' => get_post_meta($post_id, '_video_bg_url', true),
        'fallback_bg_option' => get_post_meta($post_id, '_fallback_bg_option', true),
        'fallback_bg_image' => get_post_meta($post_id, '_fallback_bg_image', true),
        'fallback_bg_color' => get_post_meta($post_id, '_fallback_bg_color', true),
        'title_asset_options' => get_post_meta($post_id, '_title_asset_options', true),
        'title_asset' => get_post_meta($post_id, '_title_asset', true),
        'main_asset_options' => get_post_meta($post_id, '_main_asset_options', true),
        'main_asset' => get_post_meta($post_id, '_main_asset', true),
        'main_asset_animated' => get_post_meta($post_id, '_main_asset_animated', true),
        'static_asset_1_options' => get_post_meta($post_id, '_static_asset_1_options', true),
        'static_asset_1' => get_post_meta($post_id, '_static_asset_1', true),
        'static_asset_2_options' => get_post_meta($post_id, '_static_asset_2_options', true),
        'static_asset_2' => get_post_meta($post_id, '_static_asset_2', true)
    );

    //defining fallback vars:

    $formats = ['webp', 'png'];
    $sizes = ['small', 'mid', 'big'];


    // Construct the assets array based on meta values
    $assets_array = [
        'slug' => $current_meta['slug'],
        'title_part_1' => $current_meta['title_part_1'],
        'title_part_2' => $current_meta['title_part_2'],
        'title_part_3' => $current_meta['title_part_3'],
        'title_color' => $current_meta['title_color'],
        'primary_color' => $current_meta['primary_color'],
        'secondary_color' => $current_meta['secondary_color'],
        'slider_color' => $current_meta['slider_color'],
        'slider_bg' => $current_meta['slider_bg'],
        'is_video' => $current_meta['video_bg_option'] !== 'none',
        'video_bg' => $current_meta['video_bg_option'] === 'default' || empty($current_meta['video_bg_option'])
            ? plugins_url().'/mn-special-archive/fallback-assets/style-beauty-bg-landing.mp4'
            : $current_meta['video_bg_url'],
        'fallback_bg_color' => $current_meta['fallback_bg_color'] !== '' ? $current_meta['fallback_bg_color'] : '#e8dace',
        'no_fallback_bg_img' => $current_meta['fallback_bg_image'] === '' && $current_meta['fallback_bg_option'] === 'custom',
        'is_title_asset' => $current_meta['title_asset_options'] !== 'none',
        'is_main_asset' => $current_meta['main_asset_options'] !== 'none',
        'is_main_animated' => $current_meta['main_asset_animated'] === 'on',
        'is_static_asset_1' => $current_meta['static_asset_1_options'] !== 'none',
        'is_static_asset_2' => $current_meta['static_asset_2_options'] !== 'none'
    ];

    // Multi-dimensional assets (only for those that need it)
    foreach ($formats as $format) {

        $assets_array['fallback_bg_image'][$format] = $current_meta['fallback_bg_option'] !== 'default' 
            ? $current_meta['fallback_bg_image'] 
            : plugins_url().'/mn-special-archive/fallback-assets/asset-bg-fallback.'.$format;

        $assets_array['title_asset'][$format] = $current_meta['title_asset_options'] === 'default' || empty($current_meta['title_asset_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-middle.'.$format
                : $current_meta['title_asset'];

        if($assets_array['is_static_asset_1']){
            $assets_array['static_asset_1'][$format] = $current_meta['static_asset_1_options'] === 'default' || empty($current_meta['static_asset_1_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-stick-1.'.$format
                : $current_meta['static_asset-1'];
        }

        if($assets_array['is_static_asset_2']){
            $assets_array['static_asset_2'][$format] = $current_meta['static_asset_2_options'] === 'default' || empty($current_meta['static_asset_2_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-stick-2.'.$format
                : $current_meta['static_asset-2'];
        }
        

        foreach ($sizes as $size) {
            $assets_array['main_asset'][$format][$size] = $current_meta['main_asset_options'] === 'default' || empty($current_meta['main_asset_options'])
                ? plugins_url().'/mn-special-archive/fallback-assets/'.$format.'/asset-ball-'.$size.'.'.$format
                : $current_meta['main_asset'];
        }

    }

    return $assets_array;
}



//Admin settings menu
add_action('admin_menu' , 'tradmin_page_settings');
function tradmin_page_settings() {
add_submenu_page('edit.php?post_type=special-archive', 'Special nastavitve', 'Nastavitve', 'edit_posts', 'settings', 'custom_special_settings_page');
}

function custom_special_settings_page(){

    echo '<div class="wrap"><h2>Work in progress</h2></div>';

}





add_filter('wpseo_metadesc', 'custom_yoast_metadesc', 10, 1);

function custom_yoast_metadesc($description) {
    global $post;

    if ($post && $post->post_type == 'special-archive') {

        // If Yoast's meta description is set, return it.
        if (!empty($description)) {
            return $description;
        }

        $default_desc = get_bloginfo('description');

        // If Yoast's meta description is not set, try to fetch the _text_top value.
        $text_top = get_post_meta($post->ID, '_text_top', true);
        
        // If _text_top has a value, return that.
        if (!empty($text_top)) {
            return $text_top;
        } else {
            return $default_desc;
        }

        // Otherwise, return the original (empty) description and Yoast will handle the default.
        return $description;
    }
}
