<?php
/*
 * Template name: Company View
 * Description: A modified page.php page template that handles calculations for company view
 * 
 */


get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

         global $wpdb;
         // Check for administrator checking a company's results
         if ( current_user_can( 'administrator' ) ) {
            if( isset( $_POST['company_view_for_admin'] ) ) {
               $company_id = $_POST['company_view_for_admin'];       
            }
            else{
               echo "Käytä admin sivua nähdäksesi tietyn yrityksen tulokset"; 
               die;
            }
         }
         else if ( current_user_can( 'company' ) ){
            $company_id = get_current_user_id(); 
         }
         else{
            die('Access Denied!');
         }
         echo '<h1>' . get_user_by('id', $company_id)->user_nicename . ' tulokset</h1>';

         $company_answer_table = $wpdb->prefix . 'Company_answer';
         $school_answer_table = $wpdb->prefix . 'School_answer';

         /* alternative query implementation
         $company_answers = $wpdb->get_results(
            "SELECT question_id, answer_max, answer_min, answer_priority
            FROM $company_answer_table
            WHERE company_id=$company_id
            ORDER BY question_id ASC");

         $school_answers = $wpdb->get_results(
            "SELECT school_id, answer, question_id
            FROM $school_answer_table
            WHERE company_id=$company_id
            ORDER BY school_id ASC, question_id ASC");
         */
         
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
         $query_result_organized = array();
         foreach($school_ids as $school_id){
            $query_result_organized[$school_id] =  array();
         }

         foreach($query_result as $result){
            $query_result_organized[$result->school_id][] = 
               array('question_id' => $result->question_id, 
                     'answer' => $result->answer,
                     'answer_max' => $result->answer_max,
                     'answer_min' => $result->answer_min,
                     'answer_priority' => $result->answer_priority);
         }

         // Record the content of company view
         ob_start();
         foreach($school_ids as $school_id){
            if(count($query_result_organized[$school_id]) == 23){
               $school_name = get_user_by('id', $school_id)->user_nicename;
               
               $match = match_alg($query_result_organized[$school_id]);
               echo '<details><summary>' . $school_name . ' ' . $match . '%</summary> .
                     <span id=more_' . $school_id . '><p>hey</p></span></details>';
            }
         }
         $company_view_content = ob_get_contents(); 
         ob_end_clean();

         if($company_view_content == ''){ 
            $company_view_content = 'Tuloksia ei vielä ole'; 
         } 

         // Loop from page.php
         while ( have_posts() ) :
				the_post();
				// get_template_part( 'template-parts/page/content', 'page' ); // prints unwanted post data 
            echo $company_view_content; // Insert custom content
				// Fetching comments removed
			endwhile;
         
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();

