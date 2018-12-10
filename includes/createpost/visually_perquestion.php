<?php

function printPerQ($num1, $num2, $num3, $num4, $num5) {

$var1 = 14;
$var5 = 14;
$var4 = 45;
$var3 = 30;
$var2 = 25;
$counter = 0;


	echo '<div style="width: 600px; height: 300px;" id="graph"></div>
<script>
    Plotly.plot("graph", [{
  type: "bar",
  name: "haluttu",
  x: [3,2,2,2],
  base: [2,1.1,2.2,1],
  y: ["setti1","setti2","setti3", "setti4"],
  marker: {
    color: ["rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(255, 99, 132, 0.2)"]
  },
  orientation: "h",
  offset: 0
},{
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
  yaxis: {
    autorange: "reversed"
  }
})                             
</script>';
	$var1 = $var1 + 1;
	$var5 = $var5 + 1;
	$var4 = $var4 + 1;
	$var3 = $var3 + 1;
	$var2 = $var2 + 1;
	$counter = $counter + 1;
}


?>
