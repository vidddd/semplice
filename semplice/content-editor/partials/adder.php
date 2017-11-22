<div class="adder main-adder">
	<ul class="types">
		<li>
			<a class="add-content p" data-content-type="content-p">
				<?php echo set_ce_icon('paragraph'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Paragraph</div>
			</div>
		</li>
		<li>
			<a class="add-content img" data-content-type="content-img">
				<?php echo set_ce_icon('image'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Image</div>
			</div>
		</li>
		<li>
			<a class="add-content gallery" data-content-type="content-gallery">
				<?php echo set_ce_icon('gallery'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Gallery</div>
			</div>
		</li>
		<li>
			<a class="add-content video" data-content-type="content-video">
				<?php echo set_ce_icon('video'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Self Hosted Video</div>
			</div>
		</li>
		<li>
			<a class="add-content audio" data-content-type="content-audio">
				<?php echo set_ce_icon('audio'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Self Hosted Audio</div>
			</div>
		</li>
		<li>
			<a class="add-content oembed" data-content-type="content-oembed">
				<?php echo set_ce_icon('oembed'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add oEmbed (Vimeo, Youtube, etc.)</div>
			</div>
		</li>
		<li>
			<a class="add-content spacer" data-content-type="content-spacer">
				<?php echo set_ce_icon('spacer'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Spacer</div>
			</div>
		</li>
		<li>
			<a class="add-content thumbnails" data-content-type="content-thumbnails">
				<?php echo set_ce_icon('grid'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Portfolio Grid</div>
			</div>
		</li>
		<li>
			<a class="add-content mc" data-content-type="multi-column">
				<?php echo set_ce_icon('mc'); ?>
			</a>
			<div class="tooltip">
				<div class="tt-arrow">
					<?php echo set_ce_icon('tt-arrow'); ?>
				</div>
				<div class="tt-text">Add Multi Column</div>
			</div>
		</li>
		<li>
			<a class="show-layers">Re-Order</a>
		</li>
		<li>
			<a class="show-modules">Modules</a>
			<ul class="modules-sub modules-sub-global">
				<div class="semplice-arrow">
					<?php echo set_ce_icon('arrow'); ?>
				</div>
				<?php 
					$modules = new modules();
					echo $modules->list_modules(false, false, false); 
				?>
			</ul>
		</li>
		<li>
			<a class="branding">Branding</a>
			<ul class="branding-sub adder-sub">
				<div class="semplice-arrow">
					<?php echo set_ce_icon('arrow'); ?>
				</div>
				<div class="branding-sub-left">
					<li>
						<div class="ce-label">Custom Fontset</div>
						<?php
							// output select box
							$e = '';
							$e .= '<div class="ce-select-box">';
							$e .= '<select name="custom-fontset" class="custom-fontset">';
							$e .= '<option value="default">Select Fontset</option>';
							
							// args
							$args = array(
								'sort_order' 		=> 'ASC',
								'post_type' 		=> 'custom_fontset',
								'post_status' 		=> 'publish',
								'posts_per_page'	=> -1
							);

							$fonts = get_posts($args);
							
							if($fonts)
							{
								foreach($fonts as $font)
								{
								
									$e .= '<option value="' . $font->ID . '">' . $font->post_title . '</option>';
								
								}
							}
							
							$e .= '</select>';
							$e .= '</div>';
							
							// output
							echo $e;
						?>
					</li>
					<li>
						<div class="ce-label">Background Color</div>
						<?php
						
							// has color?
							$has_color = false;
						
							if(preg_match('/^#[a-f0-9]{6}$/i', $styles['background-color'])) {
								  $has_color = true;
							} 
						
						?>
						<div class="wp-color"><input type="text" value="<?php if($has_color === true) : echo $styles['background-color']; else : echo '#ffffff'; endif; ?>" class="color-picker branding-bg-color" data-default-color="#ffffff" name="branding-bg-color" />
						</div>
					</li>
					<li>
						<div id="branding-bg-image">
							<div class="ce-label">Bg Image</div>
							<a class="remove-media remove-bg" data-content-id="branding-bg-image" data-media="branding-bg-image"></a>
							<img src="" class="branding-bg-image-preview">
							<a class="media-upload semplice-button bg-image-upload" data-upload-type="background" data-content-id="branding-bg-image" data-branding="branding">Upload image</a>
							<input type="hidden" name="branding-bg-image" class="branding-bg-image is-branding-bg-image is-bg-image" value="">
						</div>
					</li>
				</div>
				<div class="branding-sub-right">
					<li>
						<div class="ce-label">Background Scale</div>
						<?php	
							$bg_scale = array(
								'auto' 	=> 'No Scale',
								'cover' 	=> 'Cover (full-width)'
							);
						?>
						<div class="ce-select-box">
							<select name="branding-bg-size" class="branding-bg-size select-box branding-bg-select" data-css-attribute="background-size">
								<?php select($bg_scale, $styles['background-size']); ?>
							</select>
						</div>
					</li>
					<li>
						<div class="ce-label">Background Attachment</div>
						<?php
							$bg_attachment = array(
								'scroll' => 'None',
							    'fixed' 	=> 'Fixed'
							);
						?>
						<div class="ce-select-box">
							<select name="branding-bg-attachment" class="branding-bg-attachment select-box branding-bg-select" data-css-attribute="background-attachment">
								<?php select($bg_attachment, $styles['background-attachment']); ?>
							</select>
						</div>
					</li>
					<li>
						<?php
							$bg_pos = array(
								'0% 0%' 	=> 'Top Left',
								'50% 0%' 	=> 'Top Center',
								'100% 0%' 	=> 'Top Right',
								'0% 50%' 	=> 'Middle Left',
								'50% 50%' 	=> 'Middle Center',
								'100% 50%' 	=> 'Middle Right',
								'0% 100%' 	=> 'Bottom Left',
								'50% 100%' 	=> 'Bottom Center',
								'100% 100%' => 'Bottom Right'
							); 
						?>
						<div class="ce-label">Background Position</div>
						<div class="ce-select-box">
							<select name="branding-bg-pos" class="branding-bg-pos select-box branding-bg-select" data-css-attribute="background-position">
								<?php select($bg_pos, $styles['background-position']); ?>
							</select>
						</div>
					</li>
					<li>
						<div class="ce-label">Background Repeat</div>
						<?php
							$bg_repeat = array(
								'repeat' 	=> 'Repeat both',
								'repeat-x' 	=> 'Repeat horizontal',
								'repeat-y' 	=> 'Repeat vertical',
								'no-repeat' => 'No Repeat'
							);
						?>
						<div class="ce-select-box">
							<select name="background-repeat" class="branding-bg-repeat select-box branding-bg-select" data-css-attribute="background-repeat">
								<?php select($bg_repeat, $styles['background-repeat']); ?>
							</select>
						</div>
					</li>
				</div>
			</ul>
		</li>
		<li>
			<a class="show-templates">Templates</a>
			<ul class="templates-sub adder-sub">
				<div class="semplice-arrow">
					<?php echo set_ce_icon('arrow'); ?>
				</div>
				<li>
					<div class="ce-label">Existing Project</div>
					<?php
						// list projects
						global $post;
						
						$e = '';
						$e .= '<div class="ce-select-box">';
						$e .= '<select name="select-project" class="select-project">';
						$e .= '<option value="default">Select Project</option>';
						
						// args
						$project_args = array(
							'sort_order' 		=> 'ASC',
							'post_type' 		=> 'work',
							'post_status' 		=> 'publish,private,draft',
							'posts_per_page'   	=> -1,
						);

						$projects = get_posts($project_args);
						
						if($projects)
						{
							foreach($projects as $project)
							{
								$active_rom = get_post_meta( $project->ID, 'semplice_ce_rom', true );
								
								if($active_rom && $post->ID != $project->ID) {
									$e .= '<option value="' . $project->ID . '">' . $project->post_title . '</option>';
								}	
							
							}
						}
						
						$e .= '</select>';
						$e .= '</div>';
						
						// output
						echo $e;
					?>
				</li>
				<li>
					<div class="ce-label">Existing Page</div>
					<?php
						// list projects
						$e = '';
						$e .= '<div class="ce-select-box">';
						$e .= '<select name="select-page" class="select-page">';
						$e .= '<option value="default">Select Page</option>';
						
						// args
						$pages_args = array(
							'sort_order' 		=> 'ASC',
							'post_type' 		=> 'page',
							'post_status'		=> 'publish,private,draft',
							'posts_per_page'	=> -1
						);

						$pages = get_pages($pages_args);

						if($pages)
						{
							foreach($pages as $page)
							{
								$active_rom = get_post_meta( $page->ID, 'semplice_ce_rom', true );
								
								if($active_rom && $post->ID != $page->ID) {
									$e .= '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
								}	
							
							}
						}
						
						$e .= '</select>';
						$e .= '</div>';
						
						// output
						echo $e;
					?>
				</li>
			</ul>
		</li>
		<li>
			<a class="show-blocks">Blocks</a>
			<div class="block-added">Block added</div>
		</li>
	</ul>
	<div class="save-or-cancel">
		<a class="cancel-to-wp"></a>
		<a class="save-to-wp">Save</a>
	</div>
</div>