<?php
function jal_uninstall() {
	global $wpdb;

	$table_name2 = $wpdb->prefix . 'Questions';
	
	$table_name3 = $wpdb->prefix . 'Company_answer';
	
	$table_name4 = $wpdb->prefix . 'School_answer';

	$sql1 = "DROP TABLE IF EXISTS $table_name2;";
	$sql2 =	"DROP TABLE IF EXISTS $table_name3;";
	$sql3 =	"DROP TABLE IF EXISTS $table_name4;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$wpdb->query($sql1);
	$wpdb->query($sql2);
	$wpdb->query($sql3);

}
?>