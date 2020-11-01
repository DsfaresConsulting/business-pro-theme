<?php
/**
 * Business Pro Theme
 *
 * This file adds the service page template to the Business Pro theme, it adds
 * some basic schema.org micro data to the site inner div and H1 heading.
 *
 * Template Name: New Assessment Page
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
	wp_enqueue_script( 'jquery-enqueue', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js', array('jquery'));
	
	wp_enqueue_style('select2-style','https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css');
    wp_enqueue_script( 'select2-script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'bootstrap_scripts' );

function custom_form() {
	custom_style();
	custom_script();
	?>
	<!-- MultiStep Form -->
	<div class="row">
		<div class="form-container"> <!-- was class="col-md-6 col-md-offset-3" -->
			<form id="msform" action="" method="POST">
				<!-- progressbar -->
				<ul id="progressbar">
					<li class="active">Assessment Details</li>
					<li>Choose a Reference</li>
					<li>Create Assessment</li>
				</ul>
				<!-- fieldsets -->
				<?php 	$user_info = wp_get_current_user();
						$author_part = $user_info->user_login . ' - '; 
						// get author ID
						$author_id = $user_info->ID; 
						// echo count for post type (post and book)
						$post_count = count_user_posts($author_id , ['assessments'] ) + 1; 
				?>
				<fieldset>
					<h2 class="fs-title">Assessment Details</h2>
					<h3 class="fs-subtitle">Please update the basic details for your assessment</h3>
<!-- 					<input type="text" name="a-title" placeholder="Default Name" value="Default Name"/> -->
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon3"><?php echo $author_part; ?></span>
					  </div>
					  <input type="text" class="form-control" id="a-title" name="a-title" placeholder="Assessment Title" value="<?php echo 'Test ' . $post_count;?>" aria-describedby="basic-addon3">
					</div>
					<div class="input-group mb-3">
						<textarea type="text" name="a-intro" placeholder="Brief Intro"></textarea>
					</div>
					<input type="button" name="next" class="next action-button" value="Next"/>
				</fieldset>
				<fieldset>
					<h2 class="fs-title">Choose a Reference</h2>
					<h3 class="fs-subtitle">Select a reference to start</h3>
					<div class="input-group mb-3 select-container">
						<select class="reference-select form-control" name="reference-1" style="width: 100%;">
						  <option>-- Select a Reference --</option>
						</select>
					</div>
					<div class="reference-container">
						<div class="image-holder"></div>
						<div class="questions-holder">
							<ol class="questions"></ol>
							<div class="add-quesiton-wrapper">
								<input type="button" name="add-question" class="q-add action-button" data-toggle="modal" data-target="#addNewQuestionModal" value="Add New Question"/>
<!-- 								<button class="q-add" data-toggle="modal" data-target="#addNewQuestionModal">Add New Question</button> -->
							</div>
						</div>
					</div>
					<!-- Hidden Inputs -->
					<div id="hidden-inputs">
						<div id="questions">
						</div>
					</div>
					<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
					<input type="button" name="next" class="next action-button" value="Next"/>
<!-- 					<input type="button" name="add-section" class="add-section action-button" value="Add Section"/> -->
				</fieldset>
				<fieldset>
					<h2 class="fs-title">Create Assessment</h2>
					<h3 class="fs-subtitle">Click Submit once you are finished adding questions to your assessment.</h3>
					<input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
					<input type="submit" name="submit" class="submit action-button" value="Create"/>
				</fieldset>
			</form>
		</div>
	</div>
	<!-- /.MultiStep Form -->
	<?php
}

function custom_modal() { 
	?>
	<div id="modal-container">

		<!-- Modal -->
		<div class="modal fade" id="addNewQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addNewQuestionTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="addNewQuestionTitle">Add New Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<fieldset class="add-inputs">
					<div class="form-group">
						<label for="addQuestionText">Question Text</label>
						<textarea class="form-control" id="addQuestionText" rows="2" placeholder=" -- Add Question Text --"></textarea>				
					</div>
					<div class="form-group">
						<label for="addAnswerReasoning">Answer Reasoning</label>
						<textarea class="form-control" id="addAnswerReasoning" rows="2" placeholder=" -- Add Answer Reasoning -- "></textarea>				
					</div>
					<div class="form-group">
						<label for="addPossibleAnswers">Possible Answers</label>
						<div class="possibleAnswersContainer">
							<div class="possible-answers">
								<div class="an-answer"><input type="radio" id="" name="new_question" value=""><label for=""><input type="text" value=""></label></div>
								<div class="an-answer"><input type="radio" id="" name="new_question" value=""><label for=""><input type="text" value=""></label></div>
								<div class="an-answer"><input type="radio" id="" name="new_question" value=""><label for=""><input type="text" value=""></label></div>
								<div class="an-answer"><input type="radio" id="" name="new_question" value=""><label for=""><input type="text" value=""></label></div>
								<div class="an-answer"><input type="radio" id="" name="new_question" value=""><label for=""><input type="text" value=""></label></div>
							</div>
						</div>				
					</div>
					<div class="form-group">
						<label for="addLearningObjectives">Learning Objectives</label>
						<input type="text" class="form-control" id="addLearningObjectives" placeholder=" -- Add Learning Objectives -- ">				
					</div>
				</fieldset>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Add New Question</button>
			  </div>
			</div>
		  </div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editQuestionTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="editQuestionTitle">Edit Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<fieldset class="edit-inputs">
					<div class="form-group">
						<label for="editQuestionText">Question Text</label>
						<textarea class="form-control" id="editQuestionText" rows="2" placeholder="Needs Question Text"></textarea>				
					</div>
					<div class="form-group">
						<label for="editPossibleAnswers">Possible Answers</label>
						<div class="possibleAnswersContainer"></div>			
					</div>
					<div class="form-group">
						<label for="editAnswerReasoning">Answer Reasoning</label>
						<textarea class="form-control" id="editAnswerReasoning" rows="2" placeholder=" -- Add Answer Reasoning -- "></textarea>
					</div>
					<div class="form-group">
						<label for="editLearningObjectives">Learning Objectives</label>
						<input type="text" class="form-control" id="editLearningObjectives" placeholder=" -- Add Learning Objectives -- ">				
					</div>
				</fieldset>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary btn-confirm-edit" data-qid="">Save changes</button>
			  </div>
			</div>
		  </div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="deleteQuestionModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="deleteQuestionTitle">Delete Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p class="pre-delete-message">Are you sure you would like to delete the following question?</p>
				<blockquote class="question-to-delete"></blockquote>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger btn-delete" onclick="removeQuestion(this)" data-qid="">Confirm Delete</button>
			  </div>
			</div>
		  </div>
		</div>
	</div>
<?php
}

function custom_script() {
	?>
	<script>
		jQuery(document).ready(function( $ ) {
			// In your Javascript (external .js resource or <script> tag)
			
			var new_question_count = 0;
			
			var assessment_data= {};
			
			
			$('.reference-select').select2({
				ajax: {
					type: 'GET',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					dataType: 'json',
					data: {
						'action': 'get_references' //this is the name of the AJAX method called in WordPress
					}, 
					processResults: function (data) {
					  // Transforms the top-level key of the response object from 'items' to 'results'
					  return {
						results: data
					  };
					},
					error: function () {
						console.log('ERROR: Ajax');
					}
				}
			});
			
			
			
			$('#msform').submit(function(){
				assessment_data['title'] = $('#a-title').val();
				assessment_data['intro'] = $('textarea[name="a-intro"]').val();
				assessment_data['reference_id'] = $('.reference-select').val(); 
				
				console.log(assessment_data);
				
				$.ajax({
				  url: '<?php echo admin_url('admin-ajax.php'); ?>',
				  type: 'POST',
				  dataType: 'json',
				  data : {
					  'mydata': assessment_data,
					  'action': 'new_assessment'
				  },
				  success: function(result){
					console.log('form submitted. ', result);
				  },
				  error: function(xhr, status, error) {
// 					alert(xhr.responseText);
				  }
				});
				window.location.href = "http://demo.appliedpractice.com/dashboard";
				return false;
			});
			
			$('.add-quesiton-wrapper').hide();
			
			function select2data(posts) {
				var data = [];

				posts.forEach(function(reference) {
					var newref = {
						"id": reference.ID,
						"text": reference.post_title
					}
					console.log(newref);
					data.push(newref);
					
				});
				console.log('new');
				console.dir(data);
							
				$('reference-select').select2({data:JSON.stringify(data)});
			}
					
			$('.reference-select').on("change", function() {
				console.log('changed');
				var reference_id = $(this).val();
                var parent_row = $(this).closest('fieldset');
				
				new_question_count = 0;
                
				$.ajax({
					type: 'GET',
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					dataType: 'json',
					data: {
						'reference_id': reference_id,
						'action': 'set_default_questions' //this is the name of the AJAX method called in WordPress
					}, success: function (result) {

						var img_html = '<img class="reference_image" src="' + result.images[0].url + '"/>';
						var img_url = result.images[0].url;
						var img_html = '<figure class="wp-block-gallery">' + '<ul class="blocks-gallery-grid reference_images">'
							+ '<li class="blocks-gallery-item">' 
								+ '<figure>' + '<a href="' + img_url + '" data-featherlight="image">' + '<img loading="lazy" src="' + img_url + '"/>' + '</a>' + '</figure>'
							+ '</li>'
						+ '</ul>' + '</figure>';
						var image_holder = parent_row.find('.reference-container .image-holder');
						image_holder.empty();
						image_holder.prepend(img_html);

						var questions_holder = parent_row.find('.reference-container .questions-holder .questions');
						questions_holder.empty();
						
						result['default_questions'].forEach(function(question, index) {
							console.log('---');
							console.log(question);
							console.log(index);
							console.dir(question);

							var question_html = '<li class="question" id="question_' + question["ID"] + '" data-learning_objectives="' + question["Learning Objectives"] + '" data-qid="' + question["ID"] + '">'
								+ '<div class="question-wrapper">'
									+ '<div class="question-text">'
										+ '<a class="" data-toggle="collapse" href="#q_collapse_' + question["ID"] + '" role="button" aria-expanded="false" aria-controls="q_collapse_' + question["ID"] + '">'
										 + question["Question Text"]
									  	+ '</a>'
										+ '<div class="collapse" id="q_collapse_' + question["ID"] + '">'
											+ '<div class="question-info">'
												+ '<div class="answer-reasoning">' + question["Answer Reasoning"] + '</div>'
												+ '<div class="possible-answers">';
												var answerchoices = ['a','b','c','d','e'];
												question["Possible Answers"].forEach(function(answer, index){
													var checked = '';
													var answer_choice = answerchoices[index];
													var answer_html = '';
													
													var question_name = 'ques_' + question["ID"] + '_ans_' + answer_choice;
													if (answer["correct_answer"]){
														console.log(question_name + '- ' + 'checked');
														checked = 'checked';
													}
													var answer_html = '<div class="an-answer">' + '<input ' + checked + ' type="radio" id="' + question_name
														+ '" name="question_' + question["ID"] + '" value="' + question_name + '" ' + '>'
													+ '<label for="' + question_name + '">' + '<input type="text" value="' + answer["answer_text"] + '"></label>' + '</div>';
														
													question_html += answer_html;
												 });
												question_html += '</div>'
												+ '<div class="question-controls">' 
													+ '<input type="button" name="edit-question" class="q-edit action-button" data-toggle="modal" data-target="#editQuestionModal" value="Edit Question"/>'
													+ '<input type="button" name="delete-question" class="q-delete action-button" data-toggle="modal" data-target="#deleteQuestionModal" value="Delete Question"/>'
												+ '</div>'
											+ '</div>'
										+ '</div>'
									+ '</div>'	
								+ '</div>'
							+ '</li>';

							questions_holder.append( question_html );

							console.log('---');
						});
						buttonListeners();
						$('.add-quesiton-wrapper').show();
						$('.next').show();
					},
					error: function () {
						console.log('ERROR: Ajax');
					}
				});		
			});
			
			function buttonListeners() {
				
				$('body').on( 'click', '.q-delete', function(){
					var question = $(this).closest('.question');
					delete_button_clicked(question);
				});
				$('body').on( 'click', '.q-edit', function(){
					var question = $(this).closest('.question');
					edit_button_clicked(question);
				});
				$('body').on( 'click', '.q-add', function(){
					console.log('add-question');
					add_button_clicked();
				});
				$('body').on( 'click', '#deleteQuestionModal .btn-delete', function() {
					var qid = $(this).attr('data-qid');
					var dModal = $('#deleteQuestionModal');
					
					$(('#' + qid)).remove();
					dModal.modal('hide');
				});
				$('body').on( 'click', '#editQuestionModal .btn-confirm-edit', function() {
					var qid = $(this).attr('data-qid');
					var eModal = $('#editQuestionModal');
					
					console.log('confirm-edit');
					console.log(qid);
					
					var updatedAnswers = eModal.find('.possibleAnswersContainer .possible-answers').clone();
					console.log('updatedAnswers');
					console.dir(updatedAnswers);
					var updatedReasoning = eModal.find('#editAnswerReasoning').val();
					var updatedObjectives = eModal.find('#editLearningObjectives').val();
					var updatedText = eModal.find('#editQuestionText').val();
					
					var question = $(('#' + qid));
					
					console.dir(question);
					
					question.find('.question-text a').text(updatedText);
					question.find('.possible-answers').replaceWith(updatedAnswers);
					question.find('.answer-reasoning').text(updatedReasoning);
					question.attr('data-learning_objectives', updatedObjectives);

					eModal.modal('hide');
				});
				$('body').on( 'click', '#addNewQuestionModal .btn-primary', function() {
					var qid = $(this).attr('data-qid');
					var aModal = $('#addNewQuestionModal');
					
					console.log('confirm-add');
					console.log(qid);
					
					var qAnswers = aModal.find('.possibleAnswersContainer .possible-answers').clone();
					var qReasoning = aModal.find('#addAnswerReasoning').val();
					var qObjectives = aModal.find('#addLearningObjectives').val();
					var qText = aModal.find('#addQuestionText').val();
					
					console.dir(qAnswers);
					console.log(qReasoning);
					console.log(qObjectives);
					console.log(qText);
					
					var questionOptions = ["a","b","c","d","e"];
					
					var new_question = '<li class="question" id="question_' + qid + '" data-learning_objectives="' + qObjectives + '" data-qid="' + qid + '">'
								+ '<div class="question-wrapper">'
									+ '<div class="question-text">'
										+ '<a class="" data-toggle="collapse" href="#q_collapse_' + qid + '" role="button" aria-expanded="false" aria-controls="q_collapse_' + qid + '">'
										 + qText
									  	+ '</a>'
										+ '<div class="collapse" id="q_collapse_' + qid + '">'
											+ '<div class="question-info">'
												+ '<div class="answer-reasoning">' + qReasoning + '</div>'
												+ '<div class="possible-answers">' + '</div>'
												+ '<div class="question-controls">' 
													+ '<input type="button" name="edit-question" class="q-edit action-button" data-toggle="modal" data-qid="question_' + qid + '" data-target="#editQuestionModal" value="Edit Question"/>'
													+ '<input type="button" name="delete-question" class="q-delete action-button" data-toggle="modal" data-qid="question_' + qid + '" data-target="#deleteQuestionModal" value="Delete Question"/>'
												+ '</div>'
											+ '</div>'
										+ '</div>'
									+ '</div>'	
								+ '</div>'
							+ '</li>';
					
					$('.reference-container .questions-holder .questions').append(new_question);
					$('.reference-container .questions-holder .questions .question').last().find('.possible-answers').replaceWith(qAnswers);

					aModal.modal('hide');
				});
			}
			
			function delete_button_clicked(question_element) {
				console.log('delete question');
				var question = question_element;
				var question_id = question.attr('id');

				var question_text = question.find('.question-text a').html();
				var dModal = $('#deleteQuestionModal');

				var delete_button = dModal.find('.btn-delete');
				delete_button.attr("data-qid",question_id);
				var question_quote = dModal.find('.question-to-delete');
				question_quote.html(question_text);
				dModal.modal('show');
			}
			function edit_button_clicked(question_element) {
				console.log('edit-question');
				console.dir(question_element);
				question = question_element;
				
				var question_id = question.attr('id');
				var question_text = question.find('.question-text a').text();
				
				var possible_answers = question.find('.possible-answers').clone();
				var answer_reasoning = question.find('.answer-reasoning').clone().html();
				var learning_objectives = question.attr('data-learning_objectives');
				
				var eModal = $('#editQuestionModal');

				eModal.find('#editQuestionText').val(question_text);
				eModal.find('.possibleAnswersContainer').html(possible_answers);
				eModal.find('#editAnswerReasoning').val(answer_reasoning);
				eModal.find('#editLearningObjectives').val(learning_objectives);

				var close_button = eModal.find('.btn-secondary');
				var edit_button = eModal.find('.btn-confirm-edit');
				edit_button.attr("data-qid",question_id);
				
				eModal.modal('show');
			}
			function add_button_clicked() {
				console.log('add-question');
				new_question_count ++;
				
				var question_id = 'new' + new_question_count;
				
				var questionOptions = ["a","b","c","d","e"];
				
				var aModal = $('#addNewQuestionModal');
				var optionCount = 0;
				
				var answerLabels = aModal.find('.possible-answers .an-answer').each(function(){
					var answer_id = question_id + "_ans_" + questionOptions[optionCount];
					var placeholder = ' -- Option ' + questionOptions[optionCount].toUpperCase() + ' -- ';
					$(this).find('label').attr("for",answer_id);
					$(this).find('input:radio').attr("id",answer_id);
					$(this).find('input:radio').attr("name",question_id);
					$(this).find('input:radio').attr("value",answer_id);
					$(this).find('label input').attr("placeholder", placeholder);
					optionCount ++;
				});
			
				aModal.find('#addQuestionText').val('');
				aModal.find('.an-answer label input').val('');
				aModal.find('#addAnswerReasoning').val('');
				aModal.find('#addLearningObjectives').val('');

				var add_button = aModal.find('.btn-primary');
				add_button.attr("data-qid",question_id);
				
				aModal.modal('show');
			}
			
			function store_section_data() {
				var question_num = 1;
				console.log('-----store');
				
				assessment_data['questions'] = [];
				$('.questions .question').each(function() {
					var question_html = '';
					
					var possible_answers = [];
					$(this).find('.possible-answers .an-answer').each(function() {
						var checked = $(this).find('input:radio').is(':checked');
						var answer_text = $(this).find('label input').val();
						
						var an_answer = {
							'is_checked': checked,
							'answer_text': answer_text
						}
						possible_answers.push(an_answer);
					});
					
					var question_info = {
						'question_id': $(this).attr("data-qid"),
						'question_text': $(this).find('.question-text > a').clone().html(),
						'answer_reasoning': $(this).find('.answer-reasoning').clone().html(),
						'learning_objectives': $(this).find('.learning_objectives').clone().html(),
						'possible_answers': possible_answers
					}
					
					assessment_data['questions'].push(question_info);
// 					question_html += '<div class="a-question">';
// 						question_html += '<input type="text" id="questions['+ question_num +'][question_id]" name="questions['+ question_num +'][question_id]" value="' + $(this).attr("data-qid") +'"/>';
// 						question_html += '<input type="text" id="questions['+ question_num +'][question_text]" name="questions['+ question_num +'][question_text]" value="' + $(this).find('.question-text > a').clone().html() +'"/>';
// 						question_html += '<input type="text" id="questions['+ question_num +'][question_text]" name="questions['+ question_num +'][answer_reasoning]" value="' + $(this).find('.answer-reasoning').clone().html() +'"/>';
// 						question_html += '<input type="text" id="questions['+ question_num +'][question_text]" name="questions['+ question_num +'][learning_objectives]" value="' + $(this).find('.learning_objectives').clone().html() +'"/>';
// 					question_html += '</div>';
// 					question_num ++;
// 					$('#hidden-inputs #questions').append(question_html);
// 					
// 					console.log(assessment_data);
				});
			}
			
			
			//jQuery time
			var current_fs, next_fs, previous_fs; //fieldsets
			var left, opacity, scale; //fieldset properties which we will animate
			var animating; //flag to prevent quick multi-click glitches

			$(".next").click(function(){
				if(animating) return false;
				animating = true;
				
				store_section_data();

				current_fs = $(this).parent();
				next_fs = $(this).parent().next();

				//activate next step on progressbar using the index of next_fs
				$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

				//show the next fieldset
				next_fs.show(); 
				//hide the current fieldset with style
				current_fs.animate({opacity: 0}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale current_fs down to 80%
						scale = 1 - (1 - now) * 0.2;
						//2. bring next_fs from the right(50%)
						left = (now * 50)+"%";
						//3. increase opacity of next_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({
					'transform': 'scale('+scale+')',
					'position': 'absolute'
				  });
						next_fs.css({'left': left, 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.hide();
						animating = false;
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
				$('.next').hide();
			});
			
			$(".previous").click(function(){
				if(animating) return false;
				animating = true;

				current_fs = $(this).parent();
				previous_fs = $(this).parent().prev();

				//de-activate current step on progressbar
				$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

				//show the previous fieldset
				previous_fs.show(); 
				//hide the current fieldset with style
				current_fs.animate({opacity: 0}, {
					step: function(now, mx) {
						//as the opacity of current_fs reduces to 0 - stored in "now"
						//1. scale previous_fs from 80% to 100%
						scale = 0.8 + (1 - now) * 0.2;
						//2. take current_fs to the right(50%) - from 0%
						left = ((1-now) * 50)+"%";
						//3. increase opacity of previous_fs to 1 as it moves in
						opacity = 1 - now;
						current_fs.css({'left': left});
						previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
					}, 
					duration: 800, 
					complete: function(){
						current_fs.hide();
						animating = false;
						previous_fs.css({'position':'relative'});
					}, 
					//this comes from the custom easing plugin
					easing: 'easeInOutBack'
				});
				
				$('.next').show();
			});

			$(".submit").click(function(){
				console.log('create clicked');
// 				$('#msform').submit();
// 				return false;
			})
		});
	</script>
	<?php
}



function custom_style() {
	?>
	<style>
		/*custom font*/
		@import url(https://fonts.googleapis.com/css?family=Montserrat);
		
		:root {
			--main-color: #0072c1;
		}

		/*form styles*/
		#msform {
			text-align: center;
			position: relative;
			margin-top: 30px;
		}

		#msform fieldset {
			background: white;
			border: 0 none;
			border-radius: 0px;
			box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
			padding: 20px 30px;
			box-sizing: border-box;
			width: 100%;

			/*stacking fieldsets above each other*/
			position: relative;
		}

		/*Hide all except first fieldset*/
		#msform fieldset:not(:first-of-type) {
			display: none;
		}

		/*inputs*/
		#msform input, #msform textarea {
			padding: 15px;
			border: 1px solid #ccc;
			border-radius: 0px;
			flex: 1;
			box-sizing: border-box;
			font-family: montserrat;
			color: #2C3E50;
			font-size: 13px;
		}

		#msform input:focus, #msform textarea:focus {
			-moz-box-shadow: none !important;
			-webkit-box-shadow: none !important;
			box-shadow: none !important;
			border: 1px solid var(--main-color);
			outline-width: 0;
			transition: All 0.5s ease-in;
			-webkit-transition: All 0.5s ease-in;
			-moz-transition: All 0.5s ease-in;
			-o-transition: All 0.5s ease-in;
		}

		/*buttons*/
		#msform .action-button {
			width: 100px;
			background: var(--main-color);
			font-weight: bold;
			color: white;
			border: 0 none;
