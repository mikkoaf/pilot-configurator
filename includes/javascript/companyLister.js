jQuery( document ).ready(function($) {
	/*
	 * This function lists the companies that have answered the questionaire and outputs them to a element with id="company_list"
	 */
	
	// Checks wheter the element exists
	if( $("#company_list").length ){
		
		var companylist = document.getElementById("company_list");
		jQuery.ajax({
				
				url : company_lister.ajax_url,
				type : 'POST',
				data : {
						// Calls the PHP-function that lists the companies.
						'action' : 'list_active_companies'
				},
				success : function( response ) {
					// Replaces the element text with the companies
					companylist.innerText = companylist.textContent = response;
				}
			});
		
	}
});