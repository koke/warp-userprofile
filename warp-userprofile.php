<?php
/*
Plugin Name: Warp User Profile extension
Plugin URI: http://people.warp.es/~koke/wp-plugins/warp-userprofile
Description: Shows a directory of authors and their personal info
Version: 0.1
Author: Jorge Bernal
Author URI: http://koke.amedias.org/
*/

/*  Copyright 2008  Jorge Bernal  <jbernal@warp.es>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define(warp_userprofile_version,'0.1');

/**
* Warp User Profile extension
*/
class Warp_UserProfile
{
	function init()
	{
		// Register actions and filters here
		add_action('edit_user_profile', array('Warp_UserProfile', 'show_extra_fields'));
		add_action('show_user_profile', array('Warp_UserProfile', 'show_extra_fields'));
		add_action('profile_update', array('Warp_UserProfile', 'save_extra_fields'));
		add_action('personal_options_update', array('Warp_UserProfile', 'save_extra_fields'));
		add_filter('query_vars', array('Warp_UserProfile', 'query_vars'));
		add_filter('generate_rewrite_rules', array('Warp_UserProfile', 'register_rewrite_rules'));
		add_action('template_redirect', array('Warp_UserProfile', 'show_profiles'));
		add_action('admin_print_scripts', array('Warp_UserProfile', 'admin_js'));
		add_action('admin_menu', array('Warp_UserProfile', 'add_option_pages'));
		register_activation_hook(__FILE__, array('Warp_UserProfile', 'register_version'));
	}
	
	function register_version()
	{		
		add_option('warp_userprofile_version', warp_userprofile_version);
		update_option('warp_userprofile_version', warp_userprofile_version);
		add_option("warp_userprofile_page");
	}
	
	function register_rewrite_rules($wp_rewrite)
	{
		$plink = Warp_UserProfile::get_plink();
		$userprofile_rules = array(
			// 'people/?' => 'wp-content/plugins/warp-userprofile/people.php'
			"$plink([^/]+)/?" => 'index.php?showprofiles=1&person=' . $wp_rewrite->preg_index(1) . '&page_id=' . get_option('warp_userprofile_page'),
			"$plink?" => 'index.php?showprofiles=1' . '&page_id=' . get_option('warp_userprofile_page'),
			);
		$wp_rewrite->rules = array_merge($userprofile_rules, $wp_rewrite->rules);
	}
	
	function add_option_pages()
	{
		add_options_page(__('Profiles', 'warp_userprofile'), __('Profiles', 'warp_userprofile'), 8, 'warp-userprofile', array('Warp_UserProfile', 'options_page'));
	}
	
	function query_vars($vars)
	{
		$vars[] = "showprofiles";
		$vars[] = "person";
		$vars[] = "page_id";
		return $vars;
	}
	
	function admin_js()
	{
		wp_enqueue_script("editor");
	}
	
	function show_profiles()
	{
		global $wp_rewrite, $wp_query;
		
		if (get_query_var("showprofiles")) {
			if (get_query_var("person")) {
				$user = get_userdatabylogin(get_query_var('person'));
				if (get_usermeta($user->ID, 'warp_up_public') == 1) {
					require 'person.php';
				} else {
					$wp_query->is_404 = true;
					return;
				}
			} else {
				require 'people.php';
			}
			exit;
		}
	}
	
	function options_page()
	{
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		
		$warp_userprofile_page = get_option("warp_userprofile_page");
		echo "<div class='wrap'>";
		echo "<h2>" . __( 'Profiles Options', 'warp_userprofile') . "</h2>";
		?>
		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<h3><?php _e( 'General options', 'warp_lms'); ?></h3>
			<table class="form-table">
					<tr>
						<th>
							<?php _e( 'Profiles page', 'warp_lms'); ?>
						</th>
						<td>
							<?php wp_dropdown_pages(array('name' => 'warp_userprofile_page', 'selected' => $warp_userprofile_page)); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" name="page_options" value="warp_userprofile_page" />
			<input type="hidden" name="action" value="update" />

			<p class="submit"><input type="submit" value="<?php _e( 'Update Options', 'warp_userprofile'); ?>"></p>
		</form>
		<?php
		echo "</div>";
	}
	
	function show_extra_fields()
	{
		$user = $GLOBALS['profileuser'];
		echo '<h3>' . __( 'Profile extras', 'warp_userprofile' ) . '</h3>';
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<?php _e( 'Public profile', 'warp_userprofile' ); ?>
					</th>
					<td>
						<input type="checkbox" name="warp_up_public" value="1" id="warp_up_public" <?php if (get_usermeta($user->ID, 'warp_up_public') == 1) { echo 'checked="checked"'; } ?> />
						<label for="warp_up_public"><?php _e( 'If checked, this profile will be shown in the public directory', 'warp_userprofile' ); ?></label>
					</td>
				</tr>
				<tr>
					<th>
						<?php _e( 'Title', 'warp_userprofile' ); ?>
					</th>
					<td>
						<input type="text" name="warp_up_title" value="<?php echo get_usermeta($user->ID, 'warp_up_title'); ?>" id="warp_up_title" /><br />
						<?php _e( 'Your position at the company', 'warp_userprofile' ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<div id="editorcontainer">
			
		</div>
		<script type="text/javascript">
		<!--
		// edCanvas = document.getElementById('description');
		tinyMCE.execCommand("mceAddControl", false, "description");
		//-->
		</script>
		
		<?php
	}
	
	function save_extra_fields()
	{
		global $wpdb;
		$user_id = (int) $_POST["user_id"];
		update_usermeta($user_id, "warp_up_title", $_POST["warp_up_title"]);
		update_usermeta($user_id, "warp_up_public", $_POST["warp_up_public"]);
		update_usermeta( $user_id, 'description', $wpdb->escape($_POST["description"]) );
		// var_dump($_POST);//die;
	}
	
	function get_plink()
	{
		$home = get_option('home');
		$profile_page_id = get_option('warp_userprofile_page');
		$plink = preg_replace("|^$home/?|","",get_permalink($profile_page_id));
		
		return $plink;
	}
	
	function permalink()
	{
		$profile_page_id = get_option('warp_userprofile_page');
		return get_permalink($profile_page_id);
	}
	
	function title()
	{
		$profile_page_id = get_option('warp_userprofile_page');
		$page = get_post($profile_page_id);
		
		return $page->post_title;
	}
	
}

Warp_UserProfile::init();