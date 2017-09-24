<?php
/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html dir="<?php echo is_rtl() ? 'rtl' : 'ltr'?>">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
		<style type="text/css">
			@font-face {
			    font-family: "lusitanaBold";
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/LusitanaBold.eot");
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/LusitanaBold.eot") format("embedded-opentype"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/LusitanaBold.woff2") format("woff2"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/LusitanaBold.woff") format("woff"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/LusitanaBold.ttf") format("truetype"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/LusitanaBold.svg#LusitanaBold") format("svg");
			}
			@font-face {
			    font-family: "JosefinSansLight";
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans-Light.eot");
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans-Light.eot?#iefix") format("embedded-opentype"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans-Light.woff2") format("woff2"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans-Light.woff") format("woff"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans-Light.ttf") format("truetype"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans-Light.svg#JosefinSans-Light") format("svg");
			    font-weight: 300;
			    font-style: normal;
			}
			@font-face {
			    font-family: "JosefinSans";
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans.eot");
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans.eot?#iefix") format("embedded-opentype"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans.woff2") format("woff2"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans.woff") format("woff"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans.ttf") format("truetype"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSans.svg#JosefinSans") format("svg");
			    font-weight: normal;
			    font-style: normal;
			}
			@font-face {
			    font-family: "JosefinSansBold";
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSansBold.eot");
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSansBold.eot") format("embedded-opentype"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSansBold.woff2") format("woff2"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSansBold.woff") format("woff"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSansBold.ttf") format("truetype"),
			         url("<?php echo get_template_directory_uri() ; ?>/fonts/JosefinSansBold.svg#JosefinSansBold") format("svg");
			}
			@font-face {
			    font-family: "HelveticaNeue";
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/HelveticaNeue-Thin.eot");
			    src: url("<?php echo get_template_directory_uri() ; ?>/fonts/HelveticaNeue-Thin.eot?#iefix") format("embedded-opentype"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/HelveticaNeue-Thin.woff2") format("woff2"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/HelveticaNeue-Thin.woff") format("woff"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/HelveticaNeue-Thin.ttf") format("truetype"),
			        url("<?php echo get_template_directory_uri() ; ?>/fonts/HelveticaNeue-Thin.svg#HelveticaNeue-Thin") format("svg");
			    font-weight: 100;
			    font-style: normal;
			}
		</style>
	</head>
	<body>
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="700">
		<tr>
            <td align="center" bgcolor="#ffffff">
                <div style = "padding: 40px 0;border-bottom: 2px solid #e5e5e5;margin: 0 15px;" >
                	<?php if ( $img = get_option( 'woocommerce_email_header_image' ) ) { 
                    echo '<img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" width="213" height="34" style="display: block;" />';
                    } ?>
                </div>
            </td>
        </tr>
