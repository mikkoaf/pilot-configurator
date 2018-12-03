<?php

/*
 * The function that creates the questionaires from the database entries
 */

function createquestinaires()	{
	global $wpdb;
	require_once (dirname(__FILE__) . '/createpost/createpost.php');
	$settisets = $wpdb->get_results("SELECT DISTINCT question_set FROM wp_Questions");
	$amount = $wpdb->num_rows;
	$x = 1;
	foreach($settisets as $setti){
		$name = $setti->question_set;
		$results = $wpdb->get_results("SELECT * FROM wp_Questions WHERE question_set = '".$name."';");
		create_schoolquestions($results, $x, $amount);
		create_companyquestions($results, $x, $amount);
		$x = $x + 1;
	}
}

/*
 * Function that inserts the entries for company questionaires
 */
function company_question_insert(){
	global $wpdb;
	
	parse_str($_POST['cont'], $newarray);
	$uid = get_current_user_id();
	
	foreach($newarray as $key => $val){
		$namenumber = explode("_", $key);

		if($namenumber[0] == "cqans"){
			$minmax = explode(",", $val);
		}
		else{
			$wpdb->query(
		  "INSERT INTO wp_Company_answer VALUES 
		  (NULL, $uid, $namenumber[1], $minmax[1], $minmax[0], $val)
		  ");
		}
	}
	die();
}

/*
 * Function that inserts the entries for school questionaires (not yet implemented)
 */

function school_question_insert(){
	
	echo 'Not yet implemented';
	die();
}

/*
 * Function that lists the companies that have answered the questionaires and echos out their user_nicename (subject to change)
 */

function list_active_companies(){
	global $wpdb;
	
	
	$companies = $wpdb->get_results("SELECT DISTINCT company_id FROM wp_Company_answer");
	foreach($companies as $single){
		$company_name = $wpdb->get_var("SELECT user_nicename FROM wp_users WHERE ID = $single->company_id");
		echo $company_name;
		echo "\r\n";
	}
	die();
}

?>