<?php get_header(); ?>

<div id="body" class="section">
	<div class="contents">
		<div id="content">
			<?php if (!dynamic_sidebar( 'Alert' )) : ?><?php endif ?>
			
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div class="post-single">
					<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php if ( has_post_thumbnail() ) { echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
					<div class="post-content">
						<?php the_content(__('Read more'));?>
					</div>
					<div class="post-meta">
						<p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by '); the_author_posts_link(); ?></p>
						<p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
						<p><?php _e('Categories: '); the_category(', ') ?></p>
						<p><?php if (the_tags('Tags: ', ', ', ' ')); ?></p>
					</div><!--/.post-meta-->
				</div><!--/.post-single-->
			<?php endwhile; else: ?>
				<div class="no-results">
					<p><strong><?php _e('There has been an error.'); ?></strong></p>
					<p><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.'); ?></p>
					<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
				</div><!--/.no-results-->
			<?php endif; ?>
			
			<div class="pagination">
				<p class="older"><?php next_posts_link('&laquo; Older Entries') ?></p>
				<p class="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
			</div><!--/.pagination-->
		</div><!--/#content-->
		
		<?php get_sidebar(); ?>
	</div><!--/.contents-->
	
	<?php get_footer(); ?>
</div><!--/#body-->