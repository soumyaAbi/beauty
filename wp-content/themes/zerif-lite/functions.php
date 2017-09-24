<?php

if ( ! session_id() ) {
    session_start();
}
/**
 * Zerif Lite functions and definitions
 */

function zerif_setup() {    
	
    global $content_width;
	
    if (!isset($content_width)) {
        $content_width = 640;
    }

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on zerif, use a find and replace
     * to change 'zerif-lite' to the name of your theme in all the template files
     */
    load_theme_textdomain('zerif-lite', get_template_directory() . '/languages'); 

    add_theme_support('automatic-feed-links');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails', array('post', 'page', 'product'));

    /* Set the image size by cropping the image */
    add_image_size('post-thumbnail', 250, 250, true);
    add_image_size('post-thumbnail-large', 750, 500, true ); /* blog thumbnail */
    add_image_size('post-thumbnail-large-table', 600, 300, true ); /* blog thumbnail for table */
    add_image_size('post-thumbnail-large-mobile', 400, 200, true ); /* blog thumbnail for mobile */
    add_image_size('zerif_project_photo', 285, 214, true);
    add_image_size('zerif_our_team_photo', 174, 174, true);

    /* Register primary menu */
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'zerif-lite'),
    ));

    /* Enable support for Post Formats. */
    add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

    /* Setup the WordPress core custom background feature. */

    if( file_exists(get_stylesheet_directory() . "/images/bg.jpg") ) {
        $zerif_default_image = get_stylesheet_directory_uri() . "/images/bg.jpg";
    } else {
        $zerif_default_image = get_template_directory_uri() . "/images/bg.jpg";
    }
    add_theme_support('custom-background', apply_filters('zerif_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => $zerif_default_image,
    )));

    /* Enable support for HTML5 markup. */
    add_theme_support('html5', array(
        'comment-list',
        'search-form',
        'comment-form',
        'gallery',
    ));
	
	/* Enable support for title-tag */
	add_theme_support( 'title-tag' );

	/* Custom template tags for this theme. */
	require get_template_directory() . '/inc/template-tags.php';

	/* Custom functions that act independently of the theme templates. */
	require get_template_directory() . '/inc/extras.php';

	/* Customizer additions. */
	require get_template_directory() . '/inc/customizer.php';

	/* tgm-plugin-activation */
    require_once get_template_directory() . '/class-tgm-plugin-activation.php';

	/* Customizer upsell. */
	require_once get_template_directory() . '/inc/customize-pro/class-zerif-customize-upsell.php';

    /* woocommerce support */
	add_theme_support( 'woocommerce' );

	/* selective widget refresh */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*******************************************/
    /*************  Welcome screen *************/
    /*******************************************/

	if ( is_admin() ) {

        global $zerif_required_actions;

        /*
         * id - unique id; required
         * title
         * description
         * check - check for plugins (if installed)
         * plugin_slug - the plugin's slug (used for installing the plugin)
         *
         */
        $zerif_required_actions = array(
			array(
                "id" => 'zerif-lite-req-ac-frontpage-latest-news',
                "title" => esc_html__( 'Get the one page template' ,'zerif-lite' ),
                "description"=> esc_html__( 'If you just installed Zerif Lite, and are not able to see the one page template, you need to go to Settings -> Reading , Front page displays and select "Your latest posts".','zerif-lite' ),
				"check" => zerif_lite_is_not_latest_posts()
            )
            /*,
            array(
                "id" => 'zerif-lite-req-ac-install-pirate-forms',
                "title" => esc_html__( 'Install Pirate Forms' ,'zerif-lite' ),
                "description"=> esc_html__( 'In the next updates, Zerif Lite\'s default contact form will be removed. Please make sure you install the Pirate Forms plugin to keep your site updated, and experience a smooth transition to the latest version.','zerif-lite' ),
                "check" => defined("PIRATE_FORMS_VERSION"),
                "plugin_slug" => 'pirate-forms'
            ),
            array(
                "id" => 'zerif-lite-req-ac-check-pirate-forms',
                "title" => esc_html__( 'Check the contact form after installing Pirate Forms' ,'zerif-lite' ),
                "description"=> esc_html__( "After installing the Pirate Forms plugin, please make sure you check your frontpage contact form is working fine. Also, if you use Zerif Lite in other language(s) please make sure the translation is ok. If not, please translate the contact form again.",'zerif-lite' ),
            )*/
        );

		require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
	}

	/***********************************/
	/**************  HOOKS *************/
	/***********************************/

	/* Enables user customization via WordPress plugin API. */
	require get_template_directory() . '/inc/hooks.php';

	add_action( 'zerif_404_title', 'zerif_404_title_function' ); # Outputs the title on 404 pages
	add_action( 'zerif_404_content', 'zerif_404_content_function' ); # Outputs a helpful message on 404 pages

	add_action( 'zerif_page_header', 'zerif_page_header_function' ); # Outputs the title on pages

	add_action( 'zerif_page_header_title_archive', 'zerif_page_header_title_archive_function' ); # Outputs the title on archive pages
	add_action( 'zerif_page_term_description_archive', 'zerif_page_term_description_archive_function' ); # Outputs the term description

	add_action( 'zerif_footer_widgets', 'zerif_footer_widgets_function' ); #Outputs the 3 sidebars in footer

	add_action( 'zerif_our_focus_header_title', 'zerif_our_focus_header_title_function' ); #Outputs the title in Our focus section
	add_action( 'zerif_our_focus_header_subtitle', 'zerif_our_focus_header_subtitle_function' ); #Outputs the subtitle in Our focus section

	add_action( 'zerif_our_team_header_title', 'zerif_our_team_header_title_function' ); #Outputs the title in Our team section
	add_action( 'zerif_our_team_header_subtitle', 'zerif_our_team_header_subtitle_function' ); #Outputs the subtitle in Our team section

	add_action( 'zerif_testimonials_header_title', 'zerif_testimonials_header_title_function' ); #Outputs the title in Testimonials section
	add_action( 'zerif_testimonials_header_subtitle', 'zerif_testimonials_header_subtitle_function' ); #Outputs the subtitle in Testimonials section

	add_action( 'zerif_latest_news_header_title', 'zerif_latest_news_header_title_function' ); #Outputs the title in Latest news section
	add_action( 'zerif_latest_news_header_subtitle', 'zerif_latest_news_header_subtitle_function' ); #Outputs the subtitle in Latest news section

	add_action( 'zerif_small_title_text', 'zerif_small_title_text_function' ); #Outputs the text in Small title section
    add_action( 'zerif_big_title_text', 'zerif_big_title_text_function' ); #Outputs the text in Big title section
    
	add_action( 'zerif_about_us_header_title', 'zerif_about_us_header_title_function' ); #Outputs the title in About us section
	add_action( 'zerif_about_us_header_subtitle', 'zerif_about_us_header_subtitle_function' ); #Outputs the subtitle in About us section

	add_action( 'zerif_sidebar', 'zerif_sidebar_function' ); #Outputs the sidebar

	add_action( 'zerif_primary_navigation', 'zerif_primary_navigation_function' ); #Outputs the navigation menu

    add_filter( 'excerpt_more', 'zerif_excerpt_more' );

}

