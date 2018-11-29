jQuery(document).ready(function(event) {
	jQuery('.questionForm').submit(testSubmit);
	
	function testSubmit(){
		/*var pagepath = window.location.pathname;
		if( jQuery("#schoolQuestForm").length ){
			var pageelem = document.getElementById('schoolQuestForm');
		}
		if( jQuery("#companyQuestForm").length ){
			var pageelem = document.getElementById('companyQuestForm');
		}
		var pagenumber = parseInt(pageelem.dataset.pgnumber);
		var newpagenumber = pagenumber + 1;
		if (pagepath.includes("school_question")) {
			var newpage =  "https://wordpress.local/school_question" + newpagenumber; 
		}
		if (pagepath.includes("company_question")) {
			var newpage =  "https://wordpress.local/company_question" + newpagenumber; 
		}*/
		var testData = jQuery(this).serialize();
		console.log(testData);
		jQuery.ajax({
			
			url : testname.ajax_url,
			type : 'POST',
			data : {
					'action' : 'test_echo',
					'cont' : testData
			},
			success : function( response ) {
				console.log(response);
			}
		});
		return false;
	}

})