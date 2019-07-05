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


/* function create_countries_details(){
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
*/


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
 function save_your_field_meta($post_id, $post){

  // Return if the user doesn't have edit permissions.
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
    return $post_id;
  }
  // Verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times.
  if ( ! isset( $_POST['topleveldomain'] ) || ! wp_verify_nonce( $_POST['country_fields'], basename(__FILE__) ) ) {
    return $post_id;
  }
  // Now that we're authenticated, time to save the data.
  // This sanitizes the data from the field and saves it into an array $country_meta.
  $country_meta['country'] = esc_textarea( $_POST['country'] );
  $country_meta['topleveldomain'] = esc_textarea( $_POST['topleveldomain'] );
  $country_meta['alphatocode'] = esc_textarea( $_POST['alphatocode'] );
  $country_meta['alphathcode'] = esc_textarea( $_POST['alphathcode'] );
  $country_meta['callingcodes'] = esc_textarea( $_POST['callingcodes'] );
  $country_meta['timezones'] = esc_textarea( $_POST['timezones'] );
  $country_meta['currencies'] = esc_textarea( $_POST['currencies'] );
  $country_meta['country_flag'] = esc_textarea( $_POST['country_flag'] );
  $country_meta['correspondingcountry'] = esc_textarea( $_POST['correspondingcountry'] );
 // $country_meta['callingcodes'] = esc_textarea( $_POST['callingcodes'] );


 // print_r( $country_meta[]);
 // exit();
  // Cycle through the $events_meta array.
  // Note, in this example we just have one item, but this is helpful if you have multiple.
  foreach ( $country_meta as $key => $value ) :
    // Don't store custom data twice
    if ( 'revision' === $post->post_type ) {
      return;
    }
    if ( get_post_meta( $post_id, $key, false ) ) {
      // If the custom field already has a value, update it.
      update_post_meta( $post_id, $key, $value );
    } else {
      // If the custom field doesn't have a value, add it.
      add_post_meta( $post_id, $key, $value);
    }
    if ( ! $value ) {
      // Delete the meta key if there's no value
      delete_post_meta( $post_id, $key );
    }
  endforeach;
}
  

    add_action( 'save_post', 'save_your_field_meta' );
  
 

 
 
function prfx_meta_callback( ) {
  //global $wpdb;
  //$conn = mysqli_connect("localhost", "root", "", "deskera_2");
  
  global $post;
  //$meta = get_post_meta($post->ID,'');
  wp_nonce_field( basename( __FILE__ ), 'country_fields' );

  $topleveldomain = get_post_meta($POST->ID, 'topleveldomain', true);
  $country = get_post_meta($POST->ID,'country', true);
  $alphatocode = get_post_meta($POST->ID,'alphatocode',true);
  $alphathcode = get_post_meta($POST->ID,'alphathcode',true);
  $callingcodes = get_post_meta($POST->ID,'callingcodes',true);
  $timezones = get_post_meta($POST->ID,'timezones',true);
  $Currencies = get_post_meta($POST->ID,'Currencies',true);
  $Flag = get_post_meta($POST->ID,'Flag',true);
  $correspondingcountry = get_post_meta($POST->ID,'correspondingcountry',true);
  $corrtime = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, IN);
// echo"<pre>";print_r($corrtime);exit();



  
  ?>
  
  <!--<input type="hidden" name="v_metabox_nonce" value="<?php echo wp_create_nonce(basename(__FILE__));?>">-->
  
  
  <p>
      <label for="meta-select">Select Country</label>
      <br>
      <select name="country" id="country" onchange="myFunction()">
    <option value="Select Countries ?>">select countries</option>
    <?php 
    global $wpdb;
  $conn = mysqli_connect("localhost", "root", "", "deskera_2");
  $result = mysqli_query($conn,"Select DISTINCT country,topLevelDomain,alpha2Code,alpha3Code,callingCodes,timezones,currencies, country_flag from wp_countries"); 




  //$time = gmmktime();
//echo date("Y-m-d H:i:s", $time); 
    
    while($row = mysqli_fetch_array($result)){

          echo"<option data-topLevelDomain='$row[1]' data-alpha2Code='$row[2]' data-alpha3Code='$row[3]'data-callingCodes='$row[4]' data-timezones='$row[5]' data-currencies='$row[6]' data-country_flag='$row[7]' value='$row[0]'> $row[0] </option>";
    }?>
      </select>
    </p>
  
  <p>
      <label for="meta-text">topLevelDomain</label>
      <br>
    
      <input type="text" name="topleveldomain" id="topleveldomain"  class="regular-text">
    
    </p>
  <p>
      <label for="meta-text">alpha2Code</label>
      <br>
      <input type="text" name="alphatocode" id="alphatocode" class="regular-text">
    </p>
  <p>
      <label for="meta-text">alpha3Code</label>
      <br>
      <input type="text" name="alphathcode" id="alphathcode" class="regular-text">
    </p>
  <p>
      <label for="meta-text">Calling Codes</label>
      <br>
      <input type="text" name="callingcodes" id="callingcodes" class="regular-text">
    </p>
  <p>
      <label for="meta-text">Timezones</label>
      <br>
      <input type="text" name="timezones" id="timezones" class="regular-text">
    </p>
    <p>
      <label for="meta-text">Currencies</label>
      <br>
      <input type="text" name="currencies" id="currencies" class="regular-text">
    </p>
  <p>
      <label for="meta-text">Flag</label>
      <br>
      <input type="text" name="country_flag" id="country_flag" class="regular-text">
     <!-- <div class="image-preview"><img src="<?php echo $row['country_flag']; ?>" style="max-width: 250px;"></div>-->
	 <?php 
	 //$country_flag = get_post_meta($post->ID, 'country_flag', true);
					   //print_r($topleveldomain);
                    //  echo '<img style="width:30px" src="' . $country_flag .'"/>';
			
