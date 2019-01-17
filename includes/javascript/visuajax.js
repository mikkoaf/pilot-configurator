jQuery(document).ready(function($){
    console.log('visuajax ready');
    $('.results').click(function(){
		var cid = $(this).data('cid');
		var sid = $(this).data('sid');
		var element = document.getElementById("company_"+cid);
    var marksCanvas = document.getElementById("marksChartcompany_"+cid);
    radarChart(marksCanvas);


		$.ajax({
			url: visuAjax.ajax_url,
			dataType: 'html',
			type: 'POST',
			data: {
				'action' : 'printradarchart',
				'cid' : cid,
				'sid' : sid
			},
			success : function(response){
				console.log(response);
				element.innerHTML = response;

			}
		});

	});
	function evalJSFromHtml(html) {
  var newElement = document.createElement('div');
  newElement.innerHTML = html;

  var scripts = newElement.getElementsByTagName("script");
  for (var i = 0; i < scripts.length; ++i) {
    var script = scripts[i];
    eval(script.innerHTML);
  }
}

});


function radarChart(marksCanvas){

  console.log('canvas');
  console.log(marksCanvas);
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
    data: [10,10,13,14,15]
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
}
