<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
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
 * @version     2.3.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $woocommerce; 
$default_pay = 'full';
if(isset($_REQUEST['cart_pay_type'])) {
	$default_pay = $_REQUEST['cart_pay_type'];
}
$total_pay = $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total + $_SESSION['thrd_deduction'] ;
$action = strtok($_SERVER["REQUEST_URI"],'?');
?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2><?php _e( 'Summary', 'woocommerce' ); ?></h2>
	<form action="<?php echo $action; ?>" method="post" id="cart_total_frm">
		<table cellspacing="0" class="shop_table shop_table_responsive">

			<tr>
				<td colspan="2" class="thrd_cart_options">
					<div>
						<input name="cart_pay_type" value="full" id="cart_full" class="thrd_cart_pay_type" 
						<?php if($default_pay == 'full') { echo 'checked="checked"';} ?> 
						type="radio" />
						<label for="cart_full">Pay full amount</label>
					</div>
					<div>
					<input name="cart_pay_type" value="partial" id="cart_partial" class="thrd_cart_pay_type" 
					<?php if($default_pay == 'partial') { echo 'checked="checked"';} ?>
					type="radio" />
						<label for="cart_full">Pay <?php echo $_SESSION['thrd_down_pay']; ?>%</label>
					</div>				
				</td>
			</tr>
			
			<?php if($default_pay == 'partial') { ?>
			<tr><td colspan="2" class="pre-help-text"> 
			Remaining balance must be paid before we will build your unit.
			</td></tr>
			<?php } ?>	
			
			<tr class="cart-subtotal">
				<th><?php _e( 'Subtotal:', 'woocommerce' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
			</tr>

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
					<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

			<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

				<tr class="shipping">
					<th><?php _e( 'Shipping', 'woocommerce' ); ?></th>
					<td data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
				</tr>

			<?php endif; ?>

			<?php 
				$fee_count = 0;
				$thrd_deduction = $_SESSION['thrd_deduction'] * -1;
				foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<tr class="fee <?php if($fee_count != 0 && $_SESSION['thrd_pay_type'] == 'partial') { ?> thrd-partial<?php } ?>">
					<th><?php echo esc_html( $fee->name ).':'; ?></th>
					<td data-title="<?php echo esc_attr( $fee->name ); ?>"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span><?php echo '($'.$thrd_deduction.')'; ?></span></td>
				</tr>
			<?php 
				$thrd_remain = -1 * $fee->amount; 
				$fee_count++;
			?>
			<?php endforeach; ?>
			<?php 
			$amt = strip_tags(str_replace('&#36;', '', WC()->cart->get_cart_total()));
			$amount = floatval(preg_replace('/[^\d\.]/', '', $amt));
			$pay_amount = $amount + $_SESSION['thrd_deduction'];

			$discount_amount = $amount + $_SESSION['thrd_deduction'] ;
			$down_pay = $discount_amount - ($discount_amount * $_SESSION['thrd_down_pay_percent']);
			$pay_amount = $pay_amount - $down_pay; ?>
			<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
				$taxable_address = WC()->customer->get_taxable_address();
				$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
						? sprintf( ' <small>(' . __( 'estimated for %s', 'woocommerce' ) . ')</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
						: '';

				if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
						<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
							<th><?php echo esc_html( $tax->label ) . $estimated_text; ?></th>
							<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr class="tax-total">
						<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></th>
						<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

			<?php if($_SESSION['thrd_pay_type'] == 'partial') { ?>
			<!-- <tr class="thrd-total thrd-ship-details">
				<td colspan="2"><span class="ship-label"><?php //_e( 'Shipping & Tax:', 'woocommerce' ); ?></span>
				<span class="thrd-ship">See details to the left</span></td>
			</tr> -->
			<tr class="order-total">
				<th><?php _e( 'Order Total:', 'woocommerce' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Order Total', 'woocommerce' ); ?>">
				<strong>
					<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">$</span>
					<?php echo number_format($total_pay); ?></span>
				</strong>	
				</td>
			</tr>
			<tr class="thrd-total thrd-balance-tr">
				<th><?php _e( $_SESSION['thrd_down_pay'].'% down payment:', 'woocommerce' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
			<tr class="thrd-total">
				<th><?php _e( 'Balance remaining:', 'woocommerce' ); ?></th>
				<td>
				<strong>
					<span class="woocommerce-Price-amount amount">
					<span class="woocommerce-Price-currencySymbol">$</span>
					<?php echo number_format($thrd_remain ,0,'.',','); ?></span>
				</strong>
					
				</td>
			</tr>
			<?php } else {  ?>
			<!-- <tr class="thrd-total thrd-ship-details">
				<td colspan="2"><span class="ship-label"><?php //_e( 'Shipping & Tax:', 'woocommerce' ); ?></span>
				<span class="thrd-ship">See details to the left</span></td>
			</tr> -->
			<tr class="order-total">
				<th><?php _e( 'Order Total:', 'woocommerce' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
			</tr>
			<?php } ?>
			<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

		</table>
	</form>	
	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div>
