<?php
/**
 * Business Pro Theme
 *
 * This file adds the service page template to the Business Pro theme, it adds
 * some basic schema.org micro data to the site inner div and H1 heading.
 *
 * Template Name: Assessment Page
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
// add_action( 'wp_enqueue_scripts', 'bootstrap_scripts' );

function new_assessment_loop() {
	$author_id = get_current_user_id();
	$passed_id = get_query_var('id');

	if ($passed_id) {
		acf_form_head();

		while ( have_posts() ) : the_post(); 
			acf_form(array(
				'id'			=> 'edit_assessment_form',
				'post_id'		=> $passed_id,
				'post_title'	=> true,
				'honeypot' => true,
				'return' => 'http://demo.appliedpractice.com/dashboard',
				'submit_value'  => 'Update Assessment'
			));
		endwhile;
	} else {
		$new_post_title = get_the_author_meta('user_email', $author_id) . ' - ' . get_the_date( 'M j' ) . ' - ' . current_time( 'timestamp' );

		acf_form_head();

		while ( have_posts() ) : the_post(); 
			acf_form(array(
				'id'			=> 'new_assessment_form',
				'post_id'		=> 'new_post',
				'new_post'      => array(
					'post_type'     => 'assessments',
					'post_status'   => 'publish'
				),
				'post_title'	=> true,
				'honeypot' => true,
				'return' => 'http://demo.appliedpractice.com/dashboard',
				'submit_value'  => 'Create new assessment'
			));
		endwhile;
	}
}

add_action('genesis_before_content','new_assessment_loop');


function reference_select_jquery() {
	?>
	<script>
		jQuery(document).ready(function( $ ) {
			var postID = acf.get('post_id');
			console.log(postID);
		});
	</script>
	<?php
}

add_action('genesis_before_content', 'reference_select_jquery');

// Run Genesis.
genesis();
