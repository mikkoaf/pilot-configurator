<?php
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

function test_echo(){
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
?>