jQuery( document ).ready(function($) {
	
	if( $("#schoolQuestForm").length ){
		 var x = 0;
		 var y = 1;
		 var school = ".schoolSlider" + y;
		 while(x == 0){
			if ( $( school ).length ) {
		 
				$(school).slider({ min: 1, max: 5, value: 3, focus: true });

			}
			else{
				x = 1;
			}
			y = y + 1;
			school = ".schoolSlider" + y;
		 }
	}
	
	if( $("#companyQuestForm").length ){
		 var x = 0;
		 var y = 1;
		 var companyDS = ".companyDS" + y;
		 var companySS = ".companySS" + y;
		 
		 while(x == 0){
			if ( $( companyDS ).length ) {
		 
				$(companyDS).slider({ id: "comDS", min: 1, max: 5, value: [1, 5], ticks:[1, 2, 3, 4, 5], ticks_labels: ["Eri mieltä", "", "", "", "Samaa mieltä"], focus: true,});
				$(companySS).slider({ class: "comSS", ticks:[1, 2, 3], ticks_labels: ["Ei tärkeä", "Tärkeä", "Hyvin Tärkeä"], tooltip: "hide", value: 2});

			}
			else{
				x = 1;
			}
			y = y + 1;
			companyDS = ".companyDS" + y;
			companySS = ".companySS" + y;
		 }
	}
});