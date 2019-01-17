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
