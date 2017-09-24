<?php
/**
 * Displays footer widgets if assigned
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<?php
if ( is_active_sidebar( 'sidebar-2' ) ||
	 is_active_sidebar( 'sidebar-3' ) ||
	 is_active_sidebar( 'sidebar-4' ) ||
	 is_active_sidebar( 'sidebar-5' ) ) :
?>	
	<div class="col-sm-12">
		<div class="row bottom-footer-block">
		<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div>
	</div>

	<div class="footer-widget-wrap">
		<div class="row">
			<div class="footer-widget col-xs-12 col-sm-6">
				<div class="row bottom-footer-block">
				<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
					<div class="widget-column footer-widget-1">
						<?php dynamic_sidebar( 'sidebar-2' ); ?>
					</div>
				<?php } ?>
				</div><!-- .row -->
			</div>
			<div class="footer-widget col-xs-12 col-sm-3">
				<div class="row bottom-footer-block">
				<?php if ( is_active_sidebar( 'sidebar-3' ) ) { ?>
					<div class="widget-column footer-widget-2">
						<?php dynamic_sidebar( 'sidebar-3' ); ?>
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="footer-widget col-xs-12 col-sm-3">
				<div class="row bottom-footer-block">
				<?php if ( is_active_sidebar( 'sidebar-4' ) ) { ?>
					<div class="widget-column footer-widget-3">
						<?php dynamic_sidebar( 'sidebar-4' ); ?>
					</div>
				<?php } ?>
				</div>
			</div>
			<div class="footer-widget col-xs-12 col-sm-3">
				<div class="row bottom-footer-block">
				<?php if ( is_active_sidebar( 'sidebar-5' ) ) { ?>
					<div class="widget-column footer-widget-4">
						<?php dynamic_sidebar( 'sidebar-5' ); ?>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<?php if ( is_active_sidebar( 'sidebar-6' ) ) { ?>
				<div class="widget-column footer-widget-5">
					<?php dynamic_sidebar( 'sidebar-6' ); ?>
				</div>
			<?php } ?>
		</div>
	</div><!-- .footer-widget-wrap -->
<?php endif; ?>
