<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Access Denied!' );
}

function pilotcfg_questionform( $atts = [], $content = null, $tag = 'pilotcfg_questionform' ) {
  if ( ! is_user_logged_in() ) {
    die( 'Access Denied! Log in to access this page!' );
  }

  if ( current_user_can( 'administrator' ) ) {
    echo 'You are the administrator. Access this site as a user to view the form';
  } else {
    $transient_name = wp_get_current_user()->user_login . '-formpagenbr';

    if( !get_transient( $transient_name ) ) {
      set_transient( $transient_name, 0 );
    }
    $pagenbr = get_transient( $transient_name );
    global $wpdb;
    $settisets = $wpdb->get_results('SELECT DISTINCT question_set FROM wp_Questions');
    $amount = $wpdb->num_rows;
    $results = $wpdb->get_results("SELECT * FROM wp_Questions WHERE question_set = '" . $pagenbr . "';");

  }

  ob_start();
  if ( current_user_can( 'school') ) {
    echo school_questions( $results, $pagenbr, $amount );
  }

  if ( current_user_can( 'company') ) {
    echo company_questions( $results, $pagenbr, $amount );
  }

  return ob_get_clean();
}

function school_questions( $results, $pagenbr, $maxpages ) {
  global $wpdb;
  $transient_name = wp_get_current_user()->user_login . '-formpagenbr';
	$link = home_url( '/questionform', 'https' );
  $qst_nmbr = 1;
  if ( $pagenbr == 0 ) {
      $title = 'Kysymys info';
      ob_start();
      echo '<h1>Lyhyet ohjeet kysymyksiin:</h1>';
      echo '<p>Seuraavilla sivuilla tulet näkemään ' . $maxpages . ' joukkoa kysymyksiä.</p>';
      echo '<p>Nämä näihin kysymyksiin vastataan asteikolla 1 - 5 jossa 5 tarkoittaa että mielestänne väite vastaa koulunne kykyjä ja 1 että väite ei ole koulunne vahvuuksia.</p>';
      echo '<p>Voitte antaa myös kommennttilaatikkoon lisäinfoa jos näette sen tarpeelliseksi, tämä ei ole pakollista</p>';
      echo '<input type="button" onclick="location.href=\'' . $link . '\';" value="Kysymyksiin" />';
      $content = ob_get_contents();
      ob_end_clean();
      set_transient( $transient_name, $pagenbr + 1 );
  } else {
    if ( $pagenbr <= $maxpages ) {

        ob_start();
        echo 'Kysymykset ' . $pagenbr . '/' . $maxpages . '';
        echo '<form id="schoolQuestForm" class="questionForm" data-maxpages="' . $maxpages . '"  data-pgnumber="' . $pagenbr . '">';
      foreach ( $results as $row ) {
        $title = $row->theme;
        $this_question = $row->question;
        $dbnumber = $row->question_id;
        echo '<h3>' . $this_question . '</h3>Eri mieltä &emsp; &emsp;<input name="sqans_' . $dbnumber . '" class="schoolSlider' . $qst_nmbr . '" type="text" data- / > &emsp; &emsp; Samaa mieltä';
        echo '<br><br>Lisätietoja (ei pakollinen)<br><input type="text" name="sqcom_' . $dbnumber . '" placeholder="Kirjoita mahdolliset lisätiedot tähän" /><br><hr><br>';
        $qst_nmbr++;
      }
      if ( $pagenbr != 1 ) {
        echo '<br><input type="button" id="back_button" value="Edellinen"></input>';
      }
        echo '<input type="submit" value="Seuraava"></input></form>';

        $content = ob_get_contents();
        ob_end_clean();
    } else {
        ob_start();
        $title = 'Kiitokset';
        echo '<p>Kiitos vastauksista kysymyksiin</p>';
        echo '<p>Voitte jatkaa vastaamista valitsemalla toisen tuotteen alta:</p>';
        echo '<span id="company_list"> </span>';
        echo '<p>Voitte myös palata takaisin aloitussivulle painamalla alla olevaa nappia</p>';
        echo '<input type="button" id="end_button" value="Etusivulle"></input>';
    }
  }
  echo "something";
  echo $pagenbr;
  echo $maxpages;
  return ob_get_clean();
}

function company_questions( $results, $pagenbr, $maxpages  ) {
  global $wpdb;
  $qst_nmbr = 1;
	$link = home_url( '/questionform', 'https' );

  if ( $pagenbr == 0 ) {
      $title = 'Kysymys info';
      ob_start();
      echo '<h1>Lyhyet ohjeet kysymyksiin:</h1>';
      echo '<p>Seuraavilla sivuilla tulet näkemään ' . $maxpages . ' joukkoa kysymyksiä.</p>';
      echo '<p>Näissä kysymyksissä on kaksi kohtaa. Ensimmäisenä on vierityspalkki jossa kaksi palloa, näiden avulla voitte määrittää kysymykselle <b>miniarvon</b> (ensimmäinen pallo), kysymyksen <b>hyväksyttävä arvo</b> (kahden pallon välinen alue) sekä kysymyksen <b>toivottu arvo</b></p>';
      echo '<p><b>Minimiarvolla</b> kysymys ei tuota pisteitä yhteensopivuuslaskelmiin.<br><b>Hyväksyttävä arvo</b> tuottaa osan pisteistä yhteensopivuuslaskelmiin.<br><b>Toivottu arvo</b> tuottaa täydet pisteet yhteensopivuuslaskelmiin';
      echo '<p>Seuraava vierityspalkki on pienempi. Sen avulla voitte määrittää kuinka tärkeä kyseinen kysymys on teidän tuotteellenne. Mitä tärkeämpi se on, sitä enemmän kyseinen kysymys vaikuittaa yhteensopivuuslaskelmiin.</p>';
      echo '<input type="button" onclick="location.href=\'' . $link . '\';" value="Kysymyksiin" />';
  } else {
    if ( intval($pagenbr) <= intval($maxpages) ) {
        ob_start();
        echo 'Kysymykset ' . $pagenbr . '/' . $maxpages . '';
        echo '<form id="companyQuestForm" class="questionForm" data-maxpages="' . $maxpages . '" data-pgnumber="' . $pagenbr . '">';
      foreach ( $results as $row ) {
        $title = $row->theme;
        $this_question = $row->question;
        $dbnumber = $row->question_id;
        echo '<h3>' . $this_question . '</h3><input name="cqans_' . $dbnumber . '" class="companyDS' . $qst_nmbr . '" type="text" data-slider-ticks="[1, 2, 3, 4, 5]" data-slider-ticks-labels=\'["1", "2", "3", "4", "5"]\' /><br>';
        echo '<input name="sqimprtance_' . $dbnumber . '" class="companySS' . $qst_nmbr . '" type="text" data-slider-ticks="[1, 2, 3]" data-slider-ticks-labels=\'["1", "2", "3"]\' data-slider-tooltip="hide" /><br>';
        $qst_nmbr++;
      }
      if ( $pagenbr != 1 ) {
          echo '<br><input type="button" id="back_button" value="Edellinen"></input>';
      }
        echo '<input type="submit" value="Seuraava"></input></form>';
    } else {
        ob_start();
        $title = 'Kiitokset';
        echo '<p>Kiitos vastauksista kysymyksiin</p>';
        echo '<p>Voitte palata etusivulle painamalla alla olevaa nappia</p>';
        echo '<input type="button" id="end_button" value="Etusivulle"></input>';
    }
  }
  return ob_get_clean();
}
