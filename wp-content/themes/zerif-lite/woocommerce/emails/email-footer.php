<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

			       <tr>
                <td>
                	<div style="margin-top: 10px; border-top: 1px solid #e5e5e5; padding-top: 30px; font-family: 'HelveticaNeue'; font-style:normal;font-variant:normal; font-weight:normal; letter-spacing:normal;line-height:normal; text-align:-webkit-auto; text-indent:0px; text-transform:uppercase; white-space:normal; word-spacing:0px;">
                   		<?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
                   	</div>
                </td>
            </tr>
        </table>
    </body>
</html>
