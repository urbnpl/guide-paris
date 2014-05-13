<?php

// BEGIN: if you are logged into the admin area, show what template someone is using on the top of all pages
//  if (is_user_logged_in()) { add_action('wp_footer', 'show_template'); }
//
//  function show_template() {
//      global $template;
//      print_r($template);
//      //global $wp_taxonomies;
//      //print_r($wp_taxonomies['sections']);
//  }

// // create a new taxonomy called 'Countries'
// function countries_init() {
//   register_taxonomy(
//     'countries',
//     'post',
//     array(
//       'label' => __('Countries'),
//       'sort' => true,
//       'args' => array('orderby' => 'term_order'),
//       'rewrite' => array('slug' => 'countries'),
//     )
//   );
// }
// add_action( 'init', 'countries_init' );

// Translate
load_theme_textdomain( get_template_directory() . '/languages' );
// For Responsive images and thumbnails, removes the width and height from the markup
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}


// Removes tags generated in the WordPress Head that we don't use, you could read up and re-enable them if you think they're needed
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');


// Load jQuery
// you can either load the local or google CDN version below by commenting out one or another wp_register_script line function


    function my_init_method() {
        if (!is_admin()) {

            wp_deregister_script( 'jquery' );

            // local copy of jquery
            wp_register_script( 'jquery', '/wp-includes/js/jquery/jquery.js"');

            // google CDN copy of jquery
            //wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
            
            wp_enqueue_script( 'jquery' );
        }
    } 
    add_action('init', 'my_init_method');


// Add theme support
    
if (function_exists('add_theme_support')) {
    
    // Activates menu features
    add_theme_support('menus');
    
    // Activates Featured Image functions
    add_theme_support( 'post-thumbnails' );

}



// Improves the body_class function
function condensed_body_class($classes) {
    global $post;


    // add class for the name of the custom template used (if any)
    $temp = get_page_template();
    if ( $temp != null ) {
        $path = pathinfo($temp);
        $tmp = $path['filename'] . "." . $path['extension'];
        $tn= str_replace(".php", "", $tmp);
        $classes[] = "template_".$tn;
    }

    return $classes;

}

add_filter('body_class', 'condensed_body_class');


// Removes the automatic paragraph tags from the excerpt, we leave it on for the content and have a custom field you can use to turn it off on a page by page basis --> wpautop = false
    remove_filter('the_excerpt', 'wpautop');

// Used to create custom length excerpts
function get_the_custom_excerpt($length){
    return substr( get_the_excerpt(), 0, strrpos( substr( get_the_excerpt(), 0, $length), ' ' ) ).'...';
}

// Register wigetized sidebars, changing the default output from lists to divs

    if ( function_exists('register_sidebar') )

    register_sidebar(array(
        'id' => 'sidebar-main',
        'name' => 'Sidebar: Main',
        'description' => 'The second (secondary) sidebar.',
        'before_widget' => '<div class="%1$s widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));


// Post Type: Section

		function custom_post_type() {
            $labels = array( 
                'name'               => _x( 'Sections', 'general name' ),
                'singular_name'      => _x( 'Section', 'singular name' ),
                'add_new'            => _x( 'Add New', 'Sections' ),
                'add_new_item'       => __( 'Add Section' ),
                'edit_item'          => __( 'Edit Section' ),
                'new_item'           => __( 'New Section' ),
                'all_items'          => __( 'All Sections' ),
                'view_item'          => __( 'View Sections' ),
                'search_items'       => __( 'Search Sections' ),
                'not_found'          => __( 'No Sections found' ),
                'not_found_in_trash' => __( 'No Sections found in the Trash' ),
                'parent_item_colon'  => '',
                'menu_name'          => 'Sections'
            );
            $args = array( 
                'labels'        => $labels,
                'public'        => true,
                'menu_position' => null,
                'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes' ),
                'has_archive'   => true,
            );
            register_post_type(__( 'section' ), $args); 
        }
        add_action( 'init', 'custom_post_type' );

/* Disable WordPress Admin Bar for all users but admins. */
	show_admin_bar(false);
// Disable Comments Column on Page List
function custom_post_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_posts_columns', 'custom_post_columns');

function custom_pages_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}

add_filter('manage_pages_columns', 'custom_pages_columns');

// Disable Menu and Submenu Items Admin Bar
function remove_menus () {
global $menu;
		$restricted = array(__('Posts'), __('Links'), __('Comments'), __(''));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
}
add_action('admin_menu', 'remove_menus');

function remove_submenus() { 
global $submenu;
unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
} 
add_action('admin_menu', 'remove_submenus'); 

// Remove Links From Admin Bar
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

// Remove default widgets

// unregister all widgets
function unregister_default_widgets() {
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
     unregister_widget('WP_Nav_Menu_Widget');
 }
 add_action('widgets_init', 'unregister_default_widgets', 11);
// Randomly chosen placeholder text for post/page edit screen
function wpfme_writing_encouragement( $content ) {
	global $post_type;
	if($post_type == "post"){
	$encArray = array(
		// Placeholders for the posts editor
		"Test post message one.",
		"Test post message two.",
		"<h1>Test post heading!</h1>"
		);
		return $encArray[array_rand($encArray)];
	}
	else{ $encArray = array(
		// Placeholders for the pages editor
		"Test page message one.",
		"Test page message two.",
		"<h1>Test Page Heading</h1>"
		);
		return $encArray[array_rand($encArray)];
	}
}
add_filter( 'default_content', 'wpfme_writing_encouragement' );
// Editor toolbar
function fb_change_mce_options($initArray) {
        $ext = 'pre[id|name|class|style],iframe[align|longdesc| name|width|height|frameborder|scrolling|marginheight| marginwidth|src]';
        if ( isset( $initArray['extended_valid_elements'] ) ) {
                $initArray['extended_valid_elements'] .= ',' . $ext;
        } else {
                $initArray['extended_valid_elements'] = $ext;
        }
        return $initArray;
}
add_filter('tiny_mce_before_init', 'fb_change_mce_options');


/**
 * Include the TGM_Plugin_Activation class.
 */
require_once 'includes/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'Basic SEO Pack',
            'slug'      => 'basic-seo-pack',
            'required'  => false,
        ),
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'Testimonials',
            'slug'      => 'testimonials',
            'required'  => true,
        ),
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
?>