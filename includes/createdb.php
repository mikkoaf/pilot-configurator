<?php
function jal_install() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'Users';
		
	$table_name2 = $wpdb->prefix . 'Questions';
	
	$table_name3 = $wpdb->prefix . 'Company_answer';
	
	$table_name4 = $wpdb->prefix . 'School_answer';
	
	$charset_collate = $wpdb->get_charset_collate();
	
	
	$sql = "CREATE TABLE $table_name(
		user_id INT(3) AUTO_INCREMENT,
		name VARCHAR(30) NOT NULL,
		status VARCHAR(30) NOT NULL,
		email VARCHAR(50),
		PRIMARY KEY (user_id)
		);
		CREATE TABLE $table_name2(
		question_id INT(3) AUTO_INCREMENT,
		setti VARCHAR(20S) NOT NULL,
		question VARCHAR(30) NOT NULL,
		theme VARCHAR(300),
		comment VARCHAR(300),
		PRIMARY KEY (question_id)
		);
		CREATE TABLE $table_name3(
		company_answer_id INT(3),
		user_id int(3) NOT NULL,
		question_id INT(3) NOT NULL,
		answer_max INT(1),
		answer_min INT(1),
		answer_val INT(1),
		comment VARCHAR(300),
		FOREIGN KEY (user_id) REFERENCES $table_name (user_id),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		PRIMARY KEY (company_answer_id)
		);
		CREATE TABLE $table_name4(
		school_answer_id INT(3) NOT NULL,
		user_id INT(3) NOT NULL,
		question_id INT(3) NOT NULL,
		answer INT(1),
		comment VARCHAR(300),
		FOREIGN KEY (user_id) REFERENCES $table_name (user_id),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		PRIMARY KEY (school_answer_id)
		)$charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
function jal_install_data() {
	global $wpdb;
	
	$name = 'Herwoodin koulu';
	$status = 'Koulu';
	$email = 'Herwoodinkoulu@herwoord.com';
	
	
	$table_name = $wpdb->prefix . 'Users';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'name' => $name, 
			'status' => $status,
			'email' => $email,
		) 
	);
    

    $name1 = 'Kauppisen maansiirto Oy';
	$status1 = 'Yritys';
	$email1 = 'kauppisen.maansiirto@tyoukko.com';
	
	$table_name = $wpdb->prefix . 'Users';

    $wpdb->insert( 
		$table_name, 
		array( 
			'name' => $name1, 
			'status' => $status1,
			'email' => $email1,
		) 
	);
	
	
	$settt = 'Yksityisia';
	$questii = 'Mika maa, mika paiva?';
	$dunno = 'Teema?';

	$table_name2 = $wpdb->prefix . 'Questions';

	$wpdb->insert( 
		$table_name2, 
		array( 
			'setti' => $settt,
			'question' => $questii,
			'theme' => $dunno
		)
	);
	$wpdb->insert( 
		'wp_Questions', 
		array( 
			'setti' => 'Yksityisia',
			'question' => 'Mis on mailman punaisimmat?',
			'theme' => 'Teema?'
		)
	);
}
?>