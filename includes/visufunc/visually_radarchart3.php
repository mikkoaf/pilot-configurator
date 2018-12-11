<?php

function printRadar($num1, $num2, $num3, $num4, $num5, $cid, $sid) {
$hiddennum = 100;
$var1 = 14;
$var5 = 14;
$var4 = 45;
$var3 = 30;
$var2 = 25;
$counter = 0;


	echo '
	<canvas id="marksChart' . json_encode($cid) . '+' . json_encode($sid) . '" width="600" height="400"></canvas>
	<script>var marksCanvas = document.getElementById("marksChart' . json_encode($cid) . '+' . json_encode($sid) . '");
Chart.defaults.global.defaultFontSize = 18;
var marksData = {
  labels: ["setti1", "setti2", "setti3", "setti4", "setti5"],
  datasets: [{
    label: "Koulu",
    backgroundColor: "transparent",
    borderColor: "rgba(200,0,0,0.6)",
    fill: false,
    radius: 6,
    pointRadius: 6,
    pointBorderWidth: 3,
    pointBackgroundColor: "orange",
    pointBorderColor: "rgba(200,0,0,0.6)",
    pointHoverRadius: 10,
    data: [' . json_encode($num1) . ',
			' . json_encode($num2) . ',
			' . json_encode($num3) . ',
			' . json_encode($num4) . ',
			' . json_encode($num5) . ']
  }]
};
var chartOptions = {
  scale: {
    ticks: {
      beginAtZero: true,
      min: 0,
      max: 100,
      stepSize: 20
    },
    pointLabels: {
      fontSize: 18
    }
  },
  legend: {
    position: "left"
  }
};
var radarChart = new Chart(marksCanvas, {
  type: "radar",
  data: marksData,
  options: chartOptions
});</script>';
	$var1 = $var1 + 1;
	$var5 = $var5 + 1;
	$var4 = $var4 + 1;
	$var3 = $var3 + 1;
	$var2 = $var2 + 1;
	$counter = $counter + 1;
}


?>
