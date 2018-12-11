<?php
/**
  * Class file for plugin core class
  *
  *
  * @package Pilot_Configurator
  */

namespace Inno_Oppiva;

if ( ! defined( 'ABSPATH' ) ) {
    die('Access Denied!');
}

require PILOT_CONFIGURATOR_DIR_PATH . 'includes/admin/pilot-admin.php';

if ( ! class_exists( 'Pilot_Configurator_Client' ) ) {

  class Pilot_Configurator_Client {
    private $plugin_name;
    public function __construct() {
      $this->plugin_name = 'pilot-configurator';
    }

    public function init() {
      //add actions here
      add_action('admin_menu', array( $this, 'register_admin_page' ));

    }

    public function register_admin_page() {
      add_menu_page(
        'Pilot Configurator',
        'Pilot Configurator Options',
        'administrator',
        'pilot_configurator',
        'pilot_admin_page_html'
      );
    }
  }
}
