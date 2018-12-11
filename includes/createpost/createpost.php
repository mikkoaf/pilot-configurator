<?php
function create_schoolquestions($results, $pagenbr, $maxpages) {
	global $wpdb;

	$author_id = 1;
	$slug = 'school_question'.$pagenbr.'';
	
	$author_id = 1;
	$qst_nmbr = 1;
	if($pagenbr <= $maxpages){
			
		ob_start();
		echo 'Kysymykset '.$pagenbr.'/'.$maxpages.'';
		echo '<form id="schoolQuestForm" class="questionForm" data-maxpages="' . $maxpages . '"  data-pgnumber="'.$pagenbr.'">';
		foreach ($results as $row){
			$title = $row->theme;
			$this_question = $row->question;
			$dbnumber = $row->question_id;
			echo '<p>'.$this_question.'</p><div class="schoolQCont"><input name="sqans_'.$dbnumber.'" class="schoolSlider'.$qst_nmbr.'" type="text"/></div><br/>';
			echo '<br><br>Lisätietoja (ei pakollinen)<br><input type="text" name="sqcom_'.$dbnumber.'" placeholder="Kirjoita mahdolliset lisätiedot tähän"><br><hr><br>';
			$qst_nmbr = $qst_nmbr + 1;
		}
		if($pagenbr != 1){
		echo '<br><input type="button" id="back_button" value="Edellinen"></input>';
		}
		echo '<input type="submit" value="Seuraava"></input></form>';

		$content = ob_get_contents(); 
		ob_end_clean();
	}
	else{
		ob_start();
		$title = "Kiitokset";
		echo '<p>Kiitos vastauksista kysymyksiin</p>';
		echo '<p>Voitte jatkaa vastaamista valitsemalla toisen tuotteen alta:</p>';
		echo '<span id="company_list"> </span>';
		echo '<p>Voitte myös palata takaisin aloitussivulle painamalla alla olevaa nappia</p>';
		echo '<input type="button" id="end_button" value="Etusivulle"></input>';
	$content = ob_get_contents(); 
	ob_end_clean();
	}

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
function create_companyquestions($results, $pagenbr, $maxpages) {
	global $wpdb;

	$author_id = 1;
	$slug = 'company_question'.$pagenbr.'';
	
	$qst_nmbr = 1;
	
	if(intval($pagenbr) <= intval($maxpages)){
		ob_start();
		echo 'Kysymykset '.$pagenbr.'/'.$maxpages.'';
		echo '<form id="companyQuestForm" class="questionForm" data-maxpages="' . $maxpages . '" data-pgnumber="'.$pagenbr.'">';
		foreach ($results as $row){
			$title = $row->theme;
			$this_question = $row->question;
			$dbnumber = $row->question_id;
			echo '<p>'.$this_question.'</p><input name="cqans_'.$dbnumber.'" class="companyDS'.$qst_nmbr.'" type="text"/><br>';
			echo '<input name="sqimprtance_'.$dbnumber.'" class="companySS'.$qst_nmbr.'" type="text" data-slider-ticks="[1, 2, 3]" data-slider-ticks-labels=\'["1", "2", "3"]\' data-slider-tooltip="hide" /><br>';
			$qst_nmbr = $qst_nmbr + 1;
		}	
		if($pagenbr != 1){
			echo '<br><input type="button" id="back_button" value="Edellinen"></input>';
		}
		echo '<input type="submit" value="Seuraava"></input></form>';
		
		$content = ob_get_contents(); 
		ob_end_clean();
	}
	else{
		ob_start();
		$title = "Kiitokset";
		echo '<p>Kiitos vastauksista kysymyksiin</p>';
		echo '<p>Voitte palata etusivulle painamalla alla olevaa nappia</p>';
		echo '<input type="button" id="end_button" value="Etusivulle"></input>';
	$content = ob_get_contents(); 
	ob_end_clean();
	}
	
	
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
