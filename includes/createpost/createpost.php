<?php
function create_schoolquestions($results, $pagenbr) {
	global $wpdb;

	$author_id = 1;
	$slug = 'school_question'.$pagenbr.'';
	
	$author_id = 1;
	$qst_nmbr = 1;
	//Vaihda value placeholderiksi
	ob_start();
	echo '<form id="schoolQuestForm" class="questionForm">';
	foreach ($results as $row){
		$title = $row->theme;
		$this_question = $row->question;
		echo '<p>'.$this_question.'</p><div class="schoolQCont"><input name="sqans'.$qst_nmbr.'" class="schoolSlider'.$qst_nmbr.'" type="text"/></div><br/>';
		echo '<br><br>Lisätietoja (ei pakollinen)<input type="text" name="sqcom'.$qst_nmbr.'" value="Kirjoita mahdolliset lisätiedot tähän"><br><hr><br>';
		$qst_nmbr = $qst_nmbr + 1;
	}
	echo '<br><input type="button" value="Edellinen" height="60"></input>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Seuraava" height="60"></input></form>';
	$content = ob_get_contents(); 
	ob_end_clean();
	

	if( null == get_page_by_path( $slug, 'OBJECT', 'page') ) {

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
}
function create_companyquestions($results, $pagenbr) {
	global $wpdb;

	$author_id = 1;
	$slug = 'company_question'.$pagenbr.'';
	
	$qst_nmbr = 1;
	ob_start();
	echo '<form id="companyQuestForm" class="questionForm">';
	foreach ($results as $row){
		$title = $row->theme;
		$this_question = $row->question;
		echo '<p>'.$this_question.'</p><input name="cqans'.$qst_nmbr.'" class="companyDS'.$qst_nmbr.'" type="text"/><br>';
		echo '<input name="sqimprtance'.$qst_nmbr.'" class="companySS'.$qst_nmbr.'" type="text"/><br>';
		echo '<br><br>Lisätietoja (ei pakollinen)<input type="text" name="sqcom'.$qst_nmbr.'" value="Kirjoita mahdolliset lisätiedot tähän"><br><hr><br>';
		$qst_nmbr = $qst_nmbr + 1;
	}
	echo '<br><input type="button" value="Edellinen" height="60"></input>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Seuraava" height="60"></input></form>';
	$content = ob_get_contents(); 
	ob_end_clean();
	
	if( null == get_page_by_path( $slug, 'OBJECT', 'page') ) {

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
}

?>