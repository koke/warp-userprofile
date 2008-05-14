<?php get_header(); ?>

	<div id="content" class="narrowcolumn warp-span-6">
		<div style='float: right' class="profileback">
			<a href="<?php echo Warp_Userprofile::permalink() ?>"><?php _e( 'See all', 'warp_userprofile' ); ?></a>			
			<?php 
			global $userdata;
			if (current_user_can('edit_users')): ?>
			<br /><a href="<?php echo get_bloginfo('wpurl') . '/wp-admin/user-edit.php?user_id=' . $user->ID ?>"><?php _e( 'Edit profile', 'warp_userprofile' ); ?></a>						
			<?php elseif ($userdata->ID == $user->ID): ?>
				<br /><a href="<?php echo get_bloginfo('wpurl') . '/wp-admin/profile.php' ?>"><?php _e( 'Edit profile', 'warp_userprofile' ); ?></a>						
			<?php endif; ?>
		</div>
		<div class="profile" style='clear: left; margin-bottom: 10px'>
			<div class="avatar" style='float: left; margin-right: 12px'><?php echo get_avatar($user->user_email, 48); ?></div>
			<h2 style='line-height: 32px; font-size: 24px; margin: 0;'><?php echo $user->display_name; ?></h2>
			<h3 style='line-height: 16px; font-size: 16px; margin: 0;'><?php echo get_usermeta($user->ID, 'warp_up_title'); ?></h3>
			<div class="bio">
				<?php echo apply_filters( 'the_content', $user->description ); ?>
			</div>
			<dl class="contact_info">
				<dt><?php _e( 'Email', 'warp_userprofile') ?></dt>
				<dd><a href="mailto:<?php echo $user->user_email ?>"><?php echo $user->user_email ?></a></dd>
				<?php if (!empty($user->user_url) && ($user->user_url != "http://")): ?>
				<dt><?php _e( 'Website', 'warp_userprofile' ); ?></dt>
				<dd><a href="<?php echo $user->user_url ?>"><?php echo $user->user_url ?></a></dd>
				<?php endif; ?>
			</dl>
		</div>

	</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