add_action('after_setup_theme', 'zerif_setup');

function zerif_excerpt_more( $more ) {
    return ' <a href="'.get_the_permalink().'" rel="nofollow"><span class="sr-only">' . esc_html__('Read more about ', 'zerif-lite').get_the_title() . '</span>[...]</a>';
}

function zerif_lite_is_not_latest_posts() {
	return ('posts' == get_option( 'show_on_front' ) ? true : false);
}

/**
 * Register widgetized area and update sidebar with default widgets.
 */

function zerif_widgets_init() {    

	register_sidebar(array(
        'name' => __('Sidebar', 'zerif-lite'),
        'id' => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('About us section', 'zerif-lite'),
        'id' => 'sidebar-aboutus',
        'before_widget' => '<span id="%1$s">',
        'after_widget'  => '</span>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));

    register_sidebars( 
        4, 
        array(
            'name'          => __('Footer area %d','zerif-lite'),
            'id'            => 'zerif-sidebar-footer',
            'before_widget' => '<div class="row bottom-footer-block">',
            'after_widget'  => '</div>',
            'before_title'  => '<h1 class="widget-title">',
            'after_title'   => '</h1>'
        ) 
    );

    register_sidebar(array(
        'name' => __('Bottom Footer', 'zerif-lite'),
        'id' => 'zerif-footer-bottom',
        'before_widget' => '<span id="%1$s">',
        'after_widget'  => '</span>',
        'before_title' => '<h1 class="widget-title">',
        'after_title' => '</h1>',
    ));
    
}

add_action('widgets_init', 'zerif_widgets_init');

function zerif_slug_fonts_url() {
    $fonts_url = '';
     /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $lato = _x( 'on', 'Lato font: on or off', 'zerif-lite' );
    $homemade = _x( 'on', 'Homemade font: on or off', 'zerif-lite' );
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $monserrat = _x( 'on', 'Monserrat font: on or off', 'zerif-lite' );

    $zerif_use_safe_font = get_theme_mod('zerif_use_safe_font');
    
    if ( ( 'off' !== $lato || 'off' !== $monserrat || 'off' !== $homemade ) && isset($zerif_use_safe_font) && ($zerif_use_safe_font != 1) ) {
        $font_families = array();

        if ( 'off' !== $lato ) {
            $font_families[] = 'Lato:300,400,700,400italic';
        }
         if ( 'off' !== $monserrat ) {
            $font_families[] = 'Montserrat:400,700';
        }
        
        if ( 'off' !== $homemade ) {
            $font_families[] = 'Homemade Apple';
        }
         $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
         $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
     return $fonts_url;
}
/**
 * Enqueue scripts and styles.
 */

function zerif_scripts() {    

	wp_enqueue_style('zerif_font', zerif_slug_fonts_url(), array(), null );

    wp_enqueue_style( 'zerif_font_all', '//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600italic,600,700,700italic,800,800italic');
    
    wp_enqueue_style('zerif_bootstrap_style', get_template_directory_uri() . '/css/bootstrap.css');
	
    wp_style_add_data( 'zerif_bootstrap_style', 'rtl', 'replace' );

    wp_enqueue_style('zerif_fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), 'v1');

    wp_enqueue_style('zerif_style', get_stylesheet_uri(), array('zerif_fontawesome'), 'v1');

    wp_enqueue_style('zerif_responsive_style', get_template_directory_uri() . '/css/responsive.css', array('zerif_style'), 'v1');

    wp_enqueue_style('zerif_ie_style', get_template_directory_uri() . '/css/ie.css', array('zerif_style'), 'v1');
    
    wp_style_add_data( 'zerif_ie_style', 'conditional', 'lt IE 9' );
    
    wp_enqueue_style('zerif_custom_styles', get_template_directory_uri() . '/css/custom-styles.css', array('zerif_style'), 'v1');
    wp_enqueue_style('zerif_custom_footer_styles', get_template_directory_uri() . '/css/custom-styles-footer.css', array('zerif_style'), 'v1');

    if ( wp_is_mobile() ){
        
        wp_enqueue_style( 'zerif_style_mobile', get_template_directory_uri() . '/css/style-mobile.css', array('zerif_bootstrap_style', 'zerif_style'),'v1' );
    
    }

    /* Bootstrap script */
    wp_enqueue_script('zerif_bootstrap_script', get_template_directory_uri() . '/js/bootstrap.min.js', array("jquery"), '20120206', true);

    /* Knob script */
    //wp_enqueue_script('zerif_knob_nav', get_template_directory_uri() . '/js/jquery.knob.js', array("jquery"), '20120206', true);
    
    //wp_enqueue_script('zerif_d3_min', get_template_directory_uri() . '/js/d3.min.js', array("jquery"), '20120206', true);
    
    wp_enqueue_script('zerif_gen_scripts', get_template_directory_uri() . '/js/custom-scripts.js', array("jquery"), '20120206', true);
    
    /* Smootscroll script */
    //$zerif_disable_smooth_scroll = get_theme_mod('zerif_disable_smooth_scroll');
    /*if( isset($zerif_disable_smooth_scroll) && ($zerif_disable_smooth_scroll != 1)):
        wp_enqueue_script('zerif_smoothscroll', get_template_directory_uri() . '/js/smoothscroll.js', array("jquery"), '20120206', true);
    endif;*/  
	
	/* scrollReveal script */
	if ( !wp_is_mobile() ){
		wp_enqueue_script( 'zerif_scrollReveal_script', get_template_directory_uri() . '/js/scrollReveal.js', array("jquery"), '20120206', true  );
	}

    /* zerif script */
   // wp_enqueue_script('zerif_script', get_template_directory_uri() . '/js/zerif.js', array("jquery", "zerif_knob_nav"), '20120206', true);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {

        wp_enqueue_script('comment-reply');

    }

    /* HTML5Shiv*/
    wp_enqueue_script( 'zerif_html5', get_template_directory_uri() . '/js/html5.js');
    wp_script_add_data( 'zerif_html5', 'conditional', 'lt IE 9' );

    /* parallax effect */
    /*if ( !wp_is_mobile() ){

        /* include parallax only if on frontpage and the parallax effect is activated */
       /* $zerif_parallax_use = get_theme_mod('zerif_parallax_show');

        if ( !empty($zerif_parallax_use) && ($zerif_parallax_use == 1) && is_front_page() ):

            wp_enqueue_script( 'zerif_parallax', get_template_directory_uri() . '/js/parallax.js', array("jquery"), 'v1', true  );

        endif;
    }*/

	add_editor_style('/css/custom-editor-style.css');
	
}
add_action('wp_enqueue_scripts', 'zerif_scripts');


/**
 * Adjust content width based on template.
 */
function zerif_adjust_content_width() {
    global $content_width;

	$zerif_change_to_full_width = get_theme_mod( 'zerif_change_to_full_width' );
    if ( is_page_template( 'template-fullwidth.php' ) || is_page_template( 'template-fullwidth-no-title.php' ) || is_page_template( 'woocommerce.php' ) || is_page_template( 'single-download.php' ) || ( is_page_template( 'page.php' ) && !empty($zerif_change_to_full_width) ) )
	    $content_width = 1110;

}
add_action( 'template_redirect', 'zerif_adjust_content_width' );


/**
 * Remove Yoast rel="prev/next" link from header
 */
function zerif_remove_yoast_rel_link() {
	return false;
}
add_filter( 'wpseo_prev_rel_link', 'zerif_remove_yoast_rel_link' );
add_filter( 'wpseo_next_rel_link', 'zerif_remove_yoast_rel_link' );

add_action('tgmpa_register', 'zerif_register_required_plugins');

function zerif_register_required_plugins() {	
	
	$wp_version_nr = get_bloginfo('version');
	
	if( $wp_version_nr < 3.9 ):

		$plugins = array(
			array(
				'name' => 'Widget customizer',
				'slug' => 'widget-customizer', 
				'required' => false 
			),
			array(
				'name'      => 'Pirate Forms',
				'slug'      => 'pirate-forms',
				'required'  => false,
			)
		);
		
	else:
	
		$plugins = array(
			array(
				'name'      => 'Pirate Forms',
				'slug'      => 'pirate-forms',
				'required'  => false,
			)
		);
	
	endif;

    $config = array(
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => '',
        'strings' => array(
            'page_title' => __('Install Required Plugins', 'zerif-lite'),
            'menu_title' => __('Install Plugins', 'zerif-lite'),
            'installing' => __('Installing Plugin: %s', 'zerif-lite'),
            'oops' => __('Something went wrong with the plugin API.', 'zerif-lite'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','zerif-lite'),
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','zerif-lite'),
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','zerif-lite'),
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','zerif-lite'),
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','zerif-lite'),
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','zerif-lite'),
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','zerif-lite'),
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','zerif-lite'),
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins','zerif-lite'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins','zerif-lite'),
            'return' => __('Return to Required Plugins Installer', 'zerif-lite'),
            'plugin_activated' => __('Plugin activated successfully.', 'zerif-lite'),
            'complete' => __('All plugins installed and activated successfully. %s', 'zerif-lite'),
            'nag_type' => 'updated'
        )
    );

    tgmpa($plugins, $config);

}

/* Load Jetpack compatibility file. */

require get_template_directory() . '/inc/jetpack.php';

function zerif_wp_page_menu() {    

	echo '<ul class="nav navbar-nav navbar-right responsive-nav main-nav-list">';

		wp_list_pages(array('title_li' => '', 'depth' => 1));

    echo '</ul>';

}

add_filter('the_title', 'zerif_default_title');

function zerif_default_title($title) {    

	if ($title == '')

        $title = __("Default title",'zerif-lite');

    return $title;

}

/*****************************************/
/******          WIDGETS     *************/
/*****************************************/

add_action('widgets_init', 'zerif_register_widgets');

function zerif_register_widgets() {    

	//register_widget('zerif_ourfocus');
    register_widget('zerif_testimonial_widget');
    //register_widget('zerif_clients_widget');
    //register_widget('zerif_team_widget');
	
	
	$zerif_lite_sidebars = array ( 'sidebar-ourfocus' => 'sidebar-ourfocus', 'sidebar-testimonials' => 'sidebar-testimonials', 'sidebar-ourteam' => 'sidebar-ourteam' );
	
	/* Register sidebars */
	foreach ( $zerif_lite_sidebars as $zerif_lite_sidebar ):
		$extra_class = '';
		if( $zerif_lite_sidebar == 'sidebar-ourfocus' ):
		
			$zerif_lite_name = __('Our focus section widgets', 'zerif-lite');
		
		elseif( $zerif_lite_sidebar == 'sidebar-testimonials' ):
			$extra_class = 'feedback-box';
			$zerif_lite_name = __('Testimonials section widgets', 'zerif-lite');
			
		elseif( $zerif_lite_sidebar == 'sidebar-ourteam' ):
		
			$zerif_lite_name = __('Our team section widgets', 'zerif-lite');
			
		else:
		
			$zerif_lite_name = $zerif_lite_sidebar;
			
		endif;
		
        register_sidebar(
            array (
                'name'          => $zerif_lite_name,
                'id'            => $zerif_lite_sidebar,
                'before_widget' => '<span id="%1$s" class="'.$extra_class.'">',
                'after_widget' => '</span>',
            )
        );
		
    endforeach;
	
}

/**
 * Add default widgets
 */
add_action('after_switch_theme', 'zerif_register_default_widgets');
	
function zerif_register_default_widgets() {

	$zerif_lite_sidebars = array ( 'sidebar-ourfocus' => 'sidebar-ourfocus', 'sidebar-testimonials' => 'sidebar-testimonials', 'sidebar-ourteam' => 'sidebar-ourteam' );

	$active_widgets = get_option( 'sidebars_widgets' );	

	/**
     * Default Our Focus widgets
     */
	if ( empty ( $active_widgets[ $zerif_lite_sidebars['sidebar-ourfocus'] ] ) ):

		$zerif_lite_counter = 1;

        /* our focus widget #1 */
		$active_widgets[ 'sidebar-ourfocus' ][0] = 'ctup-ads-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/parallax.png' ) ):
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'PARALLAX EFFECT', 'text' => 'Create memorable pages with smooth parallax effects that everyone loves. Also, use our lightweight content slider offering you smooth and great-looking animations.', 'link' => '#', 'image_uri' => get_stylesheet_directory_uri()."/images/parallax.png" );
        else:
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'PARALLAX EFFECT', 'text' => 'Create memorable pages with smooth parallax effects that everyone loves. Also, use our lightweight content slider offering you smooth and great-looking animations.', 'link' => '#', 'image_uri' => get_template_directory_uri()."/images/parallax.png" );
        endif;
        update_option( 'widget_ctup-ads-widget', $ourfocus_content );
        $zerif_lite_counter++;

        /* our focus widget #2 */
        $active_widgets[ 'sidebar-ourfocus' ][] = 'ctup-ads-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/woo.png' ) ):
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'WOOCOMMERCE', 'text' => 'Build a front page for your WooCommerce store in a matter of minutes. The neat and clean presentation will help your sales and make your store accessible to everyone.', 'link' => '#', 'image_uri' => get_stylesheet_directory_uri()."/images/woo.png" );
        else:
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'WOOCOMMERCE', 'text' => 'Build a front page for your WooCommerce store in a matter of minutes. The neat and clean presentation will help your sales and make your store accessible to everyone.', 'link' => '#', 'image_uri' => get_template_directory_uri()."/images/woo.png" );
        endif;
        update_option( 'widget_ctup-ads-widget', $ourfocus_content );
        $zerif_lite_counter++;

        /* our focus widget #3 */
        $active_widgets[ 'sidebar-ourfocus' ][] = 'ctup-ads-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/ccc.png' ) ):
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'CUSTOM CONTENT BLOCKS', 'text' => 'Showcase your team, products, clients, about info, testimonials, latest posts from the blog, contact form, additional calls to action. Everything translation ready.', 'link' => '#', 'image_uri' => get_stylesheet_directory_uri()."/images/ccc.png" );
        else:
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'CUSTOM CONTENT BLOCKS', 'text' => 'Showcase your team, products, clients, about info, testimonials, latest posts from the blog, contact form, additional calls to action. Everything translation ready.', 'link' => '#', 'image_uri' => get_template_directory_uri()."/images/ccc.png" );
        endif;
        update_option( 'widget_ctup-ads-widget', $ourfocus_content );
        $zerif_lite_counter++;

        /* our focus widget #4 */
        $active_widgets[ 'sidebar-ourfocus' ][] = 'ctup-ads-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/ti-logo.png' ) ):
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'GO PRO FOR MORE FEATURES', 'text' => 'Get new content blocks: pricing table, Google Maps, and more. Change the sections order, display each block exactly where you need it, customize the blocks with whatever colors you wish.', 'link' => '#', 'image_uri' => get_stylesheet_directory_uri()."/images/ti-logo.png" );
        else:
            $ourfocus_content[ $zerif_lite_counter ] = array ( 'title' => 'GO PRO FOR MORE FEATURES', 'text' => 'Get new content blocks: pricing table, Google Maps, and more. Change the sections order, display each block exactly where you need it, customize the blocks with whatever colors you wish.', 'link' => '#', 'image_uri' => get_template_directory_uri()."/images/ti-logo.png" );
        endif;
        update_option( 'widget_ctup-ads-widget', $ourfocus_content );
        $zerif_lite_counter++;

		update_option( 'sidebars_widgets', $active_widgets );
		
    endif;

    /**
     * Default Testimonials widgets
     */
    if ( empty ( $active_widgets[ $zerif_lite_sidebars['sidebar-testimonials'] ] ) ):

        $zerif_lite_counter = 1;

        /* testimonial widget #1 */
        $active_widgets[ 'sidebar-testimonials' ][0] = 'zerif_testim-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/testimonial1.jpg' ) ):
            $testimonial_content[ $zerif_lite_counter ] = array ( 'title' => 'Dana Lorem', 'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec sem vel sapien venenatis mattis non vitae augue. Nullam congue commodo lorem vitae facilisis. Suspendisse malesuada id turpis interdum dictum.', 'image_uri' => get_stylesheet_directory_uri()."/images/testimonial1.jpg" );
        else:
            $testimonial_content[ $zerif_lite_counter ] = array ( 'title' => 'Dana Lorem', 'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec sem vel sapien venenatis mattis non vitae augue. Nullam congue commodo lorem vitae facilisis. Suspendisse malesuada id turpis interdum dictum.', 'image_uri' => get_template_directory_uri()."/images/testimonial1.jpg" );
        endif;
        update_option( 'widget_zerif_testim-widget', $testimonial_content );
        $zerif_lite_counter++;

        /* testimonial widget #2 */
        $active_widgets[ 'sidebar-testimonials' ][] = 'zerif_testim-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/testimonial2.jpg' ) ):
            $testimonial_content[ $zerif_lite_counter ] = array ( 'title' => 'Linda Guthrie', 'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec sem vel sapien venenatis mattis non vitae augue. Nullam congue commodo lorem vitae facilisis. Suspendisse malesuada id turpis interdum dictum.', 'image_uri' => get_stylesheet_directory_uri()."/images/testimonial2.jpg" );
        else:
            $testimonial_content[ $zerif_lite_counter ] = array ( 'title' => 'Linda Guthrie', 'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec sem vel sapien venenatis mattis non vitae augue. Nullam congue commodo lorem vitae facilisis. Suspendisse malesuada id turpis interdum dictum.', 'image_uri' => get_template_directory_uri()."/images/testimonial2.jpg" );
        endif;
        update_option( 'widget_zerif_testim-widget', $testimonial_content );
        $zerif_lite_counter++;

        /* testimonial widget #3 */
        $active_widgets[ 'sidebar-testimonials' ][] = 'zerif_testim-widget-' . $zerif_lite_counter;
        if ( file_exists( get_stylesheet_directory().'/images/testimonial3.jpg' ) ):
            $testimonial_content[ $zerif_lite_counter ] = array ( 'title' => 'Cynthia Henry', 'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec sem vel sapien venenatis mattis non vitae augue. Nullam congue commodo lorem vitae facilisis. Suspendisse malesuada id turpis interdum dictum.', 'image_uri' => get_stylesheet_directory_uri()."/images/testimonial3.jpg" );
        else:
            $testimonial_content[ $zerif_lite_counter ] = array ( 'title' => 'Cynthia Henry', 'text' => 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Curabitur nec sem vel sapien venenatis mattis non vitae augue. Nullam congue commodo lorem vitae facilisis. Suspendisse malesuada id turpis interdum dictum.', 'image_uri' => get_template_directory_uri()."/images/testimonial3.jpg" );
        endif;
        update_option( 'widget_zerif_testim-widget', $testimonial_content );
        $zerif_lite_counter++;

        update_option( 'sidebars_widgets', $active_widgets );

    endif;

    /**
     * Default Our Team widgets
     */
    if ( empty ( $active_widgets[ $zerif_lite_sidebars['sidebar-ourteam'] ] ) ):

        $zerif_lite_counter = 1;

        /* our team widget #1 */
        $active_widgets[ 'sidebar-ourteam' ][0] = 'zerif_team-widget-' . $zerif_lite_counter;
        $ourteam_content[ $zerif_lite_counter ] = array ( 'name' => 'ASHLEY SIMMONS', 'position' => 'Project Manager', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'fb_link' => '#', 'tw_link' => '#', 'bh_link' => '#', 'db_link' => '#', 'ln_link' => '#', 'image_uri' => get_template_directory_uri()."/images/team1.png" );
        update_option( 'widget_zerif_team-widget', $ourteam_content );
        $zerif_lite_counter++;

        /* our team widget #2 */
        $active_widgets[ 'sidebar-ourteam' ][] = 'zerif_team-widget-' . $zerif_lite_counter;
        $ourteam_content[ $zerif_lite_counter ] = array ( 'name' => 'TIMOTHY SPRAY', 'position' => 'Art Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'fb_link' => '#', 'tw_link' => '#', 'bh_link' => '#', 'db_link' => '#', 'ln_link' => '#', 'image_uri' => get_template_directory_uri()."/images/team2.png" );
        update_option( 'widget_zerif_team-widget', $ourteam_content );
        $zerif_lite_counter++;

        /* our team widget #3 */
        $active_widgets[ 'sidebar-ourteam' ][] = 'zerif_team-widget-' . $zerif_lite_counter;
        $ourteam_content[ $zerif_lite_counter ] = array ( 'name' => 'TONYA GARCIA', 'position' => 'Account Manager', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'fb_link' => '#', 'tw_link' => '#', 'bh_link' => '#', 'db_link' => '#', 'ln_link' => '#', 'image_uri' => get_template_directory_uri()."/images/team3.png" );
        update_option( 'widget_zerif_team-widget', $ourteam_content );
        $zerif_lite_counter++;

        /* our team widget #4 */
        $active_widgets[ 'sidebar-ourteam' ][] = 'zerif_team-widget-' . $zerif_lite_counter;
        $ourteam_content[ $zerif_lite_counter ] = array ( 'name' => 'JASON LANE', 'position' => 'Business Development', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus, eros at accumsan auctor, felis eros condimentum quam, non porttitor est urna vel neque', 'fb_link' => '#', 'tw_link' => '#', 'bh_link' => '#', 'db_link' => '#', 'ln_link' => '#', 'image_uri' => get_template_directory_uri()."/images/team4.png" );
        update_option( 'widget_zerif_team-widget', $ourteam_content );
        $zerif_lite_counter++;

        update_option( 'sidebars_widgets', $active_widgets );

    endif;

}

/****************************/
/****** testimonial widget **/
/***************************/

class zerif_testimonial_widget extends WP_Widget {	

	public function __construct() {
		parent::__construct(
			'zerif_testim-widget',
			__( 'Zerif - Testimonial widget', 'zerif-lite' ),
			array (
				'customize_selective_refresh' => true,
			)
		);
		add_action('admin_enqueue_scripts', array($this, 'widget_scripts'));
	}

	function widget_scripts($hook) {
        if( $hook != 'widgets.php' ) 
            return;
	    wp_enqueue_media();
		wp_enqueue_script('zerif_widget_media_script', get_template_directory_uri() . '/js/widget-media.js', false, '1.1', true);
	}

    function widget($args, $instance) {

        extract($args);
		
		$zerif_accessibility = get_theme_mod('zerif_accessibility');
		// open link in a new tab when checkbox "accessibility" is not ticked
		$attribut_new_tab = (isset($zerif_accessibility) && ($zerif_accessibility != 1) ? ' target="_blank"' : '' );

		echo $before_widget;

	    ?>


            <!-- MESSAGE OF THE CLIENT -->

			<?php if( !empty($instance['text']) ): ?>
				<div class="message">
					<?php echo htmlspecialchars_decode(apply_filters('widget_title', $instance['text'])); ?>
				</div>
			<?php endif; ?>

            <!-- CLIENT INFORMATION -->

            <div class="client">

                <div class="quote red-text">

                    <i class="fa fa-quote-left"></i>

                </div>

                <div class="client-info">

					<a <?php echo $attribut_new_tab; ?> class="client-name" <?php if( !empty($instance['link']) ): echo 'href="'.esc_url($instance['link']).'"'; endif; ?>><?php if( !empty($instance['title']) ): echo apply_filters('widget_title', $instance['title'] ); endif; ?></a>
					

					<?php if( !empty($instance['details']) ): ?>
                    <div class="client-company">

                        <?php echo apply_filters('widget_title', $instance['details']); ?>

                    </div>
					<?php endif; ?>

                </div>

                <?php
				
				if( !empty($instance['image_uri']) && ($instance['image_uri'] != 'Upload Image') ) {

					echo '<div class="client-image hidden-xs">';

						echo '<img src="' . esc_url($instance['image_uri']) . '" alt="" />';

					echo '</div>';
					
				} elseif( !empty($instance['custom_media_id']) ) {
			
					$zerif_testimonials_custom_media_id = wp_get_attachment_image_src($instance["custom_media_id"] );
                    $alt = get_post_meta($instance['custom_media_id'], '_wp_attachment_image_alt', true);

					if( !empty($zerif_testimonials_custom_media_id) && !empty($zerif_testimonials_custom_media_id[0]) ) {
						
						echo '<div class="client-image hidden-xs">';

							echo '<img src="' . esc_url($zerif_testimonials_custom_media_id[0]) . '" alt="'. $alt .'" />';

						echo '</div>';
				
					}
				} 

                ?>

            </div>
            <!-- / END CLIENT INFORMATION-->


        <?php

	    echo $after_widget;

    }

    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['text'] = stripslashes(wp_filter_post_kses($new_instance['text']));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['details'] = strip_tags($new_instance['details']);
        $instance['image_uri'] = strip_tags($new_instance['image_uri']);
		$instance['link'] = strip_tags( $new_instance['link'] );
		$instance['custom_media_id'] = strip_tags($new_instance['custom_media_id']);
	    $instance['image_in_customizer'] = strip_tags($new_instance['image_in_customizer']);
        return $instance;

    }

    function form($instance) {
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Author', 'zerif-lite'); ?></label><br/>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php if( !empty($instance['title']) ): echo $instance['title']; endif; ?>" class="widefat">
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Author link','zerif-lite'); ?></label><br />
			<input type="text" name="<?php echo $this->get_field_name('link'); ?>" id="<?php echo $this->get_field_id('link'); ?>" value="<?php if( !empty($instance['link']) ): echo esc_url($instance['link']); endif; ?>" class="widefat">
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('details'); ?>"><?php _e('Author details', 'zerif-lite'); ?></label><br/>
            <input type="text" name="<?php echo $this->get_field_name('details'); ?>" id="<?php echo $this->get_field_id('details'); ?>" value="<?php if( !empty($instance['details']) ): echo $instance['details']; endif; ?>" class="widefat">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text', 'zerif-lite'); ?></label><br/>
            <textarea class="widefat" rows="8" cols="20" name="<?php echo $this->get_field_name('text'); ?>" id="<?php echo $this->get_field_id('text'); ?>"><?php if( !empty($instance['text']) ): echo htmlspecialchars_decode($instance['text']); endif; ?></textarea>
        </p>
	    <p>
		    <label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Image', 'zerif-lite'); ?></label><br/>

		    <?php
		    $image_in_customizer = '';
		    $display = 'none';
		    if( !empty($instance['image_in_customizer']) && !empty($instance['image_uri']) ){
			    $image_in_customizer = esc_url($instance['image_in_customizer']);
			    $display = 'inline-block';
		    } else {
			    if( !empty($instance['image_uri']) ){
				    $image_in_customizer = esc_url($instance['image_uri']);
				    $display = 'inline-block';
			    }
		    }
		    $zerif_image_in_customizer = $this->get_field_name('image_in_customizer');
		    ?>
		    <input type="hidden" class="custom_media_display_in_customizer" name="<?php if(!empty($zerif_image_in_customizer)) { echo $zerif_image_in_customizer; } ?>" value="<?php if( !empty($instance['image_in_customizer']) ): echo $instance['image_in_customizer']; endif; ?>">
		    <img class="custom_media_image" src="<?php echo $image_in_customizer; ?>" style="margin:0;padding:0;max-width:100px;float:left;display:<?php echo $display; ?>" alt="<?php echo __( 'Uploaded image', 'zerif-lite' ); ?>" /><br />

		    <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php if( !empty($instance['image_uri']) ): echo $instance['image_uri']; endif; ?>" style="margin-top:5px;">

		    <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="<?php _e('Upload Image','zerif-lite'); ?>" style="margin-top:5px;">
	    </p>
		
		<input class="custom_media_id" id="<?php echo $this->get_field_id( 'custom_media_id' ); ?>" name="<?php echo $this->get_field_name( 'custom_media_id' ); ?>" type="hidden" value="<?php if( !empty($instance["custom_media_id"]) ): echo $instance["custom_media_id"]; endif; ?>" />

    <?php

    }

}

function zerif_customizer_custom_css() {

    wp_enqueue_style('zerif_customizer_custom_css', get_template_directory_uri() . '/css/zerif_customizer_custom_css.css');

}
add_action('customize_controls_print_styles', 'zerif_customizer_custom_css');


/* Enqueue Google reCAPTCHA scripts */
add_action( 'wp_enqueue_scripts', 'recaptcha_scripts' );

function recaptcha_scripts() {

    if ( is_home() ):
        $zerif_contactus_sitekey = get_theme_mod('zerif_contactus_sitekey');
        $zerif_contactus_secretkey = get_theme_mod('zerif_contactus_secretkey');
        $zerif_contactus_recaptcha_show = get_theme_mod('zerif_contactus_recaptcha_show');
        if( isset($zerif_contactus_recaptcha_show) && $zerif_contactus_recaptcha_show != 1 && !empty($zerif_contactus_sitekey) && !empty($zerif_contactus_secretkey) ) :
            wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js' );
        endif;
    endif;

}

/* remove custom-background from body_class() */
add_filter( 'body_class', 'remove_class_function' );
function remove_class_function( $classes ) {

    if ( !is_home() ) {   
        // index of custom-background
        $key = array_search('custom-background', $classes);
        // remove class
        unset($classes[$key]);
    }
    return $classes;

}

function zerif_lite_themeisle_sdk(){
	require 'vendor/themeisle/load.php';
	themeisle_sdk_register (
		array(
			'product_slug'=>'zerif-lite',
			'store_url'=>'http://themeisle.com',
			'store_name'=>'Themeisle',
			'product_type'=>'theme',
			'wordpress_available'=>false,
			'paid'=>false,
		)
	);
}

zerif_lite_themeisle_sdk(); 

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


/**
  * WooCommerce function to allow only one product in cart
  **/
//add_filter( 'woocommerce_add_to_cart_validation', 'allow_one_product_in_cart' );
  
function allow_one_product_in_cart( $cart_item_data ) {

    global $woocommerce;

    $woocommerce->cart->empty_cart();

    return $cart_item_data;
}

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );          // Remove the description tab
    unset( $tabs['reviews'] );          // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab

    return $tabs;

}

// Display Price For Variable Product With Same Variations Prices
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
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
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
                    <h2 class="awts-title">'.$head_tile.'</h2>
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
    if(basename(get_permalink()) == 'faqs') {
        wp_register_script('zerif_front_js', get_template_directory_uri(). '/js/faq_wd_front_end.js', array('jquery',
                'jquery-ui-widget'), '1.0.24', true);
        wp_enqueue_script('zerif_front_js');
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
function wpb_disable_feed() {
wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
}

add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);

