<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div id="content" class="site-content">
	<div class="container-fluid ">
		<div class="content-left-wrap col-md-12">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

					endwhile; // End of the loop.
				?>

				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .content-left-wrap -->
	</div><!-- .container -->
</div><!-- .site-content -->

<?php get_footer();
