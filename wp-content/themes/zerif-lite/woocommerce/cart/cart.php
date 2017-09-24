<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 

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
<h1>My Cart</h1>
<h2>Pre-Order today to reserve a spot in our production queue</h2>
<p>Pre-Order units are estimated to ship in 12-18 months</p>
<div class="cart-summary col-sm-9">
	<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" class="col-sm-9">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart" cellspacing="0">
		<thead>
			<tr>	
				<th class="product-thumbnail"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-name"><?php _e( 'Description', 'woocommerce' ); ?></th>
				<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$thrd_data =  get_variation_titles($cart_item); 
					foreach($thrd_data['tbl_head'] as $key => $data) { ?>
						<th class="variation-<?php echo sanitize_html_class( $data['key'] ); ?>"><?php echo wp_kses_post( $data['key'] ); ?></th>
					<?php }
				 	break; 
				 } 
				 ?>
				<?php /*<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>*/?>
				<th class="product-quantity-unit"><?php _e( 'Units', 'woocommerce' ); ?></th>
				<?php /*<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th> */?>
				<th class="product-remove">Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				$prd_url = get_permalink($cart_item['product_id']);

				$thrd_data =  get_variation_titles($cart_item);

				$type = array_key_exists(0, $thrd_data['tbl_attr'])?$thrd_data['tbl_attr'][0]['value']:'';

				$arr_type = explode('(', $type);

				$type = $arr_type[0];

				$colour = array_key_exists(1, $thrd_data['tbl_attr'])?$thrd_data['tbl_attr'][1]['key'].' '.$thrd_data['tbl_attr'][1]['value']:'';

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo $thumbnail;
								} else {
									printf( '%s', $thumbnail );
								}
							?>

						</td>

						<td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
							<?php
								/*if ( ! $product_permalink ) {
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'.$type;
								} else {
									
								}*/

								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;'.$type;

								echo '<span>'.$colour.'</span>';
								if(strtolower($type) == 'solo ') {
									echo '<span>'.get_field('solo_size',$cart_item['product_id']).'</span>';
								} else {
									echo '<span>'.get_field('solo_plus_size',$cart_item['product_id']).'</span>';
								}

								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
								}

								echo $_product->post->post_excerpt;
							?>
						</td>
						<?php 
						// Meta data
						echo WC()->cart->get_item_data( $cart_item );
						/*
						<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>
						*/ ?>

						<td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0'
									), $_product, false );
								}
								echo '<span class="cart-qty">';
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
								echo '</span>';
							?>
							<div class="quantity-nav"><div class="quantity-button quantity-up" id="up">+</div><div class="quantity-button quantity-down" id="down">-</div></div>
						</td>
						<?php /*
						<td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
						<?php */ ?>

						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_cart_contents' );
			?>
			<tr>
				<td colspan="2" class="actions">
					<a href="<?php echo $prd_url; ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to product page</a>
				</td>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">

							<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>			
					<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" style="display: none;" /> 

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

	</form>
	<?php echo html_entity_decode(get_field('shipping_fee_details'), ENT_QUOTES, 'UTF-8'); ?>
</div>

<div class="cart-collaterals col-sm-3">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
