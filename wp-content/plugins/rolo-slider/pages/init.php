<?php
/*
 Custom dashboard that will be opened on install, or update
*/

class Rolo_Pages {
 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
 
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() { 

		add_action('admin_menu', array( $this,'rolo_register_menu') );
 
	} // end constructor
 
	
	function rolo_register_menu() {
		add_submenu_page( 'edit.php?post_type=rolo_slider', 'About', 'About', 'read', 'about', array( $this,'about') );
		add_submenu_page( 'edit.php?post_type=rolo_slider', 'Addons', 'Addons', 'read', 'addons', array( $this,'addons') );
		add_submenu_page( 'edit.php?post_type=rolo_slider', 'Demo Data', 'Demo Data', 'read', 'demo-data', array( $this,'demo') );
		add_submenu_page( 'edit.php?post_type=rolo_slider', 'Import', 'Import', 'read', 'import', array( $this,'import') );
		add_submenu_page( 'edit.php?post_type=rolo_slider', 'Export', 'Export', 'read', 'export', array( $this,'export') );
	}
	
	function about() {
		include_once( 'dashboard.php'  );
	}

	function addons() {
		include_once( 'addons.php'  );
	}

	function demo() {
		include_once( 'demo-data.php'  );
		new DemoData();
	}

	function import() {
		include_once( 'import-page.php'  );
		new ImportPage();
	}
    
    function export() {
		include_once( 'export-page.php'  );
		new RoloExportPage();
	}
}