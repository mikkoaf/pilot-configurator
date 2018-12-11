<?php

function printPerQTest($carr, $sarr) {

//$svar1 = "SELECT school_answer_value FROM '$table' WHERE keygen=2";
//$svar2 = "SELECT school_answer_value FROM '$table' WHERE keygen=2";
//$svar3 = "SELECT school_answer_value FROM '$table' WHERE keygen=3";
//$svar4 = "SELECT school_answer_value FROM '$table' WHERE keygen=4";
//$svar5 = "SELECT school_answer_value FROM '$table' WHERE keygen=5";
//$cvar1 = (int)$table[0]->company_answer_value;
//$cvar2 = "SELECT company_answer_value FROM '$table' WHERE keygen=2";
//$cvar3 = "SELECT company_answer_value FROM '$table' WHERE keygen=3";
//$cvar4 = "SELECT company_answer_value FROM '$table' WHERE keygen=4";
//$cvar5 = "SELECT company_answer_value FROM '$table' WHERE keygen=5";
$counter = 0;


	echo '<div style="width: 600px; height: 300px;" id="graph"></div>
	<script>
	/* Create arrays */
	var sarr = ' . json_encode($sarr) . ';
	var carr = ' . json_encode($carr) . ';
	var i;
	
    Plotly.plot("graph", [{
		
	for (i = 0; carr.length; i++) {
		displayModeBar: false,	
		type: "bar",
		name: "haluttu",
		x: [carr[i]],
		base: [5-carr[i]],
		y: ["kyssäri"],
		marker: {
			color: ["rgba(255, 99, 132, 0.2)"]
		},
		orientation: "h",
		offset: 0
		}
	},{
	for (i = 0; sarr.length; i++) {
		displayModeBar: false,	
		type: "bar",
		name: "vastattu",
		x: [0.05],
		base: [carr[i]],
		y: ["kyssäri"],
		marker: {
			color: ["orange"]
		},
		orientation: "h",
		offset: 0
		}
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
