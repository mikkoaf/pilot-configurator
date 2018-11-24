<?php
function pilot_admin_page_html() {

  if ( ! current_user_can( 'administrator' ) ) {
    return;
  }
  ?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
      <?php
            settings_fields('pilot_configurator_settings');
            do_settings_sections('pilot_configurator');
            
            submit_button('Save Settings');
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
    'Question value options',
    'settings_priority_section_cb',
    'pilot_configurator'
  );

  // register 'settings_security_section' section on the 'pilot_configurator' page
  add_settings_section(
    'settings_security_section',
    'Security options',
    'settings_security_section_cb',
    'pilot_configurator'
  );

  // create the 'settings_priority_section' section
  function settings_priority_section_cb($args) {
    ?>
    <p><?php esc_html_e('Multipliers for questions importance to a company (inno_oppiva_priorities)', 'pilot_configurator'); ?></p>
    <?php
  }

  // create the 'settings_security_section' section
  function settings_security_section_cb($args) {
    ?>
    <p><?php esc_html_e('Security options for administrator', 'pilot_configurator'); ?></p>
    <?php
  }

  // register 'settings_priority_value_#' field in the "settings_priority_section" section
  add_settings_field(
    'settings_priority_value_1',
    'PRIORITY_1_STRING',
    'setting_priority_1_cb',
    'pilot_configurator',
    'settings_priority_section'
    );
  add_settings_field(
    'settings_priority_value_2',
    'PRIORITY_2_STRING',
    'setting_priority_2_cb',
    'pilot_configurator',
    'settings_priority_section'
    );
  add_settings_field(
    'settings_priority_value_3',
    'PRIORITY_3_STRING',
    'setting_priority_3_cb',
    'pilot_configurator',
    'settings_priority_section'
    );

  // register 'settings_security_secret' field in the "settings_security_section" section
  add_settings_field(
  'settings_security_secret',
  'Secret hashing salt (inno_oppiva_secret)',
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
