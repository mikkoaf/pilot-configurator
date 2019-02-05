<?php

if ( ! defined( 'ABSPATH' ) ) {
  die('Access Denied!');
}

/*
 * Function that lists the companies that have answered the questionaires and echos out their user_nicename (subject to change)
 */

function list_active_companies() {
	global $wpdb;

	$companies = $wpdb->get_results('SELECT DISTINCT company_id FROM wp_Company_answer');
	$test = '';

	$test .= '<ul>';
  foreach ( $companies as $single ) {
      $id = $single->company_id;
      // Check if the user is actually a company
      $user = get_userdata( $id );
      $user_roles = $user->roles;
      if ( in_array( 'company', $user_roles, true ) ) {
        $company_name = $wpdb->get_var("SELECT user_nicename FROM wp_users INNER JOIN wp_usermeta WHERE ID = $single->company_id");
        $test .= '<li><a href="#" onclick="return giveCompanyCookie(' . $id . ')"> ' . $company_name . '</a></li>';
        $test .= "\r\n";
      }

  }
	$test .= '</ul>';
	echo $test;
	die();
}

function company_id_cookie_set() {
	global $wpdb;
	$company_id = $_POST['cont'];

	$urlpath = get_site_url();
	$urlpath .= '/product_information';

    setcookie( 'company-identification', $company_id, time() + 3600, '/');
	echo $urlpath;
	die();
}

/*
 * Function that inserts the entries for school questionaires (not yet implemented)
 */

function school_question_insert() {
	global $wpdb;

	parse_str($_POST['cont'], $newarray);
	$uid = get_current_user_id();
	$cookieVal = $_COOKIE['company-identification'];

  foreach ( $newarray as $key => $val ) {
      $namenumber = explode('_', $key);

    if ( $namenumber[0] == 'sqans' ) {
        $schoolans = $val;
    } else {

        // Checks whether there already is a database entry, if it does exist it is only updated, if it doesnt it is created
      if ( $wpdb->get_row("SELECT * FROM wp_School_answer WHERE school_id = $uid AND question_id = $namenumber[1] AND company_id = $cookieVal") == null ) {
          $wpdb->query(
        "INSERT INTO wp_School_answer VALUES
			  (NULL, $uid, $namenumber[1], $cookieVal, $schoolans, '$val')
			  ");
      } else {
          $wpdb->update('wp_School_answer', array(
            'answer_val' => $schoolans,
            'comment' => $val,
          ), array(
            'school_id' => $uid,
            'question_id' => $namenumber[1],
            'company_id' => $cookieVal,
          ));
      }
    }
  }
  pkfg_advance();
	die();
}

/*
 * Function that inserts the entries for company questionaires
 */
function company_question_insert() {
	global $wpdb;

	parse_str($_POST['cont'], $newarray);
	$uid = get_current_user_id();

  foreach ( $newarray as $key => $val ) {
      $namenumber = explode('_', $key);

    if ( $namenumber[0] == 'cqans' ) {
        $minmax = explode(',', $val);
    } else {

        // Checks whether there already is a database entry, if it does exist it is only updated, if it doesnt it is created
      if ( $wpdb->get_row("SELECT * FROM wp_Company_answer WHERE company_id = $uid AND question_id = $namenumber[1]") == null ) {
          $wpdb->query(
        "INSERT INTO wp_Company_answer VALUES
			  (NULL, $uid, $namenumber[1], $minmax[1], $minmax[0], $val)
			  ");
      } else {
          $wpdb->update('wp_Company_answer', array(
            'answer_max' => $minmax[1],
            'answer_min' => $minmax[0],
            'answer_priority' => $val,
          ), array(
            'company_id' => $uid,
            'question_id' => $namenumber[1],
          ));
      }
    }
  }
  pkfg_advance();
	die();
}

function pkfg_advance() {
  $transient_name = wp_get_current_user()->user_login . '-formpagenbr';
  if( get_transient( $transient_name ) ){
    $cookieVal = get_transient( $transient_name );
    $cookieVal = $cookieVal +1 ;
    set_transient( $transient_name, $cookieVal);
  }
}

function back_button_function(){

	$transient_name = wp_get_current_user()->user_login . '-formpagenbr';

	if( get_transient( $transient_name ) ){

		$cookieVal = get_transient( $transient_name );
		if($cookieVal > 0){
			$cookieVal = $cookieVal - 1;
			set_transient( $transient_name, $cookieVal);
			echo '1';
		}
		else{
			echo '0';
		}
	}
	else{
		echo '0';
	}

}

function pilot_visualize( $data_array ) {
  // Old visualization methods
  $form = [4,4,2,4,4];
  $hard_form = $form;
  $current_set = array_shift($form);
  $prio = array_column($data_array, 'answer_priority');    // questions priority to the company
  $min = array_column($data_array, 'answer_min');      // minimium value to get any points
  $max = array_column($data_array, 'answer_max');      // "maximium" value, get max points after this
  $answ = array_column($data_array, 'answer');         // school's answer

  $length = count($data_array);       // can be smaller than question count
  $priority = get_option('inno_oppiva_priorities');

  $points = 0;                 // counts how well school's answers are valued by the company
  $points_max = 0;             // counts how many points a perfect set of answers would get
  for ( $i = 0; $i < $length; $i++ ) {
      $points_max += $priority[ $prio[ $i ] ];
  }
  $temp = [];
  $ret_arr = [];
  for ( $i = 0; $i < $length; $i++ ) {
    if ( $answ[ $i ] >= $min[ $i ] ) {
        // check if school deserves full points or not
      if ( $answ[ $i ] >= $max[ $i ] ) {
        // add full points for given question
        array_push($temp, floatval($priority[ $prio[ $i ] ]));
      } else {
          // add some points, determined by how high school's answer was
          array_push($temp, floatval(( $answ[ $i ] + 1 - $min[ $i ] ) / ( $max[ $i ] + 1 - $min[ $i ] ) * $priority[ $prio[ $i ] ]));
      }
    }
    #ugly but works
    if(count($form) >= 0 && $current_set >= 1){
      $current_set = $current_set - 1;
    } else {
      # lisätään vertailuarvot taulukkoon
      array_push($ret_arr, $temp);
      $temp = [];
      if(count($form)){
          $current_set = array_shift($form);
      }
    }
  }
  $result = 0;
  if ( $points_max != 0 ) {
      $result = $points / $points_max * 100; // calculates the results in percents
  }
  $xValues =[];
  for($i = 0; $i < count($max); $i++){
    array_push($xValues, $max[$i]-$min[$i]);
  }

  $sAnswers = json_encode($answ);
  $baseValues = json_encode($min);
  $xValues = json_encode($xValues);
  $ret_arr = json_encode($ret_arr);
  $hard_form = json_encode($hard_form);
  $rand = rand();
  #Esitetään käyttäjälle useampi eri visualisointi.
  echo
    "<div style='width: 1000px; height: 800px;' class='pilotchart' id='pilotchart-$rand' data-carr-min='$baseValues' data-xValues='$xValues' data-sAnswers='$sAnswers'></div>
    <div class='radarChart col-sm-offset-6' id='radar-$rand' data-matrix='$ret_arr' data-form='$hard_form'></div>
      <details><summary>Vastausten yhteneväisyys</summary>
      <div class='heatmap' id='heatmap-$rand' data-matrix='$ret_arr'></div>
      </details>";

}
