<?php
/**
 * The Header for our theme.
 * Displays all of the <head> section and everything up till <div id="content">
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<?php zerif_top_head_trigger(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="p:domain_verify" content="fb4f1af26111ef336bed9a3385cde19b"/>
<meta name="robots" content="index, follow"/>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php 
$fav = get_stylesheet_directory_uri().'/images/fav.png';
if ( class_exists( 'content_messenger' ) ) {
	$fav =  get_option('tutsplus-site-fav-icon'); 
}?>
<link rel="shortcut icon" type="image/png" href="<?php echo $fav; ?>"/>

<?php wp_head(); ?>

<?php zerif_bottom_head_trigger(); ?>
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

<?php if(isset($_POST['scrollPosition'])): ?>

	<body <?php body_class(); ?> onLoad="window.scrollTo(0,<?php echo intval($_POST['scrollPosition']); ?>)" 
	<?php if(is_home() || is_front_page()){?>id="th-home"<?php } else {?>id="th-page"<?php } ?>>

<?php else: ?>

	<body <?php body_class(); ?> <?php if(is_home() || is_front_page()){?>id="th-home"<?php } else {?>id="th-page"<?php } ?>>

<?php endif; ?>
<?php	
	zerif_top_body_trigger();
	
	/* Preloader */

	if(is_front_page() && !is_customize_preview() && get_option( 'show_on_front' ) != 'page' ):
 
		$zerif_disable_preloader = get_theme_mod('zerif_disable_preloader');
		
		if( isset($zerif_disable_preloader) && ($zerif_disable_preloader != 1)):
			echo '<div class="preloader">';
				echo '<div class="status">&nbsp;</div>';
			echo '</div>';
		endif;	

	endif; ?>


<div id="mobilebgfix">
	<div class="mobile-bg-fix-img-wrap">
		<div class="mobile-bg-fix-img"></div>
	</div>
	<div class="mobile-bg-fix-whole-site">


<header id="home" class="header menu-align-center" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
	
	<div id="main-nav" class="navbar navbar-inverse bs-docs-nav" role="banner">

		<div class="container-fluid">

			<div class="navbar-header responsive-logo">

				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">

				<span class="sr-only"><?php _e('Toggle navigation','zerif-lite'); ?></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				</button>

				<?php

					$zerif_logo = get_theme_mod('zerif_logo');

					if(isset($zerif_logo) && $zerif_logo != ""):           

					    if(is_home() || is_front_page()):
    						echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';
    
    							echo '<img src="'.esc_url( $zerif_logo ).'" alt="'.esc_attr( get_bloginfo('title') ).'">';
    
    						echo '</a>';
                        else:
                            echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';
    
                                echo '<img src="'.get_stylesheet_directory_uri().'/images/logo-page.png" alt="'.esc_attr( get_bloginfo('title') ).'">';
    
                            echo '</a>';
                        endif;
					else:
					
					   if(is_home() || is_front_page()):
					   
    						echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';
    						
    							if( file_exists(get_stylesheet_directory()."/images/logo.png")):
    							
    								echo '<img src="'.get_stylesheet_directory_uri().'/images/logo.png" alt="'.esc_attr( get_bloginfo('title') ).'">';
    							
    							else:
    								
    								echo '<img src="'.get_template_directory_uri().'/images/logo.png" alt="'.esc_attr( get_bloginfo('title') ).'">';
    								
    							endif;
    
    						echo '</a>';
    				    else:
    				        echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand">';
                            
                                if( file_exists(get_stylesheet_directory()."/images/logo-page.png")):
                                
                                    echo '<img src="'.get_stylesheet_directory_uri().'/images/logo-page.png" alt="'.esc_attr( get_bloginfo('title') ).'">';
                                
                                else:
                                    
                                    echo '<img src="'.get_template_directory_uri().'/images/logo-page.png" alt="'.esc_attr( get_bloginfo('title') ).'">';
                                    
                                endif;
    
                            echo '</a>';
    				    endif;

					endif;

				?>

			</div>

			<?php zerif_primary_navigation_trigger(); ?>

		</div>

	</div>
	<!-- / END TOP BAR -->