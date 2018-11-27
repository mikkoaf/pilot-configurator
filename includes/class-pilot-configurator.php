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
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/test-page.php';       // Test page code

if ( ! class_exists( 'Pilot_Configurator_Client' ) ) {

  class Pilot_Configurator_Client {
    private $plugin_name;
    public function __construct() {
      $this->plugin_name = 'pilot-configurator';
    }

    public function init() {
      //add actions here
      add_action('admin_menu', array( $this, 'register_admin_page' ));
	    add_action('admin_menu', array( $this, 'register_test_page' ));			// Test page code

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
	
	// Test page code
	 public function register_test_page() {
      add_menu_page(
        'Pilot Configurator test-page',
        'Pilot Configurator test',
        'administrator',
        'pilot_test',
        'pilot_test_page_html'
      );
    }
  }
}
