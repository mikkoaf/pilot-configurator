<?php
function filldb() {

global $wpdb;

$wpdb->insert(

	'wp_Testing_visualisation',
	array(
		'school'				=> 1,
		'school_answer_value'	=> 2,
		'company_answer_value'	=> 5
	)



);


}

function wipedb() {
	global $wpdb;
	$table  = $wpdb->prefix . 'wp_Testing_visualisation';
	$wpdb->query("TRUNCATE TABLE `wp_table_name`");
}

?>
