jQuery(document).ready(function(event) {
	jQuery('.questionForm').submit(testSubmit);
	
	/*
	 * Function that sends the form data to the corresponding PHP-function that inputs the form data into the database.
	 * Also after successfull database entry, redirects the user to the next part of the questionaire
	 */
	function testSubmit(){
		
		// Takes the current url-path to a variable
		var pagepath = window.location.pathname;
		
		// Checks wheter the page is a schoolquestionform or a companyquestionform
		if( jQuery("#schoolQuestForm").length ){
			var pageelem = document.getElementById('schoolQuestForm');
			var activefunction = 'school_question_insert';
		}
		
		if( jQuery("#companyQuestForm").length ){
			var pageelem = document.getElementById('companyQuestForm');
			var activefunction = 'company_question_insert';
		}
		
		// The questionsets are numbered so by adding to the pagenumber the script can create the new url.
		var pagenumber = parseInt(pageelem.dataset.pgnumber);
		var maxpages = parseInt(pageelem.dataset.maxpages);
		var newpagenumber = pagenumber + 1;
	if (newpagenumber <= maxpages ){	
		if (pagepath.includes("school_question")) {
			var newpage =  "https://wordpress.local/school_question" + newpagenumber; 
		}
		if (pagepath.includes("company_question")) {
			var newpage =  "https://wordpress.local/company_question" + newpagenumber; 
		}
	}else {
		if (pagepath.includes("school_question")) {
			var newpage =  "https://wordpress.local/school_splash"; 
		}
		if (pagepath.includes("company_question")) {
			var newpage =  "https://wordpress.local/company_splash"; 
		}
		
	}	
		// Ajax that sends the data to the corresponding PHP-function.
		
		var testData = jQuery(this).serialize();
		
		jQuery.ajax({
			
			url : questionFormFunctions.ajax_url,
			type : 'POST',
			data : {
					'action' : activefunction,
					'cont' : testData
			},
			success : function( response ) {
				console.log(response);
				// This redirects the page
				window.location.href = newpage;
			}
			});
		return false;
	}
	
	/*
	 * The function that is called when the back-button is pressed, just redirects the user to the previous questionset.
	 */

	jQuery('#back_button').click(function(e){
		
		/*
		 * This whole function is a copy and paste from the above function. Refer to that if questions arise.
		 */
		var pagepath = window.location.pathname;
		
		if( jQuery("#schoolQuestForm").length ){
			var pageelem = document.getElementById('schoolQuestForm');
		}
		
		if( jQuery("#companyQuestForm").length ){
			var pageelem = document.getElementById('companyQuestForm');
		}
		
		var pagenumber = parseInt(pageelem.dataset.pgnumber);
		var newpagenumber = pagenumber - 1;
		
		if (pagepath.includes("school_question")) {
			var newpage =  "https://wordpress.local/school_question" + newpagenumber; 
		}
		if (pagepath.includes("company_question")) {
			var newpage =  "https://wordpress.local/company_question" + newpagenumber; 
		}
		
		// This redirects the page
		window.location.href = newpage;
	});
	
});