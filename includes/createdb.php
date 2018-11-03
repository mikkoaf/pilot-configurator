<?php
function jal_install() {
	global $wpdb;
	
	$table_name1 = $wpdb->prefix . 'users';

	$table_name2 = $wpdb->prefix . 'Questions';
	
	$table_name3 = $wpdb->prefix . 'Company_answer';
	
	$table_name4 = $wpdb->prefix . 'School_answer';
	
	$charset_collate = $wpdb->get_charset_collate();
	
	
	$sql = "CREATE TABLE $table_name2(
		question_id INT(3) AUTO_INCREMENT,
		setti VARCHAR(20) NOT NULL,
		question VARCHAR(30) NOT NULL,
		theme VARCHAR(300),
		comment VARCHAR(300),
		PRIMARY KEY (question_id)
		);
		CREATE TABLE $table_name3(
		company_answer_id INT(3),
		wpuser_id BIGINT(20) UNSIGNED NOT NULL,
		question_id INT(3) NOT NULL,
		answer_max INT(1) NOT NULL,
		answer_min INT(1) NOT NULL,
		answer_val INT(1),
		comment VARCHAR(300),
		FOREIGN KEY (wpuser_id) REFERENCES $table_name1 (ID),
		FOREIGN KEY (question_id) REFERENCES $table_name2 (question_id),
		PRIMARY KEY (company_answer_id)
		);
		CREATE TABLE $table_name4(
		school_answer_id INT(3) NOT NULL,
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
}
function jal_install_data() {
	global $wpdb;
	
	$ulogin = 'Herwoodin koulu';
	$upass = 'herwood123';
	$nicename = 'Herwoodin koulu';
	$umail = 'herwoodkoulu@mymail.com';
	$status = 1;
	$displayname = 'Herwoodin koulu';
	
	
	$table_name1 = $wpdb->prefix . 'users';
	
	$wpdb->insert( 
		$table_name1, 
		array( 
			'user_login' => $ulogin, 
			'user_pass' => $upass,
			'user_nicename' => $nicename,
			'user_email' => $umail,
			'user_status' => $status,
			'display_name' => $displayname,
		) 
	);
    

    $ulogin1 = 'Teknologia Oy';
	$upass1 = 'teknologia123';
	$nicename1 = 'Teknologia Oy';
	$umail1 = 'teknologiaoy@teknologia.com';
	$status1 = 2;
	$displayname1 = 'Teknologia Oy';
	
	$table_name1 = $wpdb->prefix . 'users';

    $wpdb->insert( 
		$table_name1, 
		array( 
			'user_login' => $ulogin1, 
			'user_pass' => $upass1,
			'user_nicename' => $nicename1,
			'user_email' => $umail1,
			'user_status' => $status1,
			'display_name' => $displayname1,
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
			'theme' => $dunno,
		)
	);

	$cid = 1;
	$uid = 7;
	$qid = 6;
	$ans_max = 5;
	$ans_min = 3;

	$table_name3 = $wpdb->prefix . 'Company_answer';

	$wpdb->insert( 
		$table_name3, 
		array( 
			'company_answer_id' => $cid,
			'wpuser_id' => $uid,
			'question_id' => $qid,
			'answer_max' => $ans_max,
			'answer_min' => $ans_min,
		)
	);


	$sid = 1;
	$uidd = 6;
	$qidd = 6;
	$cidd = 1;
	$ans_val = 4;

	$table_name4 = $wpdb->prefix . 'School_answer';

	$wpdb->insert( 
		$table_name4, 
		array( 
			'school_answer_id' => $sid,
			'wpuser_id' => $uidd,
			'question_id' => $qidd,
			'company_answer_id' => $cidd,
			'answer_val' => $ans_val,
		)
	);
	
}
?>