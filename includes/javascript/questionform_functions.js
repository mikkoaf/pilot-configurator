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
    if ( jQuery("#schoolQuestForm").length ) {
        var pageelem = document.getElementById('schoolQuestForm');
        var activefunction = 'school_question_insert';
    }

    if ( jQuery("#companyQuestForm").length ) {
        var pageelem = document.getElementById('companyQuestForm');
        var activefunction = 'company_question_insert';
    }
// TODO: setting the user to the right page
      // The questionsets are numbered so by adding to the pagenumber the script can create the new url.
      var pagenumber = parseInt(pageelem.dataset.pgnumber);
      var maxpages = parseInt(pageelem.dataset.maxpages);
      var newpagenumber = pagenumber + 1;
			// TODO : what
    if (newpagenumber <= maxpages + 1 ) {
			var newpage = window.location.protocol;
			newpage = newpage + "//" + window.location.hostname + "/questionform";
    } else {
			var newpage = window.location.protocol;
			newpage = newpage + "//" + window.location.hostname + "/any_splash";

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
		var newpage = window.location.protocol + "//" + window.location.hostname + "/questionform";
		// This redirects the page
		window.location.href = newpage;
	});
	jQuery('#end_button').click(function(e){
		var newpage = window.location.protocol + "//" + window.location.hostname + "/any_splash";
		// This redirects the page
		window.location.href = newpage;
	});

});
