<?php

$var1 = 1;
$var5 = 2;
$var4 = 3;
$var3 = 4;
$var2 = 5;
$counter = 0;

while($counter < 3) {
echo '<div style="width: 200px; height: 200px;"><canvas id="chart" width="50px" height="50px"></canvas></div>
<div style="width: 400px; height: 400px;"><canvas id="myChart2" width="50px" height="50px"></canvas></div>
<script>
var num1 = ' . json_encode($var1) . ';
var num2 = ' . json_encode($var2) . ';
var num3 = ' . json_encode($var3) . ';
var num4 = ' . json_encode($var4) . ';
var num5 = ' . json_encode($var5) . ';
var ctx = document.getElementById("chart");
var myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["setti1", "setti2", "setti3", "setti4", "setti5"],
        datasets: [{
            label: "Bar",
            data: [num1, num2, num3, num4, num5],
            backgroundColor: [
                "rgba(255, 99, 132, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
                "rgba(255,99,132,1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<script>
var ctx = document.getElementById("myChart2");
var myChart = new Chart(ctx, {
    type: "radar",
    data: {
        labels: ["setti1", "setti2", "setti3", "setti4", "setti5"],
        datasets: [{
            label: "Radar",
            data: [20, 23, 12, 10, 15],
            backgroundColor: [
                "rgba(255, 99, 132, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
                "rgba(255,99,132,1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});
</script>';
$var1 = $var1 + 1;
$var5 = $var5 + 1;
$var4 = $var4 + 1;
$var3 = $var3 + 1;
$var2 = $var2 + 1;
$counter = $counter + 1;
}
?>