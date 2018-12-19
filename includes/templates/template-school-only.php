<?php
/**
 * Template name: School only
 * Description: A modified page.php page template where users are checked
 * and only school and administrator users are allowed
 */

get_header(); 
if ( !current_user_can( 'school') && !current_user_can( 'administrator') ){
   echo 'Access Denied!';
   get_footer();
   die();
}
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
         while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/page/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
               comments_template();
            endif;

         endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
