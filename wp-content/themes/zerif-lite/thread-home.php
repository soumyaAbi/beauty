<?php /* Template Name: ThreadHome */ ?>

<?php get_header(); ?>

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
<?php zerif_after_header_trigger(); ?>

<div id="content" class="site-content">
<?php
remove_filter('the_content', 'wpautop');
// TO SHOW THE PAGE CONTENTS
while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
        <?php the_content(); ?> <!-- Page Content -->
<?php 
endwhile; 

get_footer(); 
?>

