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
		<div class="profile">
			<div class="avatar"><?php echo get_avatar($user->user_email, 48); ?></div>
			<h2 class='name'><?php echo $user->display_name; ?></h2>
			<h3 class='title'><?php echo get_usermeta($user->ID, 'warp_up_title'); ?></h3>
			<div class="bio">
				<?php echo apply_filters( 'the_content', $user->description ); ?>
			</div>
			<dl class="contact_info">
				<dt class="email"><?php _e( 'Email', 'warp_userprofile') ?></dt>
				<dd class="email"><a href="mailto:<?php echo $user->user_email ?>"><?php echo $user->user_email ?></a></dd>
				<?php if (!empty($user->user_url) && ($user->user_url != "http://")): ?>
				<dt class="website"><?php _e( 'Website', 'warp_userprofile' ); ?></dt>
				<dd class="website"><a href="<?php echo $user->user_url ?>"><?php echo $user->user_url ?></a></dd>
				<?php endif; ?>
				<?php if ($aim = get_usermeta($user->ID, 'aim')): ?>
				<dt class="aim"><?php _e( 'AIM', 'warp_userprofile' ); ?></dt>
				<dd class="aim"><a href="aim:goim?screenname=<?php echo $aim ?>"><?php echo $aim ?></a></dd>
				<?php endif; ?>
				<?php if ($yim = get_usermeta($user->ID, 'yim')): ?>
				<dt class="yim"><?php _e( 'Yahoo Messenger', 'warp_userprofile' ); ?></dt>
				<dd class="yim"><a href="ymsgr:sendim?<?php echo $yim ?>"><?php echo $yim ?></a></dd>
				<?php endif; ?>
				<?php if ($jabber = get_usermeta($user->ID, 'jabber')): ?>
				<dt class="jabber"><?php _e( 'Jabber/GTalk', 'warp_userprofile' ); ?></dt>
				<dd class="jabber"><a href="jabber:<?php echo $jabber ?>"><?php echo $jabber ?></a></dd>
				<?php endif; ?>
			</dl>
		</div>

	</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
