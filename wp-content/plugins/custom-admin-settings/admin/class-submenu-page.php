<?php
/**
 * Creates the submenu page for the plugin.
 *
 * @package Custom_Admin_Settings
 */

/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package Custom_Admin_Settings
 */
class Submenu_Page {
    
    public function __construct( $deserializer ) {
        $this->deserializer = $deserializer;
    }

	/**
	 * This function renders the contents of the page associated with the Submenu
	 * that invokes the render method. In the context of this plugin, this is the
	 * Submenu class.
	 */
	public function render() {
        wp_enqueue_style('jquery-ui-tab', plugin_dir_url(__FILE__). 'css/jquery-ui.css', array(), '1.12.1');
         wp_enqueue_style('custom-admin', plugin_dir_url(__FILE__). 'css/custom-admin.css', array(), '1.0');
        if(function_exists( 'wp_enqueue_media' )) {
		    wp_enqueue_media();
		} else {
		    wp_enqueue_style('thickbox');
		    wp_enqueue_script('media-upload');
		    wp_enqueue_script('thickbox');
		    wp_enqueue_script( 'editor' );
		    wp_enqueue_media();
		    add_action( 'admin_head', 'wp_tiny_mce' );
		}
		include_once( 'views/settings.php' );
	}
}
