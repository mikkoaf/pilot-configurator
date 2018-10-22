<?php
function createquestinaires()	{
	global $wpdb;
	require_once (dirname(__FILE__) . '/createpost/createpost.php');
	$settisets = $wpdb->get_results("SELECT DISTINCT question_set FROM wp_Questions");
	$x = 1;
	foreach($settisets as $setti){
		$name = $setti->question_set;
		$results = $wpdb->get_results("SELECT * FROM wp_Questions WHERE question_set = '".$name."';");
		create_schoolquestions($results, $x);
		create_companyquestions($results, $x);
		$x = $x + 1;
	}
}

function test_echo(){
	
	
	parse_str($_POST['cont'], $newarray);
	print_r($newarray);
	//foreach($data as $key => $value) {
	//echo $key . "<- : ->" . $value;
		//}
	die();
}
?>