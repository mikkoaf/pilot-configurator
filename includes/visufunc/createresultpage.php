<?php


function create_results_page($results) {
	global $wpdb;
	
	$author_id = 1;
	$slug = 'resultpage';
	$title = 'Kaikkitulokset';
	ob_start();
		include_once PILOT_CONFIGURATOR_DIR_PATH . 'includes/visufunc/visufunc.php';
		echo printeach();
		$content = ob_get_contents(); 
	ob_end_clean();
	
	if( null == get_page_by_path( $title, 'OBJECT', 'page') ) {

		$post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_author'		=>	$author_id,
				'post_name'			=>	$slug,
				'post_title'		=>	$title,
				'post_content'		=>	$content,
				'post_status'		=>	'publish',
				'post_type'			=>	'page'
			)
		);
	}
}
?>