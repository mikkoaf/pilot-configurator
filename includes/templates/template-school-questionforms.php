<?php
/*
 * Template name: Questionform-template
 * Description: Template for questionforms
 * 
 */
get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			
         global $wpdb;
		 
         if (!( current_user_can( 'administrator' ) || current_user_can( 'school' ) ) ) {
			die('Access Denied!');
		 }
		 
		 
		 while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/page/content', 'page' ); // prints unwanted post data
			endwhile;
         
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();