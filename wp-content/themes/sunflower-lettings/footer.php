<div id="footer" class="section">
	<div class="contents">
		<?php if (!dynamic_sidebar( 'Footer' )) : ?><!--Wigitized Footer--><?php endif ?>
		
		<div id="nav-footer" class="nav">
			<?php wp_nav_menu( array('theme_location' => 'footer-menu' )); /* editable within the Wordpress backend */ ?>
		</div><!--/#nav-footer-->
		
		<p class="clear"><a href="#main"><?php _e('Top'); ?></a></p>
		<p><a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow"><?php _e('Entries (RSS)'); ?></a> | <a href="<?php bloginfo('comments_rss2_url'); ?>" rel="nofollow">
		<?php _e('Comments (RSS)'); ?></a></p>
		<p>&copy; <?php echo date("Y") ?> <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a>. <?php _e('All Rights Reserved.'); ?></p>
		<p><?php _e('Signed by'); ?> <a href="http://rockablemedia.com">Rockable Media</a>. <?php _e('Powered by'); ?> <a href="http://wordpress.org">Wordpress</a>.</p>
	</div><!--.contents-->
</div><!--#footer-->

<?php wp_footer(); ?>
</body>
</html>