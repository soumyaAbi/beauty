<?php
/*
Plugin Name: Awesome Team Showcase
Plugin URI: http://www.netattingo.com/
Description: This plugin provides to show awesome team showcase to you post or pages just using shortcode.
Author: NetAttingo Technologies
Version: 1.0.0
Author URI: http://www.netattingo.com/
*/

//initialize constant
define('AWTS_DIR', plugin_dir_path(__FILE__));
define('AWTS_URL', plugin_dir_url(__FILE__));
define('AWTS_INCLUDE_DIR', plugin_dir_path(__FILE__).'pages/');
define('AWTS_INCLUDE_URL', plugin_dir_url(__FILE__).'pages/');

// plugin activation hook called	
function awts_install() {
   	global $wpdb;
}
register_activation_hook(__FILE__, 'awts_install');

// plugin deactivation hook called	
function awts_uninstall() {	
	global $wpdb;
}
register_deactivation_hook(__FILE__, 'awts_uninstall');

//Include css and js file at particular location
function awts_js_css_files() {
	wp_enqueue_style( 'awts_css', plugins_url('includes/front-style.css',__FILE__ ));
}
add_action( 'wp_enqueue_scripts','awts_js_css_files');

//add admin css
function awts_admin_css() {
  wp_register_style('admin_css', plugins_url('includes/admin-style.css',__FILE__ ));
  wp_enqueue_style('admin_css');
}
add_action( 'admin_init','awts_admin_css');


// admin menu
function awts_menus() {
	add_submenu_page("edit.php?post_type=aw-team-member", "About Us", "About Us", "administrator", "about-us", "awts_pages");
}
add_action("admin_menu", "awts_menus");


//function menu pages
function awts_pages() {

   $setting = AWTS_INCLUDE_DIR.$_GET["page"].'.php';
   include($setting);

}


//Custom post - Awesome Team Member 
function awts_team_manager() {
  $labels = array(
    'name'               => __( 'Awesome Team Member', 'aw-team-member' ),
    'singular_name'      => __( 'Awesome Team Member', 'aw-team-member' ),
    'add_new'            => __( 'Add New Member', 'member' ),
    'add_new_item'       => __( 'Add New Member' ),
    'edit_item'          => __( 'Edit Member' ),
    'new_item'           => __( 'New Member' ),
    'all_items'          => __( 'All Members' ),
    'view_item'          => __( 'View Member' ),
    'search_items'       => __( 'Search Members' ),
    'not_found'          => __( 'No Member found' ),
    'not_found_in_trash' => __( 'No Member found in the Trash' ), 
    'parent_item_colon'  => __( '' ),
    'menu_name'          => __( 'Awesome Team Member' )
  );
	
  $profile_slug = get_option('awts_mem_pro_page_slug');

  $args = array(
    'labels'        => $labels,
    'description'   => 'Team Members Add',
    'public'        => true,
	'rewrite'       => array( 'slug' => $profile_slug ),
	'menu_position' => null,
    'supports'      => array( 'title', 'editor', 'thumbnail'),
    'has_archive'   => true,
    'menu_icon'   => 'dashicons-groups'
	
  );
  register_post_type( 'aw-team-member', $args ); 
  
  register_taxonomy(
                "awts-team-category", "aw-team-member", array(
                "hierarchical"   => true,
                "label"          => "Member Categories",
                "singular_label" => "Member Categories", 
                "rewrite"        => true));

        register_taxonomy_for_object_type('awts-team-category', 'aw-team-member');     

        flush_rewrite_rules();

}

add_action( 'init', 'awts_team_manager' );


// Add meta box for Role of member
add_action( 'add_meta_boxes', 'awts_member_role_box' );

function awts_member_role_box() {
    add_meta_box( 
        'awts_member_role_box',
        'Role of Member',
        'awts_member_role_box_content',
        'aw-team-member',
        'normal',
        'high'
    );
}

