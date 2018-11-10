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

      // if no inno_oppiva_secret exist, create here -- move this elsewhere
      if(!get_option('inno_oppiva_secret')) add_option('inno_oppiva_secret', 'no-secret-set');

      add_action('admin_init', 'pilot_admin_page_settings_init');
    }

  }
}

