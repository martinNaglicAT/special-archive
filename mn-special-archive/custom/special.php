<?php 
function mn_register_special_post_type() {

	register_post_type(
			'special-archive',
			[
				'labels'                => [
					'name'                  => __( 'Speciali', 'forum' ),
					'singular_name'         => __( 'Special', 'forum' ),
					'all_items'             => __( 'Vsi speciali', 'forum' ),
					'archives'              => __( 'Speciali Archives', 'forum' ),
					'attributes'            => __( 'Special Attributes', 'forum' ),
					'insert_into_item'      => __( 'Insert into Special', 'forum' ),
					'uploaded_to_this_item' => __( 'Uploaded to this Special', 'forum' ),
					'featured_image'        => _x( 'Featured Image', 'special-archive', 'forum' ),
					'set_featured_image'    => _x( 'Set featured image', 'special-archive', 'forum' ),
					'remove_featured_image' => _x( 'Remove featured image', 'special-archive', 'forum' ),
					'use_featured_image'    => _x( 'Use as featured image', 'special-archive', 'forum' ),
					'filter_items_list'     => __( 'Filter specials list', 'forum' ),
					'items_list_navigation' => __( 'specials list navigation', 'forum' ),
					'items_list'            => __( 'specials list', 'forum' ),
					'new_item'              => __( 'New Special', 'forum' ),
					'add_new'               => __( 'Add New', 'forum' ),
					'add_new_item'          => __( 'Add New Special', 'forum' ),
					'edit_item'             => __( 'Edit Special', 'forum' ),
					'view_item'             => __( 'View Special', 'forum' ),
					'view_items'            => __( 'View Specials', 'forum' ),
					'search_items'          => __( 'Search Specials', 'forum' ),
					'not_found'             => __( 'No Specials found', 'forum' ),
					'not_found_in_trash'    => __( 'No Specials found in trash', 'forum' ),
					'parent_item_colon'     => __( 'Parent Special:', 'forum' ),
					'menu_name'             => __( 'Special', 'forum' ),
				],
				'public'                => true,
				'hierarchical'          => false,
				'show_ui'               => true,
				'show_in_nav_menus'     => true,
				'publicly_queryable'    => true,
				'supports'              => [ 'thumbnail', 'custom-fields', 'slug', 'image', 'video' ],
				'has_archive'           => false,
				'rewrite'               => ['slug' => 'special', 'with_front' => false ],
				'query_var'             => true,
				'menu_position'         => 3,
				'menu_icon'             => 'dashicons-art',
				'show_in_rest'          => true,
				'rest_base'             => 'special-archive',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
			]
		);

}
