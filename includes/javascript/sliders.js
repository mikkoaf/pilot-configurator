jQuery( document ).ready(function($) {
 
	if( $("#schoolQuestForm").length ){
		 var x = 0;
		 var y = 1;
		 var school = ".schoolSlider" + y;
		 while(x == 0){
			if ( $( school ).length ) {
		 
				$(school).slider({ min: 0, max: 5, value: 0, focus: true });

			}
			else{
				x = 1;
			}
			y = y + 1;
			school = ".schoolSlider" + y;
			 console.log(school);
		 }
	}
	
	if( $("#companyQuestForm").length ){
		 var x = 0;
		 var y = 1;
		 var companyDS = ".companyDS" + y;
		 var companySS = ".companySS" + y;
		 
		 while(x == 0){
			if ( $( companyDS ).length ) {
		 
				$(companyDS).slider({ min: 0, max: 5, value: [0, 5], focus: true });
				$(companySS).slider({ min: 0, max: 2, value: 0, focus: true });

			}
			else{
				x = 1;
			}
			y = y + 1;
			companyDS = ".companyDS" + y;
			companySS = ".companySS" + y;
			console.log(school);
		 }
	}
});