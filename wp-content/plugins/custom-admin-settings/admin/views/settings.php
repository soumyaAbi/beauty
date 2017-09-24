<div class="wrap">
 
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
 
    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
 
        <div id="tabs" class="form-wrap">
            <ul>
                <li><a href="#homeslider">Header and Banner</a></li>
                <?php /*
                <li><a href="#meet-thread">Meet ThreadRobe</a></li>
                <li><a href="#modern-way">Modern Way</a></li>
                <li><a href="#image-gallery">Image Gallery</a></li>
                <li><a href="#put-together">Put it all together</a></li>
                <li><a href="#two-blocks">Two Blocks</a></li>
                <li><a href="#peek-inside">Take a peek inside</a></li>
                <?php */ ?>
                <li><a href="#app">App Section</a></li>
                <?php /*
                <li><a href="#wardrobe">Wardrobe Options</a></li>
                <li><a href="#signup">Signup Form</a></li>
                <?php */ ?>
            </ul>            
            <div id="homeslider"> 
                <div class="form-field form-required">
                    <label for="site-fav-icon">Site Fav Icon</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-site-fav-icon' ) ); ?>" height="16" width="16"/>
                    <input name="site-fav-icon" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-site-fav-icon' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image 16 X 16px</a>
                </div>
                <div class="form-field form-required">
                    <label for="homeslider-name">Home Slider Name</label>
                    <input name="homeslider-name"  
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-homeslider-name' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="homeslider-video">Home Slider Video</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-homeslider-video' ) ) , 'homeslider-video', $settings = array('homeslider-video'=>'homeslider-video') ); ?>
                </div>
            </div>
            <?php /*
            <div id="meet-thread">
                <div class="form-field form-required">
                    <label for="meet-thread-image">Meet Threadrobe Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-meet-thread-image' ) ); ?>" height="100" width="100"/>
                    <input name="meet-thread-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-meet-thread-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div> 
                <div class="form-field form-required">
                    <label for="meet-thread-head">Meet Threadrobe Heading</label>
                    <input name="meet-thread-head"   
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-meet-thread-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>                
                <div class="form-field form-required">
                    <label for="meet-thread-description">Meet Threadrobe Description</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-meet-thread-description' ) ) , 'meet-thread-description', $settings = array('meet-thread-description'=>'meet-thread-description') ); ?>
                </div>    
            </div>
            <div id="modern-way"> 
                 <div class="form-field form-required">
                    <label for="modernway-head">Modern Way Main Heading</label>
                    <input name="modernway-head" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-modernway-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>  
                
                <div class="form-field form-required">
                    <label for="modernway-description">Modern Way Main Description</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-modernway-description' ) ) , 'modernway-description', $settings = array('modernway-description'=>'modernway-description') ); ?>
                </div>
                 <div class="form-field form-required">
                    <label for="modernway-image">Modern Way Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-modernway-image' ) ); ?>" height="100" width="100"/>
                    <input name="modernway-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-modernway-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div>  
                <div class="form-field form-required">
                    <label for="modernway-sub-description">Modern Way Sub Description</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-modernway-sub-description' ) ) , 'modernway-sub-description', $settings = array('modernway-sub-description'=>'modernway-sub-description') ); ?>
                </div>
                <div class="form-field form-required">
                    <label for="modernway-subhead">Modern Way Sub Heading</label>
                    <input name="modernway-subhead"  
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-modernway-subhead' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>  
            </div>
            <div id="image-gallery"> 
                <?php for($i=0; $i<6; $i++) { ?>
                <div class="form-field form-required">
                    <label for="gallery-image[]">Gallery Image <?php echo $i+1; ?></label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-gallery-image'.$i ) ); ?>" height="100" width="100"/>
                    <input name="gallery-image[]" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-gallery-image'.$i ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div>
                <div class="form-field form-required">
                    <label for="gallery-heading[]">Gallery heading <?php echo $i+1; ?></label>
                    <input name="gallery-heading[]"
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-gallery-heading'.$i ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="gallery-description[]">Gallery description <?php echo $i+1; ?></label>
                    <input name="gallery-description[]"
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-gallery-description'.$i ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label>Pop Photo <?php echo $i+1; ?></label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-pop-photo'.$i ) ); ?>" height="100" width="100"/>
                    <input name="pop-photo[]" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-pop-photo'.$i ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div>
                <div class="form-field form-required border-btm">
                    <label>Pop Text</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-pop-text'.$i ) ) , "pop-text".$i, $settings = array("pop-text[$i]"=>"pop-text[$i]") ); ?>
                </div>
                <?php } ?>
            </div>
            <div id="put-together"> 
                <div class="form-field form-required">
                    <label for="put-together-head">Put together Main Heading</label>
                    <input name="put-together-head"  
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-put-together-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="put-together-sub-head">Put together Sub Heading</label>
                    <input name="put-together-sub-head" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-put-together-sub-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="put-together-description">Put together Description</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-put-together-description' ) ) , 'put-together-description', $settings = array('put-together-description'=>'put-together-description') ); ?>
                </div>
                <div class="form-field form-required">
                    <label for="mput-together-image">Put together Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-put-together-image' ) ); ?>" height="200" width="200"/>
                    <input name="put-together-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-put-together-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div>
            </div>
            <div id="two-blocks">
                <div class="form-field form-required">
                    <label for="twoblocks-left-image">Left Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-left-image' ) ); ?>" height="100" width="100"/>
                    <input name="twoblocks-left-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-left-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div> 
                <div class="form-field form-required">
                    <label for="twoblocks-left-head">Left Heading</label>
                    <input name="twoblocks-left-head"  
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-left-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="twoblocks-left-description">Left Description</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-left-description' ) ) , 'twoblocks-left-description', $settings = array('twoblocks-left-description'=>'twoblocks-left-description') ); ?>
                </div>
                <div class="form-field form-required">
                    <label for="twoblocks-right-image">Right Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-right-image' ) ); ?>" height="100" width="100"/>
                    <input name="twoblocks-right-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-right-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div> 
                <div class="form-field form-required">
                    <label for="twoblocks-right-head">Right Heading</label>
                    <input name="twoblocks-right-head"  
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-right-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="twoblocks-right-description">Right Description</label>        
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-twoblocks-right-description' ) ) , 'twoblocks-right-description', $settings = array('twoblocks-right-description'=>'twoblocks-right-description') ); ?>
                </div>
            </div>
            <div id="peek-inside"> 
                <div class="form-field form-required">
                    <label for="peekinside-head">Peek Inside Main Heading</label>
                    <input name="peekinside-head" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-peekinside-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>  
                <?php for($i=0; $i<1; $i++) { ?>
                <div class="form-field form-required">
                    <label for="peekinside-subhead<?php echo $i; ?>">Peek Inside Subhead</label>
                    <input name="peekinside-subhead[]" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-peekinside-subhead'.$i ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required border-btm">
                    <label>Video Script</label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-peekinside-video-link'.$i ) ) , "peekinside-video-link".$i, $settings = array("peekinside-video-link[$i]"=>"peekinside-video-link[$i]") ); ?>
                </div>
                <?php } ?>
            </div>
            <?php */ ?>
            <div id="app"> 
                <?php /*
                <div class="form-field form-required">
                    <label for="app-head">App Main Heading</label>
                    <input name="app-head" id="app-head" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-app-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>  
                <div class="form-field form-required">
                    <label for="app-description">App Main Description</label>
                    <textarea name="app-description" id="app-description" rows="3" 
                    cols="40"><?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-app-description' ) ); ?></textarea>
                </div>
                <div class="form-field form-required">
                    <label for="app-sub-head">App Sub Heading</label>
                    <input name="app-sub-head" id="app-sub-head" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-app-sub-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                */ ?>
                <?php for($i=0; $i<4; $i++) { ?>
                <div class="form-field form-required">
                    <label for="app-button-link<?php echo $i; ?>">Video Script <?php echo $i+1; ?></label>
                    <?php wp_editor( esc_attr( $this->deserializer->get_value( 'tutsplus-app-button-link'.$i ) ) , "app-button-link".$i, $settings = array("app-button-link[$i]"=>"app-button-link[$i]") ); ?>
                </div>
                <?php } ?>
            </div>
            <?php /*
            <div id="wardrobe"> 
                <div class="form-field form-required">
                    <label for="wardrobe-image">Wardrobe Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-wardrobe-image' ) ); ?>" height="200" width="200"/>
                    <input name="wardrobe-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-wardrobe-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div>
            </div>
            <div id="signup"> 
                <div class="form-field form-required">
                    <label for="signup-form">Signup Form ID</label>
                    <input name="signup-form" id="signup-form" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-signup-form' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="signup-head">Signup Heading</label>
                    <input name="signup-head"  
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-signup-head' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="signup-description">Signup Description</label>
                    <input name="signup-description" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-signup-description' ) ); ?>" 
                   size="40" aria-required="true" type="text" />
                </div>
                <div class="form-field form-required">
                    <label for="signup-image">Signup Image</label>
                    <img src="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-signup-image' ) ); ?>" height="200" width="200"/>
                    <input name="signup-image" class="upload-text" 
                   value="<?php echo esc_attr( $this->deserializer->get_value( 'tutsplus-signup-image' ) ); ?>" type="hidden" />
                   <a href="#" class="image-upload">Upload Image</a>
                </div>
            </div>
            <?php */ ?>    
        <?php
            wp_nonce_field( 'acme-settings-save', 'acme-custom-message' );
            submit_button();
        ?>
        </div><!-- #tabs -->
 
    </form>
   <script type="text/javascript">
   jQuery( function() {
	    jQuery( "#tabs" ).tabs();
  } );
   jQuery(document).ready(function($) {
        $('.image-upload').click(function(e) {
            $this = $(this);
            e.preventDefault();

            var custom_uploader = wp.media({
                title: 'Custom Image',
                button: {
                    text: 'Upload Image'
                },
                multiple: false  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $this.parent().find('img').attr('src', attachment.url);
                $this.parent().find('.upload-text').val(attachment.url);

            })
            .open();
        });
    });
  </script>
</div><!-- .wrap -->