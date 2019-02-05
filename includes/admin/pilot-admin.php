<?php
function pilot_admin_page_html() {

  if ( ! current_user_can( 'administrator' ) ) {
    return;
  }
  ?>
	<script> 
		jQuery(document).ready(function(event) {
			jQuery('#compgen_button').click(function(e){
						
				var activefunction = "company_csv_gen";
				
				jQuery.ajax({

					url : ajaxurl,
					type : 'GET',
					data : {
					  'action' : activefunction
					},
					success : function( response ) {
						var file_path = response;
						var a = document.createElement('A');
						a.href = file_path;
						a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
						document.body.appendChild(a);
						a.click();
						document.body.removeChild(a);
					}
				});
			});
			jQuery('#schoolgen_button').click(function(e){
						
				var activefunction = "school_csv_gen";
				
				jQuery.ajax({

					url : ajaxurl,
					type : 'GET',
					data : {
					  'action' : activefunction
					},
					success : function( response ) {
						var file_path = response;
						var a = document.createElement('A');
						a.href = file_path;
						a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
						document.body.appendChild(a);
						a.click();
						document.body.removeChild(a);
					}
				});
			});
		});
	</script>
  <div class="wrap">
    <h1>Ylläpitäjän työkalut</h1>

    <form name="post" action="/view_results" method="post">
      <fieldset>
        <legend><h2>Yritysten tulosten katsaus</h2></legend>
        <p>
          <label>Valitse yritys</label>
          <select name="company_view_for_admin">

            <?php
            $companies = get_users( array( 'role' => 'company' ) );
            foreach ( $companies as $company ) {
              echo '<option value="' . $company->ID . '">' . $company->data->user_login . '</option>';
            }
            ?>

          </select>
        </p>
      </fieldset>
      <input type="submit" value="Yrityksen tuloksiin" >
    </form>

    <form name="post" action="/view_results" method="post">
      <fieldset>
        <legend><h2>Koulujen tulosten katsaus</h2></legend>
        <p>
          <label>Valitse koulu</label>
          <select name="school_view_for_admin">

            <?php
            $schools = get_users( array( 'role' => 'school' ) );
            foreach ( $schools as $school ) {
              echo '<option value="' . $school->ID . '">' . $school->data->user_login . '</option>';
            }
            ?>

          </select>
        </p>
      </fieldset>
      <input type="submit" value="Koulun tuloksiin" >
    </form>
	
	<form name="csvgencomp">
		<legend><h2>Lataa yhtiöiden .csv</h2></legend>
		<input type="button" id="compgen_button" value="Lataa">
	</form>
	<form name="csvgenschool">
		<legend><h2>Lataa koulujen .csv</h2></legend>
		<input type="button" id="schoolgen_button" value="Lataa">
	</form>

    <h1>Ylläpito asetukset</h1>
    <form action="options.php" method="post">
      <?php
         settings_fields('pilot_configurator_settings');
         do_settings_sections('pilot_configurator');
         submit_button('Tallenna asetukset');
      ?>
    </form>
  </div>
  <?php

}

