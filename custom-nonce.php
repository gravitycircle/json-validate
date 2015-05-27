<?php
/*
Plugin Name: Custom Nonce for AngularJS
Plugin URI:  http://kevinlouisdesign.com
Description: This plugin secures API communication between a matching AngularJS site.
Version:     1.0
Author:      Richard Ong
Author URI:  http://richardbryanong.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/
include_once(plugin_dir_path( __FILE__ ).'actions/encryption.php');
include_once(plugin_dir_path( __FILE__ ).'admin-menu/options.php');


if(is_admin())
{
	add_action( 'admin_menu', 'custom_nonce' );
	add_action( 'admin_init', 'register_custom_nonce_settings' );
}

function custom_nonce() {

	add_menu_page( 'JSON Security Options', 'JSON Security', 'manage_options', 'custom-nonce', 'nonce_settings', '', 79 );
}

function generate_option_metabox($id, $title, $array) {
	$echo = '';
	if(is_array($array))
	{
		$els = '';
		foreach($array as $otitle => $object)
		{
			if($object['type'] == 'text')
			{
				$input = '<input type="text" class="cn_input" name="'.$object['option-name'].'" value="'.esc_attr(get_option($object['option-name'])).'" style="width: 100%;" />';
			}
			else if($object['type'] == 'paragraph')
			{
				$input = '<textarea class="cn_input" name="'.$object['option-name'].'" style="width: 100%; height: 120px; resize: none;">'.esc_attr(get_option($object['option-name'])).'</textarea>';
			}
			$d = '';
			$c = '';
			if($object['description'] != '')
			{
				$d = '<p style="color: #999; font-style: italic;">'.$object['description'].'</p>';
			}

			if($object['classes'] != '')
			{
				$c = ' class="'.$object['classes'].'"';
			}

			$els .= '<p><strong>'.$otitle.'</strong></p>'.$d.'<p'.$c.'>'.$input.'</p>';
		}

		$echo = '
		<div id="'.$id.'" class="postbox ">
			<div class="handlediv" title="Click to toggle">
				<br>
			</div>
			<h3 class="hndle ui-sortable-handle">
				<span>'.$title.'</span>
			</h3>
			<div class="inside">
				'.$els.'
			</div>
		</div>
		';
	}

	return $echo;
}

function my_enqueue($hook) {
    
    if($hook == 'toplevel_page_custom-nonce')
    {
    	wp_enqueue_style('custom-nonce-styles', plugin_dir_url( __FILE__ ) . 'behaviors.css' );
    	wp_enqueue_script('custom-nonce-actions', plugin_dir_url( __FILE__ ) . 'actions.js' );
    }
}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );
?>