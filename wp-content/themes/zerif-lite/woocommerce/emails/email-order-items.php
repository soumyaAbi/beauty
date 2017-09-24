<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
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
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

foreach ( $items as $item_id => $item ) :
	$_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
	$item_meta    = new WC_Order_Item_Meta( $item, $_product );

	if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		?>
		<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
			<td><div style="border-right: 1px solid #e5e5e5; height: 96px; margin-top: 10px; text-align: center; padding-top: 28px;font-family: 'JosefinSansLight'; font-size: 14px;color: #7a6f70;"><?php // Show title/image etc
				if ( $show_image ) {
					echo apply_filters( 'woocommerce_order_item_thumbnail', '<div style="margin-bottom: 5px"><img src="' . ( $_product->get_image_id() ? current( wp_get_attachment_image_src( $_product->get_image_id(), 'thumbnail') ) : wc_placeholder_img_src() ) .'" alt="' . esc_attr__( 'Product Image', 'woocommerce' ) . '" height="' . esc_attr( $image_size[1] ) . '" width="' . esc_attr( $image_size[0] ) . '" style="vertical-align:middle; margin-right: 10px;" /></div>', $item );
				}
			?></div></td>
			<td><div style="border-right: 1px solid #e5e5e5; height: 115px; padding-top: 9px; margin-top: 10px; padding-left: 10px;font-family: 'JosefinSansLight'; font-size: 14px;color: #7a6f70;"><?php

				// Product name
				echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item, false );

				// SKU
				if ( $show_sku && is_object( $_product ) && $_product->get_sku() ) {
					echo ' (#' . $_product->get_sku() . ')';
				}

				// allow other plugins to add additional product information here
				do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, $plain_text );

				// Variation
				if ( ! empty( $item_meta->meta ) ) {
					echo '<br/><small>' . nl2br( $item_meta->display( true, true, '_', "\n" ) ) . '</small>';
				}

				// File URLs
				if ( $show_download_links ) {
					$order->display_item_downloads( $item );
				}

				// allow other plugins to add additional product information here
				do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, $plain_text );

			?></div></td>
			<td><div style="border-right: 1px solid #e5e5e5; height: 96px; margin-top: 10px; text-align: center; padding-top: 28px;font-family: 'JosefinSansLight'; font-size: 14px;color: #7a6f70;"><?php echo apply_filters( 'woocommerce_email_order_item_quantity', $item['qty'], $item ); ?></div></td>
			<td><div style="height: 96px; margin-top: 10px; text-align: center; padding-top: 28px;font-family: 'JosefinSansLight'; font-size: 14px;color: #7a6f70;"><?php echo $order->get_formatted_line_subtotal( $item ); ?></div></td>
		</tr>
		<?php
	}

	if ( $show_purchase_note && is_object( $_product ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) : ?>
		<tr>
			<td colspan="3" style="text-align:left; vertical-align:middle; border: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>
		</tr>
	<?php endif; ?>

<?php endforeach; ?>
