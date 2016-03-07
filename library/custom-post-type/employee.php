<?php
// ===== Custom Post Type - TriMark Employee
// ================================================================================

// Custom Post Type Definition
function cpt_employee() {
	register_post_type('employee',
		array(
			'labels' => array(
				'name' => 'Employees', // general name for post type, generally plural
				'singular_name' => 'Employee', // name for one object of this post type
				'all_items' =>'All Employees', // the "all items" text used in the menu
				'add_new' => 'Add New', // the "add new" menu item
				'add_new_item' => 'Add New Employee', // the "add new" menu item text
				'edit' => 'Edit', // the "edit" menu item
				'edit_item' => 'Edit Employee', // the "edit" menu item text
				'new_item' => 'New Employee', // the "new item" text
				'view_item' => 'View Employee', // the "view item" text
				'search_items' => 'Search Employee', // the "search item" text
				'not_found' =>  'Nothing found in the Database.', // the "not found" text
				'not_found_in_trash' => 'Nothing found in Trash', // the "not found in trash" text
				'parent_item_colon' => ''
			),
			'description' => 'TriMark Employee Profiles.',
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'menu_position' => 8,
			'menu_icon' => 'dashicons-groups',
			'rewrite' => array(
				'slug' => 'employee',
				'with_front' => false
			),
			'has_archive' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array(
				'title'
			)
		)
	);
}
add_action('init', 'cpt_employee');
?>
