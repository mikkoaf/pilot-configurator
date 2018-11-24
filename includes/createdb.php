<?php
function jal_install() {
	global $wpdb;
	
	$table_name1 = $wpdb->prefix . 'users';

	$table_name2 = $wpdb->prefix . 'Questions';
	
	$table_name3 = $wpdb->prefix . 'Company_answer';
	
	$table_name4 = $wpdb->prefix . 'School_answer';
	
	$charset_collate = $wpdb->get_charset_collate();
	
	
	$sql = "CREATE TABLE IF NOT EXISTS $table_name2(
		question_id INT(3) NOT NULL AUTO_INCREMENT,
		setti VARCHAR(20) NOT NULL,
		question VARCHAR(30) NOT NULL,
		theme VARCHAR(300),
		comment VARCHAR(300),
		PRIMARY KEY (question_id)
		)$charset_collate;";

	$sql1 = "CREATE TABLE IF NOT EXISTS $table_name3(
		company_answer_id INT(3) NOT NULL AUTO_INCREMENT,
		wpuser_id BIGINT(20) UNSIGNED NOT NULL,
		question_id INT(3) NOT NULL,
		answer_max INT(1) NOT NULL,
		answer_min INT(1) NOT NULL,
		answer_val INT(1),
		comment VARCHAR(300),
		FOREIGN KEY (wpuser_id) REFERENCES $table_name1 (ID),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		PRIMARY KEY (company_answer_id)
		)$charset_collate;";

	$sql2 =	"CREATE TABLE IF NOT EXISTS $table_name4(
		school_answer_id INT(3) NOT NULL AUTO_INCREMENT,
		wpuser_id BIGINT(20) UNSIGNED NOT NULL,
		question_id INT(3) NOT NULL,
		company_answer_id INT(3) NOT NULL,
		answer_val INT(1) NOT NULL,
		comment VARCHAR(300),
		FOREIGN KEY (wpuser_id) REFERENCES $table_name1 (ID),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		FOREIGN KEY (company_answer_id) REFERENCES $table_name3 (company_answer_id), 
		PRIMARY KEY (school_answer_id)
		)$charset_collate;";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	dbDelta( $sql1 );
	dbDelta( $sql2 );
}
?>
