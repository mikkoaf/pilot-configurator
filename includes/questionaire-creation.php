<?php
function createquestinaires()	{
	global $wpdb;
	require_once (dirname(__FILE__) . '/createpost/createpost.php');
	$settisets = $wpdb->get_results("SELECT DISTINCT setti FROM wp_Questions");
	$x = 1;
	foreach($settisets as $setti){
		$name = $setti->setti;
		$results = $wpdb->get_results("SELECT * FROM wp_Questions WHERE setti = '".$name."';");
		create_school_questions($results, $x);
		$x++;
	}
}

?>