<?php

class wpWings {
	protected $pluginPath;
	protected $pluginUrl;

	public function __construct() {
		// Set Plugin Path
		$this->pluginPath = dirname(__FILE__);

		// Set Plugin URL
		$this->pluginUrl = WP_PLUGIN_URL . '/wings';

		add_shortcode('Wings', array($this, 'shortcode'));
		
		// Add shortcode support for widgets  
		add_filter('widget_text', 'do_shortcode');
	}

	public function shortcode($atts) {
		// extract the attributes into variables
		extract(shortcode_atts(array(
			'images' => 3,
			'width' => 50,
			'height' => 50,
			'caption' => true,
		), $atts));
	
		// pass the attributes to getImages function and render the images
		return $this->getImages($atts['user'], $images, $width, $height, $caption);
	}

	public function getImages($user, $images = 3, $width = 50, $height = 50, $caption = true) {
		include 'DribbbleAPI.php';

		$DribbbleAPI = new DribbbleAPI($user);
		$shots = $DribbbleAPI->getPlayerShots($images);

		if($shots) {
		}
	}
	// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
   function all_settings_link() {
    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
   }
   add_action('admin_menu', 'all_settings_link');
   
   // CUSTOM ADMIN LOGIN HEADER LOGO
   function my_custom_login_logo() {
    echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/images/your-logo-image.png) !important; } </style>';
   }
   add_action('login_head', 'my_custom_login_logo');


// CUSTOM ADMIN LOGIN HEADER LINK & ALT TEXT
   function change_wp_login_url() {
    echo bloginfo('url');  // OR ECHO YOUR OWN URL
   }
   function change_wp_login_title() {
    echo get_option('blogname'); // OR ECHO YOUR OWN ALT TEXT
   }
   add_filter('login_headerurl', 'change_wp_login_url');
   add_filter('login_headertitle', 'change_wp_login_title');

}
// REMOVE META BOXES FROM DEFAULT POSTS SCREEN
   function remove_default_post_screen_metaboxes() {
 remove_meta_box( 'postcustom','post','normal' ); // Custom Fields Metabox
 remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
 remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Metabox
 remove_meta_box( 'trackbacksdiv','post','normal' ); // Talkback Metabox
 remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
 remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
 }
   add_action('admin_menu','remove_default_post_screen_metaboxes');


// REMOVE META BOXES FROM DEFAULT PAGES SCREEN
   function remove_default_page_screen_metaboxes() {
 remove_meta_box( 'postcustom','post','normal' ); // Custom Fields Metabox
 remove_meta_box( 'postexcerpt','post','normal' ); // Excerpt Metabox
 remove_meta_box( 'commentstatusdiv','post','normal' ); // Comments Metabox
 remove_meta_box( 'trackbacksdiv','post','normal' ); // Talkback Metabox
 remove_meta_box( 'slugdiv','post','normal' ); // Slug Metabox
 remove_meta_box( 'authordiv','post','normal' ); // Author Metabox
 }
   add_action('admin_menu','remove_default_page_screen_metaboxes');

// even more smart jquery inclusion :)
add_action( 'init', 'jquery_register' );

// register from google and for footer
function jquery_register() {

if ( !is_admin() ) {

    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', ( 'https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js' ), false, null, true );
    wp_enqueue_script( 'jquery' );
}
}

// remove version info from head and feeds
function complete_version_removal() {
    return '';
}
add_filter('the_generator', 'complete_version_removal');

// spam & delete links for all versions of wordpress
function delete_comment_link($id) {
    if (current_user_can('edit_post')) {
        echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&c='.$id.'">del</a> ';
        echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&dt=spam&c='.$id.'">spam</a>';
    }
}
// MAKE CUSTOM POST TYPES SEARCHABLE
function searchAll( $query ) {
 if ( $query->is_search ) { $query->set( 'post_type', array( 'site','plugin', 'theme','person' )); } 
 return $query;
}
add_filter( 'the_search_query', 'searchAll' );

Customize the Dashboard

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
   global $wp_meta_boxes;
Remove these dashboard widgets...

   unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
   unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
   unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
Add a custom widget called 'Help and Support'

   wp_add_dashboard_widget('custom_help_widget', 'Help and Support', 'custom_dashboard_help');
}
This is the content for your custom widget

 function custom_dashboard_help() {
    echo '<p>Lorum ipsum delor sit amet et nunc</p>';
}





add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
global $wp_meta_boxes;
 //Right Now - Comments, Posts, Pages at a glance
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
//Recent Comments
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
//Incoming Links
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
//Plugins - Popular, New and Recently updated Wordpress Plugins
unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);

//Wordpress Development Blog Feed
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
//Other Wordpress News Feed
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
//Quick Press Form
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
//Recent Drafts List
unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}





// unregister all default WP Widgets
function unregister_default_wp_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);



// customize admin footer text
function custom_admin_footer() {
        echo 'add your custom footer text and html here';
} 
add_filter('admin_footer_text', 'custom_admin_footer');



// MOVE THE AUTHOR METABOX INTO THE PUBLISH METABOX
add_action( 'admin_menu', 'remove_author_metabox' );
add_action( 'post_submitbox_misc_actions', 'move_author_to_publish_metabox' );
function remove_author_metabox() {
    remove_meta_box( 'authordiv', 'post', 'normal' );
}
function move_author_to_publish_metabox() {
    global $post_ID;
    $post = get_post( $post_ID );
    echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
    post_author_meta_box( $post );
    echo '</div>';
}


Add a "Settings" link for plugins on the plugin list page

Set "Settings" link for plugins on plugin-page in WordPress backend, easy to use jump to settings for users (the code is also with an solution for WordPress version smaller 2.9)

// plugin definitions
define( 'FB_BASENAME', plugin_basename( __FILE__ ) );
define( 'FB_BASEFOLDER', plugin_basename( dirname( __FILE__ ) ) );
define( 'FB_FILENAME', str_replace( FB_BASEFOLDER.'/', '', plugin_basename(__FILE__) ) );
function filter_plugin_meta($links, $file) {
  /* create link */
  if ( $file == FB_BASENAME ) {
    array_unshift(
      $links,
      sprintf( '<a href="options-general.php?page=%s">%s</a>', FB_FILENAME, __('Settings') )
    );
  }
  return $links;
}

global $wp_version;
if ( version_compare( $wp_version, '2.7alpha', '>' ) ) {
    add_filter( 'plugin_action_links_' . FB_WM_BASENAME, 'filter_plugin_meta', 10, 2);
} else {
    add_filter( 'plugin_action_links', 'filter_plugin_meta', 10, 2 );
}



/* Change WordPress dashboard CSS */
function custom_admin_styles() {
    echo '<style type="text/css">#wphead{background:#069}</style>';
}
add_action('admin_head', 'custom_admin_styles');



/***************************************************************
* Function custom_pages_columns
* Remove "comments" from pages overview (rarely use comments on pages)
***************************************************************/

add_filter('manage_pages_columns', 'custom_pages_columns');

function custom_pages_columns($defaults) {
    unset($defaults['comments']);
    return $defaults;
}





$wpWings = new wpWings();

function wp_wings($user, $images = 3, $width = 50, $height = 50, $caption = true) {
	$wpWings = new wpWings;
	echo $wpWings->getImages($user, $images, $width, $height, $caption);
}

?>