function pilot_admin_page_settings_init() {
  register_setting('pilot_configurator_settings', 'inno_oppiva_secret');
  register_setting('pilot_configurator_settings', 'inno_oppiva_priorities');

  // register 'settings_priority_section' section on the 'pilot_configurator' page
  add_settings_section(
    'settings_priority_section',
    'Kysymysten arvot',
    'settings_priority_section_cb',
    'pilot_configurator'
  );

  // register 'settings_security_section' section on the 'pilot_configurator' page
  add_settings_section(
    'settings_security_section',
    'Tietoturva asetukset',
    'settings_security_section_cb',
    'pilot_configurator'
  );

  // create the 'settings_priority_section' section
  function settings_priority_section_cb( $args ) {
    ?>
    <p><?php esc_html_e('Painoarvot kysymysten tärkeydelle', 'pilot_configurator'); ?></p>
    <?php
  }

  // create the 'settings_security_section' section
  function settings_security_section_cb( $args ) {
    ?>
    <p><?php esc_html_e('Ylläpidon tietoturva asetukset', 'pilot_configurator'); ?></p>
    <?php
  }

  // register 'settings_priority_value_#' field in the "settings_priority_section" section
  add_settings_field(
    'settings_priority_value_1',
    '"Ei tärkeä"',
    'setting_priority_1_cb',
    'pilot_configurator',
    'settings_priority_section'
    );
  add_settings_field(
    'settings_priority_value_2',
    '"Tärkeä"',
    'setting_priority_2_cb',
    'pilot_configurator',
    'settings_priority_section'
    );
  add_settings_field(
    'settings_priority_value_3',
    '"Hyvin tärkeä"',
    'setting_priority_3_cb',
    'pilot_configurator',
    'settings_priority_section'
    );

  // register 'settings_security_secret' field in the "settings_security_section" section
  add_settings_field(
  'settings_security_secret',
  'Salainen hash suola (inno_oppiva_secret)',
  'setting_string_cb',
  'pilot_configurator',
  'settings_security_section'
  );

  // create a text box
  function setting_string_cb() {
    $options = get_option('inno_oppiva_secret');
    echo "<input id='inno_oppiva_secret' name='inno_oppiva_secret' size='40' type='text' value='{$options}' />";
  }

  // create text boxes for number input
  function setting_priority_1_cb() {
    $options = get_option('inno_oppiva_priorities');
    echo "<input id='inno_oppiva_secret' name='inno_oppiva_priorities[1]' size='3' type='number' step='1' value='{$options['1']}' />";
  }
  function setting_priority_2_cb() {
    $options = get_option('inno_oppiva_priorities');
    echo "<input id='inno_oppiva_secret' name='inno_oppiva_priorities[2]' size='3' type='number' step='1' value='{$options['2']}' />";
  }
  function setting_priority_3_cb() {
    $options = get_option('inno_oppiva_priorities');
    echo "<input id='inno_oppiva_secret' name='inno_oppiva_priorities[3]' size='3' type='number' step='1' value='{$options['3']}' />";
  }

}
function company_csv_gen(){
	  
	  global $wpdb;
	  
	  $results = $wpdb->get_results(
	  "SELECT us.user_nicename AS 'Yhtiön nimi', qu.question AS 'Kysymys', ca.answer_max AS 'Parhaan raja', ca.answer_min AS 'Toivottu raja', ca.answer_priority AS 'Kysymyksen prioriteetti'
	   FROM wp_Company_answer AS ca
	   LEFT OUTER JOIN wp_users AS us ON ca.company_id = us.ID
	   INNER JOIN wp_Questions AS qu ON ca.question_id = qu.question_id;",ARRAY_A);
	
	  if (empty($results)) {
		return;
	  }

	  $csv_output = '"'.implode('","',array_keys($results[0])).'"';

	  foreach ($results as $row) {
		$csv_output .= "\r\n".'"'.implode('","',$row).'"';
	  }

	  $file = "company_csv.csv";
	  file_put_contents($file, $csv_output );
	  header("Content-type: text/csv; charset=utf-8");
	  header("Content-disposition: csv" . date("Y-m-d") . ".csv");
	  header('Content-Disposition: attachment; filename="'. basename($file) .'";');

	  echo $file;
	  die();
}
function school_csv_gen(){
	  
	  global $wpdb;
	  
	  $results = $wpdb->get_results("SELECT us.user_nicename AS 'Koulun nimi', 
		    (SELECT DISTINCT us.user_nicename FROM wp_School_answer AS sc INNER JOIN wp_users AS us ON sc.company_id = us.ID) AS 'Yhtiön nimi',
		    qu.question AS 'Kysymys', sc.answer_val AS 'Vastaus'
			FROM wp_School_answer AS sc
			LEFT OUTER JOIN wp_users AS us ON sc.school_id = us.ID
			INNER JOIN wp_Questions AS qu ON sc.question_id = qu.question_id
			ORDER BY us.user_nicename;",ARRAY_A);
	
	  if (empty($results)) {
		return;
	  }

	  $csv_output = '"'.implode('","',array_keys($results[0])).'"';

	  foreach ($results as $row) {
		$csv_output .= "\r\n".'"'.implode('","',$row).'"';
	  }

	  $file = "school_csv.csv";
	  file_put_contents($file, $csv_output );
	  header("Content-type: text/csv; charset=utf-8");
	  header("Content-disposition: csv" . date("Y-m-d") . ".csv");
	  header('Content-Disposition: attachment; filename="'. basename($file) .'";');

	  echo $file;
	  die();
}
?>
