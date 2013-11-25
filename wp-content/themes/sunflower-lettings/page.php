<?php get_header(); ?>

<div id="body" class="section">
	<div class="contents">
		<div id="content">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
						<h1><?php the_title(); ?></h1>
						<?php edit_post_link('<small>Edit this entry</small>','',''); ?>
						<?php if ( has_post_thumbnail() ) { echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
			
						<div class="post-content page-content">
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
						</div><!--/.post-content .page-content -->
		
					<div id="page-meta">
						<h3><?php _e('Written by '); the_author_posts_link() ?></h3>
						<p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_email(), '80' ); } ?></p>
						<p><?php _e('Posted on '); the_time('F j, Y'); _e(' at '); the_time() ?></p>
					</div><!--/#page-meta-->
				</div><!--/#post-# .post-->
		
				<?php comments_template( '', true ); ?>
		
			<?php endwhile; ?>
		</div><!--/#content-->
		
		<?php get_sidebar(); ?>
	</div><!--/.contents-->
	
	<?php get_footer(); ?>
</div><!--/#body-->
