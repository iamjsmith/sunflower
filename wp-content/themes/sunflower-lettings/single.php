<?php get_header(); ?>

<div id="body" class="section">
	<div class="contents">
		<div id="content">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
					<h1><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<?php edit_post_link('<small>Edit this entry</small>','',''); ?>
					<?php if ( has_post_thumbnail() ) { echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
					<div class="post-content">
						<?php the_content(); ?>
						<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
					</div><!--/.post-content-->
		
					<div id="post-meta">
						<p><?php _e('Posted on '); the_time('F j, Y'); _e(' at '); the_time() ?></p>
						<p><?php comments_popup_link('No comments', 'One comment', '% comments', 'comments-link', 'Comments are closed'); ?> </p>
						<p><?php _e(' Categories: '); the_category(', ') ?></p>
						<p><?php the_tags('Tags: ', ', ', ' '); ?></p>
						<p><?php _e('Receive new post updates:'); ?> <a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow">Entries (RSS)</a></p>
						<p><?php _e('Receive follow up comments updates: '); ?><?php comments_rss_link('RSS 2.0'); ?></p>
					</div><!--/#post-meta-->
		
					<div id="post-author">
						<h3><?php _e('Written by '); the_author_posts_link() ?></h3>
						<p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '80' ); } ?></p>
						<div id="author-description">
							<?php the_author_meta('description') ?> 
							<div id="author-link">
								<p><?php _e('View all posts by: '); the_author_posts_link() ?></p>
							</div><!--/#author-link-->
						</div><!--/#author-description -->
					</div><!--/#post-author-->
		
				</div><!--/#post-# -->
		
				<div class="pagination">
					<p class="older"><?php previous_post_link('%link', '&laquo; Previous post') ?>
					<p class="newer"><?php next_post_link('%link', 'Next Post &raquo;') ?></p>
				</div><!--/.pagination-->
		
				<?php comments_template( '', true ); ?>
		
			<?php endwhile; /* end loop */ ?>
		</div><!--/#content-->
		
		<?php get_sidebar(); ?>
	</div><!--/.contents-->
	
	<?php get_footer(); ?>
</div><!--/#body-->