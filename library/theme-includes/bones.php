<?php

// ===== HEAD CLEANUP
// ================================================================================

function bones_head_cleanup() {
	remove_action('wp_head', 'feed_links_extra', 3); // category feeds
	remove_action('wp_head', 'feed_links', 2); // post and comment feeds
	remove_action('wp_head', 'rsd_link'); // EditURI link
	remove_action('wp_head', 'wlwmanifest_link'); // windows live writer
	remove_action('wp_head', 'index_rel_link'); // index link
	remove_action('wp_head', 'parent_post_rel_link', 10, 0); // previous link
	remove_action('wp_head', 'start_post_rel_link', 10, 0); // start link
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // links for adjacent posts
	remove_action('wp_head', 'wp_generator'); // WP version
	add_filter('style_loader_src', 'bones_remove_wp_ver_css_js', 9999); // remove WP version from css
	add_filter('script_loader_src', 'bones_remove_wp_ver_css_js', 9999); // remove Wp version from scripts
}

// Remove WP version from RSS
function bones_rss_version() { return ''; }

// Remove WP version from scripts
function bones_remove_wp_ver_css_js($src) {
	if(strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}

// Remove injected CSS for recent comments widget
function bones_remove_wp_widget_recent_comments_style() {
	if(has_filter('wp_head', 'wp_widget_recent_comments_style')) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style');
	}
}

// Remove injected CSS from recent comments widget
function bones_remove_recent_comments_style() {
	global $wp_widget_factory;
	if(isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
	}
}

// Remove injected CSS from gallery
function bones_gallery_style($css) {
	return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}



// ===== STYLES & SCRIPTS QUEUE
// ================================================================================

function bones_scripts_and_styles() {
	if (!is_admin()) {
		// In Header
		wp_deregister_script('jquery');
		wp_register_script('bones-modernizr', get_stylesheet_directory_uri().'/library/js/lib/modernizr.custom.min.js', array(), '2.5.3', false);
		wp_register_script('jquery', 'http://code.jquery.com/jquery-1.11.1.min.js', array(), '1.11.1', false);
		wp_register_style('bones-stylesheet', get_stylesheet_directory_uri().'/library/css/main.css', array(), '', 'all', false);

		// In Footer
		wp_register_script('bones-js-plugins', get_stylesheet_directory_uri().'/library/js/plugins.js', array('jquery'), '', true);
		wp_register_script('bones-js-scripts', get_stylesheet_directory_uri().'/library/js/scripts.js', array('jquery'), '', true);

		// Enqueue
		wp_enqueue_script('bones-modernizr');
		wp_enqueue_style('bones-stylesheet');
		wp_enqueue_script('jquery');
		wp_enqueue_script('bones-js-plugins');
		wp_enqueue_script('bones-js-scripts');
	}
}



// ===== THEME SUPPORT
// ================================================================================

function bones_theme_support() {
	// Post format support
	add_theme_support('post-formats',
		array(
			'aside',	// title less blurb
			'gallery',	// gallery of images
			'link',		// quick link to other site
			'image',	// an image
			'quote',	// a quick quote
			'status',	// a Facebook like status update
			'video',	// video
			'audio',	// audio
			'chat'		// chat transcript
		)
	);

	// Menus
	add_theme_support('menus');
}



// ===== PAGE NAVI
// ================================================================================

function bones_page_navi() {
	global $wp_query;
	$bignum = 999999999;
	if($wp_query->max_num_pages <= 1) {
		return;
	}
	echo '<nav class="pagination">';
		echo paginate_links(array(
			'base'         => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
			'format'       => '',
			'current'      => max(1, get_query_var('paged')),
			'total'        => $wp_query->max_num_pages,
			'prev_text'    => '&larr;',
			'next_text'    => '&rarr;',
			'type'         => 'list',
			'end_size'     => 3,
			'mid_size'     => 3
		));
	echo '</nav>';
}



// ===== MISC. CLEANUP ITEMS
// ================================================================================

// Remove the <p> surrounding images
function bones_filter_ptags_on_images($content) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// Remove the [...] to a "Read More" link
function bones_excerpt_more($more) {
	global $post;
	return '...  <a class="excerpt-read-more" href="'.get_permalink($post->ID).'" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
}

?>
