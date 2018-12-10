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
		 
         if (current_user_can( 'administrator' ) || current_user_can( 'school' ) || current_user_can( 'company' ) ) {
			die('Access Denied!');
		 }
		 
		 //$user_id = $_COOKIE['company-identification'];
		 //$content_results = wpdb->get_var( "SELECT meta_value FROM wp_usermeta WHERE user_id = $user_id AND meta_key = 'description' ");
		 //echo "Toimiiko";
		 $content_results2 = "<p>Toimiiko</p>";
		 
		 while ( have_posts() ) :
				the_post();
				//get_template_part( 'template-parts/page/content', 'page' ); // prints unwanted post data 
            echo $content_results2; // Insert custom content
				// Fetching comments removed
			endwhile;
         
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();