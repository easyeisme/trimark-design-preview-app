<?php


// ===== CORE THEME INCLUDES
// ================================================================================

require_once('library/theme-includes/bones.php');
require_once('library/theme-includes/admin.php');
require_once('library/theme-includes/functions.php');
require_once('library/custom-post-type/design-project.php');
require_once('library/custom-post-type/employee.php');



// ===== INITIALIZE
// ================================================================================

function bones_ahoy() {
	add_action('init', 'bones_head_cleanup'); // launching operation cleanup
	add_filter('the_generator', 'bones_rss_version'); // remove WP version from RSS
	add_filter('wp_head', 'bones_remove_wp_widget_recent_comments_style', 1); // remove injected css for recent comments widget
	add_action('wp_head', 'bones_remove_recent_comments_style', 1); // clean up comment styles in the head
	add_filter('gallery_style', 'bones_gallery_style'); // clean up gallery output in wp

	add_action('wp_enqueue_scripts', 'bones_scripts_and_styles', 999);
	bones_theme_support();

	add_filter('the_content', 'bones_filter_ptags_on_images'); // cleaning up random code around images
	add_filter('excerpt_more', 'bones_excerpt_more'); // cleaning up excerpt

}
add_action('after_setup_theme', 'bones_ahoy');



// ===== CUSTOM THUMBNAIL IMAGE SIZES
// ================================================================================

/*
// The following image sizes will automatically be created whenever new images
// are added to the media manager.
add_image_size('bones-thumb-600', 600, 150, true);
add_image_size('bones-thumb-300', 300, 100, true);

// The following function adds the ability to use the dropdown menu to select
// the new images sizes you have just created from within the media manager.
function bones_custom_image_sizes($sizes) {
	return array_merge($sizes, array(
		'bones-thumb-600' => '600px by 150px',
		'bones-thumb-300' => '300px by 100px',
   ));
}
add_filter('image_size_names_choose', 'bones_custom_image_sizes');
*/

?>