/* 			border-radius: 25px; */
			cursor: pointer;
			padding: 10px 5px;
			margin: 10px 5px;
		}

		#msform .action-button:hover, #msform .action-button:focus {
			box-shadow: 0 0 0 2px white, 0 0 0 3px var(--main-color);
		}

		#msform .action-button-previous {
			width: 100px;
			background: #C5C5F1;
			font-weight: bold;
			color: white;
			border: 0 none;
			border-radius: 25px;
			cursor: pointer;
			padding: 10px 5px;
			margin: 10px 5px;
		}

		#msform .action-button-previous:hover, #msform .action-button-previous:focus {
			box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
		}

		/*headings*/
		.fs-title {
			font-size: 18px;
			text-transform: uppercase;
			color: #2C3E50;
			margin-bottom: 10px;
			letter-spacing: 2px;
			font-weight: bold;
		}

		.fs-subtitle {
			font-weight: normal;
			font-size: 13px;
			color: #666;
			margin-bottom: 20px;
		}

		/*progressbar*/
		#progressbar {
			margin-bottom: 30px;
			overflow: hidden;
			/*CSS counters to number the steps*/
			counter-reset: step;
		}

		#progressbar li {
			list-style-type: none;
			text-transform: uppercase;
			font-size: 16px;
			width: 33.33%;
			float: left;
			position: relative;
			letter-spacing: 1px;
		}

		#progressbar li:before {
			content: counter(step);
			counter-increment: step;
			width: 32px;
			height: 32px;
			line-height: 34px;
			display: block;
			font-size: 22px;
			color: #333;
			background: white;
			border-radius: 25px;
			margin: 0 auto 10px auto;
		}

		/*progressbar connectors*/
		#progressbar li:after {
			content: '';
			width: 100%;
			height: 2px;
			background: white;
			position: absolute;
			left: -50%;
			top: 9px;
			z-index: -1; /*put it behind the numbers*/
		}

		#progressbar li:first-child:after {
			/*connector not needed before the first step*/
			content: none;
		}

		/*marking active/completed steps green*/
		/*The number of the step and the connector before it = green*/
		#progressbar li.active:before, #progressbar li.active:after {
			background: var(--main-color);
			color: white;
		}

	</style>
	<?php
}




