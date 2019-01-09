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
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/admin/class-pilot-configurator-admin.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/class-inno-oppiva-login.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/inno-user-roles.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/match-algorithm.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/class-page-templater.php';

require PILOT_CONFIGURATOR_DIR_PATH . 'includes/pages/company-view.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/pages/create-product-information.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/pages/splashes.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/pages/questionforms.php';

require PILOT_CONFIGURATOR_DIR_PATH . 'includes/shortcodes/splash-screen-shortcode.php';
require PILOT_CONFIGURATOR_DIR_PATH . 'includes/shortcodes/questionform-shortcode.php';

require PILOT_CONFIGURATOR_DIR_PATH . 'lib/helpers-ajax.php';

add_shortcode( 'pilotcfg_any_splash', 'pilotcfg_any_splash' );
add_shortcode( 'pilotcfg_questionform', 'pilotcfg_questionform' );

register_activation_hook (__FILE__, 'add_inno_user_roles');
register_deactivation_hook (__FILE__, 'remove_inno_user_roles');

require_once (dirname(__FILE__) . '/includes/createdb.php');
require_once (dirname(__FILE__) . '/includes/destroydb.php');

register_activation_hook (__FILE__, 'jal_install');
register_uninstall_hook( __FILE__, 'jal_uninstall' );

/**
  * Inno-Oppiva platform login system initialization commands
  *
  */
function inno_oppiva_init() {
  $inno_oppiva_login = new Inno_Oppiva\Inno_Oppiva_Login();
  $inno_oppiva_login->init();
}



remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

register_activation_hook (__FILE__, 'create_questionforms');
register_activation_hook (__FILE__, 'create_splashes');
register_activation_hook (__FILE__, 'create_product_information');
register_deactivation_hook (__FILE__, 'remove_questionforms');
register_deactivation_hook (__FILE__, 'remove_splashes');
register_deactivation_hook (__FILE__, 'remove_product_information');


// Registering PHP functions for the ajax functions
add_action('wp_ajax_list_active_companies', 'list_active_companies');
add_action('wp_ajax_school_question_insert', 'school_question_insert');
add_action('wp_ajax_company_question_insert', 'company_question_insert');
add_action('wp_ajax_company_id_cookie_set', 'company_id_cookie_set');


register_activation_hook (__FILE__, 'ajax_test_enqueue_scripts');
add_action( 'wp_enqueue_scripts', 'ajax_test_enqueue_scripts');

// Funtion that adds needed scripts and stylesheets
function ajax_test_enqueue_scripts() {

	// The scripts and stylesheet for questionform slider initialization
	wp_enqueue_style(' bootstrap_style', plugins_url( 'includes/javascript/bootstrap-slider/css/bootstrap.min.css', __FILE__ ));
	wp_enqueue_style(' sliders_style', plugins_url( 'includes/javascript/bootstrap-slider/css/bootstrap-slider.css', __FILE__ ));
	wp_enqueue_script( 'sliders_main', plugins_url( 'includes/javascript/bootstrap-slider/bootstrap-slider.js', __FILE__ ), array( 'jquery' ));
	wp_localize_script( 'slidersmain', 'mainsliders', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
	));
	wp_enqueue_script( 'sliders', plugins_url( 'includes/javascript/sliders.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_localize_script( 'slidersown', 'ownmainsliders', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
	));

	// The script for questionform button functions
	wp_enqueue_script( 'questionform_functions', plugins_url( 'includes/javascript/questionform_functions.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_localize_script( 'questionform_functions', 'questionFormFunctions', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
	));

	//The script for listing the company products in school splash screens
	wp_enqueue_script( 'companyLister', plugins_url( 'includes/javascript/companyLister.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_localize_script( 'companyLister', 'company_lister', array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
	));

}

function page_templater_init() {
	$page_templater = new Inno_Oppiva\Page_Templater();
	$page_templater->init();
}

register_activation_hook (__FILE__, 'create_company_view');
register_deactivation_hook (__FILE__, 'remove_company_view');

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
page_templater_init();
pilot_configurator_init();
