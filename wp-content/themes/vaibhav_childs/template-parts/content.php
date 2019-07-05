<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Flash
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <div id="content" role="main">

    <?php

 /*add_action('wp_head', 'add_to_wp_head');
                function add_to_wp_head( )
                {
                    if (is_single())
                    {
                        global $post;
                        $topleveldomain = get_post_meta($post->ID, 'topleveldomain', true);
                        echo 'meta box value: ' . $topleveldomain;
                    }
                } */

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



     ?>
	<?php
	/**
	 * flash_before_post_content hook
	 */
	do_action( 'flash_before_post_content' ); ?>

	<?php
	$blog_style = get_theme_mod( 'flash_blog_style', 'classic-layout' );
	if ( !is_singular() ) {
		if( $blog_style == 'classic-layout' ) {
			$image_size = 'flash-square';
		} elseif( $blog_style == 'full-width-archive' ){
			$image_size = 'flash-big';
		} else {
			$image_size = 'flash-grid';
		}
	} else {
		$image_size = 'full';
	}
	?>
	<?php if( has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail">
		<?php the_post_thumbnail( $image_size ); ?>
	</div>
	<?php endif; ?>

	<div class="entry-content-block">
		<header class="entry-header">
			<?php
			if ( !is_single() ) :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			else:
				the_title( '<div class="entry-title hidden">', '</div>' );
			endif;
			?>
		</header><!-- .entry-header -->

		<?php
		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php flash_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>

		<div class="entry-content">
			<?php if ( is_singular() ) : ?>
				<?php the_content(); ?>
			<?php else: ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'flash' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php flash_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>

	<?php
	/**
	 * flash_after_post_content hook
	 */
	do_action( 'flash_after_post_content' ); ?>

</article><!-- #post-## -->
