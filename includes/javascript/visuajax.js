jQuery(document).ready(function($){
    $('.results').click(function(){
		var $this = $(this);
		var cid = $this.data('cid');
		var sid = $this.data('sid');
		var element = document.getElementById(sid);
		console.log(element);
		
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