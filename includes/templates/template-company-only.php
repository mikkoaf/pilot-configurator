<?php
/**
 * Template name: Company only
 * Description: A modified page.php page template where users are checked
 * and only company and administrator users are allowed
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

         if ( current_user_can( 'company') || current_user_can( 'administrator') ){

            while ( have_posts() ) : the_post();

               get_template_part( 'template-parts/page/content', 'page' );

               // If comments are open or we have at least one comment, load up the comment template.
               if ( comments_open() || get_comments_number() ) :
                  comments_template();
               endif;

            endwhile; // End of the loop.

         }
         else{
            echo 'Access Denied!';
         }

         ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
