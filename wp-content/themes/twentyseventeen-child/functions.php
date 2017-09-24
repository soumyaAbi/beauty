<?php

if ( ! session_id() ) {
    session_start();
}

/*
 * Function to remove fonts and scripts of twenty seventeen
 **/
remove_action( 'wp_enqueue_scripts','awts_js_css_files');

function mytheme_dequeue_fonts(){
    wp_dequeue_style( 'twentyseventeen-fonts' );  
    if ( function_exists( 'is_woocommerce' ) ) {

        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_product()) { 
            wp_dequeue_style( 'woocommerce-twenty-seventeen' );
        }
    }

    wp_dequeue_script('twentyseventeen-skip-link-focus-fix');
    wp_dequeue_script('twentyseventeen-navigation');
    wp_dequeue_script('twentyseventeen-global'); 
    wp_dequeue_script('jquery-scrollto');     
}


remove_action( 'wp_footer', 'twentyseventeen_include_svg_icons', 9999 );

add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );

remove_action('wp_enqueue_scripts', 'alobaidi_video_popup_include_css_js');

add_action('wp_footer', 'alobaidi_video_popup_include_css_js', 5);

add_action( 'init' , 'svg_remove_thread' , 15 );

function svg_remove_thread() {
    remove_action( 'wp_footer', 'twentyseventeen_include_svg_icons', 9999 );
}

/*
 * Function to add additional CSS files for the theme
 **/
