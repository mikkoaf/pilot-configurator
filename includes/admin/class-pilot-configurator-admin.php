<?php

namespace Inno_Oppiva\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    die('Access Denied');
}

if ( ! class_exists( 'Pilot_Configurator_Admin' ) ) {

  /**
  * Class Pilot_Configurator_Admin
  * This plugin handles most of the important tasks related to
  * Pilot Configurator admin tasks
  */

  class Pilot_Configurator_Admin {
    public function init() {
      //do initialization tasks ie. add_actions

      // create plugin settings if they don't exist
      if ( ! get_option('inno_oppiva_secret') ) {
        add_option('inno_oppiva_secret', 'no-secret-set');
      }
      if ( ! get_option('inno_oppiva_priorities') ) {
        add_option('inno_oppiva_priorities', array(
          1 => 2,
          5,
          10,
        ));
      }

      add_action('admin_init', 'pilot_admin_page_settings_init');
    }

  }
}