function awts_get_meta($meta_name, $post){
	$meta_data = get_post_meta($post->ID, $meta_name, true);
	
	if( !empty($meta_data) )
		$save_meta = $meta_data;
	else
		$save_meta = '';
	
	return $save_meta;
}
function awts_member_role_box_content( $post ) {
  echo '<label for="awts_member_role">Role of Member</label>';
  $input_value = awts_get_meta('awts_member_role', $post);
  
  echo ' <input type="text" id="awts_member_role" name="awts_member_role" placeholder="Enter Member Role" 
		value="'.$input_value.'"/>';
}

add_action( 'save_post', 'awts_member_role_box_save' );

function awts_member_role_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( 'page' == sanitize_text_field($_POST['post_type'] )) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $member_role= sanitize_text_field( $_POST['awts_member_role']);
  update_post_meta( $post_id, 'awts_member_role', $member_role);
}

// Add meta box for facebook link
add_action( 'add_meta_boxes', 'awts_member_facebook_box' );

function awts_member_facebook_box() {
    add_meta_box( 
        'awts_member_facebook_box',
        'Facebook Profile Link',
        'awts_member_facebook_box_content',
        'aw-team-member',
        'normal',
        'high'
    );
}

function awts_member_facebook_box_content( $post ) {
  echo '<label for="awts_member_facebook">Facebook Profile Link</label>';
  $input_value = awts_get_meta('awts_member_facebook', $post);
  echo '<input type="text" id="awts_member_facebook" name="awts_member_facebook" placeholder="Facebook Profile Link Here" value="'.$input_value. '"/>';
}

add_action( 'save_post', 'awts_member_facebook_box_save' );

function awts_member_facebook_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;
  
  if ( 'page' == sanitize_text_field($_POST['post_type'] ) ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $member_facebook= sanitize_text_field($_POST['awts_member_facebook']);
  update_post_meta( $post_id, 'awts_member_facebook', $member_facebook);
}



// Add meta box for twitter link
add_action( 'add_meta_boxes', 'awts_member_twitter_box' );

function awts_member_twitter_box() {
    add_meta_box( 
        'awts_member_twitter_box',
        'Twitter Profile Link',
        'awts_member_twitter_box_content',
        'aw-team-member',
        'normal',
        'high'
    );
}

function awts_member_twitter_box_content( $post ) {
  echo '<label for="awts_member_twitter">Twitter Profile Link</label>';
  $input_value = awts_get_meta('awts_member_twitter', $post);
  echo '<input type="text" id="awts_member_twitter" name="awts_member_twitter" placeholder="Twitter Profile Link Here" value="'.$input_value. '"/>';
}

add_action( 'save_post', 'awts_member_twitter_box_save' );

function awts_member_twitter_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;
  
  if ( 'page' == sanitize_text_field($_POST['post_type'] )) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $member_twitter= sanitize_text_field($_POST['awts_member_twitter']);
  update_post_meta( $post_id, 'awts_member_twitter', $member_twitter);
}


// Add meta box for linkedin of member
add_action( 'add_meta_boxes', 'awts_member_linkedin_box' );

function awts_member_linkedin_box() {
    add_meta_box( 
        'awts_member_linkedin_box',
        'Linkedin Profile Link',
        'awts_member_linkedin_box_content',
        'aw-team-member',
        'normal',
        'high'
    );
}

function awts_member_linkedin_box_content( $post ) {
  echo '<label for="awts_member_linkedin">Linkedin Profile Link</label>';
  $input_value = awts_get_meta('awts_member_linkedin', $post);
  echo '<input type="text" id="awts_member_linkedin" name="awts_member_linkedin" placeholder="Linkedin Profile Link Here" value="'.$input_value. '"/>';
}

add_action( 'save_post', 'awts_member_linkedin_box_save' );

function awts_member_linkedin_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;
  
  if ( 'page' == sanitize_text_field($_POST['post_type'] )) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $member_linkedin= sanitize_text_field( $_POST['awts_member_linkedin'] );
  update_post_meta( $post_id, 'awts_member_linkedin', $member_linkedin);
}




// Add meta box for google of member
add_action( 'add_meta_boxes', 'awts_member_google_box' );

function awts_member_google_box() {
    add_meta_box( 
        'awts_member_google_box',
        'Google Profile Link',
        'awts_member_google_box_content',
        'aw-team-member',
        'normal',
        'high'
    );
}

