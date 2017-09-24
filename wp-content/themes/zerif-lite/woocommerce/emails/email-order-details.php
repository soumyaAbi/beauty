<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
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

//do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
<tr>
	<td bgcolor="#ffffff" style = "padding: 30px 0 50px;"">
	<?php if ( ! $sent_to_admin ) : ?>
		<h2 style="text-align: center;  margin-bottom: 0;"><img src="<?php echo get_template_directory_uri(); ?>/images/email_success.png"/ style="vertical-align: middle;"><span style="padding-left: 15px; display: inline-block; font-family: 'lusitanaBold'; font-size: 24px; color:  #525354;font-weight: 500;">Your pre-order has been placed</span></h2>
		<h4 style="text-align: center; margin: 10px 0 30px; font-family: 'JosefinSansBold'; font-size: 14px; color: #7a6f70; font-weight: 500;"><?php printf( __( '#ORDER: %s', 'woocommerce' ), $order->get_order_number() ); ?></h4>
		<p style="text-align: center; max-width: 555px; margin: 0 auto; font-family: 'JosefinSansLight'; line-height: 1.3; font-weight: 300;">We at ThreadRobe thank you! We’ll send you periodic updates about our progress.<br>If you have any inquiries about your pre-order, or wish to modify or cancel your pre-order, please email us at <a style = "color: #00ada8;"href="mailto:preorders@threadrobe.com">preorders@threadrobe.com</a>.</p>
	<?php else : ?>
		<h4 style="text-align: center; margin: 10px 0 30px; font-family: 'JosefinSansBold'; font-size: 14px; color: #7a6f70; font-weight: 500;"><a class="link" href="<?php echo esc_url( admin_url( 'post.php?post=' . $order->id . '&action=edit' ) ); ?>"><?php printf( __( '#ORDER: %s', 'woocommerce'), $order->get_order_number() ); ?></a> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>)</h4>
	<?php endif; ?>
	</td>
</tr>
<tr style="padding-bottom: 10px;">
	<td>
	    <h5 style="text-align: center; font-family: 'JosefinSans'; font-size: 16px; color:  #211f1f;     font-weight: 400;">SUMMARY</h5>
		<table bgcolor="#f6f5f0" width = "700px" style="padding: 20px 10px 10px; margin-bottom: 30px;">
			<thead>
				<tr>
					 <th style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="border-right: 1px solid #e5e5e5;line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400;"><?php _e( 'PRODUCT', 'woocommerce' ); ?></div></th>
					<th style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="border-right: 1px solid #e5e5e5;line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400;"><?php _e( 'DESCRIPTION', 'woocommerce' ); ?></div></th>
					<th style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="border-right: 1px solid #e5e5e5;line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400;"><?php _e( 'QUANTITY', 'woocommerce' ); ?></div></th>
					<th style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400; text-align: right;"><?php _e( 'PRICE', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php echo $order->email_order_items_table( array(
					'show_sku'      => $sent_to_admin,
					'show_image'    => true,
					'image_size'    => array( 32, 32 ),
					'plain_text'    => $plain_text,
					'sent_to_admin' => $sent_to_admin
				) ); ?>
			</tbody>
			<tfoot>
				<?php
					if ( $totals = $order->get_order_item_totals() ) {
						$i = 0;
						$count_tot = count($totals);
						$deduction = -1 * $_SESSION['thrd_deduction'];
						foreach ( $totals as $total ) {		
							if($i ==0 || $i == ($count_tot -1)) { ?>
							<?php if($i == 0 && $_SESSION['thrd_pay_type'] == 'partial') { 
								$amt = strip_tags(str_replace('&#36;', '', $total['value']));
								$amount = floatval(preg_replace('/[^\d\.]/', '', $amt));
								$pay_amount = $amount + $_SESSION['thrd_deduction'];

								$discount_amount = $amount + $_SESSION['thrd_deduction'] ;
								$down_pay = $discount_amount - ($discount_amount * $_SESSION['thrd_down_pay_percent']);
								$pay_amount = $pay_amount - $down_pay;
								
							}
								$tot_text = $i == ($count_tot -1)?'Order Total:':$total['label'];
								$tot_val = ($i == ($count_tot -1) && $_SESSION['thrd_pay_type'] == 'partial')?'$'.number_format($discount_amount,0,'.',','):$total['value'];
							?>	
							<tr>
								<th colspan="3" style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="<?php if($i==0) { ?>border-top: 1px solid #e5e5e5;<?php } ?> border-right: 1px solid #e5e5e5; line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400; text-align: right; padding-right: 4px;"><?php echo $tot_text; ?></div></th>
								<td style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="<?php if($i==0) { ?>border-top: 1px solid #e5e5e5;<?php } ?> line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #7a6f70; font-weight: 400;text-align: right;"><?php echo $tot_val; ?></div></td>
							</tr>
							<?php if($_SESSION['thrd_pay_type'] == 'partial' && $i == ($count_tot -1)) { ?>
							<tr>
								<th colspan="3" style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="border-right: 1px solid #e5e5e5; line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 800; text-align: right; padding-right: 4px"><?php echo $_SESSION['thrd_down_pay']; ?>% down payment:</div></th>
								<td style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 800;text-align: right;"><?php echo '&#36;'. number_format($down_pay,0,'.',','); ?></div></td>
							</tr>
							<tr>
								<th colspan="3" style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="border-right: 1px solid #e5e5e5; line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400; text-align: right; padding-right: 4px">Balance Remaining:</div></th>
								<td style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #7a6f70; font-weight: 400;text-align: right;"><?php echo '&#36;'. number_format($pay_amount,0,'.',','); ?></div></td>
							</tr>
							<?php } 
							 }
							else if($i==1) { ?>
							<tr>
								<th colspan="3" style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="border-right: 1px solid #e5e5e5; line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: #211f1f; font-weight: 400; text-align: right; padding-right: 4px">Pre-order Discount:</div></th>
								<td style="padding-bottom: 10px; border-bottom: 1px solid #e5e5e5;"><div style="line-height: 2;font-family: 'JosefinSans'; font-size: 12px; color: red; font-weight: 400;text-align: right;"><?php echo '($'. number_format($deduction,0,'.',',').')'; ?></div></td>
							</tr>
							<?php 	
							 } ?>
							<?php 
							$i++;
						}

					}
				?>
			</tfoot>
		</table>
	</td>
</tr>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
