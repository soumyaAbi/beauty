<?php
/**
 * Additional Customer Details
 *
 * This is extra customer data which can be filtered by plugins. It outputs below the order item table.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-customer-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<table cellspacing="0" cellpadding="0" style="width: 49%; float: left; vertical-align: top; padding-right:2%;" border="0">
	<tr>
		<td>
			<h2 style="text-align: left; font-family: 'JosefinSans'; font-size: 16px; color:  #211f1f; font-weight: 400; text-transform: uppercase;"><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
			<ul style="padding-left: 0px; text-align: left;margin-top:10px;border-top:1px solid #e5e5e5;padding-top:30px;font-family:'HelveticaNeue';line-height:20px;">
			    <?php foreach ( $fields as $field ) : ?>
			        <li style="list-style: none; margin-left: 0; padding-left: 0px;"><strong><?php echo wp_kses_post( $field['label'] ); ?>:</strong> <span class="text"><?php echo wp_kses_post( $field['value'] ); ?></span></li>
			    <?php endforeach; ?>
			</ul>
		</td>
	</tr>
</table>
