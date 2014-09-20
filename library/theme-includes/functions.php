<?php

// ===== LINK TARGETING
// ================================================================================

// Generates a link target string based on the input parameter
function get_link_target($s) {
	return 'target-'.preg_replace("/[^a-z0-9.]+/i", "", strtolower($s));
}

?>
