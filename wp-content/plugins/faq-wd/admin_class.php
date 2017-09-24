<?php

class faq_admin_class {

    protected static $instance = null;
    public $shortcode_tag = 'faq_wd';
    public $post_type = 'faq_wd';
    public $version = '1.0.30';
    private $FAQWDLangClass = null;

    private function __construct() {
        if (is_admin()) {
            require_once 'lang/SLangClass.php';
            $this->FAQWDLangClass = FAQWDLangClass::get_instance('faq_wd', 'faq-wd');
            add_action('admin_menu', array($this, 'faq_wd_submenu'));
            foreach (array('post.php', 'post-new.php') as $hook) {
                add_action('admin_head-' . $hook, array($this, 'get_shortcode_params'));
            }
            add_action('admin_init', array($this, 'add_faqwd_shortcode'));
            add_action('admin_init', array($this, 'setup_redirect'));
//categories
            add_action('create_faq_category', array($this, 'create_faq_category'));
            add_action('admin_head-edit-tags.php', array($this, 'faqwd_categories_js'));
            add_action('admin_menu', array($this, 'fawd_remove_category_meta_box'));
            add_action('add_meta_boxes', array($this, 'faqwd_add_meta_box'));
            add_action('admin_init', array($this, 'FAQWD_add_category_ordering'));
            add_action('delete_faq_category', array($this, 'delete_faq_category'));
//posts
            add_action('pre_get_posts', array($this, 'FAQWD_get_posts'));
//ajax
            add_action('wp_ajax_faqwd_sotable', array($this, 'faqwd_sotable'));
            add_action('wp_ajax_faqwd_category_sotable', array($this, 'faqwd_category_sotable'));
//scripts
            add_action('admin_enqueue_scripts', array($this, 'include_admin_style'));
            add_action('admin_enqueue_scripts', array($this, 'include_admin_scripts'));
//notices
            add_action('admin_notices', array($this, 'admin_notices'), 10, 1);
            add_action('admin_notices', array($this, 'faqwd_helper_bar'), 10000);
        }
        add_filter('parent_file', array($this, 'faqwd_submenu_parent_file'),11);
    }

    public function faq_wd_submenu() {
        add_submenu_page('edit.php?post_type=faq_wd', 'FAQ Themes', 'Themes', 'manage_options', 'theme', array($this, 'theme_submenu'));
        add_submenu_page('edit.php?post_type=faq_wd', 'Statistics', 'Statistics', 'manage_options', 'faqwd_stats', array($this, 'faq_wd_stats'));
        add_submenu_page('edit.php?post_type=faq_wd', 'Settings', 'Settings', 'manage_options', 'faq_wd_settings', array($this,
            'faq_wd_settings'
        ));

        add_submenu_page('edit.php?post_type=faq_wd', 'Translations', 'Translations', 'manage_options', 'faq_wd_lang_option', array($this->FAQWDLangClass, 'displayLaguageOptions'));
        add_submenu_page('edit.php?post_type=faq_wd', 'Uninstall', 'Uninstall', 'manage_options', 'uninstall_faq_wd', array($this, 'uninstall_faq_wd'));
    }

    public function theme_submenu() {
        include_once('views/admin/theme.php');
    }

    public function faq_wd_stats() {
        $posts = get_posts(array('numberposts' => -1, 'post_type' => 'faq_wd'));
        include_once('views/admin/faq_wd_stats.php');
    }

    public function faq_wd_settings() {
        include_once('views/admin/faq_wd_settings.php');
    }

    public function get_shortcode_params() {
        $cat_ids = get_option('faqwd_categories_order');
        $cat_ids = json_decode($cat_ids);
        ?>
        <script>
            var faq_plugin_url = '<?php echo plugins_url(plugin_basename(dirname(__FILE__))); ?>';
            var categories = new Array();

        <?php
        if ($cat_ids) {
            foreach ($cat_ids as $i => $id) {
                $term = get_term($id, 'faq_category');
                $term_name = str_replace(array("'", '"'), array("\'", '\"'), $term->name);
                ?>
                    categories.push({
                        id: '<?php echo $id; ?>',
                        name: '<?php echo $term_name; ?>'
                    });
                <?php
            }
        }
        ?></script><?php
    }

