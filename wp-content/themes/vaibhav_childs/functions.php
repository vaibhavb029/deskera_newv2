<?php
//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//  
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
//
// Your code goes below
//
add_action('init', 'create_countries_details');



function create_countries_details(){
	register_post_type('countries_details',
	array(
	'labels' =>array(
					'name' => 'Countries Details',
					'singular_name' =>'Country Detail',
					'add_new' =>'Add New',
					'add_new_item'=>'Add New Countries Details',
					'edit' =>'Edit',
					'edit_item'=>'Edit Countries Details',
					'new_item' =>'New Country Detail',
					'view' =>'View',
					'view_item'=>'View Countries Details',
					'search_items'=>'Serach Countries Details',
					'not_found'=>'No Countries details found',
					'not_found_in_trash'=>'No Countries Details found in trash',
					'parent'=>'Parent Countries Details'
					),
		 'public' =>true,
		 'menu_position'=>15,
		 'supports' =>array('title','editor','comments','thumbnail', 'custom-fields'),
		 'show_in_rest' => true,
		 'taxonomies' =>array(''),
		 'rest_controller_class' => 'WP_REST_Posts_Controller',
		 'register_meta_box_cb' => 'add_country_metaboxes',
		 'with_front' => true,
		 'has_archive' => true

		 )
	);
	register_taxonomy_for_object_type( 'category', 'countries_details' );
    	register_taxonomy_for_object_type( 'post_tag', 'countries_details' );
}

