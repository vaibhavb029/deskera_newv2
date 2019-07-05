<?php 
/*
Plugin Name: v_Countries
Description: Declares a plugin that will create a custom post type displaying movie reviews.
Version: 1.0
Author: Vaibhav B.
*/

function v_countries_install(){
	
	global $wpdb;
	
	$table_name= $wpdb->prefix."countries";
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
            `id` varchar(3) CHARACTER SET utf8 NOT NULL,
            `country` varchar(50) CHARACTER SET utf8 NOT NULL,
			`topLevelDomain` varchar(50) CHARACTER SET utf8 NOT NULL,
			`alpha2Code` varchar(50) CHARACTER SET utf8 NOT NULL,
			`alpha3Code` varchar(50) CHARACTER SET utf8 NOT NULL,
			`callingCodes` varchar(50) CHARACTER SET utf8 NOT NULL,
			`timezones` varchar(50) CHARACTER SET utf8 NOT NULL,
			`currencies` varchar(50) CHARACTER SET utf8 NOT NULL,
			`country_flag` varchar(50) CHARACTER SET utf8 NOT NULL,
			
            PRIMARY KEY (`id`)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'v_countries_install');

define('ROOTDIR', plugin_dir_path(__FILE__));

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
		 'has_archive' => true
		 )
	);
	register_taxonomy_for_object_type( 'category', 'countries_details' );
    	register_taxonomy_for_object_type( 'post_tag', 'countries_details' );
}



