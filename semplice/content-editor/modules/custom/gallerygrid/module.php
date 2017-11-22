<?php

/*
 * gallery grid module
 * semplice.theme
 */
  
if($this->edit_mode) {
	
	// output
	$e = '';

	// edit head
	$this->edit_head($values);
	
	// arrays
	$is_fluid = array(
		'no' => 'No',
		'yes' => 'Yes',
	);
	
	$remove_gutter = array(
		'no' => 'No',
		'yes' => 'Yes',
	);
	
	$span = array(
		'span12' => '1 Image',
		'span6' => '2 Images',
		'span4' => '3 Images',
		'span3' => '4 Images',
		'span2' => '6 Images',
		'span1' => '12 Images'
	);
	
	$random_grid = array(
		'disabled' 		=> 'Disabled',
		'span2.span4' 	=> 'Small: 2 Col, Big: 4 Col',
		'span3.span6'	=> 'Small: 3 Col, Big: 6 Col',
		'span4.span8'	=> 'Small: 4 Col, Big: 8 Col',
		'span6.span12'	=> 'Small: 6 Col, Big: 12 Col',
	);

	$mouseover = array(
		'color'  => 'Color',
		'shadow' => 'Shadow',
		'none'	 => 'none',
	);

	$mouseover_opacity = array(
		'1'   => '100%',
		'.95' => '95%',
		'.90' => '90%',
		'.85' => '85%',
		'.80' => '80%',
		'.75' => '75%',
		'.70' => '70%',
		'.65' => '65%',
		'.60' => '60%',
		'.55' => '55%',
		'.50' => '50%',
		'.45' => '45%',
		'.40' => '40%',
		'.35' => '35%',
		'.30' => '30%',
		'.25' => '25%',
		'.20' => '20%',
		'.15' => '15%',
		'.10' => '10%',
		'.05' => '5%',
	);
	
	$on_click = array(
		'yes' => 'Yes',
		'no' => 'No'
	);

	// tabs
	$tabs = array(
		'options' 		=> 'Options',
		'mouseover' 	=> 'Thumbnail Mouseover',
	);

	// open tabs
	$this->tabs_open($values, $tabs);

		// options tab open
		$this->tab_open('options');

			// options
			$this->get_option('select', 'Fluid Grid', 'is_fluid', 'no', $is_fluid, $values);
			$this->get_option('select', 'Remove Gutter', 'remove_gutter', 'no', $remove_gutter, $values);
			$this->get_option('select', 'Images per Row', 'span', '3', $span, $values);
			$this->get_option('select', 'Random Grid', 'random_grid', 'disabled', $random_grid, $values);
			$this->get_option('select', 'Open Lightbox on Click?', 'lightbox', 'yes', $on_click, $values);
	
		// options tab open
		$this->tab_close();

		// options tab open
		$this->tab_open('mouseover');

		$this->get_option('select', 'Mouseover', 'mouseover', 'none', $mouseover, $values);
		$this->get_option('color', 'Mouseover Color <div class="ce-help">(?)<span>Only applies for the color mouseover. Boxshadow is always black.</span></div>', 'mouseover_color', '#000000', '', $values);
		$this->get_option('select', 'Mouseover Opacity', 'mouseover_opacity', '.20', $mouseover_opacity, $values);

		// options tab open
		$this->tab_close();

	// close tabs
	$this->tabs_close($values);

	// custom module id
	$this->custom_module_id('gallerygrid', $values);
		
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

	// output
	$e = '';
	
	// fluid
	$values['has_container'] = false;

	$e .= $this->view_head($values);
	
	// shortcode wrapper start
	$e .= '<div class="is-shortcode">';
	
	// ce grid open
	$e .= '<div class="executed">' . do_shortcode('[ce_gallerygrid id="' . $values['id'] . '" images="' . $content . '" span="' . $values['options']['span'] . '" is_fluid="' . $values['options']['is_fluid'] . '" remove_gutter="' . $values['options']['remove_gutter'] . '" lightbox="' . $values['options']['lightbox'] . '" random="' . $values['options']['random_grid'] . '" mouseover="' . $values['options']['mouseover'] . '" mouseover_color="' . $values['options']['mouseover_color'] . '" mouseover_opacity="' . $values['options']['mouseover_opacity'] . '"][/ce_gallerygrid]') . '</div>';

	// unexecuted shortcode
	$e .= '<div class="unexecuted">[ce_gallerygrid id="' . $values['id'] . '" images="' . $content . '" span="' . $values['options']['span'] . '" is_fluid="' . $values['options']['is_fluid'] . '" remove_gutter="' . $values['options']['remove_gutter'] . '" lightbox="' . $values['options']['lightbox'] . '" random="' . $values['options']['random_grid'] . '" mouseover="' . $values['options']['mouseover'] . '" mouseover_color="' . $values['options']['mouseover_color'] . '" mouseover_opacity="' . $values['options']['mouseover_opacity'] . '"]][/ce_gallerygrid]</div>';
	
	// shortcode wrapper close
	$e .= '</div>';

	// cs footer
	$e .= $this->view_foot($values);

	// output
	return $e;

}
