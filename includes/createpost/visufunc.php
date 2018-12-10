<?php


/*
* Prints charts gfrom other php-files.
* 1 is for bar graph
* 2 is for heat map
* 3 is for radarchart
* 4 is for the one with the many
*/



function printCharts($chart) {
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
		echo printPerQ(41, 10, 15, 16, 40);
	}
	
}
?>
