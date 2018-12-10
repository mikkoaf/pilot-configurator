<?php
/*
 * Template name: Company product information
 * Description: Template which creates the product information page 
 * 
 */
get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			
         global $wpdb;
		 
         if (!( current_user_can( 'administrator' ) || current_user_can( 'school' ) || current_user_can( 'company' ) ) ) {
			die('Access Denied!');
		 }
		 
		 $user_id = $_COOKIE['company-identification'];
		 $content_results = $wpdb->get_var( "SELECT meta_value FROM wp_usermeta WHERE user_id = $user_id AND meta_key = 'description' ");
		 $link = home_url( '/school_question1', 'https' );
		 if($content_results == NULL || $content_results == ''){
			 $company_name = $wpdb->get_var( "SELECT user_nicename FROM wp_users WHERE ID = $user_id");
			 $content_results = "Ikävä kyllä tuotteesta $company_name ei ole kirjoitettu vielä tuotekuvaustaan"; 
		 }
		 ob_start();
		 echo '<p>';
		 echo $content_results;
		 echo '</p>';
		 
		 $content = ob_get_contents(); 
         ob_end_clean();
		 

		 
		 while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/page/content', 'page' ); // prints unwanted post data 
            echo $content;			// Insert custom content
			?>
			<input type="button" onclick="location.href='<?php echo $link ?>';" value="Kysymyksiin" />
			<?php
				// Fetching comments removed
			endwhile;
         
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();