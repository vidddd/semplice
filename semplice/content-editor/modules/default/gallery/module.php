<?php

/*
	Gallery Module
	Made by: Semplicelabs
*/

if($this->edit_mode) {
	
	// edit head
	$this->edit_head($values);
	
	//image scale
	$img_scale = array(
		'none' => 'None',
		'full_width' => 'Full Width'
	);
	
	// auto play
	$autoplay = array(
		'true' => 'On',
		'false' => 'Off'
	);
	
	// visibility
	$visibility = array(
		'true' => 'Show',
		'false'  => 'Hide'
	);
	
	// pagination position
	$pagination_position = array(
		'pagination-below' => 'Below Image',
		'pagination-over'  => 'Over Image'
	);
	
	if(!$values['in_column'] && $this->edit_mode !== 'single-edit') {
		// options head
		echo '<div class="row"><div class="span12 options">';
	} else {
		echo '<div class="options">';
	}

	$this->get_option('select', 'Image Scale', 'img-scale', 'none', $img_scale, $values);
	$this->get_option('select', 'Autoplay', 'autoplay', 'true', $autoplay, $values);
	$this->get_option('text', 'Timeout between images (in ms, minimum 600)', 'timeout', '4000', $autoplay, $values);
	$this->get_option('select', 'Arrows Visibility', 'nav', 'true', $visibility, $values);
	$this->get_option('color', 'Arrows Color', 'nav-color', '#ffffff', '', $values);
	$this->get_option('select', 'Pagination Visibility', 'pagination', 'false', $visibility, $values);
	$this->get_option('select', 'Pagination Position', 'pagination-position', 'below', $pagination_position, $values);
	$this->get_option('color', 'Pagination Color', 'pagination-color', '#000000', '', $values);
	
	// close options
	if($values['content_type'] !== 'column-content-gallery') {
		echo '</div></div>';
	} else {
		echo '</div>';
	}
	
	// output
	$e = '';
	
	// content area
	$e .= '
		<div class="edit-elements">
			<ul data-gallery-id="' . $values['id'] . '" class="gallery-images">';
			
			if($content) {
				$images = explode(',', $content);
				foreach($images as $image) {
					$thumbnail = wp_get_attachment_image_src($image, 'thumbnail');
					$e .= '<li id="' . $image . '">';
					$e .= '<a class="remove-gallery-image"></a><img src="' . $thumbnail[0] . '" alt="gallery-image" />';
					$e .= '</li>';
				}
			}
			
			$e .= '
			</ul>
			
			<script type="text/javascript">
				(function ($) {
					$(document).ready(function () {
						/* start sortable */
						$("[data-gallery-id=' . $values['id'] . ']").sortable({
							update: function(event, ui) {
							
								/* get array of ids */
								var sortIDs = $("[data-gallery-id=' . $values['id'] . '] li").map(function () { return this.id; }).get();
								
								/* append ids to val */
								$("#' . $values['id'] . '").find("input[name=gallery]").val(sortIDs);
							}
						});
						/* remove items */
						$("#' . $values['id'] . '").find(".remove-gallery-image").click(function() {
				
							$(this).parent().transition({ opacity: 0 }, 400, "ease", function() {
							
								/* remove item */
								var removeItem = $(this).attr("id");
							
								/* remove from DOM */
								$(this).remove();
								
								/* get array of ids */
								var sortIDs = $("[data-gallery-id=' . $values['id'] . '] li").map(function () { return this.id; }).get();
								
								/* append ids to val */
								$("#' . $values['id'] . '").find("input[name=gallery]").val(sortIDs);
								
							}); 
						
						});
					});
				})(jQuery); 
			</script>
			
			<div class="media-upload-box">
				<a class="media-upload semplice-button image-upload" data-content-id="' . $values['id'] . '" data-upload-type="gallery">Add Images</a>
				<div class="clear"></div>
				<input type="hidden" name="gallery" class="is-content is-image" value="' . $content . '">
			</div>
		</div>
	';
	
	// display paragraph
	echo $e;
	
	// edit foot
	$this->edit_foot($values);
		
} else {

	$scale = $values['options']['img-scale'];

	// set column content id for buttons in multi columns
	if($values['in_column']) {
		$gallery_id = str_replace('#', '', $this->id) . ',' . str_replace('#', '', $values['single_edit_content_id']);
	} else {
		$gallery_id = str_replace('#', '', $values['id']);
	}

	// output	
	$e = '';
	
	// get slider for gallery
	if(!function_exists('slider')) {
		
		function slider($content, $values, $gallery_id) {
					
			$output = '';
			
			$images = explode(',', $content);
			
			// preview image
			$preview = wp_get_attachment_image_src($images[0], 'full');
			
			// pagination position
			if($values['options']['pagination'] === 'true' && $values['options']['pagination-position']) {
				$pagination_position = $values['options']['pagination-position'];
			} else {
				$pagination_position = '';
			}

			// give column content id to the wrapper for custom css (mulpiple gallerys in MC
			if($values['in_column']) {
				$mc_id = 'data-gallery-mc-id="' . str_replace('#', '', $values['id']) . '"';
			} else {
				$mc_id = '';
			}
			
			if($images) { 
				$output .= '<div class="slider-wrapper ' . $pagination_position . '" ' . $mc_id . '>';
				$output .= '<div class="is-gallery"></div>';
				$output .= '<div class="gallery-preview"><img src="' . $preview[0] . '" /></div>';
				$output .= '[cegallery id="' . $gallery_id . '" data_timeout="' . $values['options']['timeout'] . '" data_autoplay="' . $values['options']['autoplay'] . '" images="' . $content . '" nav="' . $values['options']['nav'] . '" nav_color="' . $values['options']['nav-color'] . '" pagination="' . $values['options']['pagination'] . '" pagination_color="' . $values['options']['pagination-color'] . '" in_column="' . $values['in_column'] . '"][/cegallery]';
				$output .= '</div>';
			}
			
			return $output;
		}
	}

	if($scale === 'full_width') {
		// output image container
		$values['has_container'] = false;
		$e .= $this->view_head($values);
		$e .= slider($content, $values, $gallery_id);
		$e .= $this->view_foot($values);
		return $e;
	} elseif(!$values['in_column']) {
		// output image container
		$e .= $this->view_head($values);
		$e .= '<div class="span12">';
		$e .= slider($content, $values, $gallery_id);
		$e .= '</div>';
		$e .=$this->view_foot($values);
		return $e;
	} else {
		// output image container
		$e .= $this->view_head($values);
		$e .= slider($content, $values, $gallery_id);
		$e .= $this->view_foot($values);
		return $e;
	}

}