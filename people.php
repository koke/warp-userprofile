<?php get_header(); ?>

<?php 
  $post = get_post(get_option('warp_userprofile_page'));
  subbar($post); 
?>

	<div id="content" class="narrowcolumn warp-span-10 warp-last">
	<h2><?php echo get_the_title(get_option('warp_userprofile_page')); ?></h2>
	<?php
		echo get_query_var('person');
		$users = Warp_Userprofile::get_users_of_blog();
		$class = "even";
		foreach ($users as $user) {			
			if (get_usermeta($user->user_id, 'warp_up_public') == 1):
			if ($class == "even") {
			  $class = "odd";
			} else {
			  $class = "even";
			}
			// var_dump($user);
			?>
			<div class="profile <?php echo $class; ?>">
				<div class="avatar"><?php echo Warp_Userprofile::avatar_for($user); ?></div>
				<h3 class='name'><a href="<?php echo Warp_Userprofile::permalink() . $user->user_login; ?>"><?php echo $user->display_name; ?></a></h3>
				<h4 class='title'><?php echo get_usermeta($user->user_id, 'warp_up_title'); ?></h4>
			</div>
			<?php
			endif;
		}
	?>

	</div>

<?php get_footer(); ?>
