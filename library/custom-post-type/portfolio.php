<?php
// ===== Custom Post Type - Portfolio
// ================================================================================

// Custom Post Type Definition
function cpt_portfolio() {
	register_post_type('portfolio',
		array(
			'labels' => array(
				'name' => 'Portfolios', // general name for post type, generally plural
				'singular_name' => 'Portfolio', // name for one object of this post type
				'all_items' =>'All Portfolios', // the "all items" text used in the menu
				'add_new' => 'Add New', // the "add new" menu item
				'add_new_item' => 'Add New Portfolio', // the "add new" menu item text
				'edit' => 'Edit', // the "edit" menu item
				'edit_item' => 'Edit Portfolio', // the "edit" menu item text
				'new_item' => 'New Portfolio', // the "new item" text
				'view_item' => 'View Portfolio', // the "view item" text
				'search_items' => 'Search Portfolio', // the "search item" text
				'not_found' =>  'Nothing found in the Database.', // the "not found" text
				'not_found_in_trash' => 'Nothing found in Trash', // the "not found in trash" text
				'parent_item_colon' => ''
			),
			'description' => 'Designer portfolios.',
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 9,
			'menu_icon' => 'dashicons-schedule',
			'rewrite' => array(
				'slug' => 'portfolio',
				'with_front' => false
			),
			'has_archive' => 'portfolio',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'
			)
		)
	);
}
add_action('init', 'cpt_portfolio');
?>
