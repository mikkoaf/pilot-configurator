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
	
	
});