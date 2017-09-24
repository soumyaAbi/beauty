<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1863919977189864'); // Insert your pixel ID here.
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1863919977189864&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->
</head>

<body <?php body_class(); ?> <?php if(is_home() || is_front_page()){?>id="th-home"<?php } else {?>id="th-page"<?php } ?>>
<div id="mobilebgfix">
	<div class="mobile-bg-fix-img-wrap">
		<div class="mobile-bg-fix-img"></div>
	</div>
	<div class="mobile-bg-fix-whole-site">

	<header id="home"  class="header menu-align-center" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
	
	<div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">

		<div class="container-fluid">

			<div class="navbar-header responsive-logo">

				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">

				<span class="sr-only">Toggle navigation</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				</button>
				<?php if(is_home() || is_front_page()): ?>
				<?php the_custom_logo(); ?>
				<?php else:
	                echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';
	                    echo '<img src="'.get_stylesheet_directory_uri().'/images/logo-page.png" alt="'.esc_attr( get_bloginfo('title') ).'">';
	                echo '</a>';
	            endif; ?>
			</div>

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<nav class="navbar-collapse bs-navbar-collapse collapse" id="site-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'zerif-lite' ); ?></a>
			<?php wp_nav_menu( array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right responsive-nav main-nav-list', 'fallback_cb' => 'zerif_wp_page_menu')); ?>
			</nav>
		<?php endif; ?>
		</div>

	</div>
<?php if(!is_front_page()){ ?>
<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->
<?php $base = basename(get_permalink()); ?>
<?php } ?>