    public function add_faqwd_shortcode() {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }
        if ('true' == get_user_option('rich_editing')) {
            add_filter('mce_external_plugins', array($this,
                'mce_external_plugins'
            ));
            add_filter('mce_buttons', array($this,
                'mce_buttons'
            ));
        }
    }

    public function mce_external_plugins($plugin_array) {
        $screen = get_current_screen();
        if ($screen->post_type == 'post' || $screen->post_type == 'page') {
            $plugin_array[$this->shortcode_tag] = FAQ_URL . 'js/faqwd-mce-button.js';
        }
        return $plugin_array;
    }

    public function mce_buttons($buttons) {
        array_push($buttons, $this->shortcode_tag);
        return $buttons;
    }

    public function create_faq_category($term_id) {
        $order_ids = get_option('faqwd_categories_order');
        if ($order_ids) {
            $order_ids = json_decode($order_ids, true);
        } else {
            $order_ids = array();
        }
        $order_ids [] = $term_id;
        update_option('faqwd_categories_order', json_encode($order_ids));
    }

    public function faqwd_categories_js() {
        $cat_ids = get_option('faqwd_categories_order');
        $cat_ids = json_decode($cat_ids);
        ?>
        <script>
            var cat_ids = [];
        </script>
        <?php
        if ($cat_ids) {
            foreach ($cat_ids as $id) {
                ?>
                <script>
                    cat_ids.push(<?php echo $id; ?>);
                </script>
                <?php
            }
        }
    }

    public function fawd_remove_category_meta_box() {
        remove_meta_box('tagsdiv-faq_category', 'faq_wd', 'side');
    }

    public function faqwd_add_meta_box() {
        add_meta_box('faq_category_meta_box', 'FAQ Categories', array($this, 'faqwd_category_meta_box'), 'faq_wd', 'advanced', 'default');
    }

    public function FAQWD_add_category_ordering() {
        add_filter('get_terms', array($this, 'FAQWD_category_ordering'), 10, 3);
    }

    public function faqwd_category_meta_box($post) {
        $taxonomy = 'faq_category';
        $tax = get_taxonomy($taxonomy);

        $cat_ids = get_option('faqwd_categories_order');
        $cat_ids = json_decode($cat_ids, true);
        $popular = get_terms($taxonomy, array(
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 5,
            'offset' => 0,
            'hierarchical' => false
        ));



        $post_term_ids = wp_get_post_terms($post->ID, $taxonomy, array('fields' => 'ids'));
        $terms = array();
        if ($cat_ids) {
            foreach ($cat_ids as $i => $id) {
                $terms [$i] = get_term($id, $taxonomy);
                if (in_array($id, $post_term_ids)) {
                    $terms[$i]->checked = "checked";
                } else {
                    $terms[$i]->checked = "";
                }
            }
        }

        if ($popular) {
            foreach ($popular as $t) {
                if (in_array($t->term_id, $post_term_ids)) {
                    $t->checked = "checked";
                } else {
                    $t->checked = "";
                }
            }
        }
        $name = 'tax_input[' . $taxonomy . '][]';
        include_once('views/admin/category_meta_box.php');
    }

    public function FAQWD_category_ordering($terms, $taxonomy, $query_data) {
        $screen = get_current_screen();
        if (!empty($screen) && 'edit-faq_category' == $screen->id && !empty($terms) && isset($terms[0]->taxonomy) && $terms[0]->taxonomy == "faq_category") {
            $cat_ids = get_option('faqwd_categories_order');
            $cat_ids = json_decode($cat_ids, true);
            $new_terms = array();
            if ($cat_ids) {
                $start = $query_data['offset'];
                $end = $query_data['number'] + $query_data['offset'];
                if ($end > count($cat_ids)) {
                    $end = count($cat_ids);
                }
                for ($i = $start; $i < $end; $i++) {
                    $id = $cat_ids[$i];
                    $term = get_term($id, 'faq_category');
                    if ($term == null) {
                        continue;
                    }

                    if (isset($term->errors)) {
                        continue;
                    }

                    $new_terms [] = $term;
                }
            }
            if ($new_terms) {
                $terms = $new_terms;
            }
        }
        return $terms;
    }

    public function delete_faq_category($term_id) {
        $cat_ids = get_option('faqwd_categories_order');
        $cat_ids = json_decode($cat_ids, true);
        foreach ($cat_ids as $i => $id) {
            if ($id == $term_id) {
                unset($cat_ids[$i]);
            }
        }
        $cat_ids = array_values($cat_ids);
        update_option('faqwd_categories_order', json_encode($cat_ids));
    }

    public function faqwd_sotable() {
        if (isset($_POST['order']) && $_POST['order'] != '' && isset($_POST['page']) && intval($_POST['page']) != 0) {
            check_ajax_referer('faqwd_admin_page_nonce', 'security');
            $order = sanitize_text_field($_POST['order']);
            $ids = explode(',', $order);
            $max = count($ids) - 1;
            $page = intval($_POST['page']);

            $post_count_in_page = 20;

            $current_user = wp_get_current_user();
            if ($current_user->data->ID) {
                $meta = get_user_meta($current_user->data->ID, 'edit_faq_wd_per_page', true);
                if ($meta) {
                    $post_count_in_page = $meta;
                }
            }
            $posts_count = wp_count_posts('faq_wd');
            $posts_count = $posts_count->publish;
            foreach ($ids as $i => $id) {
                $id = intval($id);
                if ($id == 0) {
                    break;
                }
                $order = (($page - 1) * $post_count_in_page) + $i;
                $order = $posts_count - $order;
                $order = intval($order);
                update_post_meta($id, 'faqwd_order', $order);
            }
        }
    }

    public function FAQWD_get_posts($wp_query) {
        if (isset($wp_query->query['post_type']) && $wp_query->query['post_type'] == "faq_wd") {
            $wp_query->set('orderby', 'meta_value_num');
            $wp_query->set('meta_key', 'faqwd_order');
            $wp_query->set('order', 'DESC');
        }
    }

    public function faqwd_category_sotable() {
        if (isset($_POST['order']) && $_POST['order'] != '' && isset($_POST['page']) && intval($_POST['page']) != 0) {
            check_ajax_referer('faqwd_admin_page_nonce', 'security');
            $order = sanitize_text_field($_POST['order']);
            $ids = explode(',', $order);
            $opt = get_option('faqwd_categories_order');
            if ($opt == false) {
                $opt = array();
            } else {
                $opt = json_decode($opt, true);
            }

            $page = intval($_POST['page']);
            $post_count_in_page = 20;

            $current_user = wp_get_current_user();
            if ($current_user->data->ID) {
                $meta = get_user_meta($current_user->data->ID, 'edit_faq_category_per_page', true);
                if ($meta) {
                    $post_count_in_page = $meta;
                }
            }
            $start = ($page - 1) * $post_count_in_page;
            $end = $page * $post_count_in_page;

            $j = 0;
            for ($i = $start; $i < $end; $i++) {
                if (!isset($ids[$j])) {
                    break;
                }
                $id = intval($ids[$j]);
                if ($id == 0) {
                    break;
                }
                $opt[$i] = $ids[$j];
                $j ++;
            }
            ksort($opt);
            update_option('faqwd_categories_order', json_encode($opt));
            die;
        }
    }

    public function include_admin_style() {
        $scripts_key = $this->version . '_' . FAQWD_SCRIPTS_KEY;
        wp_register_style('faqwd-admin-style', FAQ_URL . 'css/admin.css', array(), $scripts_key);
        wp_enqueue_style('faqwd-admin-style');
        wp_register_style('faqwd-evol-colorpicker-min', FAQ_URL . 'css/evol.colorpicker.css', array(), $scripts_key);
        wp_enqueue_style('faqwd-evol-colorpicker-min');

        $get_current_screen = get_current_screen();
        if($get_current_screen->base == "faq_wd_page_uninstall_faq_wd") {
            wp_enqueue_style('faqwd_deactivate-css', FAQ_URL . '/wd/assets/css/deactivate_popup.css', array(), $this->version);
        }
    }

    public function include_admin_scripts() {
        $scripts_key = $this->version . '_' . FAQWD_SCRIPTS_KEY;
        wp_enqueue_style('faqwd_shortcode_style', FAQ_URL . 'css/mce-button.css',array(),$scripts_key);
        wp_register_script('faq-wd-script', FAQ_URL . 'js/admin/admin.js', array('jquery',
            'jquery-ui-sortable',
            'jquery-ui-tabs'
                ), $scripts_key, true);
        wp_enqueue_script('faq-wd-script');

        wp_localize_script(
          'faq-wd-script', 'faqwd_admin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'ajaxnonce' => wp_create_nonce('faqwd_admin_page_nonce')
          )
        );

        $get_current_screen = get_current_screen();

        if($get_current_screen->base == "faq_wd_page_uninstall_faq_wd") {
            wp_enqueue_script('faqwd-deactivate-popup', FAQ_URL.'/wd/assets/js/deactivate_popup.js', array(), FAQWD_VERSION, true );
            $admin_data = wp_get_current_user();
//faqwd_deactivate_link
            wp_localize_script( 'faqwd-deactivate-popup', 'faqwdWDDeactivateVars', array(
              "prefix" => "faqwd" ,
              "deactivate_class" => 'faqwd_deactivate_link',
              "email" => $admin_data->data->user_email,
              "plugin_wd_url" => "https://web-dorado.com/products/wordpress-faq-wd.html",
            ));
        }


        wp_enqueue_media();
    }

    public function admin_notices() {
        global $post_id;
        if ($post_id) {
            $notice = get_option('faqwd_notice');
            if (isset($notice[$post_id])) {
                echo '<div class="error">
                        <p>' . __($notice[$post_id], "faqwd") . '</p>
                     </div>';
                unset($notice[$post_id]);
                update_option('faqwd_notice', $notice);
            }
        }
    }

    function faqwd_submenu_parent_file($parent_file) {
        $screen = get_current_screen();
        if ($screen->id == "edit-faq_category" || $screen->post_type == "faqwd_theme") {
            return "edit.php?post_type=faq_wd";
        }
        return $parent_file;
    }

    public function faqwd_helper_bar() {
        $current_screen = get_current_screen();
        if ($current_screen->parent_file != "edit.php?post_type=faq_wd") {
            return;
        }
        $text = $user_guide_link = null;
        switch ($current_screen->id) {
            case "edit-faq_wd":
            case "faq_wd":
                $text = 'This section allows you to create, edit and delete FAQs';
                $user_guide_link = 'https://web-dorado.com/wordpress-faq-wd/adding-question.html';
                break;
            case "edit-faq_category":
                $text = 'This section allows you to create, edit and delete Categories';
                $user_guide_link = 'https://web-dorado.com/wordpress-faq-wd/adding-category.html';
                break;
//            case "edit-faqwd_theme":
//            case "faqwd_theme":
//                $text = 'This section allows you to create, edit and delete Themes';
//                $user_guide_link = 'https://web-dorado.com/wordpress-faq-wd/themes.html';
//                break;
            case "faq_wd_page_faq_wd_settings":
                $text = 'Here You Can Change settings';
                $user_guide_link = 'https://web-dorado.com/wordpress-faq-wd/settings.html';
                break;
        }


        if ($text !== null && $user_guide_link !== null) {
            $this->add_helper_bar($text, $user_guide_link);
        }

    }

    private function add_helper_bar($text, $user_guide_link) {
        $help_text = $text;
        $prefix = "faqwd";
        $pro_link = "https://web-dorado.com/products/wordpress-event-calendar-wd.html";
        $is_free = true;
        $support_forum_link = "https://wordpress.org/support/plugin/faq-wd";
        $support_icon = FAQ_URL . "/images/i_support.png";
        ?>


        <div class="update-nag wd_topic faqwd_topic">
    <span class="wd_help_topic">
      <?php echo sprintf(__('This section allows you to %s.', $prefix), $help_text); ?>
        <a target="_blank" href="<?php echo $user_guide_link; ?>">
        <?php _e('Read More in User Manual', $prefix); ?>
      </a>
    </span>
            <?php
            if ($is_free) {
                $text = strtoupper(__('Upgrade to paid version', $prefix));
                ?>
                <span class="wd_pro">
      <a target="_blank" href="<?php echo $pro_link; ?>">
        <span><?php echo $text; ?></span>
      </a>
    </span>
                <?php
            }
            ?>
            <span class="wd_support">
      <a target="_blank" href="<?php echo $support_forum_link; ?>">
        <img src="<?php echo $support_icon; ?>"/>
          <?php _e('Support Forum', $prefix); ?>
      </a>
    </span>
        </div>

        <?php
    }

    public function uninstall_faq_wd() {
        global $faqwd_freemius_options;
        if (!class_exists("DoradoWebConfig")) {
            include_once(FAQ_DIR . "/wd/config.php");
        }
        if(!class_exists("DoradoWebDeactivate")) {
            include_once(FAQ_DIR . "/wd/includes/deactivate.php");
        }
        $config = new DoradoWebConfig();

        $config->set_options($faqwd_freemius_options);

        $deactivate_reasons = new DoradoWebDeactivate($config);
        $deactivate_reasons->submit_and_deactivate();

        if (isset($_POST['uninstall_faq_wd']) && $_POST['uninstall_faq_wd'] == "yes") {
            check_admin_referer('delete_faq_wd', 'delete_faq_wd_fild');
            $posts = get_posts(array(
              'numberposts' => -1,
              'post_type' => 'faq_wd',
              'post_status' => 'publish,draft,auto-draft'
            ));
            foreach ($posts as $post) {
                wp_delete_post($post->ID);
            }


            $terms = get_terms('faq_category', array(
              'get' => 'all'
            ));
            foreach ($terms as $term) {
                wp_delete_term($term->term_id, 'faq_category');
            }
            delete_option('faqwd_categories_order');
            delete_option('faqwd_notice');
            delete_option('faqwd_voted_ips');
            delete_option('faqwd_upgrade_has_run');
            delete_option('faqwd_settings_general');
            delete_option('faq_category_children');
            delete_option('faqwd_version');
            delete_option('faqwd_scripts_key');
            delete_option('faqwd_do_activation_set_up_redirect');

            delete_option('faqwd_subscribe_done');
            delete_option('faqwd_redirect_to_settings');
            delete_option('faqwd_admin_notice');


            $upload_dir = wp_upload_dir();
            $lang_dir = $upload_dir['basedir'] . '/Languages_WD/faq-wd/';
            if (is_dir($lang_dir)) {
                $files = scandir($lang_dir);
                if ($files) {
                    foreach ($files as $file_name) {
                        if (is_file($lang_dir . $file_name)) {
                            unlink($lang_dir . $file_name);
                        }
                    }
                }
            }


            //$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin=' . FAQ_BASENAME, 'deactivate-plugin_' . FAQ_BASENAME);
            //echo '<br /><a href=' . $deactivate_url . ' > Click Here <a/>To Finish The Uninstallation And FAQ WD Will Be Deactivated Automatically.';
            echo '<p><strong><a href="#" class="faqwd_deactivate_link" data-uninstall="1">' . __("Click Here", "faqwd") . '</a>' . __(" To Finish The Uninstallation And FAQ WD Will Be Deactivated Automatically.", "faqwd") . '</strong></p>';
        } else {
            if (!isset($_POST['faqwd_submit_and_deactivate']) || $_POST['faqwd_submit_and_deactivate'] != '1') {
                include_once('views/admin/uninstall.php');
            }
        }





    }

    public static function global_activate($networkwide)
    {
        if (function_exists('is_multisite') && is_multisite()) {
            // Check if it is a network activation - if so, run the activation function for each blog id.
            if ($networkwide) {
                global $wpdb;
                // Get all blog ids.
                $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                foreach ($blogids as $blog_id) {
                    switch_to_blog($blog_id);
                    self::faq_wd_activate();
                    restore_current_blog();
                }
                return;
            }
        }
        self::faq_wd_activate();
    }


    static function faq_wd_activate() {
        update_option("faqwd_version", FAQWD_VERSION);
        update_option("faqwd_do_activation_set_up_redirect", 1);
    }

    public static function faqwd_freemius(){

        if (!isset($_REQUEST['ajax'])) {

            if (!class_exists("DoradoWeb")) {
                require_once(FAQ_DIR . '/wd/start.php');
            }
            global $faqwd_freemius_options;
            $faqwd_freemius_options = array(
              "prefix" => "faqwd",
              "wd_plugin_id" => 107,
              "plugin_title" => "FAQ WD",
              "plugin_wordpress_slug" => "faq-wd",
              "plugin_dir" => FAQ_DIR,
              "plugin_main_file" => FAQWD_MAIN_FILE,
              "description" => __('Do you need an elegant FAQ section to describe details of your services, terms and conditions? You have a long company history and want to have it in Q&A format? Then FAQ WD will be the most convenient tool for reaching a highly professional result.', 'faqwd'),

              "plugin_features" => array(
                array(
                  "title" => __("Unlimited FAQs", "faqwd"),
                  "description" => "",
                ),
                array(
                  "title" => __("Unlimited categories", "faqwd"),
                  "description" => "",
                ),
                array(
                  "title" => __("Option to expand/collapse FAQs", "faqwd"),
                  "description" => "",
                ),
                array(
                  "title" => __("Responsive design", "faqwd"),
                  "description" => "",
                ),
                array(
                  "title" => __("Compatible with standard WordPress themes", "faqwd"),
                  "description" => "",
                ),
                array(
                  "title" => __("Search option within the FAQs", "faqwd"),
                  "description" => "",
                )
              ),
              "user_guide" => array(
                array(
                  "main_title" => __("Installation Wizard/ Options Menu", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/installing.html",
                  "titles" => array(),
                ),
                array(
                  "main_title" => __("Adding a Question", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/adding-question.html",
                  "titles" => array()
                ),
                array(
                  "main_title" => __("Adding a Category", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/adding-category.html",
                  "titles" => array()
                ),
                array(
                  "main_title" => __("Ordering Categories", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/ordering-categories.html",
                  "titles" => array()
                ),
                array(
                  "main_title" => __("Themes", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/themes.html",
                  "titles" => array(
                    array(
                      "title" => __("General Settings", "faqwd"),
                      "url" => "https://web-dorado.com/wordpress-faq-wd/themes/general-settings.html",
                    ),
                    array(
                      "title" => __("Categories", "faqwd"),
                      "url" => "https://web-dorado.com/wordpress-faq-wd/themes/categories.html",
                    ),
                    array(
                      "title" => __("Question Settings", "faqwd"),
                      "url" => "https://web-dorado.com/wordpress-faq-wd/themes/question-settings.html",
                    ),
                    array(
                      "title" => __("Answer Settings", "faqwd"),
                      "url" => "https://web-dorado.com/wordpress-faq-wd/themes/answer-settings.html",
                    )
                  )
                ),
                array(
                  "main_title" => __("Settings", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/settings.html",
                  "titles" => array()
                ),
                array(
                  "main_title" => __("Inserting FAQs in a Page or Post", "faqwd"),
                  "url" => "https://web-dorado.com/wordpress-faq-wd/publishing-faq.html",
                  "titles" => array()
                )
              ),

//              'overview_welcome_image' => FAQ_URL."/images/icon-FAQ.png",
              "video_youtube_id" => null,  // e.g. https://www.youtube.com/watch?v=acaexefeP7o youtube id is the acaexefeP7o
              "plugin_wd_url" => "https://web-dorado.com/products/wordpress-faq-wd.html",
              "plugin_wd_demo_link" => "http://wpdemo.web-dorado.com/faq-2/",
              "plugin_wd_forum_link" => "https://wordpress.org/support/plugin/faq-wd",
              "plugin_wd_addons_link" => null,
              "after_subscribe" => "edit.php?post_type=faq_wd&page=overview_faqwd", // this can be plagin overview page or set up page
              "plugin_wizard_link" => null,
              "plugin_menu_title" => "FAQ WD", //null
              "plugin_menu_icon" =>FAQ_URL."/images/icon-FAQ.png",
              "deactivate" => true,
              "subscribe" => true,
              "custom_post" => 'edit.php?post_type=faq_wd',
              "menu_position" => "26"
            );

            dorado_web_init($faqwd_freemius_options);

        }
    }
    

    /**
     * Return an instance of this class.
     */
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function setup_redirect() {
        if (get_option('faqwd_do_activation_set_up_redirect')) {
            update_option('faqwd_do_activation_set_up_redirect',0);
            wp_safe_redirect( admin_url( 'edit.php?post_type=faq_wd&page=overview_faqwd' ) );
            exit;
        }
    }

}