echo'<br/>';
?>
    </p>
	
	<?php
	 $alphatocode = get_post_meta($POST->ID,'alphatocode',true);
	 
	//$corrtime = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, AL);
	//$tt = $corrtime[0];
		//echo"<pre>";print_r($corrtime[0]);exit();
		?>
	<p>
      <label for="meta-text">Time of the corresponding country</label>
      <br>
	  
      <input type="text" name="correspondingcountry" id="correspondingcountry" class="regular-text" value="<?php echo $tt; ?>">
    </p>


  <!--<p>
      <label for="your_fields[image]">Image Upload</label><br>
      <input type="text" name="your_fields[image]" id="your_fields[image]" class="meta-image regular-text" value="<?php echo $meta['image']; ?>">
      <input type="button" class="button image-upload" value="Browse">
    </p>
    <div class="image-preview"><img src="<?php echo $meta['image']; ?>" style="max-width: 250px;"></div>-->
  

  <?php

  }

?>
<?php 
  
/* function call_rest_api(){
 $link = "https://restcountries.eu/rest/v2/all";

// $data = json_decode($link,true);
 $data = json_decode(file_get_contents($link), true);
 echo"<pre>";
 print_r($data);
 exit();
}
add_filter('rest_api_init','call_rest_api'); */
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


    function myFunction(){
        var topleveldomain = $('#country').find(':selected').data('topleveldomain');
         //alert(topleveldomain);
       

        var alphatocode = $('#country').find(':selected').data('alpha2code');
        
    var alphathcode = $('#country').find(':selected').data('alpha3code');
        var callingcodes = $('#country').find(':selected').data('callingcodes');
       // alert(callingcodes);
    var timezones = $('#country').find(':selected').data('timezones');
    var currencies = $('#country').find(':selected').data('currencies');
    var countryflag =$('#country').find(':selected').data('country_flag');
    //alert(countryflag);
    
        //var contact = $('#name').find(':selected').data('con');
        $('#topleveldomain').val(topleveldomain);

        $('#alphatocode').val(alphatocode);
    $('#alphathcode').val(alphathcode);
        $('#callingcodes').val(callingcodes);
    $('#timezones').val(timezones);
    $('#currencies').val(currencies);
    $('#country_flag').val(countryflag);
	
	

        //$('#alpha2Code').val(alpha2Code);
    }
</script>
<script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<script>
$(document).ready(function(){
	
	$('#country').on('change', function() {
		  var nn = this.value;
		  var cc = $("#alphatocode").val();
		  //alert(cc);
		$.ajax({
		  type: "GET",
		  url: "http://localhost/deskera/wp-content/plugins/v-countries/test.php",
		  data: {'cc':cc},
		  //cache: false,
		  success: function(data){
			 //alert(data);
			 $("#correspondingcountry").val(data);
		  }
		});
		});
})	
</script>	
<!--<script>
  jQuery(document).ready(function($) {
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame
    // Runs when the image button is clicked.
    $('.image-upload').click(function(e) {
      // Get preview pane
      var meta_image_preview = $(this)
        .parent()
        .parent()
        .children('.image-preview')
      // Prevents the default action from occuring.
      e.preventDefault()
      var meta_image = $(this)
        .parent()
        .children('.meta-image')
      // If the frame already exists, re-open it.
      if (meta_image_frame) {
        meta_image_frame.open()
        return
      }
      // Sets up the media library frame
      meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
        title: meta_image.title,
        button: {
          text: meta_image.button,
        },
      })
      // Runs when an image is selected.
      meta_image_frame.on('select', function() {
        // Grabs the attachment selection and creates a JSON representation of the model.
        var media_attachment = meta_image_frame
          .state()
          .get('selection')
          .first()
          .toJSON()
        // Sends the attachment URL to our custom image input field.
        meta_image.val(media_attachment.url)
        meta_image_preview.children('img').attr('src', media_attachment.url)
      })
      // Opens the media library frame.
      meta_image_frame.open()
    })
  })
</script>-->



