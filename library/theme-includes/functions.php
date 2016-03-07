<?php

// ===== ACCESS CONTROL
// ================================================================================

// Determines if the user is a valid administrator.  Valid administrators can either be
// logged in or can come from a designated IP address.
function is_valid_administrator() {
	$valid_ip_list = array(
		'96.10.14.226',		// TriMark Office, Raleigh
		'174.106.245.120',	// Chris Jones, Southport
	);
	if(is_user_logged_in() || in_array($_SERVER['REMOTE_ADDR'], $valid_ip_list)) {
		return true;
	}
}



// ===== LINK TARGETING
// ================================================================================

// Generates a link target string based on the input parameter
function get_link_target($s) {
	return 'target-'.preg_replace("/[^a-z0-9.]+/i", "", strtolower($s));
}
?>
