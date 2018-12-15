<?php
function create_splashes(){
	global $wpdb;
	$author_id = 1;
	$title = 'Tervetuloa';

	// School splash
	$slug = 'school_splash';
	$link = 'TODO';
	
	ob_start();
		echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
				<p>Alle on listattuna tuotteet joiden kyselyihin voitte vastata:</p>
				<span id="company_list">Tähän pitäisi tulla vastanneet userit</span>';
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
	
	// Company splash
	$slug = 'company_splash';
	$link = home_url( '/company_question1/', 'https' );

	ob_start();
		echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
				<p>Jos käytät järjestelmää ensimmäistä kertaa, toivomme että vastaisitte kyselylomakkeisiin alla olevasta linkistä:</p>
				<a href="'.$link.'">Kyselylomakkeisiin</a>';
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

	// Non-assigned user splash
	$slug = 'new_user_splash';

	ob_start();
		echo '<p>Tervetuloa Inno-oppiva järjestelmään</p>
				<p>Sinulle ei vielä ole annettu järjestelmän omaa roolia, joten et voi käyttää kaikkia palvelun toimintoja</p>
				<p>Odottaessasi ylläpidon toimia, voisit kertoa profiilissa itsestäsi</p>
				<p>Palvelu tulee hyödyntämään kyseistä tietoa näyttäessäsi organisaatiotanne</p>';
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

	$slug = 'school_splash';
	$result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
	wp_delete_post($result[0], true);
	
	$slug = 'company_splash';
	$result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
	wp_delete_post($result[0], true);

	$slug = 'new_user_splash';
	$result = $wpdb->get_row("SELECT ID FROM " . $table_name . " WHERE post_name='" . $slug . "'", 'ARRAY_N');
	wp_delete_post($result[0], true);
}

?>