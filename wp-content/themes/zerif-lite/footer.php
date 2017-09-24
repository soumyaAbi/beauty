<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after
 */

?>
<?php 
if(is_home()) { 
	$signup_form =  '';
	if ( class_exists( 'content_messenger' ) ) {
	    $signup_head = get_option('tutsplus-signup-head');
	    $signup_description = get_option('tutsplus-signup-description');
	    $signup_image = get_option('tutsplus-signup-image');
	    $signup_form = get_option('tutsplus-signup-form');
	} else {
	    $signup_head = 'GET THE LATEST UPDATES';
	    $signup_description = 'Not ready to Pre-Order yet? You can still get all of our latest news, and weigh in on wardrobe and app features. Just enter your email below.';
	    $signup_image = get_stylesheet_directory_uri()."/images/news-right-img.jpg";
	} ?>
    <section class="news-updates" id="news-updates">
        <div class="container">
            <div class="row newsletter-wrap">
                <div class="col-sm-3">
                    <div class="news-block" data-scrollreveal="enter left after 0.15s over 1s">
                        <h2><?php echo $signup_head; ?></h2>
                        <p><?php echo $signup_description; ?></p>
                        <?php if ( class_exists( 'Yikes_Inc_Easy_Mailchimp_Extender_Public' ) ) { 
                        echo do_shortcode( '[yikes-mailchimp form="'.$signup_form.'"]' );
                        } ?>
                    </div>
                    <div class="adj"></div>
                </div>
                <div class="col-sm-9">
                	<img src="<?php echo $signup_image; ?>" alt="cynthia-image" class="meet-threadrobe-img">
                </div>
            </div>
        </div>
    </section>
<?php } ?>
</div><!-- .site-content -->

<?php zerif_before_footer_trigger(); ?>

<footer id="footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

	<div class="container">
    
		<?php zerif_top_footer_trigger(); ?>

		<?php zerif_footer_widgets_trigger(); ?>
		
		<?php zerif_bottom_footer_trigger(); ?>
	</div> <!-- / END CONTAINER -->

</footer> <!-- / END FOOOTER  -->

<?php zerif_after_footer_trigger(); ?>

	</div><!-- mobile-bg-fix-whole-site -->
</div><!-- .mobile-bg-fix-wrap -->


<?php wp_footer(); ?>
<?php /*if(is_home() || is_front_page()) { ?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery(window).load(function(){
        <?php if( !wp_is_mobile()) { ?>
        jQuery(document).on('mousemove', function() {
        <?php } ?>
            if(jQuery('.rolo_wrapper').find('.app-video').length == 0) {
                var baseurl = window.location.origin+window.location.pathname;
                slider_video = baseurl + 'wp-content/themes/zerif-lite/videos/slider.html';
                select_video = baseurl + 'wp-content/themes/zerif-lite/videos/select.html';
                shop_video = baseurl + 'wp-content/themes/zerif-lite/videos/shop.html';
                pack_video = baseurl + 'wp-content/themes/zerif-lite/videos/pack.html';
                stat_video = baseurl + 'wp-content/themes/zerif-lite/videos/stats.html';


                jQuery('.slider-button').after('<div class="slider-video app-video"></div>');       
                jQuery('.slider-video').load(slider_video);

                jQuery("#app-select-video").after('<div class="app-select-video app-video"></div>');
                jQuery('.app-select-video').load(select_video); 

                jQuery("#app-shop-video").after('<div class="app-shop-video app-video"></div>');
                jQuery('.app-shop-video').load(shop_video); 

                jQuery("#app-pack-video").after('<div class="app-pack-video app-video"></div>');
                jQuery('.app-pack-video').load(pack_video); 

                jQuery("#app-stats-video").after('<div class="app-stats-video app-video"></div>');
                jQuery('.app-stats-video').load(stat_video); 
               
            }
        <?php if( !wp_is_mobile()) { ?>
        });
        <?php } ?>
    });
});
</script>
<?php } */ ?>

<?php zerif_bottom_body_trigger(); ?>
</body>

</html>