<?php
function pilot_admin_page_html() {

  if ( ! current_user_can( 'administrator' ) ) {
    return;
  }
  ?>
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
