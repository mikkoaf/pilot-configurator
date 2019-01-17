<?php

function printPerQTest($carr, $sarr) {

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
