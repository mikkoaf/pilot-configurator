jQuery( document ).ready(function($) {
	if( $("#company_list").length ){
		
		var companylist = document.getElementById("company_list");
		jQuery.ajax({
				
				url : company_lister.ajax_url,
				type : 'POST',
				data : {
						'action' : 'list_active_companies'
				},
				success : function( response ) {
					console.log(response);
					companylist.innerText = companylist.textContent = response;
				}
			});
		
	}
});