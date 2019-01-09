<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Access Denied!' );
}

function pilotcfg_any_splash( $atts = [], $content = null, $tag = 'pilotcfg_any_splash' ) {
  if ( ! is_user_logged_in() || current_user_can( 'administrator' ) ) {
    $link = home_url( '/wp-login.php/', 'https' );
    echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
    <p>Sinun tulee kirjautua järjestelmään käyttääksesi tätä sivua</p>
    <p><a href="' . $link . '">Kirjautumiseen</a></p>';
  }

  if ( current_user_can( 'administrator') ) {
    echo '<br>';
  }

  ob_start();
  if ( is_user_logged_in() && ( ! current_user_can( 'company') && ! current_user_can('school') || current_user_can( 'administrator') ) ) {
     echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
      <p>Sinulle ei vielä ole annettu järjestelmän omaa roolia, joten et voi käyttää kaikkia palvelun toimintoja</p>
      <p>Odottaessasi ylläpidon toimia, voisit kertoa profiilissa itsestäsi</p>
      <p>Palvelu tulee hyödyntämään kyseistä tietoa näyttäessäsi organisaatiotanne</p>';
  }

  if ( current_user_can( 'administrator') ) {
     echo '<br>';
  }

  if ( current_user_can( 'company') || current_user_can( 'administrator') ) {
    $link = home_url( '/questionform/', 'https' );
    $results_link = home_url( '/view_results/', 'https' );
    echo '<p>Tervetuloa Inno-oppiva järjestelmään</p><p>Jos käytät järjestelmää ensimmäistä kertaa, toivomme että vastaisitte kyselylomakkeisiin alla olevasta linkistä:</p>
         <a href="' . $link . '">Kyselylomakkeisiin</a>
         <br><p><a href="' . $results_link . '">Matchmaking tulosten katsaus</a></p>';
  }

  if ( current_user_can( 'administrator') ) {
    echo '<br>';
  }

  if ( current_user_can( 'school') || current_user_can( 'administrator') ) {
    $results_link = home_url( '/view_results/', 'https' );
    echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
         <p>Alle on listattuna tuotteet joiden kyselyihin voitte vastata:</p>
         <span id="company_list">Tähän pitäisi tulla vastanneet userit</span>
         <br><p><a href="' . $results_link . '">Matchmaking tulosten katsaus</a></p>';
  }
  return ob_get_clean();
}
