<?php
/*
 * Template Name: single country template
 * Template Post Type: post, countries_details
 */
  
 get_header(); 


  ?>
 
<div id="content" role="main">

    <?php


	

				global $post;
				/*$myvals = get_post_meta($post_id);

							 foreach($myvals as $key=>$val)
								{
									echo $key . ' : ' . $val[0] . '<br/>';
								} */
								
						 $country = get_post_meta($post->ID, 'country', true);
					   //print_r($topleveldomain);
                      echo 'country: ' . $country;
echo'<br/>';		
								
                       $topleveldomain = get_post_meta($post->ID, 'topleveldomain', true);
					   //print_r($topleveldomain);
                      echo 'topleveldomain: ' . $topleveldomain;
echo'<br/>';

$alphatocode = get_post_meta($post->ID, 'alphatocode', true);
					   //print_r($topleveldomain);
                      echo 'alphatocode: ' . $alphatocode;
echo'<br/>';

$alphathcode = get_post_meta($post->ID, 'alphathcode', true);
					   //print_r($topleveldomain);
                      echo 'alphathcode: ' . $alphathcode;
echo'<br/>';

$callingcodes = get_post_meta($post->ID, 'callingcodes', true);
					   //print_r($topleveldomain);
                      echo 'callingcodes: ' . $callingcodes;
echo'<br/>';


$timezones = get_post_meta($post->ID, 'timezones', true);
					   //print_r($topleveldomain);
                      echo 'timezones: ' . $timezones;
echo'<br/>';


$currencies = get_post_meta($post->ID, 'currencies', true);
					   //print_r($topleveldomain);
                      echo 'currencies: ' . $currencies;
echo'<br/>';

$country_flag = get_post_meta($post->ID, 'country_flag', true);
					   //print_r($topleveldomain);
                      echo 'country_flag: <img style="width:30px" src="' . $country_flag .'"/>';
			
echo'<br/>';

$correspondingcountry = get_post_meta($POST->ID,'correspondingcountry',true);
					   //print_r($topleveldomain);
                     echo 'correspondingcountry: ' . $correspondingcountry;
			
echo'<br/>';

     
    ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        <small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>

        <div class="entry">
            <?php the_content(); ?>
        </div>

        <p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments »', '1 Comment »', '% Comments »'); ?></p>
    </div>
    <?php endwhile; endif; ?>
   
</div><!-- #content -->

<?php get_footer();


?>