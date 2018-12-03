<?php

 function wpb_adding_scripts() {
	 wp_register_script('chart', plugin_dir_url(__FILE__) . 'Chart.js', false);
	 wp_register_script('chart2', plugin_dir_url(__FILE__) . 'Chart.min.js', false);
	 wp_enqueue_script('chart');
	 wp_enqueue_script('chart2');
	 wp_enqueue_script('heatmap', 'https://cdn.plot.ly/plotly-latest.min.js', array(),  true);
	 wp_enqueue_script('jquery');
 }
 
 function wpd_adding_scripts2() {
	 wp_register_script('radarChart', plugin_dir_url(__FILE__) . 'radarChart.js', false);
	 
	 wp_enqueue_script('radarChart');
	 
 }
 
 add_action('wp_enqueue_scripts', 'wpb_adding_scripts');


/*
* Prints charts gfrom other php-files.
* 1 is for bar graph
* 2 is for heat map
* 3 is for radarchart
* 4 is for the one with the many
*/

//Show first set of results
//Todo: add CID and SID as parameters
/*
function showResults() {
	global $wpdb;
	$sql = $wpdb->get_results("SELECT keygen, school, school_answer_value, company_answer_value FROM wp_Testing_visualisation");
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
*/
function showresulttest() {
	include_once 'visually_perqtester.php';
	$carr[] = 1;
	$carr[] = 3;
	$carr[] = 5;
	$carr[] = 5;
	$carr[] = 4;
	$sarr[] = 1;
	$sarr[] = 3;
	$sarr[] = 3;
	$sarr[] = 2;
	$sarr[] = 1;
	echo printPerQTest($carr, $sarr);
}

//Show more, in-depth results
//Todo: add CID and SID as parameters
function showMoreResults() {
	
}


function printCharts($chart, $table) {
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
		echo printPerQ($table);
	}
	
}
?>