function awts_member_google_box_content( $post ) {
  echo '<label for="awts_member_google">Google Profile Link</label>';
  $input_value = awts_get_meta('awts_member_google', $post);
  echo '<input type="text" id="awts_member_google" name="awts_member_google" placeholder="Google Profile Link Here" value="'.$input_value. '"/>';
}

add_action( 'save_post', 'awts_member_google_box_save' );

function awts_member_google_box_save( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;
  
  if ( 'page' == sanitize_text_field($_POST['post_type'] )) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $member_google= sanitize_text_field($_POST['awts_member_google']);
  update_post_meta( $post_id, 'awts_member_google', $member_google);
}



//shortcode for team-members page
function awts_shortcode_function_member_list($atts, $content = null) {
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
		
		$team_members_output .= '<li>';
		 if( has_post_thumbnail() ){ 
			$team_members_output .= '<div class="mem-image">'.get_the_post_thumbnail(get_the_ID(), 'full') .'</div>';
		 }
		$team_members_output .= '<div class="mem-short-det">'; 
		$team_members_output .= '<div class="mem-name">'.$name.'</div>'; // member name
		$team_members_output .= '<div class="mem-role">'.$role.'</div>'; // member role
		//member social icons
		
		 $url_member_linkedin = get_post_meta( get_the_ID(), 'awts_member_linkedin', true );
		 $url_member_twitter = get_post_meta( get_the_ID(), 'awts_member_twitter', true );
		 $url_member_facebook = get_post_meta( get_the_ID(), 'awts_member_facebook', true );
		 $awts_google_linkedin = get_post_meta( get_the_ID(), 'awts_member_google', true );
		 
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
		//member social icons
		
		$team_members_output .= '<div class="mem-show-full"><a href="javascript:void(0)" onclick="showMemberDeatails('.get_the_ID().')" >View full profile</a></div>';
		$team_members_output .= '</div>';
		//detailed pop up start
		
		$team_members_output .= '<div style="display:none;" class="cls-member-detail" id="member-detail-pop-'.get_the_ID().'">';
		$team_members_output .= '<div class="close-pop"><a href="javascript:void(0)" onclick="hideMemberDeatails('.get_the_ID().')" >X</a></div>';
			$team_members_output .='<div class="det-left">';
			if( has_post_thumbnail() ){ 
				$team_members_output .= '<div class="mem-image">'.get_the_post_thumbnail(get_the_ID(), 'full') .'</div>';
		    }
			
			$team_members_output .='</div>';
			
			$team_members_output .='<div class="det-right">';
			     $team_members_output .= '<div class="mem-name">'.$name.'</div>'; // member name
		         $team_members_output .= '<div class="mem-role">'.$role.'</div>'; // member role
		         $team_members_output .= '<div class="mem-desc">'.get_the_content().'</div>'; // member role
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
				 //social icon start
			$team_members_output .='</div>';
		$team_members_output .='</div>';
		//detailed pop up end
		
	    $team_members_output .= '</li>'; 
 
		}
         $team_members_output .= '</ul>';
		 
		 $team_members_output .= '<div style="display:none;" class="pop-mask"></div>'; //mask
		// endwhile - of the loop
		$team_members_output .= '<div class="clear"></div>';

		}else{	// end if
			$team_members_output .= 'There is no member added yet.';
		} 	
		
		wp_reset_postdata(); 
		
		$team_members_output .= '</div>
	</div>';
	
	$team_members_output .='<script type="text/javascript">
		function showMemberDeatails(memid){
		 jQuery("#member-detail-pop-"+memid).show();
		 jQuery(".pop-mask").show();
		}
        function hideMemberDeatails(memid){
		 jQuery("#member-detail-pop-"+memid).hide();
		 jQuery(".pop-mask").hide();
		}		
	</script>' ;
	
	
	return $team_members_output;
} 	// END function
function register_shortcodes(){
   add_shortcode('team-members', 'awts_shortcode_function_member_list');
}
add_action( 'init', 'register_shortcodes');



