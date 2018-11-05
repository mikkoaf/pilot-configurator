

<?php

$data = array(
	'num1' => 1,
	'num5' => 5,
	'num4' => 4,
	'num3' => 3,
	'num2' => 2,
);
 function wpb_adding_scripts() {
	 wp_register_script('chart', plugin_dir_url(__FILE__) . '/Chart.js', false);
	 wp_register_script('chart2', plugin_dir_url(__FILE__) . '/Chart.min.js', false);
	 wp_enqueue_script('chart');
	 wp_enqueue_script('chart2');
	 wp_enqueue_script('jquery');
 }
 
 function wpd_adding_scripts2() {
	 wp_register_script('radarChart', plugin_dir_url(__FILE__) . 'radarChart.js', false);
	 
	 wp_enqueue_script('radarChart');
	 
 }
 
 add_action('wp_enqueue_scripts', 'wpb_adding_scripts');


function programmatically_create_post() {

	// Initialize the page ID to -1. This indicates no action has been taken.
	$post_id = -1;

	// Setup the author, slug, and title for the post
	$author_id = 1;
	$slug = 'example-post';
	$title = 'php loop try1';
	ob_start(); //Start output buffer
	
	include 'visually.php';
	$content = ob_get_contents(); 
	ob_end_clean();
	
	// If the page doesn't already exist, then create it
	if( null == get_page_by_title( $title, 'OBJECT', 'post') ) {

		// Set the post ID so that we know the post was created successfully
		$post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_author'		=>	$author_id,
				'post_name'		=>	$slug,
				'post_title'		=>	$title,
				'post_content'		=>	$content,
				'post_status'		=>	'publish',
				'post_type'		=>	'post'
			)
		);

	// Otherwise, we'll stop
	} else {

    		// Arbitrarily use -2 to indicate that the page with the title already exists
    		$post_id = -2;

	} // end if

} // end programmatically_create_post
add_filter( 'init', 'programmatically_create_post');
/*
$post_id = programmatically_create_post();
if( -1 == $post_id || -2 == $post_id ) {
   // The post wasn't created or the page already exists
} // end if*/
?>