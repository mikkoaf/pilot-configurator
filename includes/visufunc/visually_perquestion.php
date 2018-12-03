<?php

function printPerQ($table) {

//$svar1 = "SELECT school_answer_value FROM '$table' WHERE keygen=2";
//$svar2 = "SELECT school_answer_value FROM '$table' WHERE keygen=2";
//$svar3 = "SELECT school_answer_value FROM '$table' WHERE keygen=3";
//$svar4 = "SELECT school_answer_value FROM '$table' WHERE keygen=4";
//$svar5 = "SELECT school_answer_value FROM '$table' WHERE keygen=5";
$cvar1 = (int)$table[0]->company_answer_value;
//$cvar2 = "SELECT company_answer_value FROM '$table' WHERE keygen=2";
//$cvar3 = "SELECT company_answer_value FROM '$table' WHERE keygen=3";
//$cvar4 = "SELECT company_answer_value FROM '$table' WHERE keygen=4";
//$cvar5 = "SELECT company_answer_value FROM '$table' WHERE keygen=5";
$counter = 0;


	echo '<div style="width: 600px; height: 300px;" id="graph"></div>
<script>
    Plotly.plot("graph", [{
	displayModeBar: false,	
  type: "bar",
  name: "haluttu",
  x: [' . json_encode($cvar1) . ',2,2,2],
  base: [5-' . json_encode($cvar1) . ',2.2,1],
  y: ["setti1","setti2","setti3", "setti4"],
  marker: {
    color: ["rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)"]
  },
  orientation: "h",
  offset: 0
},{
	displayModeBar: false,
  type: "bar",
  x: [0.05,0.05,0.05,0.05],
  name: "vastattu",
  base: [3,2,3,2],
  y: ["setti1","setti2","setti3", "setti4"],
  marker: {
    color: ["orange", "orange", "orange", "orange"]
  },
  orientation: "h",
  offset: 0
}], {
	displayModeBar: false,
  yaxis: {
    autorange: "reversed"
  }
}, {displayModeBar: false})                             
</script>';
	$counter = $counter + 1;
}


?>
