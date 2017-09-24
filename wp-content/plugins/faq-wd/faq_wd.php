<?php

/**
 * Plugin Name: FAQ WD
 * Plugin URI: https://web-dorado.com/products/wordpress-faq-wd.html 
 * Description: Do you need an elegant FAQ section to describe details of your services, terms and conditions? You have a long company history and want to have it in Q&A format? Then FAQ WD will be the most convenient tool for reaching a highly professional result. 
 * Version: 1.0.30
 * Author: WebDorado
 * Author URI: https://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
if (!defined('FAQ_DIR') && !defined('FAQ_URL') && !defined('FAQ_BASENAME')) {
    define('FAQ_DIR', dirname(__FILE__));
    define('FAQ_URL', plugin_dir_url(__FILE__));
    define('FAQ_BASENAME', plugin_basename(__FILE__));
    define('FAQWD_MAIN_FILE', __FILE__);
    define('FAQWD_VERSION', '1.0.30');
    require_once('faq_class.php');

    add_action('plugins_loaded', array('faq_class', 'get_instance'));
    register_activation_hook(__FILE__, array('faq_admin_class', 'global_activate'));
    if (is_admin()) {
        require_once('admin_class.php');
        $faq_admin = faq_admin_class::get_instance();
        add_action('plugins_loaded', array('faq_admin_class', 'faqwd_freemius'));
    }
}