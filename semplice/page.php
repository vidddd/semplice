<?php 
/*
 * single page
 * semplice.theme
 */
?>
<?php get_header(); # inlude header ?>

<?php if ( post_password_required() ) { ?>
 
	<div class="container">
		<div class="row">
			<div class="span12">
				<?php echo get_the_password_form(); ?>
			</div>
		</div>
	</div>
 
<?php } else { ?>

	<?php if(get_field('use_semplice') !== 'active' && get_field('use_semplice') !== 'coverslider') : ?>
	
		<section id="page-content" class="fade-content">
			<div id="post" class="container">
				<?php if (has_post_thumbnail( $post->ID ) ) : ?>
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
					<div class="row">
						<div class="span12 featured">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="Featured Image"  /></a>
						</div>
					</div>
				<?php endif; ?>
				<div class="row">
					<div class="<?php if(get_field('skinoptions_content_width', 'options')) : echo get_field('skinoptions_content_width', 'options'); else : echo 'span8 offset2'; endif; ?>">
						<div class="post-heading">
							<p><a href="<?php the_permalink(); ?>"><?php echo get_the_date('F d, Y'); ?></a> &middot; <?php comments_popup_link(__('No Comments!', 'semplice'), __('1 comment.', 'semplice'), __('% comments', 'semplice')); ?></p>
					<h2 class="<?php if(get_field('skinoptions_heading_weight', 'options')) : echo get_field('skinoptions_heading_weight', 'options'); else : echo 'bold'; endif; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						</div>
						<div class="wysiwyg <?php font_sizes(); ?>">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	
	<?php else : ?>
		
		<?php if(get_field('use_semplice') === 'coverslider') {
			
			get_template_part('partials/cover_slider'); # include cover slider
			
			if(get_field('coverslider_orientation') === 'horizontal' && get_field('content_after_slider')) {
				$content_slider_id = get_field('content_after_slider');
				$content_slider_id = $content_slider_id->ID;
			}
		
		} ?>
		
		<?php if(get_field('use_semplice') === 'active' || isset($content_slider_id)) : ?>
			
			<?php
				if(isset($content_slider_id)) {
					$post_id = $content_slider_id;
				} else {
					$post_id = get_the_ID();
				}
			?>

			<?php if(get_field('cover_visibility') === 'visible' && !isset($content_slider_id)) : ?>
			<?php get_template_part('partials/fullscreen-cover'); ?>
			<?php endif; ?>
			
			<!-- content fade -->
			<div class="fade-content">
				<?php
					// Remove wpautop
					remove_filter('the_content', 'wpautop');
					
					// get content			
					$content = get_post_meta( $post_id, 'semplice_ce_content', true );

					// strip out double quotes on bg images
					$content = remove_esc_bg_quotes($content);
					
					// output content
					$output = apply_filters('the_content', $content);

					echo $output;
					
					// reset postdata
					wp_reset_postdata();
				?>
			</div>	
			
			<?php if(get_field('share_visibility', $post_id) === 'visible' && get_field('global_share_visbility', 'options') !== 'hidden') : ?>
				<div class="share-box fade-content">
					<div class="container">
						<?php get_template_part('partials/share'); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php } ?>
<?php get_footer(); # inlude footer ?>