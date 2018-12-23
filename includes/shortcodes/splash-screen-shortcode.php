<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Access Denied!' );
}
  error_log('Shortcodes added');

function pilotcfg_any_splash( $atts = [], $content = null, $tag = 'pilotcfg_any_splash' ) {
  ob_start();
  if ( ( !current_user_can( 'company') && !current_user_can('school') || current_user_can( 'administrator') ) ){
    echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
      <p>Sinulle ei vielä ole annettu järjestelmän omaa roolia, joten et voi käyttää kaikkia palvelun toimintoja</p>
      <p>Odottaessasi ylläpidon toimia, voisit kertoa profiilissa itsestäsi</p>
      <p>Palvelu tulee hyödyntämään kyseistä tietoa näyttäessäsi organisaatiotanne</p>';
  }

  if ( current_user_can( 'company') || current_user_can( 'administrator') ){
    $link = home_url( '/company_question1/', 'https' );
    echo '<p>Tervetuloa Inno-oppiva järjestelmään</p><p>Jos käytät järjestelmää ensimmäistä kertaa, toivomme että vastaisitte kyselylomakkeisiin alla olevasta linkistä:</p><a href="' . $link . '">Kyselylomakkeisiin</a>';
  }

  if ( current_user_can( 'school') || current_user_can( 'administrator') ){
      echo '<p>Tervetuloa Inno-oppiva järjestelmään</p><p>Alle on listattuna tuotteet joiden kyselyihin voitte vastata:</p><span id="company_list">Tähän pitäisi tulla vastanneet userit</span>';
  }
  return ob_get_clean();
}
