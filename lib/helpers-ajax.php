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
      $company_name = $wpdb->get_var("SELECT user_nicename FROM wp_users WHERE ID = $single->company_id");
      $test .= '<li><a href="#" onclick="return giveCompanyCookie(' . $id . ')"> ' . $company_name . '</a></li>';
      $test .= "\r\n";
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
	die();
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