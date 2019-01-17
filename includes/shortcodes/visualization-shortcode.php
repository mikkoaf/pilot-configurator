<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Access Denied!' );
}

/*
 Prints all visualizations
*/
function pilotcfg_visualization() {

}

/*
* Prints charts gfrom other php-files.
* 1 is for bar graph
* 2 is for heat map
* 3 is for radarchart
* 4 is for the one with the many
*/

//Show first set of results
//Todo: add CID and SID as parameters

function printradarchart() {
	global $wpdb;
	$cid = $_POST['cid'];
	$sid = $_POST['sid'];
	//Heatmap ja per question toimii, mutta radar ei näy ajax kutsun kautta
	echo showresulttest2((int)$cid, (int)$sid);
	echo heatprint((int)$cid, (int)$sid);

	echo radarchart((int)$cid, (int)$sid);
}

function printeach() {
	global $wpdb;
	$scids = $wpdb->get_results("SELECT DISTINCT school_id, company_id FROM wp_School_answer");
	$i = 0;
	foreach ($scids as $results) {
		showresulttest2((int)$results->company_id, (int)$results->school_id);
		radarchart((int)$results->company_id, (int)$results->school_id);
	}
}

function showResults($sid, $cid) {
	global $wpdb;
	$sqls = $wpdb->get_results("SELECT * FROM wp_School_answer WHERE school_id=$school_id AND company_id=$company_id");
	$sqls = $wpdb->get_results("SELECT * FROM wp_Company_answer WHERE company_id=$company_id");
	printCharts(4, $sql);

	$x = 0;
	//Create array of school answer values
	foreach($sql as $schoolArray){
		$schoolData[] = (int)$schoolArray->school_answer_value;
	}
	//Create array of company answer values
	foreach($sql as $companyArray){
		$companyData[] = (int)$companyArray->company_answer_value;
	}

	printCharts(4, $schoolData, $companyData);

}

function showresulttest() {
		//filldata();
	global $wpdb;
	$sql = $wpdb->get_results("SELECT keygen, school, school_answer_value, company_answer_value FROM wp_Testing_visualisation");
	printCharts(4, $sql);

}
function showresulttest2($cid, $sid) {
	//filldata();
	global $wpdb;
	$sqls = $wpdb->get_results("SELECT answer_val FROM wp_School_answer WHERE school_id=$sid AND company_id=$cid");
	$sqlc = $wpdb->get_results("SELECT answer_min, answer_max FROM wp_Company_answer WHERE company_id=$cid");
	printCharts(4, $sqls, $sqlc, $cid, $sid);
}

//Show more, in-depth results
//Todo: add CID and SID as parameters
function filldata() {
	include_once PILOT_CONFIGURATOR_DIR_PATH . 'includes/test-page.php';
	create_data_base();
}

function radartester() {
	include_once PILOT_CONFIGURATOR_DIR_PATH . 'includes/match-algorithm.php';
	global $wpdb;
	$cid = 2;
	$sid = 6;
	$sqls = $wpdb->get_results("SELECT answer_val, question_id FROM wp_School_answer WHERE school_id=$sid AND company_id=$cid");
	$sqlc = $wpdb->get_results("SELECT answer_min, answer_max, question_id, answer_priority FROM wp_Company_answer WHERE company_id=$cid");

	$wp_query_result = $wpdb->get_results(
		"SELECT DISTINCT wp_School_answer.answer_val as answer, answer_max, answer_min, wp_Company_answer.answer_priority, wp_School_answer.question_id
		FROM wp_Company_answer, wp_School_answer
		WHERE wp_Company_answer.company_id=$cid
			AND wp_Company_answer.question_id=wp_School_answer.question_id
			AND wp_School_answer.school_id=$sid
			AND wp_School_answer.company_id=$cid
			AND wp_Company_answer.question_id<6
		ORDER BY question_id ASC");


	$category1 = match_alg($wp_query_result);
	echo $category1;

}
//Test numbers for radarchart
function radarchart ($cid, $sid) {
	include_once 'visually_radarchart3.php';
	global $wpdb;

	$category1 = getdb(1, $cid, $sid);
	$category2 = getdb(2, $cid, $sid);
	$category3 = getdb(3, $cid, $sid);
	$category4 = getdb(4, $cid, $sid);
	$category5 = getdb(5, $cid, $sid);

	echo printRadar($category1, $category2, $category3, $category4, $category5, $cid, $sid);
}

//called when calculating match% for category
function getdb($cat, $cid, $sid) {
	include_once PILOT_CONFIGURATOR_DIR_PATH . 'includes/match-algorithm.php';
	global $wpdb;
	$qidmin = 0;
	$qidmax = 0;
	if ($cat == 1) {
		$qidmin = 1;
		$qidmax = 5;
	}
	elseif ($cat == 2) {
		$qidmin = 6;
		$qidmax = 10;
	}
	elseif ($cat == 3) {
		$qidmin = 11;
		$qidmax = 15;
	}
	elseif ($cat == 4) {
		$qidmin = 16;
		$qidmax = 20;
	}
	elseif ($cat == 5) {
		$qidmin = 21;
		$qidmax = 23;
	}

	$wp_query_result = $wpdb->get_results(
		"SELECT DISTINCT wp_School_answer.answer_val as answer, answer_max, answer_min, wp_Company_answer.answer_priority, wp_School_answer.question_id
		FROM wp_Company_answer, wp_School_answer
		WHERE wp_Company_answer.company_id=$cid
			AND wp_Company_answer.question_id>=$qidmin
			AND wp_Company_answer.question_id<=$qidmax
			AND wp_Company_answer.question_id=wp_School_answer.question_id
			AND wp_School_answer.school_id=$sid
			AND wp_School_answer.company_id=$cid
		ORDER BY question_id ASC");

		return match_alg($wp_query_result);

}

function printCharts($chart, $sqls, $sqlc, $cid, $sid) {
	include_once 'visually_bargraph.php';
	include_once 'visually_heatmap.php';
	include_once 'visually_radarchart.php';
	include_once 'visually_perquestion.php';


	if ($chart == 1) {
		echo printBar(41, 10, 15, 16, 40);
	}
	elseif ($chart == 2) {
		echo printHeat();
	}
	elseif ($chart == 3) {
		echo printRadar(41, 10, 15, 16, 40);
	}
	elseif ($chart == 4) {
		echo printPerQ($sqls, $sqlc, $cid, $sid);
	}

}
?>