function my_theme_enqueue_styles() {

    wp_enqueue_style('twentyseventeen_fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), 'v1');


    wp_enqueue_style('twentyseventeen_custom_styles', get_template_directory_uri() . '/css/custom-styles.css', array(), 'v1');
    wp_enqueue_style('twentyseventeen_custom_footer_styles', get_template_directory_uri() . '/css/custom-styles-footer.css', array(), 'v1');

    /* Bootstrap script */
    wp_enqueue_script('twentyseventeen_bootstrap_script', get_template_directory_uri() . '/js/bootstrap.min.js', array("jquery"), '20120206', true);

    
    wp_enqueue_script('twentyseventeen_gen_scripts', get_template_directory_uri() . '/js/custom-scripts.js', array("jquery"), '20120206', true);
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles',15 );


function my_theme_load_bootstrap() {

    wp_enqueue_style('twentyseventeen_bootstrap_style', get_template_directory_uri() . '/css/bootstrap.css');
    
    wp_style_add_data( 'twentyseventeen_bootstrap_style', 'rtl', 'replace' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_load_bootstrap',1 );

/* 
 * FAQ WD - Plugin override starts
 * 
 * */

function add_faq_category_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="faq-category-image-id"><?php _e('Image', 'hero-theme'); ?></label>
     <input type="hidden" id="faq-category-image-id" name="faq-category-image-id" class="custom_media_url" value="">
     <div id="faq-category-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
    </p>
   </div>
 <?php
 }
 
 add_action( 'faq_category_add_form_fields', 'add_faq_category_image' );
 
 add_action( 'admin_footer', 'add_script');
 
 /*
 * Add script
 * @since 1.0.0
 */
 function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
               console.log(attachment);
             if ( _custom_media ) {
               $('#faq-category-image-id').val(attachment.id);
               $('#faq-category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#faq-category-image-wrapper .custom_media_image').attr('src',attachment.sizes.full.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button'); 
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#faq-category-image-id').val('');
       $('#faq-category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-faq-category-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#faq-category-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }

 add_action( 'created_faq_category', 'save_faq_category_image' );
 
 function save_faq_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['faq-category-image-id'] ) && '' !== $_POST['faq-category-image-id'] ){
     $image = $_POST['faq-category-image-id'];
     add_term_meta( $term_id, 'faq-category-image-id', $image, true );
   }
 }

 /*
  * Edit the form field
  * @since 1.0.0
 */
 function update_faq_category_image ( $term ) { ?>
   
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="faq-category-image-id"><?php _e( 'Image', 'hero-theme' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'faq-category-image-id', true ); ?>
       <input type="hidden" id="faq-category-image-id" name="faq-category-image-id" value="<?php echo $image_id; ?>">
       <div id="faq-category-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }

/*
 * Update the form field value
 * @since 1.0.0
 */
function updated_faq_category_image ( $term_id ) {
    if( isset( $_POST['faq-category-image-id'] ) && '' !== $_POST['faq-category-image-id'] ){
        $image = $_POST['faq-category-image-id'];
        update_term_meta ( $term_id, 'faq-category-image-id', $image );
    } else {
        update_term_meta ( $term_id, 'faq-category-image-id', '' );
    }
}
 
add_action( 'faq_category_edit_form_fields', 'update_faq_category_image' );
 
add_action( 'edited_faq_category', 'updated_faq_category_image' );

 /* 
 * FAQ WD - Plugin override ends 
 * */

/*
 * Woocommerce over riding functions start
 * */

/**
 * Ensure variation combinations are working properly - standard limit is 30
 * 
 */

function woo_custom_ajax_variation_threshold( $qty, $product ) {
    return 200;
}       
add_filter( 'woocommerce_ajax_variation_threshold', 'woo_custom_ajax_variation_threshold', 10, 2 );

/* Woocommerce update variations in cart image overriding */
remove_filter( 'woocommerce_cart_item_name', 'WOO_CK_WUVIC_cart_product_title', 20, 3);
function WOO_CK_WUVIC_cart_product_titles( $title, $values, $cart_item_key ) {

    if(get_option( "WOO_CK_WUVIC_edit_link_text" )=="") {
        $WOO_CK_WUVIC_edit_link_text="Edit";
    } else {
        $WOO_CK_WUVIC_edit_link_text=get_option( "WOO_CK_WUVIC_edit_link_text" );
    }

    if(count($values['variation']) && get_option( 'WOO_CK_WUVIC_status' )=="true" ) {
        $targetPath = WUVIC_WOO_UPDATE_CART_ASSESTS_URL.'/img/loader.gif';
        return $title . '<br><span class="WOO_CK_WUVIC_buttom '.get_option( "WOO_CK_WUVIC_edit_link_class" ).'" id="'.$cart_item_key.'" >'.$WOO_CK_WUVIC_edit_link_text.'</span>'.'<img src="'.$targetPath.'" alt="Smiley face" height="42" width="42" id="loder_img" style="display:none;">';
    } else { 
        return $title; 
    }
}

add_filter( 'woocommerce_cart_item_thumbnail', 'WOO_CK_WUVIC_cart_product_titles', 20, 3);

remove_action( $tag, $function_to_remove, $priority ); 

/**
  * Change Proceed To Checkout Text in WooCommerce
  * Place this in your Functions.php file
  **/
function woocommerce_button_proceed_to_checkout() {
    $checkout_url = WC()->cart->get_checkout_url();
?>
    <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
<?php
}

function my_custom_cart_button_text( $text, $product ) {
    if( $product->is_type( 'variable' ) && is_home() ){
        $text = __('Pre-Order', 'woocommerce');
    }
    return $text;
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'my_custom_cart_button_text', 10, 2 );

/*
 * Display Price For Variable Product With Same Variations Prices
 **/ 
add_filter('woocommerce_available_variation', function ($value, $object = null, $variation = null) {
    if ($value['price_html'] == '') {
        $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }
    return $value;
}, 10, 3);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

add_action('woocommerce_cart_calculate_fees', 'woo_add_cart_fee');

function woo_add_cart_fee() {

    global $woocommerce; 

    $discount = 0;
    $discount_full = 750;
    $discount_partial = 250;
    $down_pay_percent = 1 - .10;
    $down_pay = 10;
    if( class_exists('acf') ) {
        $args     = array( 'post_type' => 'product','post_status' => 'publish');
        $products = get_posts( $args );
        $prd_id = $products[0]->ID;
        $discount_full = get_field( "pay_in_full_offer_amount",$prd_id);
        $discount_partial = get_field( "down_payee_preorder_discount",$prd_id);
        $down_pay = get_field( "down_payment_percentage",$prd_id);
        $down_pay_percent = 1 - ($down_pay/100);
    }
    

    if(is_cart()) {

        if(isset($_REQUEST['cart_pay_type']) && $_REQUEST['cart_pay_type'] == 'partial') {
            
            $deduction = -$discount_partial * $woocommerce->cart->cart_contents_count ; 
            $discount = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total + $deduction ) * -$down_pay_percent;         
        } 
        else {
            $deduction = -$discount_full * $woocommerce->cart->cart_contents_count ;    
        }
        $_SESSION['thrd_deduction'] = $deduction;
        $_SESSION['thrd_pay_type'] = $_REQUEST['cart_pay_type'];
        $_SESSION['thrd_discount'] = $discount;
        $_SESSION['thrd_down_pay'] = $down_pay;
        $_SESSION['thrd_down_pay_percent'] = $down_pay_percent;
    } 
    else {
        $deduction = $_SESSION['thrd_deduction'];
        $discount = $_SESSION['thrd_discount'];    
    }
    $woocommerce->cart->add_fee( 'Pre-order discount', $deduction );

    if($_SESSION['thrd_pay_type'] == 'partial') {
        $woocommerce->cart->add_fee( $down_pay.'% due now', $discount );
    }

}

// removes Order Notes Title - Additional Information
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

add_filter( 'woocommerce_billing_fields', 'woo_filter_state_billing', 10, 1 );

function woo_filter_state_billing( $address_fields ) { 
  $address_fields['billing_state']['required'] = false;
    return $address_fields;
}

// Hook in checkout page
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {

    unset($fields['order']['order_comments']);

    unset($fields['billing']['billing_company']);

    $address_fields['billing_postcode']['required'] = false;

    $address_fields['billing_state']['required'] = false;

    $order = array(
        "billing_first_name", 
        "billing_last_name", 
        "billing_phone",
        "billing_email", 
        "billing_address_1", 
        "billing_address_2", 
        "billing_state", 
        "billing_postcode",

    );

    $fields['billing']['billing_phone'] = array(
        'label'     => __('Phone', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-first'),
        'clear'     => false
    );

    $fields['billing']['billing_email'] = array(
        'label'     => __('Email', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-last'),
        'clear'     => true
    );


    $fields['billing']['billing_address_1'] = array(
        'label'     => __('Address', 'woocommerce'),
        'required'  => true,
        'class'     => array('form-row-first'),
        'clear'     => false,
        'placeholder' => __('')
    );

    $fields['billing']['billing_address_2'] = array(
        'label'     => __('Apt/Flr/Bldg', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-last'),
        'clear'     => true,
        'placeholder' => __('')
    );

    $fields['billing']['billing_postcode'] = array(
        'label'     => __('Zip/Postal Code', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row form-row-last'),
        'clear'     => true,
        'placeholder' => __('')
    );

    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["billing"][$field];
    }

    $fields["billing"] = $ordered_fields;

    return $fields;
}

/**
 * change in checkout button text
 */

add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 

function woo_custom_order_button_text() {
    return __( 'Place Your Pre-Order', 'woocommerce' ); 
}

// hook this on priority 31, display below add to cart button.
add_action( 'woocommerce_single_product_summary', 'woocommerce_total_product_variation_price', 31 );
function woocommerce_total_product_variation_price() {
    global $woocommerce, $product;

    if( class_exists('acf') ) {
        $args     = array( 'post_type' => 'product','post_status' => 'publish');
        $products = get_posts( $args );
        $prd_id = $products[0]->ID;
        $discount_full = get_field( "pay_in_full_offer_amount",$prd_id);
        $discount_partial = get_field( "down_payee_preorder_discount",$prd_id);
    }
    else {
        $discount_full = 750; 
        $discount_partial = 250;   
    }
    ?>
    <script>
        jQuery(function($){
            
        var currency = ' <?php echo get_woocommerce_currency_symbol(); ?>';
        var discount_full = '<?php echo $discount_full; ?>';
        var discount_partial = '<?php echo $discount_partial; ?>';

            function priceformat() {
                var thrd_text = jQuery('.woocommerce-Price-amount.amount').html();
                thrd_text = thrd_text.replace(/(<([^>]+)>)/ig,"");
                thrd_text = thrd_text.replace(/[$,]/g, '')
                pay_full = parseFloat(thrd_text) - parseFloat(discount_full);
                pay_partial = parseFloat(thrd_text) - parseFloat(discount_partial);
                jQuery('.pay-full span').html('$' + pay_full);
                jQuery('.pay-partial span').html('$' + pay_partial);
            }

            jQuery('body').on('change','.variations input[type=radio]',function(){
                priceformat();              
            });
            
        });
    </script>
<?php }

/*
 * Function to remove WooCommerce Scripts from unnecessary pages
 **/

add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );

function dequeue_woocommerce_styles_scripts() {
    if ( function_exists( 'is_woocommerce' ) ) {

        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_product()) {
            # Styles
            wp_dequeue_style( 'woocommerce-general' );
            wp_dequeue_style( 'woocommerce-layout' );
            wp_dequeue_style( 'woocommerce-smallscreen' );
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            # Scripts
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
        }
    }
}
/**
 * Function to override styles from woocommerce twnety seventeen theme
 */
if( class_exists('WC_Twenty_Seventeen') ) {
    class WC_Thread_Twenty extends WC_Twenty_Seventeen {
        public function enqueue_styles( $styles ) {
            $styles['woocommerce-twenty-seventeen'] = array(
                'src'     => str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/css/woocommerce.css',
                'deps'    => '',
                'version' => WC_VERSION,
                'media'   => 'all'
            );

            return apply_filters( 'woocommerce_twenty_seventeen_styles', $styles );
        }
    }

    new WC_Thread_Twenty();
}


/**
 * Remove default functionality of yikes-inc-easy-mailchimp-extender
 */

/*function remove_subscription() {
    remove_action('woocommerce_checkout_order_processed', 'subscribe_from_woocommerce_checkout');
}

add_action( 'init', 'remove_subscription', 1 );

if( class_exists( 'Yikes_Easy_MC_WooCommerce_Checkbox_Class' ) ) {

    class Zerif_Yikes_WooCommerce extends Yikes_Easy_MC_WooCommerce_Checkbox_Class {
        public function __construct() {
            
            add_action( 'woocommerce_checkout_order_processed', array( $this, 'subscribe_zerif_woocommerce_checkout' ) );
        }

        /**
        * @param int $order_id
        * @return boolean
        */
        /*public function subscribe_zerif_woocommerce_checkout( $order_id ) {

            $do_optin = get_post_meta( $order_id, 'yikes_easy_mailchimp_optin', true );
            if( $do_optin == '1' ) {
                $order = new WC_Order( $order_id );
                $email = $order->billing_email;
                $merge_vars = array(
                    'NAME' => "{$order->billing_first_name} {$order->billing_last_name}",
                    'FNAME' => $order->billing_first_name,
                    'LNAME' => $order->billing_last_name,
                );
                // subscribe the user
                zerif_subscribe_user_integration( sanitize_email( $email ) , $this->type , $merge_vars );
            }
            return false;
        }
    }

    new Zerif_Yikes_WooCommerce;
}

 /**
 * Hook to submit the data to MailChimp when a new integration type is submitted.
 *
 * @since 6.0.0
 *
 * @param string $email      The email address.
 * @param string $type       The integration type.
 * @param array  $merge_vars The array of form data to send.
 */
/*function zerif_subscribe_user_integration( $email, $type, $merge_vars ) {

    // get checkbox data
    $options = get_option( 'optin-checkbox-init', '' );

    // Make sure we have a list ID.
    if ( ! isset( $options[ $type ] ) || ! isset( $options[ $type ]['associated-list'] ) ) {
        // @todo: Throw some kind of error?
        return;
    }

    // Check for an IP address.
    $user_ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
    if ( isset( $merge_vars['OPTIN_IP'] ) ) {
        $user_ip = sanitize_text_field( $merge_vars['OPTIN_IP'] );
    }

    // Build our data
    $list_id   = $options[ $type ]['associated-list'];
    $interests = isset( $options[ $type ]['interest-groups'] ) ? $options[ $type ]['interest-groups'] : array();
    $id        = md5( $email );
    $data      = array(
        'email_address'    => sanitize_email( $email ),
        'merge_fields'     => apply_filters( 'yikes-mailchimp-checkbox-integration-merge-variables', $merge_vars, $type ),
        'status'    => 'subscribed',
        'timestamp_signup' => (string) current_time( 'timestamp', true ),
        'ip_signup'        => $user_ip,
    );

    // Only re-format and add interest groups if not empty
    if ( ! empty( $interests ) ) {

        $groups = array();

        // Need to reformat interest groups array as $interest_group_ID => true
        foreach( $interests as $interest ) {
            if ( is_array( $interest ) ) {
                foreach( $interest as $group_id ) {
                    $groups[ $group_id ] = true;
                }
            }
        }

        $data['interests'] = $groups;
    }

    // Subscribe the user to the list via the API.
    $response = yikes_get_mc_api_manager()->get_list_handler()->member_subscribe( $list_id, $id, $data );
    if ( is_wp_error( $response ) ) {
        $error_logging = new Yikes_Inc_Easy_Mailchimp_Error_Logging();
        $error_logging->maybe_write_to_log(
            $response->get_error_code(),
            __( "Checkbox Integration Subscribe User", 'yikes-inc-easy-mailchimp-extender' ),
            "Checkbox Integrations"
        );
    }

    return;
}*/

/**
 * Changes in smart variation plugin
 */

/*if( class_exists( 'woocommerce_svi_frontend' ) ) {
    
}*/

/*add_action('wp_print_scripts', 'remove_smart_variation_scripts');

function remove_smart_variation_scripts() {
    if(is_product()) {
        wp_dequeue_script('woosvijs'); 
        wp_register_script('zerif_woosvijs', get_template_directory_uri(). '/js/svi-frontend.min.js', array('jquery'), '', true);
        wp_enqueue_script('zerif_woosvijs', 150, 1);
    }
}
*/

/*add_action('wp','alter_woo_hooks');

function alter_woo_hooks() {
    if(is_product()) {
        //remove_action('woocommerce_before_single_product_summary', array($this, 'show_product_images'), 20);
        //add_action('woocommerce_before_single_product_summary', array($this, 'show_zerif_products'), 20);
    }
}*/

/*function show_zerif_products() {
    require_once(get_template_directory() . '/display.php');    
}*/

/*
 * Woocommerce over riding functions ends
 * */

/*
 * Awesome Team member plugin view override starts
 **/
remove_action('init','register_shortcodes');

add_shortcode('team-members', 'awts_shortcode_member_list');

//shortcode for team-members page
function awts_shortcode_member_list($atts, $content = null) {
    extract(shortcode_atts(array(
        'category' => '',
        ), $atts));
        
        $head_tile='Team Members';
        if($category != ''){
         $head_tile= $category;
        }
        
    
        // return string
    $team_members_output = '';
    $team_members_output = '<div id="id-awts-wrapper" class="awts-wrapper-main">
        <div class="awts-members">'; 
    
            $team_members_output .= '<header class="awts-header">
                    <h1 class="awts-title">'.$head_tile.'</h1>
            </header>';
        

        
        if( $category != ''){
            $args = array(
                'post_type' => 'aw-team-member',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'awts-team-category',
                        'field'    => 'name',
                        'terms'    => $category,
                    )
                ),
                'posts_per_page' => -1,
                
            );
        }else{
            $args = array(
                'post_type' => 'aw-team-member',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            );
        }
        //query_posts( $args );
        $query = new WP_Query( $args );
        
 
        if( $query -> have_posts() ) {
        $team_members_output .= '<ul>';
        while( $query -> have_posts() ) {   
        $query -> the_post();
        
            
            $name = get_the_title();
            $role = get_post_meta( get_the_ID(), 'awts_member_role', true );
            $short_desc = strip_tags(html_entity_decode(get_the_content(), ENT_QUOTES, 'UTF-8')) ;
        
        $team_members_output .= '<li>';
         if( has_post_thumbnail() ){ 
            $team_members_output .= '<div class="mem-image">'.get_the_post_thumbnail(get_the_ID(), 'full') .'</div>';
         }
        
        $team_members_output .= '<div class="mem-short-det">'; 
        $team_members_output .= '<h3>'.$name.'</h3>'; // member name
        $team_members_output .= '<h4>'.$role.'</h4>'; // member role
        $team_members_output .= '<p class="team-desc">'.$short_desc.'</p>'; // member description
         
        
        //$team_members_output .= '<div class="see-more"><a href="javascript:void(0)" onclick="showMemberDeatails('.get_the_ID().')" ><i class="fa fa-plus"></i>See More</a></div>';
        $team_members_output .= '</div>';
        //detailed pop up start
        
        $team_members_output .= '<div style="display:none;" class="cls-member-detail" id="member-detail-pop-'.get_the_ID().'">';
        $team_members_output .= '<div class="cls-member-inner">';
        $team_members_output .= '<div class="close-pop"><a href="javascript:void(0)" onclick="hideMemberDeatails('.get_the_ID().')" >X</a></div>';
            $team_members_output .='<div class="det-left">';
            if( has_post_thumbnail() ){ 
                $team_members_output .= '<div class="mem-image">'.get_the_post_thumbnail(get_the_ID(), 'full') .'</div>';
            }
            
            //social icon start
             $team_members_output .= '<div class="mem-social-icons">';
                if($url_member_linkedin != ''){
                 $team_members_output .='<a href="'.$url_member_linkedin.'" target="_blank" class="mem-linkedin">ln</a>';
                }
                if($url_member_twitter != ''){
                 $team_members_output .='<a href="'.$url_member_twitter.'" target="_blank" class="mem-twitter">tw</a>';
                }
                if($url_member_facebook != ''){
                 $team_members_output .='<a href="'.$url_member_facebook.'" target="_blank" class="mem-facebook">fb</a>';
                }
                if($awts_google_linkedin != ''){
                 $team_members_output .='<a href="'.$awts_google_linkedin.'" target="_blank" class="mem-google">google</a>';
                }
            $team_members_output .='</div>';
            
            $team_members_output .='</div>';
            
            $team_members_output .='<div class="det-right">';
                 $team_members_output .= '<h3>'.$name.'</h3>'; // member name
                 $team_members_output .= '<h4>'.$role.'</h4>'; // member role
                 $team_members_output .= '<div class="team-full-desc">'.get_the_content().'</div>'; // member role
                 //social icon start
            $team_members_output .='</div>';
            $team_members_output .='</div>';
        $team_members_output .='</div>';
        //detailed pop up end
        
        $team_members_output .= '</li>'; 
 
        }
         $team_members_output .= '</ul>';
         
         $team_members_output .= '<div style="display:none;" class="pop-mask"></div>'; //mask
        // endwhile - of the loop
        $team_members_output .= '<div class="clear"></div>';

        }else{  // end if
            $team_members_output .= 'There is no member added yet.';
        }   
        
        wp_reset_postdata(); 
        
        $team_members_output .= '</div>
    </div>';
    
    return $team_members_output;
}   // END function

/*
 * Awesome Team member plugin view override ends
 **/
/*
 * FAQ plugin view override starts
 **/
function remove_faq_scripts() {
 
    wp_dequeue_script('faqwd_front_js'); 
    wp_dequeue_style('faqwd_front_end_style');
    wp_dequeue_style('faqwd_front_end_default_style');
    if(basename(get_permalink()) == 'faqs') {
        wp_register_script('zerif_front_js', get_template_directory_uri(). '/js/faq_wd_front_end.js', array('jquery',
                'jquery-ui-widget'), '1.0.24', true);
        wp_enqueue_script('zerif_front_js');

        wp_register_style('faqwd_front_end_style', get_template_directory_uri() . 'css/front_end_style.css', array(), '1.0.24');
        wp_enqueue_style('faqwd_front_end_style');

        wp_register_style('faqwd_front_end_default_style', get_template_directory_uri() . 'css/default.css', array(), '1.0.24');
        wp_enqueue_style('faqwd_front_end_default_style');
    }
}
 
add_action('wp_enqueue_scripts', 'remove_faq_scripts');

add_action( 'after_setup_theme', 'calling_child_theme_setup' );

function calling_child_theme_setup() {
   
   remove_shortcode( 'faq_wd' );
   include_once(get_template_directory(). "/faq_wd_front.php");
   add_shortcode( 'faq_wd', 'faq_wd_zeif_display' );
}

function faq_wd_zeif_display($atts) {
    global $post;
    $post_id = $post->ID;

    extract(shortcode_atts(array('cat_ids' => 'no',
        'faq_like' => false,
        'faq_hits' => false,
        'faq_user' => false,
        'faq_date' => false,
        'faq_category_numbering' => false,
        'category_show_description' => false,
        'category_show_title' => false,
        'faq_expand_answers' => false,
        'faq_search' => false
                    ), $atts));
    if (isset($cat_ids)) {
        $cat_ids = explode(",", $cat_ids);
    } else {
        $cat_ids = array();
    }

    wp_reset_postdata();
    $args = array('post_id' => $post_id,
        'cat_ids' => $cat_ids,
        'faq_expand_answers' => $faq_expand_answers,
        'category_show_title' => $category_show_title,
        'faq_category_numbering' => $faq_category_numbering,
        'category_show_description' => $category_show_description,
        'faq_user' => $faq_user,
        'faq_date' => $faq_date,
        'faq_like' => $faq_like,
        'faq_hits' => $faq_hits,
        'faq_search' => $faq_search
    );
    $display = new newDisplay($args);
    $html = $display->show();
    return $html;
}

function child_shortcode_function( $atts) {
    $atts = shortcode_atts( array(
        'img'  => '',
        'cat'  => '',
        'capt' => '',
        'link' => ''
    ), $atts );

//YOUR OWN CODE HERE

    $imgSrc = wp_get_attachment_image_src( $atts['img'], 'delicious-gallery' );

    $imgFull = wp_get_attachment_image_src( $atts['img'], 'full' );



    $b = '<div class="screen-item" data-groups=\'["'.strtolower(str_replace(' ', '_', $atts["cat"])).'", "all"]\'>'.

        '<a href="'.$atts["link"].'" data-title="'.$atts["capt"].'" target="_blank"><img src="'.$imgSrc[0].'" alt="SCREEN" class="screenImg" /></a>'.

        '<span>'.$atts["capt"].'</span>'.

    '</div>';

//YOUR OWN CODE HERE

    return $b;
}

/*
 * FAQ plugin view override ends
 **/
/*
 * Rolo slider override starts
 **/
remove_shortcode( 'rolo_slider', array( $this, 'rolo_shortcode' ) );

if( class_exists( 'Rolo_Shortcode' ) ) {

    class Rolo_Shortcode_Zerif extends Rolo_Shortcode {
        function __construct() {
            add_shortcode( 'rolo_slider', array( $this, 'zerif_rolo_shortcode' ) );
            add_action('wp_footer', array($this, 'print_styles') );
        }

        public function zerif_rolo_shortcode( $atts ) {
        /**
          * Call post by name extracting the $name 
          * from the shortcode previously created
          * in custom post column
          */
          extract( shortcode_atts( array(
                 'name'         => ''
            ), $atts )
          );
          
          $args = array('post_type' => 'rolo_slider', 'name' => $name);
          $slides = get_posts( $args );
          $html = '';
          $n = 0;
          $ID = $name;

          foreach( $slides as $slide ) {
            setup_postdata($slide);

            //collect option values 
            $layout = get_post_meta( $slide->ID, '_rl_layout', true );
            $forcew = get_post_meta( $slide->ID, '_rl_force_width', true );
            $iconStyle = get_post_meta( $slide->ID, '_rl_icstyle', true );
            $slide_data = get_post_meta( $slide->ID, '_rl_slide', true );
            $imgCheck = 0;

            $rolo_id = 'rolo_'. $slide->ID. '_'. rand(0,10);
            $wrapper_unique = rand(0,10);

            if( !isset( $layout[0] ) ) $layout[0] = 'default';

            $data = $this->slider_data($slide);
            $css = $this->slider_css($slide->ID, $rolo_id, $wrapper_unique);
            $addon_style = $this->addon_styles($ID, $slide);
            $css .= $addon_style;

            $this->style .= $css; 
            
            $wrapperCls = array('rolo_wrapper', $layout[0]);
            $wrapperCls[] = 'rolo_wrapper'.$wrapper_unique;
            if( '' == $forcew || 'yes' == $forcew ) $wrapperCls[] = 'force-width';
            $wrapperCls = implode( ' ', $wrapperCls );

            $html .= '<div class="'.$wrapperCls.'"><div id="'. $rolo_id .'" class="owl-carousel rolo_slider clearfix '.$iconStyle.'" '.$data.'>';

            /**
            * Check for layout, and then call appropriate markup
            *
            */
            foreach( $slide_data as $key => $value ) {
              $image = $this->value_check( $value,'_rl_screen' );

              $data  = $this->slide_data($value);

              if( 'default' === $layout[0] ) {
                  $img = '<div class="slide-img" style="background-image: url('.$image.')" '.$data.'></div>';

                  $meta = $this->slide_meta_thread($value);

                  // output
                  $html .= '<div class="item">';
                  $html .= $img;
                  $html .= $meta;
                  $html .= '</div>';
              } else if( 'images' === $layout[0] && 0 == $imgCheck ) {
                $images = get_post_meta( $slide->ID, '_rl_responsive', true ); 
                $imgCheck++;

                foreach( (array) $images as $id => $url ) {
                    $alt = get_post_meta( $id, '_wp_attachment_image_alt', true);
                    $html .= '<div class="item">';
                    $html .=  '<img alt="'.$alt.'" class="slide-img" src="'.esc_url($url).'"/>';
                    $html .= '</div>';
                }//foreach()
              }
            }

            $html .= '</div></div>';

          }
          
          return $html;
        }

        /**
         * This function returns slide meta
         *
         * @since 1.0.0
         */
        function slide_meta_thread($value) {

            $thumb_id = $this->value_check( $value,'_rl_screen_id' );
            $heading = $this->value_check( $value,'_rl_title' );
            $subtitle = $this->value_check( $value,'_rl_subtitle' );
            $content = $this->value_check( $value, '_rl_desc' );
            $button1 = $this->value_check( $value,'_rl_button1' );
            $button1url = $this->value_check( $value,'_rl_button_url1' );
            $button2 = $this->value_check( $value,'_rl_button2' );
            $button2url = $this->value_check( $value,'_rl_button_url2' );
            $captions = $this->value_check($value, '_rl_captions');
            $hor_pos = $this->value_check( $value, '_rl_hor_pos' );
            $ver_pos = $this->value_check( $value, '_rl_ver_pos' );
            $pos = $hor_pos . ' ' . $ver_pos;

            $metaClass = array('slider-meta-outer-wrap', $pos, 'has-caption');
            if( $captions ) $metaClass = array_diff($metaClass, array('has-caption'));

            $meta = '';
            $hasMeta = false;

            if($heading || $subtitle || $content || $button1 || $button2) $hasMeta = true;
            if( $hasMeta ) $meta .= "<div class='".implode(' ', $metaClass)."'><div class='slider-meta-wrap'>";
            if($heading) $meta .= "<div class='slide-layer'><h3 class='slider-title'>".$heading.'</h3></div>';
            if($subtitle) $meta .= "<div class='slide-layer'><h4 class='slider-subtitle'>".$subtitle.'</h4></div>';
            if($content) $meta .= "<div class='slide-layer'><p class='slide-desc'>".$content.'</p></div>';
            if($button1 || $button2) $meta .= "<div class='slider-buttons'>";
            if($button1) $meta .= "<div class='vd-wrap'><a href='".$button1url."' class='slider-button slider-button-1 vp-a'>".$button1.'</a></div>';
            if($button2) $meta .= "<a href='".$button2url."' class='slider-button slider-button-1'>".$button2.'</a>';
            if($button1 || $button2) $meta .= "</div>";
            if( $hasMeta ) $meta .= "</div></div>";

            return $meta;
        }
    }

    new Rolo_Shortcode_Zerif();
}
/*
 * Rolo slider override ends
 **/

/*
 * Function to remove shop link from xml sitemap
 **/
function remove_archive_url_sitemap($url){
    if( $url === site_url()."/shop/"){
        return;
    }
    return $url;
}
add_filter('wpseo_sitemap_post_type_archive_link','remove_archive_url_sitemap');

/*
 * Function to remove rss feed
 **/
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

// Add theme support for Custom Logo.
    
add_action( 'after_setup_theme', 'remove_post_formats', 11 ); 

function remove_post_formats() {

    remove_theme_support( 'custom-logo' );
    add_theme_support( 'custom-logo', array(
        'width'       => 294,
        'height'      => 48
    ) );
}

/**
 * Register Extra widgets in child theme
 *
 */
function twentyseventeen_additional_widgets() {

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'twentyseventeen' ),
        'id'            => 'sidebar-4',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 4', 'twentyseventeen' ),
        'id'            => 'sidebar-5',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Bottom Footer', 'twentyseventeen' ),
        'id'            => 'sidebar-6',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'twentyseventeen_additional_widgets' );

/**
 * Function to add class for logo
 *
 */
add_filter( 'get_custom_logo', 'change_logo_class' );

function change_logo_class( $html ) {

    $html = str_replace( 'custom-logo-link', 'navbar-brand', $html );

    return $html;
}

add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/*
 * 
 **/ 

remove_action( 'init', array( 'LazyLoad_Images', 'init' ) );

add_action( 'init', array( 'Lazy_Twenty_Images', 'init' ) );

if ( class_exists( 'LazyLoad_Images' ) ) {

    class Lazy_Twenty_Images extends LazyLoad_Images {

        static function init() {
            if ( is_admin())
                return;

            if($_SERVER['REQUEST_URI'] != '/') {
                return;
            }
               
            if ( ! apply_filters( 'lazyload_is_enabled', true ) ) {
                self::$enabled = false;
                return;
            }

            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_scripts' ) );
            add_action( 'wp_head', array( __CLASS__, 'setup_filters' ), 9999 ); // we don't really want to modify anything in <head> since it's mostly all metadata, e.g. OG tags
        }

       // new Lazy_Twenty_Images();
    }
}

/*
 * To load script asynchronously
 **/
add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );
function wsds_defer_scripts( $tag, $handle, $src ) {

    // The handles of the enqueued scripts we want to defer
    $defer_scripts = array( 
        'owl-carousel',
        'rolo',
        'faqwd_vote_button',
        'twentyseventeen_bootstrap_script',
        'twentyseventeen_gen_scripts',
        'jquery-migrate', 
        'wp-embed',  
        'yikes-easy-mc-ajax',
        'form-submission-helpers',
        'oba_youtubepopup_plugin',
        'oba_youtubepopup_activate',
        'blankshield',
        'itsec-wt-block-tabnapping'
        );

    if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
    }
    
    return $tag;
} 