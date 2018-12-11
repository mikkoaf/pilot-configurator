<?php

function printRadaryy($num1, $num2, $num3, $num4, $num5) {
	echo'
	<canvas id="marksChart" width="600" height="400"></canvas>
	<script>
	var marksCanvas = document.getElementById("marksChart");

Chart.defaults.global.defaultFontSize = 18;

var marksData = {
  labels: ["setti1", "setti2", "setti3", "setti4", "setti5"],
  datasets: [{
    label: "koulu",
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
  }, {
    label: "Student B",
    backgroundColor: "transparent",
    borderColor: "rgba(0,0,200,0.6)",
    fill: false,
    radius: 6,
    pointRadius: 6,
    pointBorderWidth: 3,
    pointBackgroundColor: "cornflowerblue",
    pointBorderColor: "rgba(0,0,200,0.6)",
    pointHoverRadius: 10,
    data: [54, 65, 60, 70, 70]
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
});
</script>';
}


?>
