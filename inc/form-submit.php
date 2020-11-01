<?php
function submit_response() {
	$assessment_id = get_the_id();

	$student_name = $_POST["student_name"];
    $student_ID = $_POST["student_id"];
    $student = array(
        'student_name' => $student_name,
        'student_id' => $student_ID
    );
	
	$answers = array();
    $row_count = 0;
	$answerstring ='';
    foreach($_POST as $key => $value)
    {
        if (strstr($key, 'question_'))
        {
            $row_count ++;
            $answer = array(
                'question_id' => $key,
                'chosen_answer' => $value
            );
			$answerstring .= ' | ' . $key . ' - ' . $value;
            array_push($answers, $answer);
        }
    }
	
	$responses = get_field('responses');
	$has_responses = 'boop';
	
	if ($responses) {
		$has_responses = 'true';
	} else {
		$has_responses = 'false';
	}
	
	$student['answers'] = $answers;
	
// 	$student_responses = get_post_meta($assessment_id, 'student_responses', false);
// 	if ($student_responses) {
// 		array_push($student_responses, $student);
// 		update_post_meta( $assessment_id, 'student_responses', $student_responses );
// 	} else {
// 		$student_responses = array($student);
// 		add_post_meta( $assessment_id, 'student_responses', $student_responses);
// 	}
	
	$row = array(
		'student_name'   => 'David',
		'student_id'  => 'test'
	);

	$can_response = update_field('field_5f3410d6cf267', array($row), $assessment_id); //responses
// 	wp_redirect( home_url() . '?student_name=' . $student_name . '&student_id=' . $student_ID . '&responses=' . $student);
	echo '<Div class="submitted-message">' . $can_response . '</div>';
}

submit_response();
?>