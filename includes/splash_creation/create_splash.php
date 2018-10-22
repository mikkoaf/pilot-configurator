<?php
function create_splashes($results) {
	global $wpdb;
	
	$author_id = 1;
	$slug = 'schoolsplash';
	$title = 'Tervetuloa';
	ob_start();
		echo '<p>Tervetuloa Inno-oppiva järjestelmään</p><p>Jos käytät järjestelmää ensimmäistä kertaa, toivomme että vastaisitte kyselylomakkeisiin alla olevasta linkistä:</p><a href="">Kyselylomakkeisiin</a>';
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
	
		
	$author_id = 1;
	$slug = 'companysplash';
	$title = 'Tervetuloa';
	ob_start();
		echo '<p>Tervetuloa Inno-oppiva järjestelmään</p><p>Jos käytät järjestelmää ensimmäistä kertaa, toivomme että vastaisitte kyselylomakkeisiin alla olevasta linkistä:</p><a href="">Kyselylomakkeisiin</a>';
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