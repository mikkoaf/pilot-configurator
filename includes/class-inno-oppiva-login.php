<?php
/** WIP
  */

namespace Inno_Oppiva;

if ( ! defined( 'ABSPATH' ) ) {
  die('Access Denied!');
}

if ( ! class_exists('Inno_Oppiva_Login') ) {

  class Inno_Oppiva_Login {
    private $plugin_name;
    public function __construct() {
      $this->plugin_name = 'pilot-configurator';
    }

    public function init() {
      // add login related actions here
      add_action( 'wp_login', array( $this, 'inno_oppiva_cookie_set' ), 10, 2 );
      add_action( 'wp_logout', array( $this, 'inno_oppiva_cookie_clear' ), 10, 2 );
      add_action( 'wp_login', array( $this, 'inno_oppiva_redirect_to_splash' ), 10, 2 );
	  //add_action('wp_login', array( $this, 'company_check_productpage' ), 10, 2);
    }

    public function inno_oppiva_cookie_set( $user_login, $user ) {
      // set cookie for relevant users
      if ( user_can( $user, 'company' ) || user_can( $user, 'school') || user_can( $user, 'administrator') ) {
        $salt  = get_option('inno_oppiva_secret');
        $some_user_information = $user->user_login . '.' . $user->roles[0];
        $some_user_information_hash = hash("sha256", $some_user_information . '.' . $salt);
        setcookie( 'inno-oppiva-login-cookie', $some_user_information_hash, time() + 3600, '/');
        setcookie( 'inno-oppiva-login-cookie-unhashed', $some_user_information . '.' . $salt, time() + 3600, '/');
      }
    }

    public function inno_oppiva_cookie_clear() {
      if ( isset( $_COOKIE['inno-oppiva-login-cookie'] ) ) {
        setcookie( 'inno-oppiva-login-cookie', '', -1, '/');
        setcookie( 'inno-oppiva-login-cookie-unhashed', '', -1, '/');
      }
    }

    public function inno_oppiva_redirect_to_splash( $user_login, $user ) {
      global $wpdb;
      $table_name = $wpdb->prefix . 'posts';
  
      if ( user_can( $user, 'company' ) ){
          $slug = 'company_splash';
          $result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
          wp_redirect(get_permalink($result[0]));
          exit;
      }
      else if (user_can( $user, 'school') ){
          $slug = 'school_splash';
          $result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
          wp_redirect(get_permalink($result[0]));
          exit;
      }

    }
	/*
	public function company_check_productpage( $user_login, $user){
		global $wpdb;
		
		if ( user_can( $user, 'company' ) ){
			
			$nicename = $wpdb->get_var("SELECT user_nicename FROM wp_users WHERE ID = $user->ID");
			$result = $wpdb->get_row("SELECT * FROM wp_posts WHERE post_name = $nicename");
			
			if( results == NULL ){
				require_once (dirname(__FILE__) . '/createpost/createpost.php');
				create_productpage( $nicename, $user->ID);
				exit;
			}
			exit;
		}
			
		exit;
	}
	*/
  }
}
