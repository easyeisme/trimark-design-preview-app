<?php
// ===== Custom Post Type - Design Project
// ================================================================================

// Custom Post Type Definition
function cpt_past_design_work() {
	register_post_type('past-design-work',
		array(
			'labels' => array(
				'name' => 'Past Design Projects', // general name for post type, generally plural
				'singular_name' => 'Past Design Project', // name for one object of this post type
				'all_items' =>'All Past Design Projects', // the "all items" text used in the menu
				'add_new' => 'Add New', // the "add new" menu item
				'add_new_item' => 'Add New Design Project', // the "add new" menu item text
				'edit' => 'Edit', // the "edit" menu item
				'edit_item' => 'Edit Design Project', // the "edit" menu item text
				'new_item' => 'New Design Project', // the "new item" text
				'view_item' => 'View Design Project', // the "view item" text
				'search_items' => 'Search Design Project', // the "search item" text
				'not_found' =>  'Nothing found in the Database.', // the "not found" text
				'not_found_in_trash' => 'Nothing found in Trash', // the "not found in trash" text
				'parent_item_colon' => ''
			),
			'description' => 'Past Design Works/Pieces created by our design team.',
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 9,
			'menu_icon' => 'dashicons-schedule',
			'rewrite' => array(
				'slug' => 'past-work',
				'with_front' => false
			),
			'has_archive' => 'past-work',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'
			)
		)
	);
}
add_action('init', 'cpt_past_design_work');
?>
