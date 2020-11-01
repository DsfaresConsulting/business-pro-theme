<?php
/**
 * Business Pro Theme
 *
 * This file adds the service page template to the Business Pro theme, it adds
 * some basic schema.org micro data to the site inner div and H1 heading.
 *
 * Template Name: Dashboard Page
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

// add_filter( 'genesis_attr_site-inner', 'business_service_site_inner' );
// /**
//  * Filter the site-inner div.
//  *
//  * Adds schema.org microdata to the site-inner div to declare
//  * the contents as a service.
//  *
//  * @since 1.0.0
//  *
//  * @param  array $attr Array of site-inner values.
//  * @return array
//  */
// function business_service_site_inner( $attr ) {
// 	$attr['itemscope'] = 'itemscope';
// 	$attr['itemtype']  = 'https://schema.org/Service';

// 	return $attr;
// }

// add_filter( 'business_hero_title_markup', 'business_service_title' );
// /**
//  * Filter the page title.
//  *
//  * Adds the correct schema.org markup for service type heading.
//  * The type of service being offered, e.g. veterans' benefits,
//  * emergency relief, etc.
//  *
//  * @since 1.0.0
//  *
//  * @link   http://schema.org/serviceType
//  * @return string
//  */
// function business_service_title() {
// 	return '<h1 itemprop="serviceType">';
// }
// 



function bootstrap_scripts() {
	wp_enqueue_style('bootstrap-style','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'bootstrap_scripts' );



function assessment_loop() {
	$assessmentCount = 0;
	$user_id = get_current_user_id();
	
	echo '<div class="assessment-list">';
	$loop = new WP_Query( array( 'post_type' => 'assessments', 'author' => $user_id ) ); 
	if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
		<div class="assessment" id="assessment_<?php echo get_the_ID();?>">
			<div class="assessment-row">
				<div class="a-title"><?php echo get_the_title(); ?></div>
				<div class="a-results">
					<a href="<?php echo 'http://demo.appliedpractice.com/assessment-results?id=' . get_the_ID(); ?>" title="results-<?php the_title(); ?>">Results</a>
				</div>
				<div class="a-edit">
					<a href="<?php echo 'http://demo.appliedpractice.com/create-new-assessment?id=' . get_the_ID() . '&action=edit'; ?>" title="edit-<?php the_title(); ?>">Edit</a>
				</div>
				<div class="a-link">
					<a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>">+ Create Link</a>
				</div>
				<div class="a-delete">
					<a href="#" title="<?php the_title(); ?>" data-aid="<?php echo get_the_id();?>">Delete</a>
				</div>
			</div>
		</div>
	<?php endwhile;
	endif;
	wp_reset_postdata();
	
	echo '</div>';
}

function dashboard_modals() {
	?>
	<script>
		jQuery(document).ready(function( $ ) {
			$('body').on( 'click', '.a-delete a', function(){
				var assessment_id = $(this).attr('data-aid');
				var dModal = $('#deleteAssessmentModal');
				
				dModal.find('.btn-delete').attr('data-aid', assessment_id);
				dModal.modal('show');
			});
			$('body').on( 'click', '#deleteAssessmentModal .btn-delete', function(){
				var assessment_id = $(this).attr('data-aid');
				delete_assessment_clicked(assessment_id);
			});
			
			function delete_assessment_clicked(_assessment_id) {
				$.ajax({
				  url: '<?php echo admin_url('admin-ajax.php'); ?>',
				  type: 'POST',
				  dataType: 'json',
				  data : {
					  'post_to_delete': _assessment_id,
					  'action': 'delete_assessment'
				  },
				  success: function(result){
					console.log('form submitted. ', result);
					$(('#assessment_' + _assessment_id)).remove();	  
					$('#deleteAssessmentModal').modal('hide');
				  },
				  error: function(xhr, status, error) {
				// 					alert(xhr.responseText);
				  }
				});
				return false;
			}
		});
	</script>
	<div id="modal-container">
		<!-- Modal -->
		<div class="modal fade" id="deleteAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="deleteAssessmentTitle" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="deleteAssessmentTitle">Delete Assessment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p class="pre-delete-message">Are you sure you would like to delete the following assessment?</p>
				<blockquote class="assessment-to-delete"></blockquote>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger btn-delete" data-aid="">Confirm Delete</button>
			  </div>
			</div>
		  </div>
		</div>
	</div>
	<?php 
}

add_action('genesis_before_content','assessment_loop');

add_action('genesis_before_footer', 'dashboard_modals');

// Run Genesis.
genesis();
