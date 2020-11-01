<?php
/**
 * Business Pro Theme
 *
 * This file adds the service page template to the Business Pro theme, it adds
 * some basic schema.org micro data to the site inner div and H1 heading.
 *
 * Template Name: Results Page
 *
 * @package      Business Pro
 * @link         https://seothemes.com/themes/business-pro
 * @author       SEO Themes
 * @copyright    Copyright © 2019 SEO Themes
 * @license      GPL-3.0-or-later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function bootstrap_scripts() {
	wp_enqueue_style('bootstrap-style','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'bootstrap_scripts' );

function assessment_loop() {
	$assessmentCount = 0;
	$user_id = get_current_user_id();
	
	$query_var = get_query_var('id');
	
	echo '<div class="assessment-list">';
	$loop = new WP_Query( array( 'post_type' => 'assessments', 'author' => $user_id ) ); 
	if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); 
		$assessmentCount ++; 
		$correctAnswers = array();
	
		if (get_the_ID() == $query_var) {
			
			$section_count = 0;
			$question_num = 0;
			
			if (have_rows('sections')): while(have_rows('sections')): the_row();
				$section_count ++;
				$reference = get_sub_field('reference');
				$reference_id = $reference->ID;
				$default_questions = get_field('all_questions', $reference_id);
// 				if ($default_questions) {
// 					foreach($default_questions as $question ) {
// 						$question_num ++;

// 	// 					$aquestion = ['questionNum' => $question_num];
// 						$question_id = $question->ID;
// 	// 					$aquestion['id'] = $question->ID;
// 	// 					$aquestion['text'] = $question->post_content;

// 						$possible_answers = ['a','b','c','d','e'];
// 						$answerCount = 0;

// 						$answerInfo = ['answer_reasoning' => get_field('answer_reasoning', $question_id)];
// 						 $answerInfo['learning_objectives'] = get_field('learning_objectives', $question_id);

// 						while (have_rows('possible_answers', $question_id)) {
// 							the_row();
// 							if (get_sub_field('correct_answer')) {
// 								$correct_answer = get_sub_field('answer_text');
// 	// 							$aquestion['correct_answer'] = $correct_answer;

// 								 $answerInfo['correct_choice'] = $possible_answers[$answerCount];

// 							}
// 							$answerCount ++;
// 						}

// 						$correctAnswers[$question_id] = $answerInfo;
// 	// 					array_push($questions, $aquestion);
// 					}
// 				}
				if(have_rows('all_questions')){
					while(have_rows('all_questions')) {
						the_row();
						$question_num ++;

	// 					$aquestion = ['questionNum' => $question_num];

						$question_id = get_sub_field('question_id');
						if (!$question_id) {
							$question_id = $question_num;
						}

// 						$question_id = 's_' . $section_count . '_' . $question_id;
	// 					$question_text = get_sub_field('question_text');

	// 					$aquestion['id'] = $question_id;
	// 					$aquestion['text'] = $question_text;

						$possible_answers = ['a','b','c','d','e'];
						$answerCount = 0;

						$answerInfo = ['answer_reasoning' => get_sub_field('answer_reasoning')];
						$answerInfo['learning_objectives'] = get_sub_field('learning_objectives');

						while (have_rows('possible_answers')) {
							the_row();
							if (get_sub_field('correct_answer')) {
								$correct_answer = get_sub_field('answer_text');
	// 							$aquestion['correct_answer'] = $correct_answer;
	// 							
								$answerInfo['correct_choice'] = $possible_answers[$answerCount];
							}
							$answerCount ++;
						}
	// 					array_push($questions, $aquestion);
	// 					
						$correctAnswers[$question_id] = $answerInfo;
					}
				}
			endwhile; endif;

	?>

		<div class="assessment">
			<div class="assessment-title">
				<h2><?php echo get_the_title(); ?></h2> - <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">[View]</a> <a href="<?php echo 'http://apdemo.flywheelsites.com/wp-admin/post.php?post=' . get_the_ID() . '&action=edit'; ?>" title="edit-<?php the_title(); ?>">[Edit]</a>
			</div>
			<div id="<?php echo 'assessment' . $assessmentCount . '-responses';?>" class="responses acordion">
				<?php
					if (have_rows('responses')) {
						$responseCount = 0;
						while (have_rows('responses')) {
							the_row();
							echo '<div class="response card">';
								$responseCount ++;
								$student_name = get_sub_field('student_name');
								$student_ID = get_sub_field('student_id');
								$student_score = 0;
								$total_questions = 0;
								echo '<div id="collapse' . $assessmentCount . $responseCount .'" class="student-responses collapse" data-parent="#' . 'assessment' . $assessmentCount . '-responses' .'">';
									echo '<div class="card-body">';
										echo '<table>';
							?>
								<colgroup>
									<col style="width:250px;">
									<col style="width:150px;">
									<col style="width:150px;">
									<col>
								</colgroup>
									<?php
										echo '<tbody>';
										echo '<tr>';
										echo '<th>' . 'Question Name' . '</th>';
										echo '<th>' . 'Chosen Answer' . '</th>';
										echo '<th>' . 'Learning Objectives' . '</th>';
										echo '<th>' . 'Correct Answer' . '</th>';
										echo '</tr>';
										while (have_rows('answers')) {
											the_row();											
											$question_id = get_sub_field('question_id');
											$question_name = get_sub_field('question_name');
											$chosen_answer = get_sub_field('chosen_answer');
											$total_questions ++;
											
											$question_id = str_replace('question_','',$question_id);
											$answer_pre = $question_id . "_";

											$chosen_answer = str_replace($answer_pre,'',$chosen_answer);

											$q_class = '';

											$correct_answer = $correctAnswers[$question_id]['correct_choice'];
											$learning_objectives = $correctAnswers[$question_id]['learning_objectives'];

											if ($correct_answer == $chosen_answer) {
												$q_class = 'correct';
												$student_score ++;
											} else {
												$q_class = 'incorrect';
											}

											echo '<tr class="' . $question_id . ' ' . $q_class . ' ' . $correct_answer .'">';
											echo '<td>' . $question_name . '</td>';
											echo '<td><span="chosen_answer">' . $chosen_answer . '</span></td>';
											echo '<td>' . $learning_objectives . '</td>';
											echo '<td>'
												. '<div class="correct-answer-panel">' 
													. '<div class="panel-title">' . 'Correct Answer - ' . $correct_answer . '</div>' 
													. '<div class="panel-description">' . $correctAnswers[$question_id]['answer_reasoning'] . '</div>'
												. '</div>'
												. '</div></td>';
											echo '</tr>'; 
										}
										echo '</tbody>';
										echo '</table>';
									echo '</div>';
								echo '</div>';
							
								echo '<div class="student-info card-header">';
									echo '<a class="card-link" data-toggle="collapse" href="#collapse' . $assessmentCount . $responseCount . '">' 
										. '<div class="student-name">'. $student_name . ' - ' . $student_ID . '</div>' 
										. '<div class="student-score">' . 'Score: ' . $student_score . '/' . $total_questions . '</div>'
										.'</a>';
								echo '</div>';
							
							echo '</div>';
							// End Response Card
						}
					} else {
						echo '<div class="no-responses">No responses submitted</div>';
					}
				?>
			</div>

		</div>
	<?php }
		else {
// 			echo 'query - ' . $query_var;
// 			echo 'id - ' . get_the_ID();
		}
	endwhile;
	endif;
	wp_reset_postdata();
	
	echo '</div>';
}

add_action('genesis_before_content','assessment_loop');

// Run Genesis.
genesis();
