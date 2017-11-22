<?php 
/*
 * blog single
 * semplice.theme
 */
?>
<?php get_header(); # inlude header ?>
<section id="blog" class="fade-content">
	<?php get_template_part('partials/blog-search'); ?>
	<?php get_template_part('partials/blog-archives'); ?>
	<?php get_template_part('partials/blog-loop'); ?>
	<section id="comment">
		<div class="container">
			<div class="row">
				<div class="<?php if(get_field('skinoptions_content_width', 'options')) : echo get_field('skinoptions_content_width', 'options'); else : echo 'span8 offset2'; endif; ?> comment">
					<?php comments_template(); ?>
				</div>
			</div>
		</div>
	</section>
</section>
<?php get_footer(); # inlude footer ?>
