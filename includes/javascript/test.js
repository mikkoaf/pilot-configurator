jQuery(document).ready(function(event) {
	jQuery('.questionForm').submit(testSubmit);
	
	function testSubmit(){
		var testData = jQuery(this).serialize();
		//testData = JSON.stringify(testData);
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
	
	//
})