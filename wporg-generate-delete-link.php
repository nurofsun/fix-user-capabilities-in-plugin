<?php
/**
* Plugin Name: WPorg Generate delete  Link
*/
//function wporg_generate_delete_link($content)
//{
//// run only for single post page
//if (is_single() && in_the_loop() && is_main_query()) {
//// add query arguments: action, post
//$url = add_query_arg(
//[
//'action' => 'wporg_frontend_delete',
//'post'   => get_the_ID(),
//],
//home_url()
//);
//return $content . ' <a href="' . esc_url($url) . '">' . esc_html__('Delete Post', 'wporg') . '</a>';
//}
//return null;
//}
 
/**
* request handler
*/
//function wporg_delete_post()
//{
//if (isset($_GET['action']) && $_GET['action'] === 'wporg_frontend_delete') {
 
//// verify we have a post id
//$post_id = (isset($_GET['post'])) ? ($_GET['post']) : (null);
 
//// verify there is a post with such a number
//$post = get_post((int)$post_id);
//if (empty($post)) {
//return;
//}
 
//// delete the post
//wp_trash_post($post_id);
 
//// redirect to admin page
//$redirect = admin_url('edit.php');
//wp_safe_redirect($redirect);
 
//// we are done
//die;
//}
//}

//function wporg_generate_delete_link_plugin()
//{
	//if (current_user_can('edit_others_posts')) {
	/**
	* add the delete link to the end of the post content
	*/
	//add_filter('the_content', 'wporg_generate_delete_link');
	
	/**
	* register our request handler with the init hook
	*/
	//add_action('init', 'wporg_delete_post');
	//}
//}
//add_action('plugins_loaded','wporg_generate_delete_link_plugin');
function noor_generated_delete_link($content)
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
		add_filter('the_content', 'noor_generated_delete_link');

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
add_action('plugins_loaded','noor_delete_post');
