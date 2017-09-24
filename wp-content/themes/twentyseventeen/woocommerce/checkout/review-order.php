<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function get_variation_titles( $cart_item, $flat = false ) {

	$item_data = array();

	$i = 0;
	// Variation data
	if ( ! empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

		foreach ( $cart_item['variation'] as $name => $value ) {

			if ( '' === $value )
				continue;

			$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

			// If this is a term slug, get the term's nice name
			if ( taxonomy_exists( $taxonomy ) ) {
				$term = get_term_by( 'slug', $value, $taxonomy );
				if ( ! is_wp_error( $term ) && $term && $term->name ) {
					$value = $term->name;
				}
				$label = wc_attribute_label( $taxonomy );

			// If this is a custom option slug, get the options name
			} else {
				$value              = apply_filters( 'woocommerce_variation_option_name', $value );
				$product_attributes = $cart_item['data']->get_attributes();
				if ( isset( $product_attributes[ str_replace( 'attribute_', '', $name ) ] ) ) {
					$label = wc_attribute_label( $product_attributes[ str_replace( 'attribute_', '', $name ) ]['name'] );
				} else {
					$label = $name;
				}
			}
			if($i >= 2) {
				$item_data['tbl_head'][] = array(
					'key'   => $label,
					'value' => $value
				);
			}
			else {
				$item_data['tbl_attr'][] = array(
					'key'   => $label,
					'value' => $value
				);		
			}
			$i++;
		}
	}

	// Filter item data to allow 3rd parties to add more to the array
	$item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

	return $item_data ;
}

?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$thrd_data =  get_variation_titles($cart_item); 
				foreach($thrd_data['tbl_head'] as $key => $data) { ?>
					<th class="variation-<?php echo sanitize_html_class( $data['key'] ); ?>"><?php echo wp_kses_post( $data['key'] ); ?></th>
				<?php }
			 	break; 
			 } 
			 ?>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				$thrd_data =  get_variation_titles($cart_item);

				$type = array_key_exists(0, $thrd_data['tbl_attr'])?$thrd_data['tbl_attr'][0]['value']:'';

				$arr_type = explode('(', $type);

				$type = $arr_type[0];

				$colour = array_key_exists(1, $thrd_data['tbl_attr'])?$thrd_data['tbl_attr'][1]['key'].': '.$thrd_data['tbl_attr'][1]['value']:'';

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-name">
							<span class="thrd-review">
							<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'.$type.'<br/>'.$colour; ?>
							</span>
							<span class="thrd-review thrd-review-checkout">
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
							<?php echo WC()->cart->get_item_data( $cart_item ); ?>
							</span>
						</td>
						<td class="product-total">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th colspan="4"><?php _e( 'Subtotal:', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td colspan="4"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php 
		$fee_count = 0;
		$thrd_deduction = $_SESSION['thrd_deduction'] * -1; 
		foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee   <?php if($fee_count != 0 && $_SESSION['thrd_pay_type'] == 'partial') { ?> thrd-partial<?php } ?>">
				<th colspan="4"><?php echo esc_html( $fee->name ).":"; ?></th>
				<td><?php echo '($'.$thrd_deduction.')'; ?></td>
			</tr>
			<?php $thrd_remain = -1 * $fee->amount; 
			$fee_count++; ?>
		<?php endforeach; ?>
		<?php 
		$amt = strip_tags(str_replace('&#36;', '', WC()->cart->get_cart_total()));
		$amount = floatval(preg_replace('/[^\d\.]/', '', $amt));
		$pay_amount = $amount + $_SESSION['thrd_deduction'];

		$discount_amount = $amount + $_SESSION['thrd_deduction'] ;
		$down_pay = $discount_amount - ($discount_amount * $_SESSION['thrd_down_pay_percent']);
		$pay_amount = $pay_amount - $down_pay; ?>
		<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td colspan="4"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th colspan="4"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td <?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php if($_SESSION['thrd_pay_type'] == 'partial') { ?>
			<tr class="order-total">
				<th colspan="4"><?php _e( 'Order Total:', 'woocommerce' ); ?></th>
				<td><strong>
					<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">$</span>
					<?php echo number_format($discount_amount ,0,'.',','); ?></span>
				</strong></td>
			</tr>
			<tr class="thrd-total thrd-balance-tr">
				<th colspan="4"  style="font-weight: bold;"><?php _e( $_SESSION['thrd_down_pay'] .'% down payment:', 'woocommerce' ); ?></th>
				<td><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
			<tr class="thrd-total">
				<th colspan="4"><?php _e( 'Balance remaining:', 'woocommerce' ); ?></th>
				<td>
				<strong>
					<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">$</span>
					<?php echo number_format($thrd_remain ,0,'.',','); ?></span>
				</strong>
					
				</td>
			</tr>
			<?php } else {  ?>
			<tr class="order-total">
				<th colspan="4"><?php _e( 'Order Total:', 'woocommerce' ); ?></th>
				<td><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
			<?php } ?>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
