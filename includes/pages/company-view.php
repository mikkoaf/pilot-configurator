<?php

function create_company_view() {
	global $wpdb;

	$slug = 'view_results';
	
	if( null == get_page_by_path( $slug, 'OBJECT', 'page') ) {

		wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_author'		=>	'1',
				'post_name'			=>	$slug,
				'post_title'		=>	'View Results',
				'post_content'		=>	'',
				'post_status'		=>	'publish',
				'post_type'			=>	'page',
				'page_template'	=> 'templates/template-company-view.php'
			)
		);
	}
}

function remove_company_view() {
   global $wpdb;
	$table_name = $wpdb->prefix . 'posts';

	$slug = 'view_results';
   
   $result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
	wp_delete_post($result[0], true);
}