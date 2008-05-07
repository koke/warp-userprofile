<?php
/*
Plugin Name: Warp User Profile extension
Plugin URI: http://people.warp.es/~koke/wp-plugins/warp_userprofile
Description: Imports user feeds from other blogs and let editors promote them to front page
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
		register_activation_hook(__FILE__, array('Warp_UserProfile', 'register_version'));
	}
	
	function register_version()
	{		
		add_option('warp_userprofile_version', warp_userprofile_version);
		update_option('warp_userprofile_version', warp_userprofile_version);
	}
	
	function show_extra_fields()
	{
		echo '<h3>' . __( 'Profile extras', 'warp_userprofile' ) . '</h3>';
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<?php _e( 'Public profile', 'warp_userprofile' ); ?>
					</th>
					<td>
						<input type="checkbox" name="warp_up_public" value="<?php echo $warp_up_public; ?>" id="warp_up_public" />
						<label for="warp_up_public"><?php _e( 'If checked, this profile will be shown in the public directory', 'warp_userprofile' ); ?></label>
					</td>
				</tr>
				<tr>
					<th>
						<?php _e( 'Title', 'warp_userprofile' ); ?>
					</th>
					<td>
						<input type="text" name="warp_up_title" value="<?php echo $warp_up_title; ?>" id="warp_up_title" /><br />
						<?php _e( 'Your position at the company', 'warp_userprofile' ); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}	
}

Warp_UserProfile::init();