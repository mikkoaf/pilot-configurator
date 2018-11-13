<?php
/*
 * Match algorithm function
 * 
 * $data_array should have one school's and one company's answers to all of the questions
 * function uses values from columns named answer_priority, answer_min, answer_max and answer
 * 
 * returns intvalue() representing % of match for a school's answers compared to a company's answers
 */
function match_alg($data_array){
		
	$priority = array_column($data_array, 'answer_priority');    // questions priority to the company
	$min = array_column($data_array, 'answer_min');      // minimium value to get any points
	$max = array_column($data_array, 'answer_max');      // "maximium" value, get max points after this
	$answ = array_column($data_array, 'answer');         // school's answer

	$answer_count = count($answ);	// count questions, could be hardcoded

	$points = 0;                 // counts how well school's answers are valued by the company
	$points_max = 0;             // counts how many points a perfect set of answers would get
	for($i=0; $i<$answer_count; $i++){ 
		$points_max+= $priority[$i];
	}

	for($i=0; $i<$answer_count; $i++){
		if($answ[$i] >= $min[$i]){
			// check if school deserves full points or not
			if($answ[$i] > $max[$i]){ 
				// add full points for given question
				$points+= $priority[$i];
			}
			else{	
				// add some points, determined by how high school's answer was
				$points+= ($answ[$i] + 1 - $min[$i]) / ($max[$i] + 1 - $min[$i]) *$priority[$i];
			}
		}
	}
	$result = 0; 
	if($points_max != 0)
		$result = $points / $points_max * 100; // calculates the results in percents
	return intval($result);
}