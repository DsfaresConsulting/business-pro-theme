<?php
/**
 * Business Pro Theme
 *
 * This file adds the front page to the Business Pro Theme.
 *
 * @package   BusinessProTheme
 * @link      https://seothemes.com/themes/business-pro
 * @author    SEO Themes
 * @copyright Copyright © 2019 SEO Themes
 * @license   GPL-3.0-or-later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Check if any front page widgets are active.
if ( is_active_sidebar( 'front-page-1' ) ||
	is_active_sidebar( 'front-page-2' ) ||
	is_active_sidebar( 'front-page-3' ) ||
	is_active_sidebar( 'front-page-4' ) ||
	is_active_sidebar( 'front-page-5' ) ||
	is_active_sidebar( 'front-page-6' ) ) {

	// Force full-width-content layout.
	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	// Remove default hero section.
	remove_action( 'genesis_before_content_sidebar_wrap', 'business_hero_section' );

	// Remove content-sidebar-wrap.
	add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

	// Remove default loop.
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_loop', 'business_front_page_loop' );

	/**
	 * Front page content.
	 *
	 * @since  1.0.5
	 *
	 * @return void
	 */
	function business_front_page_loop() {

		// Get custom header markup.
		ob_start();
		the_custom_header_markup();
		$custom_header = ob_get_clean();

		// Check if using SEO slider.
		$hero_section = business_sidebar_has_widget( 'front-page-1', 'seo_slider' ) ? '" role="banner">' : ' hero-section" role="banner">' . $custom_header;

		// Display Front Page 1 widget area.
		genesis_widget_area( 'front-page-1', array(
			'before' => '<div class="front-page-1 widget-area' . $hero_section . '<div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Front page 2 widget area.
		genesis_widget_area( 'front-page-2', array(
			'before' => '<div class="front-page-2 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Front page about widget area.
		genesis_widget_area( 'front-page-about', array(
			'before' => '<div class="front-page-about widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
		
		// Front page 3 widget area.
		genesis_widget_area( 'front-page-3', array(
			'before' => '<div class="front-page-3 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Front page 4 widget area.
		genesis_widget_area( 'front-page-4', array(
			'before' => '<div class="front-page-4 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Front page 5 widget area.
		genesis_widget_area( 'front-page-5', array(
			'before' => '<div class="front-page-5 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );

		// Front page 6 widget area.
		genesis_widget_area( 'front-page-6', array(
			'before' => '<div class="front-page-6 widget-area"><div class="wrap">',
			'after'  => '</div></div>',
		) );
	}
}

// Run Genesis.
genesis();
