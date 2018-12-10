<?php
function create_school_questions($results, $setnmbr) {
	global $wpdb;
	
	$author_id = 1;
	$qst_nmbr = 1;
	//Start a buffer for the page-content
	ob_start();
	foreach ($results as $row){//Loop the individual questions
	
		$title = $row->setti;
		$this_question = $row->question;
		echo '<p>'.$this_question.'</p><form>1<input type="radio" name="q'.$qst_nmbr.'" value="qval'.$qst_nmbr.'"><input type="radio" name="q'.$qst_nmbr.'" value="qval'.$qst_nmbr.'"><input type="radio" name="q'.$qst_nmbr.'" value="qval'.$qst_nmbr.'"><input type="radio" name="q'.$qst_nmbr.'" value="qval'.$qst_nmbr.'"><input type="radio" name="q'.$qst_nmbr.'" value="qval'.$qst_nmbr.'">5</form>';
		echo '<form><br><br>Lisätietoja (ei pakollinen)<input type="text" name="qcom'.$qst_nmbr.'" value="Kirjoita mahdolliset lisätiedot tähän"></form><br><hr><br>';
		$qst_nmbr = $qst_nmbr + 1;
	}
	echo '<br><button type="button" onclick="last_page()">Edellinen</button><button type="button" onclick="next_page()">Seuraava</button>';
	$content = ob_get_contents(); 
	ob_end_clean();
	
	
	$slug = 'schoolq'.$setnmbr.'';
	
	if( null == get_page_by_title( $title, 'OBJECT', 'page') ) {
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