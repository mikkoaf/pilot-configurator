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

#namespace Inno_Oppiva;

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

require PILOT_CONFIGURATOR_DIR_PATH . 'includes/class-pilot-configurator.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/visufunc/visufunc.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/admin/class-pilot-configurator-admin.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/class-inno-oppiva-login.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/inno-user-roles.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/match-algorithm.php';

register_activation_hook (__FILE__, 'add_inno_user_roles');
register_deactivation_hook (__FILE__, 'remove_inno_user_roles');

require_once (dirname(__FILE__) . '/includes/createdb.php');
require_once (dirname(__FILE__) . '/includes/destroydb.php');
//require_once (dirname(__FILE__) . '/includes/filldb.php');

register_activation_hook (__FILE__, 'jal_install');
//register_activation_hook (__FILE__, 'filldb');
register_uninstall_hook( __FILE__, 'jal_uninstall' );
//register_deactivation_hook( __FILE__, 'wipedb' );


 function wpb_adding_scripts() {
	 wp_register_script('chart', plugin_dir_url(__FILE__) . '/includes/visufunc/Chart.js', false);
	 wp_register_script('chart2', plugin_dir_url(__FILE__) . '/includes/visufunc/Chart.min.js', false);
	 wp_enqueue_script('chart');
	 wp_enqueue_script('chart2');
	 wp_enqueue_script('heatmap', 'https://cdn.plot.ly/plotly-latest.min.js', array(),  true);
	 wp_enqueue_script('jquery');
 }
 
 function wpd_adding_scripts2() {
	 wp_register_script('radarChart', plugin_dir_url(__FILE__) . 'radarChart.js', false);
	 
	 wp_enqueue_script('radarChart');
	 
 }
 
 add_action('wp_enqueue_scripts', 'wpb_adding_scripts');
/**
  * Inno-Oppiva platform login system initialization commands
  *
  */
function inno_oppiva_init() {
  $inno_oppiva_login = new Inno_Oppiva\Inno_Oppiva_Login();
  $inno_oppiva_login->init();
}

require (dirname(__FILE__) . '/includes/questionaire-creation.php');
require (dirname(__FILE__) . '/includes/splash_creation/create_splash.php');


//register_activation_hook (__FILE__, 'createquestinaires');
register_activation_hook (__FILE__, 'create_splashes');

/**
  * Begins the execution of the plugin. Pilot_Configurator_Admin is required only when
  * currently in admin, but Pilot_Configurator needs to be initialized anyway.
  */
function pilot_configurator_init() {

  $pilot_configurator_client = new Inno_Oppiva\Pilot_Configurator_Client();
  $pilot_configurator_client->init();

  if ( is_admin() ) {
    $pilot_configurator_admin = new Inno_Oppiva\Admin\Pilot_Configurator_Admin();
    $pilot_configurator_admin->init();
  }
}
inno_oppiva_init();
pilot_configurator_init();
