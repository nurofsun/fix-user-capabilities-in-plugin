<?php
/**
 * Plugin Name: Noor Frontend Delete Link
 * Version: 1.0
 * Description: Adding Feature That Admin Can Delete Post Through Frontend
 * Author: Noor
 * Author URI: https://maxrooted.com
 * License: GPL2
 *
 *
 * @info fixed current_user_can function undefined
 */
function noor_generate_delete_link($content)
{
	if ( is_single() && in_the_loop() && is_main_query() )
	{
		$url = add_query_arg(
			[
				'action' => 'noor_deleting_post',
				'post' => get_the_ID()
			],
			home_url()
		);

		return $content . '<a href="' . $url . '">' . __('Delete') . '</a>';
	}

	return false;
}

function noor_delete_post()
{
	if ( current_user_can('edit_others_posts') )
	{
		add_filter('the_content', 'noor_generate_delete_link');

		if ( isset($_GET['action']) && $_GET['action'] === 'noor_deleting_post' )
		{
			// condition and get the value into variable
			$post_id = isset($_GET['post']) ? $_GET['post'] : null;

			// checking the post
			$available_post = get_post((int)$post_id); // pass the $post_id here, and also check is that integer or not.

			if (empty($available_post))
			{
				return;
			} // if $available_post empty then it's not execute any code after this line.

			wp_trash_post($post_id); // trash post or delete post

			wp_safe_redirect(admin_url('edit.php')); // redirect it safely

			die;
		}
	}
}
add_action('init','noor_delete_post');

// register activation hook
function noor_frontend_delete_activated() {
	noor_delete_post();
}
register_activation_hook(__FILE__,'noor_frontend_delete_activated');


function noor_remove_delete_link($content) {
	return $content;
}
add_filter('the_content','noor_remove_delete_link');
//
function noor_frontend_delete_deactivated()
{
	remove_query_arg(
		['action','post'],
		home_url()
	);
	noor_remove_delete_link($content);
}
register_deactivation_hook(__FILE__,'noor_frontend_delete_deactivated');
