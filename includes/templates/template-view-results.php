<?php
/*
 * Template name: View Results
 * Description: A modified page.php page template where any post data
 * is ignored and instead the view_result page is printed, which shows
 * either a school's results on all their compleated answers or
 * company's match results from all the school's that have answered
 * their questions
 *
 */


get_header(); ?>

<div class="wrap">
<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">

    <?php
    global $wpdb;

    // Check user
    if ( current_user_can( 'administrator' ) ) {
      if ( isset( $_POST['company_view_for_admin'] ) ) {
         $company_id = $_POST['company_view_for_admin'];
      } else if ( isset( $_POST['school_view_for_admin'] ) ) {
         $school_id = $_POST['school_view_for_admin'];
      } else {
         die('Käytä admin sivua nähdäksesi tietyn yrityksen tai koulun tulokset');
      }
    } else if ( current_user_can( 'company' ) ) {
      $company_id = get_current_user_id();
    } else if ( current_user_can( 'school' ) ) {
      $school_id = get_current_user_id();
    } else {
      die('Access Denied!');
    }

    // Common defines
    $company_answer_table = $wpdb->prefix . 'Company_answer';
    $school_answer_table = $wpdb->prefix . 'School_answer';
    $query_result_organized = array();
    $question_count = 23;
    $page_content = '';



    // Check which type of result page to print
    if ( isset($school_id) ) {
      // Make school's result page
      echo '<h1>' . get_user_by('id', $school_id)->user_nicename . ' tulokset</h1>';

      $query_result = $wpdb->get_results(
         "SELECT $school_answer_table.company_id, answer_val AS answer, $school_answer_table.question_id, answer_max, answer_min, answer_priority
         FROM $school_answer_table
         INNER JOIN (SELECT company_id, question_id, answer_max, answer_min, answer_priority
                     FROM $company_answer_table
                     ) AS company_answer_query ON $school_answer_table.question_id=company_answer_query.question_id
                                                AND $school_answer_table.company_id=company_answer_query.company_id
         WHERE school_id=$school_id
         ORDER BY school_id ASC, question_id ASC");

       /*
       * SQL-query result will be turned into an array of company_ids that
       * all have an array which consist of all the answers the school in
       * question gave to that company
       */
       $company_id_column = array_column($query_result, 'company_id');
       $company_ids = array_unique($company_id_column);
      foreach ( $company_ids as $company_id ) {
        $query_result_organized[ $company_id ] = array();
      }
      foreach ( $query_result as $result ) {
         $query_result_organized[ $result->company_id ][] =
           array(
             'question_id' => $result->question_id,
             'answer' => $result->answer,
             'answer_max' => $result->answer_max,
             'answer_min' => $result->answer_min,
             'answer_priority' => $result->answer_priority,
		   );
      }

       // Record the content of school view
       ob_start();
      foreach ( $company_ids as $company_id ) {
        if ( count($query_result_organized[ $company_id ]) == $question_count ) {
          $company_name = get_user_by('id', $company_id)->user_nicename;

          $match = match_alg($query_result_organized[ $company_id ]);
          echo '<details><summary>' . $company_name . ' ' . $match . '%</summary> .
                  <span id=company_' . $company_id . '>
                    <div style="width: 600px; height: 800px;" id="graph' . $company_id . '+' . $school_id . '"></div>
                  </span></details>';
        }
      }
       $page_content = ob_get_contents();
       ob_end_clean();
    } else {
      // Make company's result page

      echo '<h1>' . get_user_by('id', $company_id)->user_nicename . ' tulokset</h1>';

      $query_result = $wpdb->get_results(
         "SELECT school_id, answer_val AS answer, $school_answer_table.question_id, answer_max, answer_min, answer_priority
         FROM $school_answer_table
         INNER JOIN (SELECT question_id, answer_max, answer_min, answer_priority
                     FROM $company_answer_table
                     WHERE company_id=$company_id
                     ) AS company_answer_query ON $school_answer_table.question_id=company_answer_query.question_id
         WHERE company_id=$company_id
         ORDER BY school_id ASC, question_id ASC");

       /*
       * SQL-query result will be turned into an array of school_ids that
       * all have an array which consist of that school's answers to the
       * company in question
       */
       $school_id_column = array_column($query_result, 'school_id');
       $school_ids = array_unique($school_id_column);
      foreach ( $school_ids as $school_id ) {
        $query_result_organized[ $school_id ] = array();
      }
      foreach ( $query_result as $result ) {
         $query_result_organized[ $result->school_id ][] =
           array(
             'question_id' => $result->question_id,
             'answer' => $result->answer,
             'answer_max' => $result->answer_max,
             'answer_min' => $result->answer_min,
             'answer_priority' => $result->answer_priority,
		   );
      }

       // Record the content of company view
       ob_start();
      foreach ( $school_ids as $school_id ) {
        if ( count($query_result_organized[ $school_id ]) == $question_count ) {
          $school_name = get_user_by('id', $school_id)->user_nicename;

          $match = match_alg($query_result_organized[ $school_id ]);
          echo '<details><summary>' . $school_name . ' ' . $match . '%</summary> .
                  <span id=school_' . $school_id . '>
                  <div style="width: 600px; height: 800px;" id="graph' . $company_id . '+' . $school_id . '"></div>

                  </span></details>';
        }
      }
       $page_content = ob_get_contents();
       ob_end_clean();
    }

    // Insert page content
    if ( $page_content == '' ) {
      $page_content = 'Tuloksia ei vielä ole';
    }
    echo $page_content;

    ?>

</main><!-- #main -->
</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
