<?php
function create_product_information() {
	global $wpdb;

	$author_id = 1;
	$slug = 'product-information';

	if( null == get_page_by_path( $slug, 'OBJECT', 'page') ) {

		wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_author'		=>	$author_id,
				'post_name'			=>	$slug,
				'post_title'		=>	'Tuotteen tiedot',
				'post_content'		=>	'Minne menee',
				'post_status'		=>	'publish',
				'post_type'			=>	'page',
				'page_template'		=>  'templates/template-company-information.php'
			)
		);
	}
}