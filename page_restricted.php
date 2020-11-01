<?php
/**
 * Template Name: Restricted Content
 */

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

if( is_user_logged_in()) {
	add_action( 'genesis_entry_content', 'genesis_do_post_content' );
} else {
	add_action( 'genesis_entry_content', 'restricted_user_message');
}

function restricted_user_message() {
	$message_for_user = get_field('message_for_restricted_users');
	echo $message_for_user;
}
genesis();