/*add_action('rest_api_init', function(){
	register_rest_route('https://restcountries.eu/rest/v2/all', array(
				'methods'=> 'GET',
				'callback' =>'my_awesome_func',
	
	));
		
});


function my_awesome_func( WP_REST_Request $request ) {
  // You can access parameters via direct array access on the object:
  $param = $request['some_param'];
  
  // Or via the helper method:
  $param = $request->get_param( 'some_param' );
 
  // You can get the combined, merged set of parameters:
  $parameters = $request->get_params();
 
  // The individual sets of parameters are also available, if needed:
  $parameters = $request->get_url_params();
  $parameters = $request->get_query_params();
  $parameters = $request->get_body_params();
  $parameters = $request->get_json_params();
  $parameters = $request->get_default_params();
 
  // Uploads aren't merged in, but can be accessed separately:
  $parameters = $request->get_file_params();
}
/*add_action('admin_init','my_admin' );

function my_admin(){
	
	add_meta_box('countries_details_meta_box',
				'countries_details_description',
				'display_countries_details_meta_box',
				'countries_details','normal','high'
		);
}

function display_countries_details_meta_box(){ */
require_once(ROOTDIR . 'rest_api.php');	
	
	
function prfx_custom_meta() {
	add_meta_box( 'prfx_meta', __( 'Countries Details', 'prfx-textdomain' ), 'prfx_meta_callback', 'countries_details','normal', 'high' );
}
add_action( 'add_meta_boxes', 'prfx_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>
	
	<p>
		<label for="meta-select" class="prfx-row-title"><?php _e( 'country', 'prfx-textdomain' )?></label>
		<select name="meta-select" id="meta-select">
			<option value="select-one" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-one' ); ?>><?php _e( 'One', 'prfx-textdomain' )?></option>';
			<option value="select-two" <?php if ( isset ( $prfx_stored_meta['meta-select'] ) ) selected( $prfx_stored_meta['meta-select'][0], 'select-two' ); ?>><?php _e( 'Two', 'prfx-textdomain' )?></option>';
		</select>
	</p>

	<p>
		<label for="meta-text" class="prfx-row-title"><?php _e( 'topLevelDomain', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-text1" id="meta-text1" value="<?php if ( isset ( $prfx_stored_meta['meta-text1'] ) ) echo $prfx_stored_meta['meta-text1'][0]; ?>" />
	</p>
	
	<p>
		<label for="meta-text" class="prfx-row-title"><?php _e( 'alpha2Code', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-text2" id="meta-text2" value="<?php if ( isset ( $prfx_stored_meta['meta-text2'] ) ) echo $prfx_stored_meta['meta-text2'][0]; ?>" />
	</p>
	
	
	<p>
		<label for="meta-tex" class="prfx-row-title"><?php _e( 'alpha3Code', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-text3" id="meta-text3" value="<?php if ( isset ( $prfx_stored_meta['meta-text3'] ) ) echo $prfx_stored_meta['meta-text3'][0]; ?>" />
	</p>
	
	
	<p>
		<label for="meta-text" class="prfx-row-title"><?php _e( 'callingCodes', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-text4" id="meta-text4" value="<?php if ( isset ( $prfx_stored_meta['meta-text4'] ) ) echo $prfx_stored_meta['meta-text4'][0]; ?>" />
	</p>

	<p>
		<label for="meta-text" class="prfx-row-title"><?php _e( 'timezones', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-text5" id="meta-text5" value="<?php if ( isset ( $prfx_stored_meta['meta-text5'] ) ) echo $prfx_stored_meta['meta-text5'][0]; ?>" />
	</p>
	
	
	<p>
		<label for="meta-text" class="prfx-row-title"><?php _e( 'currencies', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-text6" id="meta-text6" value="<?php if ( isset ( $prfx_stored_meta['meta-text6'] ) ) echo $prfx_stored_meta['meta-text6'][0]; ?>" />
	</p>
	
	<!--<p>
		<span class="prfx-row-title"><?php _e( 'Example Checkbox Input', 'prfx-textdomain' )?></span>
		<div class="prfx-row-content">
			<label for="meta-checkbox">
				<input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox'] ) ) checked( $prfx_stored_meta['meta-checkbox'][0], 'yes' ); ?> />
				<?php _e( 'Checkbox label', 'prfx-textdomain' )?>
			</label>
			<label for="meta-checkbox-two">
				<input type="checkbox" name="meta-checkbox-two" id="meta-checkbox-two" value="yes" <?php if ( isset ( $prfx_stored_meta['meta-checkbox-two'] ) ) checked( $prfx_stored_meta['meta-checkbox-two'][0], 'yes' ); ?> />
				<?php _e( 'Another checkbox', 'prfx-textdomain' )?>
			</label>
		</div>
	</p>-->

	<!--<p>
		<span class="prfx-row-title"><?php _e( 'Example Radio Buttons', 'prfx-textdomain' )?></span>
		<div class="prfx-row-content">
			<label for="meta-radio-one">
				<input type="radio" name="meta-radio" id="meta-radio-one" value="radio-one" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-one' ); ?>>
				<?php _e( 'Radio Option #1', 'prfx-textdomain' )?>
			</label>
			<label for="meta-radio-two">
				<input type="radio" name="meta-radio" id="meta-radio-two" value="radio-two" <?php if ( isset ( $prfx_stored_meta['meta-radio'] ) ) checked( $prfx_stored_meta['meta-radio'][0], 'radio-two' ); ?>>
				<?php _e( 'Radio Option #2', 'prfx-textdomain' )?>
			</label>
		</div>
	</p>-->

	

	<!--<p>
		<label for="meta-textarea" class="prfx-row-title"><?php _e( 'Example Textarea Input', 'prfx-textdomain' )?></label>
		<textarea name="meta-textarea" id="meta-textarea"><?php if ( isset ( $prfx_stored_meta['meta-textarea'] ) ) echo $prfx_stored_meta['meta-textarea'][0]; ?></textarea>
	</p>-->

	<!--<p>
		<label for="meta-color" class="prfx-row-title"><?php _e( 'Color Picker', 'prfx-textdomain' )?></label>
		<input name="meta-color" type="text" value="<?php if ( isset ( $prfx_stored_meta['meta-color'] ) ) echo $prfx_stored_meta['meta-color'][0]; ?>" class="meta-color" />
	</p>-->

	<p>
		<label for="meta-image" class="prfx-row-title"><?php _e( 'Example File Upload', 'prfx-textdomain' )?></label>
		<input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
		<input type="button" id="meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'prfx-textdomain' )?>" />
	</p>
 

	<?php
}



/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'meta-text' ] ) ) {
		update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
	}

	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox', '' );
	}
	 
	// Checks for input and saves
	if( isset( $_POST[ 'meta-checkbox-two' ] ) ) {
		update_post_meta( $post_id, 'meta-checkbox-two', 'yes' );
	} else {
		update_post_meta( $post_id, 'meta-checkbox-two', '' );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-radio' ] ) ) {
		update_post_meta( $post_id, 'meta-radio', $_POST[ 'meta-radio' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-select' ] ) ) {
		update_post_meta( $post_id, 'meta-select', $_POST[ 'meta-select' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-textarea' ] ) ) {
		update_post_meta( $post_id, 'meta-textarea', $_POST[ 'meta-textarea' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-color' ] ) ) {
		update_post_meta( $post_id, 'meta-color', $_POST[ 'meta-color' ] );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'meta-image' ] ) ) {
		update_post_meta( $post_id, 'meta-image', $_POST[ 'meta-image' ] );
	}

}
add_action( 'save_post', 'prfx_meta_save' );


/**
 * Adds the meta box stylesheet when appropriate
 */
function prfx_admin_styles(){
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'prfx_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
	}
}
add_action( 'admin_print_styles', 'prfx_admin_styles' );


/**
 * Loads the color picker javascript
 */
function prfx_color_enqueue() {
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'meta-box-color-js', plugin_dir_url( __FILE__ ) . 'meta-box-color.js', array( 'wp-color-picker' ) );
	}
}
add_action( 'admin_enqueue_scripts', 'prfx_color_enqueue' );

/**
 * Loads the image management javascript
 */
function prfx_image_enqueue() {
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
		wp_localize_script( 'meta-box-image', 'meta_image',
			array(
				'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
				'button' => __( 'Use this image', 'prfx-textdomain' ),
			)
		);
		wp_enqueue_script( 'meta-box-image' );
	}
}
add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );


$url = rest_url( 'https://restcountries.eu/rest/v2/all' );
	echo"<pre>";
	print_r($url);
exit(); 

