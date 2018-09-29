<?php
/**
Plugin Name: Pilot Configurator 
Plugin URI: 
Description: Pilot Configurator for providing matchmaking in the Inno-Oppiva project
Author: Mikko Ala-Fossi
Version: 0.0.1
Text Domain: pilot-configurator

-----------------

Glossary:

User - a WordPress user account

*/

namespace Inno_Oppiva;

// Deny direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
  die( ' Access denied!' );
}

/**
  * Define plugin settings as PHP globals.
  */
define( 'PILOT_CONFIGURATOR_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PILOT_CONFIGURATOR_PLUGIN_VERSION', '0.0.1' );

/**
  * Require plugin files. 
  *
  */

# require PILOT_CONFIGURATOR_DIR_PATH . 'includes/class-pilot-configurator.php';
# require PILOT_CONFIGURATOR_DIR_PATH . 'includes/admin/class-pilot-configurator-admin.php';


/**
  * Begins the execution of the plugin. Pilot_Configurator_Admin is required only when
  * currently in admin, but Pilot_Configurator needs to be initialized anyway.
  */
function pilot_configurator_init() {
  error_log( "Pilot Configurator is still under construction" );
  # $pilot_configurator = new Inno_Oppiva\Pilot_Configurator();
  # $pilot_configurator->init();

  if ( is_admin() ) {
    # $pilot_configurator_admin = new Inno_Oppiva\Admin\Pilot_Configurator_Admin();
    # $pilot_configurator_admin->init();
  }
}
pilot_configurator_init();
