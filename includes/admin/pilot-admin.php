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
            echo("Current inno_oppiva_secret is " . get_option('inno_oppiva_secret') . "\n");
            
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

  // register 'settings_security_section' section on the 'pilot_configurator' page
  add_settings_section(
    'settings_security_section',
    'Security options',
    'settings_security_section_cb',
    'pilot_configurator'
  );

  // create the 'settings_security_section' section
  function settings_security_section_cb($args) {
    ?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Security options for administrator', 'pilot_configurator'); ?></p>
    <?php
  }

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
}
