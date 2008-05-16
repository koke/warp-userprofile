<?php get_header(); ?>

	<div id="content" class="narrowcolumn warp-span-6">
	<h2><?php echo get_the_title(get_option('warp_userprofile_page')); ?></h2>
	<?php
		echo get_query_var('person');
		$users = get_users_of_blog();
		foreach ($users as $user) {			
			if (get_usermeta($user->user_id, 'warp_up_public') == 1):
			// var_dump($user);
			?>
			<div class="profile">
				<div class="avatar"><?php echo get_avatar($user->user_email, 48); ?></div>
				<h3 class='name'><a href="<?php echo Warp_Userprofile::permalink() . $user->user_login; ?>"><?php echo $user->display_name; ?></a></h3>
				<h4 class='title'><?php echo get_usermeta($user->user_id, 'warp_up_title'); ?></h4>
			</div>
			<?php
			endif;
		}
	?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
