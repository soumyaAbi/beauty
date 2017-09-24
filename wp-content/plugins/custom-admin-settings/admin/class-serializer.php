<?php
/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * @package Custom_Admin_Settings
 */
 
/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * This will also check the specified nonce and verify that the current user has
 * permission to save the data.
 *
 * @package Custom_Admin_Settings
 */
class Serializer {
 
    /**
     * Initializes the function by registering the save function with the
     * admin_post hook so that we can save our options to the database.
     */
    public function init() {
        add_action( 'admin_post', array( $this, 'save' ) );
    }
 
    /**
     * Validates the incoming nonce value, verifies the current user has
     * permission to save the value from the options page and saves the
     * option to the database.
     */
    public function save() {
 
        // First, validate the nonce and verify the user as permission to save.
        if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
            // TODO: Display an error message.
        }
        
        // If the above are valid, sanitize and save the option.
        $this->save_homeslider();

        //$this->save_meet_thread();
        
        //$this->save_modernway();
        
        //$this->save_gallery();
        
        //$this->save_puttogether();
        
        //$this->save_twoblocks();
        
        //$this->save_peek_inside();
        
        $this->save_app();

        //$this->save_wardrobe();

        //$this->save_signup();
 
        $this->redirect();
 
    }

    private function save_homeslider() {

        if ( null !== wp_unslash( $_POST['homeslider-name'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['homeslider-name'] ));
            update_option('tutsplus-homeslider-name',$value );
        }  

        if ( null !== wp_unslash( $_POST['site-fav-icon'] ) ) {
            $value = stripslashes_deep(sanitize_text_field($_POST['site-fav-icon'])) ;
            update_option('tutsplus-site-fav-icon',$value );
        } 

        if ( null !== wp_unslash( $_POST['homeslider-video'] ) ) {
            $value = stripslashes_deep($_POST['homeslider-video']) ;
            update_option('tutsplus-homeslider-video',$value );
        } 
    }
    
    private function save_meet_thread() {
        
        if ( null !== wp_unslash( $_POST['meet-thread-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['meet-thread-head'] ));
            update_option('tutsplus-meet-thread-head',$value );
        }
        
        if ( null !== wp_unslash( $_POST['meet-thread-description'] ) ) {
            $value = stripslashes_deep(wp_kses_post( $_POST['meet-thread-description'] )) ;
            update_option('tutsplus-meet-thread-description',$value );
        }
        
        if ( null !== wp_unslash( $_POST['meet-thread-image'] ) ) {
            $value = stripslashes_deep(sanitize_text_field($_POST['meet-thread-image'])) ;
            update_option('tutsplus-meet-thread-image',$value );
        }
    }
    
    private function save_modernway() {
        
        if ( null !== wp_unslash( $_POST['modernway-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['modernway-head'] ));
            update_option('tutsplus-modernway-head',$value );
        }
        
        if ( null !== wp_unslash( $_POST['modernway-description'] ) ) {
            $value = stripslashes_deep(wp_kses_post( $_POST['modernway-description'] )) ;
            update_option('tutsplus-modernway-description',$value );
        }
        
        if ( null !== wp_unslash( $_POST['modernway-image'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['modernway-image'] ));
            update_option('tutsplus-modernway-image',$value );
        }

        if ( null !== wp_unslash( $_POST['modernway-subhead'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['modernway-subhead'] ));
            update_option('tutsplus-modernway-subhead',$value );
        }
        
        if ( null !== wp_unslash( $_POST['modernway-sub-description'] ) ) {
            $value = stripslashes_deep(wp_kses_post( $_POST['modernway-sub-description'] )) ;
            update_option('tutsplus-modernway-sub-description',$value );
        }
    }
    
    private function save_gallery() {
        
        for($i=0; $i<6; $i++) { 
            if ( null !== wp_unslash( $_POST['gallery-image'][$i] ) ) {
                $value = stripslashes_deep(sanitize_text_field( $_POST['gallery-image'][$i] ));
                update_option('tutsplus-gallery-image'.$i,$value );
            }
            
            if ( null !== wp_unslash( $_POST['gallery-heading'][$i] ) ) {
                $value = stripslashes_deep(sanitize_text_field( $_POST['gallery-heading'][$i] ));
                update_option('tutsplus-gallery-heading'.$i,$value );
            }

            if ( null !== wp_unslash( $_POST['gallery-description'][$i] ) ) {
                $value = stripslashes_deep(sanitize_text_field( $_POST['gallery-description'][$i] ));
                update_option('tutsplus-gallery-description'.$i,$value );
            }

            if ( null !== wp_unslash( $_POST['pop-photo'][$i] ) ) {
                $value = stripslashes_deep(sanitize_text_field( $_POST['pop-photo'][$i] ));
                update_option('tutsplus-pop-photo'.$i,$value );
            }

            if ( null !== wp_unslash( $_POST['pop-text'.$i] ) ) {
                $value = stripslashes_deep(wp_kses_post( $_POST['pop-text'.$i]));
                update_option('tutsplus-pop-text'.$i,$value );
            }
        }
    }
    
    private function save_puttogether() {

        if ( null !== wp_unslash( $_POST['put-together-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['put-together-head'] ));
            update_option('tutsplus-put-together-head',$value );
        }
        
        if ( null !== wp_unslash( $_POST['put-together-sub-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['put-together-sub-head'] ));
            update_option('tutsplus-put-together-sub-head',$value );
        }

        if ( null !== wp_unslash( $_POST['put-together-description'] ) ) {
            $value = stripslashes_deep(wp_kses_post( $_POST['put-together-description'] ));
            update_option('tutsplus-put-together-description',$value );
        }

        if ( null !== wp_unslash( $_POST['put-together-image'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['put-together-image'] ));
            update_option('tutsplus-put-together-image',$value );
        }
    }
    
    private function save_twoblocks() {
        
        if ( null !== wp_unslash( $_POST['twoblocks-left-image'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['twoblocks-left-image'] ));
            update_option('tutsplus-twoblocks-left-image',$value );
        }
        
        if ( null !== wp_unslash( $_POST['twoblocks-left-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['twoblocks-left-head'] ));
            update_option('tutsplus-twoblocks-left-head',$value );
        }

        if ( null !== wp_unslash( $_POST['twoblocks-left-description'] ) ) {
            $value = stripslashes_deep(wp_kses_post( $_POST['twoblocks-left-description'] ));
            update_option('tutsplus-twoblocks-left-description',$value );
        }

        if ( null !== wp_unslash( $_POST['twoblocks-right-image'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['twoblocks-right-image'] ));
            update_option('tutsplus-twoblocks-right-image',$value );
        }
        
        if ( null !== wp_unslash( $_POST['twoblocks-right-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['twoblocks-right-head'] ));
            update_option('tutsplus-twoblocks-right-head',$value );
        }

        if ( null !== wp_unslash( $_POST['twoblocks-right-description'] ) ) {
            $value = stripslashes_deep(wp_kses_post( $_POST['twoblocks-right-description'] ));
            update_option('tutsplus-twoblocks-right-description',$value );
        }
    }
    
    private function save_peek_inside() {
        
        if ( null !== wp_unslash( $_POST['peekinside-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['peekinside-head'] ));
            update_option('tutsplus-peekinside-head',$value );
        }

        for($i=0; $i<4; $i++) { 
            if ( null !== wp_unslash( $_POST['peekinside-subhead'][$i] ) ) {
                $value = stripslashes_deep(sanitize_text_field( $_POST['peekinside-subhead'][$i] ));
                update_option('tutsplus-peekinside-subhead'.$i,$value );
            }
            
            if ( null !== wp_unslash( $_POST['peekinside-video-link'.$i] ) ) {
                $value =  stripslashes_deep($_POST['peekinside-video-link'.$i])  ;
                update_option('tutsplus-peekinside-video-link'.$i,$value );
            }
        }
    }
    
    private function save_app() {
        
        /*if ( null !== wp_unslash( $_POST['app-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['app-head'] ));
            update_option('tutsplus-app-head',$value );
        }
        
        if ( null !== wp_unslash( $_POST['app-description'] ) ) {
            $value = stripslashes_deep( esc_textarea( $_POST['app-description'] )) ;
            update_option('tutsplus-app-description',$value );
        }

        if ( null !== wp_unslash( $_POST['app-sub-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['app-sub-head'] ));
            update_option('tutsplus-app-sub-head',$value );
        }*/
        
        for($i=0; $i<4; $i++) {
            /*if ( null !== wp_unslash( $_POST['app-button-text'][$i] ) ) {
                $value = stripslashes_deep(sanitize_text_field( $_POST['app-button-text'][$i] )) ;
                update_option('tutsplus-app-button-text'.$i,$value );
            }*/
            
            if ( null !== wp_unslash( $_POST['app-button-link'.$i] ) ) {
                $value = stripslashes_deep($_POST['app-button-link'.$i]) ;
                update_option('tutsplus-app-button-link'.$i,$value );
            }
        }

    }

    function save_wardrobe() {

        if ( null !== wp_unslash( $_POST['wardrobe-image'] ) ) {
            $value = esc_url_raw( $_POST['wardrobe-image'] ) ;
            update_option('tutsplus-wardrobe-image',$value );
        }    
    }

    function save_signup() {

        if ( null !== wp_unslash( $_POST['signup-form'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['signup-form'] ));
            update_option('tutsplus-signup-form',$value );
        } 

        if ( null !== wp_unslash( $_POST['tutsplus-signup-head'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['tutsplus-signup-head'] ));
            update_option('tutsplus-signup-head',$value );
        }

        if ( null !== wp_unslash( $_POST['signup-description'] ) ) {
            $value = stripslashes_deep(sanitize_text_field( $_POST['signup-description'] ));
            update_option('tutsplus-signup-description',$value );
        }  

        if ( null !== wp_unslash( $_POST['signup-image'] ) ) {
            $value = esc_url_raw( $_POST['signup-image'] ) ;
            update_option('tutsplus-signup-image',$value );
        }  
    }
 
    /**
     * Determines if the nonce variable associated with the options page is set
     * and is valid.
     *
     * @access private
     *
     * @return boolean False if the field isn't set or the nonce value is invalid;
     *                 otherwise, true.
     */
    private function has_valid_nonce() {
 
        // If the field isn't even in the $_POST, then it's invalid.
        if ( ! isset( $_POST['acme-custom-message'] ) ) { // Input var okay.
            return false;
        }
 
        $field  = wp_unslash( $_POST['acme-custom-message'] );
        $action = 'acme-settings-save';
 
        return wp_verify_nonce( $field, $action );
 
    }
 
    /**
     * Redirect to the page from which we came (which should always be the
     * admin page. If the referred isn't set, then we redirect the user to
     * the login page.
     *
     * @access private
     */
    private function redirect() {
 
        // To make the Coding Standards happy, we have to initialize this.
        if ( ! isset( $_POST['_wp_http_referer'] ) ) { // Input var okay.
            $_POST['_wp_http_referer'] = wp_login_url();
        }
 
        // Sanitize the value of the $_POST collection for the Coding Standards.
        $url = sanitize_text_field(
                wp_unslash( $_POST['_wp_http_referer'] ) // Input var okay.
        );
 
        // Finally, redirect back to the admin page.
        wp_safe_redirect( urldecode( $url ) );
        exit;
 
    }
}