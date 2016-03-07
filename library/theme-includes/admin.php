<?php

// ===== DASHBOARD WIDGETS
// ================================================================================

function disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	// unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);    // Right Now Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);        // Activity Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Comments Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);  // Incoming Links Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);         // Plugins Widget

	// unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    // Quick Press Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);     // Recent Drafts Widget
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);           //
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);         //

	// remove plugin dashboard boxes
	unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);           // Yoast's SEO Plugin Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);        // Gravity Forms Plugin Widget
	unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);   // bbPress Plugin Widget
}
add_action( 'wp_dashboard_setup', 'disable_default_dashboard_widgets' );



// ===== CUSTOM LOGIN PAGE
// ================================================================================

// Include Login CSS
function bones_login_css() {
	wp_enqueue_style('bones_login_css', get_template_directory_uri().'/library/css/login.css', false);
}

// Change the logo link to point to your site
function bones_login_url() {  return home_url(); }

// Changing the alt-text on the logo to show your site name
function bones_login_title() { return get_option('blogname'); }

add_action('login_enqueue_scripts', 'bones_login_css', 10);
add_filter('login_headerurl', 'bones_login_url');
add_filter('login_headertitle', 'bones_login_title');



// ===== CUSTOMIZE ADMIN
// ================================================================================

// Custom Footer
function bones_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by TriMark, for TriMark';
}
add_filter('admin_footer_text', 'bones_custom_admin_footer');

?>
