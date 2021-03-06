<?php 
/*
 * single work
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
	
	<?php if(get_field('cover_visibility') === 'visible') : ?>
	<?php get_template_part('partials/fullscreen-cover'); ?>
	<?php endif; ?>
	
	<?php if(!isset($_GET['cover-slider'])) : # if cover slider display no content ?>
		<!-- content fade -->
		<div class="fade-content">
			<?php
				// Remove wpautop
				remove_filter('the_content', 'wpautop');

				// get content
				$content = get_post_meta( get_the_ID(), 'semplice_ce_content', true );

				// strip out double quotes on bg images
				$content = remove_esc_bg_quotes($content);

				// output content
				$output = apply_filters('the_content', $content);

				echo $output;
				
				// reset postdata
				wp_reset_postdata();
			?>
		</div>
		
		<?php if(get_field('share_visibility') === 'visible' && get_field('global_share_visbility', 'options') !== 'hidden') : ?>
			<div class="share-box fade-content">
				<div class="container">
					<?php get_template_part('partials/share'); ?>
				</div>
			</div>
		<?php endif; ?>
		<div id="project-panel-footer" class="fade-content">
			<?php 
				// quick nav thumb
				$tn_transition = '';
				get_template_part('partials/project', 'panel');
			?>
		</div>

	<?php endif; ?>
	
<?php } ?>

<?php get_footer(); # inlude footer ?>