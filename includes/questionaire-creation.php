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
		
		/*
		 * Calls the questioncreation functions with parameters: 
		 * - The database results of the questions
		 * - The number the set of questions
		 * - The number of questionsets in database
		 */
		create_schoolquestions($results, $x, $amount);
		create_companyquestions($results, $x, $amount);
		$x = $x + 1;
	}
}

function remove_questionaires(){
	global $wpdb;

	$table_name = $wpdb->prefix . 'posts';

	$slug = 'school_question%';
	$result = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE post_name LIKE '" . $slug . "'");
	
	foreach($result as $row){
		$id = $row->ID;
		wp_delete_post($id, true);
	}
	
	$slug = 'company_question%';
	$result = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE post_name LIKE '" . $slug . "%'");
	foreach($result as $row){
		$id = $row->ID;
		wp_delete_post($id, true);
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
			
			// Checks whether there already is a database entry, if it does exist it is only updated, if it doesnt it is created
			if($wpdb->get_row("SELECT * FROM wp_Company_answer WHERE company_id = $uid AND question_id = $namenumber[1]") == NULL){
				$wpdb->query(
			  "INSERT INTO wp_Company_answer VALUES 
			  (NULL, $uid, $namenumber[1], $minmax[1], $minmax[0], $val)
			  ");
			}
			else{
				$wpdb->update('wp_Company_answer', array('answer_max' => $minmax[1], 'answer_min' => $minmax[0], 'answer_priority' => $val), array('company_id' => $uid, 'question_id' => $namenumber[1]));
			}
		}
	}
	die();
}

/*
 * Function that inserts the entries for school questionaires (not yet implemented)
 */

function school_question_insert(){
	global $wpdb;
	
	parse_str($_POST['cont'], $newarray);
	$uid = get_current_user_id();
	$cookieVal = $_COOKIE['company-identification'];
	
	foreach($newarray as $key => $val){
		$namenumber = explode("_", $key);

		if($namenumber[0] == "sqans"){
			$schoolans = $val;
		}
		else{
			
			// Checks whether there already is a database entry, if it does exist it is only updated, if it doesnt it is created
			if($wpdb->get_row("SELECT * FROM wp_School_answer WHERE school_id = $uid AND question_id = $namenumber[1] AND company_id = $cookieVal") == NULL){
				$wpdb->query(
			  "INSERT INTO wp_School_answer VALUES 
			  (NULL, $uid, $namenumber[1], $cookieVal, $schoolans, '$val')
			  ");
			}
			else{
				$wpdb->update('wp_School_answer', array('answer_val' => $schoolans, 'comment' => $val), array('school_id' => $uid, 'question_id' => $namenumber[1], 'company_id' => $cookieVal));
			}
		}
	}
	
	die();
}

/*
 * Function that lists the companies that have answered the questionaires and echos out their user_nicename (subject to change)
 */

function list_active_companies(){
	global $wpdb;
	
	
	$companies = $wpdb->get_results("SELECT DISTINCT company_id FROM wp_Company_answer");
	$test = "";
	
	$test .= '<ul>';
	foreach($companies as $single){
		$id = $single->company_id;
		$company_name = $wpdb->get_var("SELECT user_nicename FROM wp_users WHERE ID = $single->company_id");
		$test .= '<li><a href="#" onclick="return giveCompanyCookie('.$id.')"> ' .$company_name. '</a></li>';
		$test .= "\r\n";
	}
	$test .= '</ul>';
	echo $test;
	die();
}

function company_id_cookie_set() {
	global $wpdb;
	$company_id = $_POST['cont'];
	
	$urlpath = get_site_url();
	$urlpath .= "/product-information";
	
    setcookie( 'company-identification', $company_id, time() + 3600, '/');
	echo $urlpath;
	die();
}

?>