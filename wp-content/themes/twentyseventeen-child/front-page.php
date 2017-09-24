<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div class="home-header-wrap">	
		<?php if ( class_exists( 'content_messenger' ) ) {
			$homeslider =  get_option('tutsplus-homeslider-name'); 
		?>
		<?php echo do_shortcode('[rolo_slider name="'.$homeslider.'"]'); ?>
		<?php } else { ?>
			<?php echo do_shortcode('[rolo_slider name="home-banner"]'); ?>
		<?php } ?>
	</div>

</header> <!-- / END HOME SECTION  -->

<div id="content" class="site-content">
	<?php 
		remove_filter('the_content', 'wpautop');
		// TO SHOW THE PAGE CONTENTS
		while ( have_posts() ) : the_post(); ?> 
	        <?php the_content(); ?> <!-- Page Content -->
	<?php endwhile; ?> 
</div><!-- .site-content -->
<?php get_footer(); ?>
