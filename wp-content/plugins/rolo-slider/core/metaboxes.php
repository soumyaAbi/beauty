<?php

if( !class_exists( 'Rolo_Metaboxes' ) )
{
   class Rolo_Metaboxes
   {
      protected static function hooks()
      {
         add_action( 'cmb2_init', array( 'Rolo_Metaboxes', 'top_promo_box' ) );
         add_action( 'cmb2_init', array( 'Rolo_Metaboxes', 'rolo_metabox_init' ) );
         add_filter( 'rolo_options_sections', array( 'Rolo_Metaboxes', 'sections' ), 1, 1 );
         add_action( 'cmb2_render_promo_banner', array( 'Rolo_Metaboxes','top_promo' ), 10, 5 );
      }

      /**
      * Create metaboxes for every slider layout + options
      *
      */
       public static function rolo_metabox_init()
       {
          $prefix = '_rl_';

          $animations = array(
              'slideup' => __('Slide Up', 'rolo'),
              'slidedwn' => __('Slide Down', 'rolo'),
              'fade'  => __('Fade', 'rolo'),
          );

          $animations = apply_filters('rolo-slider-el-anms', $animations);

          //main sldies
          $hgh = new_cmb2_box( array( 
              'id' => $prefix . 'highlights_box',
              'title' => __('Slides', 'rolo'),
              'object_types' => array( 'rolo_slider' )
           ) );

          $hgh_group = $hgh->add_field( array( 
              'id'    => $prefix . 'slide',
              'type'        => 'group',
              'description' => __( 'Add/Remove New Slide', 'rolo' ),
              'options'     => array(
                  'group_title'   => __( 'Slide {#}', 'cmb' ), 
                  'add_button'    => __( 'Add Another Slide', 'cmb' ),
                  'remove_button' => __( 'Remove Slide', 'cmb' ),
                  'sortable'      => true,
              ),
            ) 
          );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-format-image"></span> ' . __('Slide Image', 'rolo'),
              'id'   => $prefix . 'screen',
              'desc' => __('Slide Image.', 'rolo'),
              'type' => 'file',
              'preview_size' => array( 230,160 )
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Title', 'rolo'),
              'id'   => $prefix . 'title',
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-star-empty"></span> ' . __('Title Animation', 'rolo'),
              'id'   => $prefix . 'title_anm',
              'desc' => __('Set title animation intro.', 'rolo'),
              'type' => 'select',
              'before_row' => "<div class='rolo-title-section-ops'>",
              'options' => $animations
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-clock"></span> ' . __('Title Animation Duration', 'rolo'),
              'id'   => $prefix . 'title_anm_dur',
              'desc' => __('Set the animation duration .', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-backup"></span> ' . __('Title Animation Delay', 'rolo'),
              'id'   => $prefix . 'title_anm_del',
              'desc' => __('Set the animation delay.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-randomize"></span> ' . __('Title Animation Value', 'rolo'),
              'id'   => $prefix . 'title_anm_val',
              'desc' => __('Set the animation starting point from which element will be animated.', 'rolo'),
              'type' => 'text',
              'after_row' => "</div>"
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Subtitle', 'rolo'),
              'id'   => $prefix . 'subtitle',
              'type' => 'text'
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-star-empty"></span> ' . __('Subitle Animation', 'rolo'),
              'id'   => $prefix . 'subtitle_anm',
              'desc' => __('Set title animation intro.', 'rolo'),
              'type' => 'select',
              'options' => $animations,
              'before_row' => "<div class='rolo-subtitle-section-ops'>"
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-clock"></span> ' . __('Subitle Animation Duration', 'rolo'),
              'id'   => $prefix . 'subtitle_anm_dur',
              'desc' => __('Set the animation duration .', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-backup"></span> ' . __('Subitle Animation Delay', 'rolo'),
              'id'   => $prefix . 'subtitle_anm_del',
              'desc' => __('Set the animation delay .', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-randomize"></span> ' . __('Subtitle Animation Value', 'rolo'),
              'id'   => $prefix . 'subtitle_anm_val',
              'desc' => __('Set the animation starting point from which element will be animated.', 'rolo'),
              'type' => 'text',
              'after_row' => "</div>"
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Desription', 'rolo'),
              'id'   => $prefix . 'desc',
              'desc' => __('Highlight Content/Description.', 'rolo'),
              'type' => 'textarea_small'
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-star-empty"></span> ' . __('Description Animation', 'rolo'),
              'id'   => $prefix . 'desc_anm',
              'desc' => __('Set title animation intro.', 'rolo'),
              'type' => 'select',
              'options' => $animations,
              'before_row' => "<div class='rolo-desc-section-ops'>"
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-clock"></span> ' . __('Description Animation Duration', 'rolo'),
              'id'   => $prefix . 'desc_anm_dur',
              'desc' => __('Set the animation duration .', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-backup"></span> ' . __('Description Animation Delay', 'rolo'),
              'id'   => $prefix . 'desc_anm_del',
              'desc' => __('Set the animation delay.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-randomize"></span> ' . __('Description Animation Value', 'rolo'),
              'id'   => $prefix . 'desc_anm_val',
              'desc' => __('Set the animation starting point from which element will be animated.', 'rolo'),
              'type' => 'text',
              'after_row' => "</div>"
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Button 1 Text', 'rolo'),
              'id'   => $prefix . 'button1',
              'desc' => __('Add button 1 text.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Button 1 URL', 'rolo'),
              'id'   => $prefix . 'button_url1',
              'desc' => __('Add button 1 url.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Button 2 Text', 'rolo'),
              'id'   => $prefix . 'button2',
              'desc' => __('Add button 2 text.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Button 2 URL', 'rolo'),
              'id'   => $prefix . 'button_url2',
              'desc' => __('Add button 2 url.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-star-empty"></span> ' . __('Buttons Animation', 'rolo'),
              'id'   => $prefix . 'buttons_anm',
              'desc' => __('Set Buttons animation intro.', 'rolo'),
              'type' => 'select',
              'before_row' => "<div class='rolo-buttons-section-ops'>",
              'options' => $animations
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-clock"></span> ' . __('Buttons Animation Duration', 'rolo'),
              'id'   => $prefix . 'buttons_anm_dur',
              'desc' => __('Set the animation duration.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-backup"></span> ' . __('Buttons Animation Delay', 'rolo'),
              'id'   => $prefix . 'buttons_anm_del',
              'desc' => __('Set the animation delay.', 'rolo'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-randomize"></span> ' . __('Buttons Animation Value', 'rolo'),
              'id'   => $prefix . 'buttons_anm_val',
              'desc' => __('Set the animation starting point from which element will be animated.', 'rolo'),
              'type' => 'text',
              'after_row' => "</div>"
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-leftright"></span> ' . __('Layers Horizontal Position', 'rolo'),
              'id'   => $prefix . 'hor_pos',
              'desc' => __('Set the alignment of the element on the picture.', 'rolo'),
              'type' => 'select',
              'options' => array(
                  'left' => __('Left', 'rolo'),
                  'right' => __('Right', 'rolo'),
                  'center' => __('Center', 'rolo'),
               )
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-sort"></span> ' . __('Layers Vertical Position', 'rolo'),
              'id'   => $prefix . 'ver_pos',
              'desc' => __('Set the alignment of the element on the picture.', 'rolo'),
              'type' => 'select',
              'options' => array(
                  'top' => __('Top', 'rolo'),
                  'middle' => __('Middle', 'rolo'),
                  'bottom' => __('Bottom', 'rolo'),
               )
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-format-aside"></span> ' . __('Transparent Captions', 'rolo'),
              'id'   => $prefix . 'captions',
              'desc' => __('Choose to leave caption background transparent around elements.', 'rolo'),
              'type' => 'checkbox',
          ) );

          //responsive layout
          $resp = new_cmb2_box( array( 
              'id' => $prefix . 'responsive_box',
              'title' => __('"Responsive Image" Slider Layout', 'rolo'),
              'object_types' => array( 'rolo_slider' )
           ) );

          $resp->add_field( array(
              'name' => '<span class="dashicons dashicons-format-image"></span> ' . __('Slides', 'rolo'),
              'id'   => $prefix . 'responsive',
              'type' => 'file_list',
              'preview_size' => array( 100, 100 ),
              'desc' => __('Select/upload multiple screens. Hold CTRL and keep clicking on the images until you do not select them all.', 'rolo'),
          ) );

          /**
          * Create action hook for adding custom element fields
          * @since 0.1
          */
          do_action( 'rolo_add_elements', $hgh, $hgh_group, $prefix );

       }

       /**
        * Main plugin options
        *
        * @since 0.1
        *
        */
       public static function sections($sections)
       {
           if( !is_array( $sections ) ) {
               return;
           }

           return apply_filters('rolo_sections_data', $sections);
       }

      /**
       * Promo Banners metabox
       *
       * @since 0.1
       *
       */
      public static function top_promo_box()
      {
         $promo = new_cmb2_box( array(
             'id'           => 'addons_metabox',
             'title'        => esc_html__('Latest Addons','rolo'),
             'object_types' => array( 'rolo_slider' ),
             'context'      => 'normal',
             'priority'     => 'high',
             'show_names'   => false
         ) );

         $promo->add_field( array(
             'name' => 'promo',
             'id'   => '_promo',
             'type' => 'promo_banner',
         ) );
      }

      /**
       * Promo Banners field
       *
       * @since 0.1
       *
       */
      public static function top_promo($field, $escaped_value, $object_id, $object_type, $field_type_object)
      {
         ?>
         <div class="rolo-banner-wrapper">
            <div class="rolo-addon">
               <img src="<?php echo ROLO_ASSETS_URL.'images/bundle.jpg' ?>" />
               <h3><?php esc_html_e('Addons Bundle','rolo'); ?></h3>
               <p style="color: green; font-style: italic; font-weight: 700; font-size: 13px;"><?php esc_html_e('Save almost 45% by purchasing the whole bundle','rolo'); ?></p>
               <p><?php esc_html_e('Rolo Slider Bundle package contain all three Rolo Slider extensions: Layer Colors, Posts Slider and WooCommerce Products Slider. Weather you want additional color settings or to display blog posts or WooCommerce products, this bundle contain it all, for a special price.', 'rolo'); ?></p>
               <a href="http://pressfore.com/item/rolo-slider-bundle/" target="_blank"><?php esc_html_e('Read More', 'rolo'); ?></a>
            </div>
            <div class="rolo-addon">
               <img src="<?php echo ROLO_ASSETS_URL.'images/controller.jpg' ?>" />
               <h3><?php esc_html_e('Controller Addon','rolo'); ?></h3>
               <p><?php esc_html_e('Offer Full Height And Kend Burns Direction Options.','rolo'); ?>
               <p><?php esc_html_e('Rolo Slider Controller Addon gives you option to change ken burns effect direction per slide, along with image zooming ratio, image moving factor in px, fade to image option and full height option for slider. 2 New Transitions are also available', 'rolo'); ?></p>
               <a href="http://pressfore.com/item/rolo-controller-addon/" target="_blank"><?php esc_html_e('Read More', 'rolo'); ?></a>
            </div>
            <div class="rolo-addon">
               <img src="<?php echo ROLO_ASSETS_URL.'images/layer-colors.jpg' ?>" />
               <h3><?php esc_html_e('Layer Colors Addon','rolo'); ?></h3>
               <p><strong><?php esc_html_e('Offer highly configurable, and professional looking slides without needing to adjust slide images in order to match content colors.','rolo'); ?></strong></p>
               <p><?php esc_html_e('Layer Colors is Rolo Slider extension. It will allow you to set diferent colors for each slide, which is very handy, because you won’t need to adjust slide images or to add some kind of overlay in a situations when there is a image with dominating ...', 'rolo'); ?></p>
               <a href="http://pressfore.com/item/layer-colors/" target="_blank"><?php esc_html_e('Read More', 'rolo'); ?></a>
            </div>
            <div class="rolo-addon">
               <img src="<?php echo ROLO_ASSETS_URL.'images/posts-slider.jpg' ?>" />
               <h3><?php esc_html_e('Posts Slider Addon','rolo'); ?></h3>
               <p><strong><?php esc_html_e('Create unlimited number of slides showcasing latest posts, or cusom selected posts.','rolo'); ?></strong></p>
               <p><?php esc_html_e('Posts Slider is Rolo Slider extension. It allows displaying blog posts over two layouts. First one will allow you to search through published posts in order to select ones which you want. Other layout will allow you to dynamicly display desired amount of latest blog posts. Beside ...', 'rolo'); ?></p>
               <a href="http://pressfore.com/item/posts-slider/" target="_blank"><?php esc_html_e('Read More', 'rolo'); ?></a>
            </div>
            <div class="rolo-addon">
               <img src="<?php echo ROLO_ASSETS_URL.'images/product-slider.jpg' ?>" />
               <h3><?php esc_html_e('WooCommerce Products Slider Addon','rolo'); ?></h3>
               <p><strong><?php esc_html_e('Easily create slides showcasing latest products from your WooCommerce shop.','rolo'); ?></strong></p>
               <p><?php esc_html_e('WooCommerce Products Slider is Rolo Slider extension. It allows displaying WooCommerce products over two layouts. First one will allow you to search through exising products in order to select ones which you want. Other layout will allow you to dynamicly display desired amount of latest products. Beside ...', 'rolo'); ?></p>
               <a href="http://pressfore.com/item/woocommerce-products-slider/" target="_blank"><?php esc_html_e('Read More', 'rolo'); ?></a>
            </div>
         </div>
         <?php
      }

      public static function init()
      {
        self::hooks();
      }
  }
}
