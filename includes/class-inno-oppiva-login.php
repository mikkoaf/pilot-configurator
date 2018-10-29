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
    }

    public function inno_oppiva_cookie_set( $user_login, $user ) {
      // if the user is a company, set the cookie
      if ( user_can( $user, 'company' ) ) {
        $value = 'Some super secret';
        setcookie( 'inno-oppiva-login-cookie', $value, time() + 3600, '/');
      }

    }
  }
}
