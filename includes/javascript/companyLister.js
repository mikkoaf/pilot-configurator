jQuery( document ).ready(function($) {
	/*
	 * This function lists the companies that have answered the questionaire and outputs them to a element with id="company_list"
	 */
console.log('pootis');
	// Checks wheter the element exists
  if ( $("#company_list").length ) {

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
          companylist.innerHTML = response;
        }
          });

  }
});

function giveCompanyCookie(CID){

	// + '://' + window.location.hostname + 'school_question1'
	var pagepath = window.location.protocol;
	pagepath = pagepath + "//" + window.location.hostname + "/questionform";

	console.log(pagepath);
	jQuery.ajax({

      url : company_lister.ajax_url,
      type : 'POST',
      data : {
        'action' : 'company_id_cookie_set',
        'cont' : CID
      },
      success : function( response ) {
              console.log(response);
              window.location.href = response;
      }
		});

}