function create_assessment() {
// 	print_r($_POST);
	$assessment_title = $_POST['a-title'];
	$assessment_intro = $_POST['a-intro'];
	$reference_1 = $POST['reference-1'];
	
	echo '<div class="new-assessment-notification">';
		echo '<h2>' . 'New Assessment Created' . '</h2>';
		echo '<h3>' . $assessment_title . '</h3>';
		echo '<p>' . '<b>Intro:</b><br/>' . $assessment_intro . '</p>';
		echo '<p>' . '<b>Reference:</b> ' . $reference_1 . '</p>';
	echo '</div>';
	echo '<div class="debug">';
		echo '<h2>' . 'DEBUG:' . '</h2>';
		echo '<p>';
		print_r($_POST);
		echo '</p>';
	echo '</div>';
}



if($_POST && $_POST['submit']) {
	add_action('genesis_entry_content', 'create_assessment');
	// Do some minor form validation to make sure there is content
	$user_info = wp_get_current_user();
	$author_part = $user_info->user_login . ' - '; 
    if (isset ($_POST['a-title'])) {
        $title =  $author_part . $_POST['a-title'];
    } else {
        echo 'Please enter a title';
    }
    if (isset ($_POST['a-intro'])) {
        $description = $_POST['a-intro'];
    } else {
        echo 'Please enter the content';
    }
    // Add the content of the form to $post as an array
    $new_post = array(
        'post_title'    => $title,
        'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
        'post_type' => 'assessments'  //'post',page' or use a custom post type if you want to
    );
    //save the new post
    $pid = wp_insert_post($new_post); 
	
	update_field('brief_intro', $description, $pid);
    //insert taxonomies
} else { 
	add_action('genesis_entry_content', 'custom_form');

	add_action('genesis_before_footer', 'custom_modal');
}

add_action('genesis_entry_content', 'create_assessment_wrapper');

// Run Genesis.
genesis();
