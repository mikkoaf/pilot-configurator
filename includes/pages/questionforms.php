<?php
function create_questionform(){
	global $wpdb;
	$author_id = 1;
	$title = 'Kysymyslomake';

	// Non-assigned user splash
	$slug = 'questionform';

	ob_start();
		echo '[pilotcfg_any_question]';
	$content = ob_get_contents();
	ob_end_clean();

	wp_insert_post(
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

function remove_splashes(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts';


	$slug = 'questionform';
	$result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
	wp_delete_post($result[0], true);
}

?>
