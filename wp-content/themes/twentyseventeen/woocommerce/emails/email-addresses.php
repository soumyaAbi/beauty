<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
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
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<table id="addresses" cellspacing="0" cellpadding="0" style="width: 49%; vertical-align: top;" border="0">
	<tr>
		<td class="td" style="text-align:left; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" valign="top" width="50%">
			<h3 style="text-align: left; font-family: 'JosefinSans'; font-size: 16px; color: #211f1f; font-weight: 400; text-transform: uppercase;"><?php _e( 'Billing address', 'woocommerce' ); ?></h3>

			<p class="text" style="padding-left: 0px; text-align: left;margin-top:10px;border-top:1px solid #e5e5e5;padding-top:30px;font-family:'HelveticaNeue';"><?php echo $order->get_formatted_billing_address(); ?></p>
		</td>
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && ( $shipping = $order->get_formatted_shipping_address() ) ) : ?>
			<td class="td" style="text-align:left; font-family: 'Helvetica Neue',Helvetica, Roboto, Arial, sans-serif;" valign="top" width="50%">
				<h3><?php _e( 'Shipping address', 'woocommerce' ); ?></h3>

				<p class="text" style="line-height:20px;"><?php echo $shipping; ?></p>
			</td>
		<?php endif; ?>
	</tr>
</table>
