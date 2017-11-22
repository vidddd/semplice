<?php

/*
 * instagram module
 * semplice.theme
 */
  
if($this->edit_mode) {
	
	// output
	$e = '';

	// edit head
	$this->edit_head($values);
	
	if(!$values['in_column'] && $this->edit_mode !== 'single-edit') {
		// options head
		echo '<div class="row"><div class="span12 options">';
	} else {
		echo '<div class="options">';
	}
	
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
	);
	
	$on_click = array(
		'lightbox' => 'Open in Lightbox',
		'dribbble' => 'Open in Instagram (new site)'
	);
	
	// get instagram access token
	$instagram = get_field('instagram', 'options');
	
	// message
	if(!empty($instagram['access_token'])) {
		$message = '<span class="ce-success">Instagram connected</span>';
	} else {
		$message = '<span class="ce-error">Please connect your Instagram account in the <a href="' . admin_url('admin.php?page=acf-options-general-settings') . '" target="_blank">General Settings</a>. <br />Semplice will automatically show your latest Instagram images. (up to max. 20)';
	}
	
	// options
	$this->get_option('message', 'Connect Instagram', $message, '', '', $values);

	$this->get_option('text', 'Number of Images (max is 33)', 'count', '20', '', $values);

	$this->get_option('select', 'Fluid Grid', 'is_fluid', 'no', $is_fluid, $values);
	
	$this->get_option('select', 'Remove Gutter', 'remove_gutter', 'no', $remove_gutter, $values);
	
	$this->get_option('select', 'Images per Row', 'span', '3', $span, $values);
	
	$this->get_option('select', 'Random Grid', 'random_grid', 'disabled', $random_grid, $values);
	
	$this->get_option('select', 'On Click Action', 'target', 'lightbox', $on_click, $values);
		
	// custom module id
	$this->custom_module_id('instagram', $values);
	
	echo '<div class="clear"></div>';
	
	// close options
	if($values['content_type'] !== 'column-content-audio') {
		echo '</div></div>';
	} else {
		echo '</div>';
	}
	
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
	$e .= '<div class="executed">' . do_shortcode('[ce_instagram id="' . $values['id'] . '" count="' . $values['options']['count'] . '" span="' . $values['options']['span'] . '" is_fluid="' . $values['options']['is_fluid'] . '" remove_gutter="' . $values['options']['remove_gutter'] . '" target="' . $values['options']['target'] . '" random="' . $values['options']['random_grid'] . '"][/ce_instagram]') . '</div>';

	// unexecuted shortcode
	$e .= '<div class="unexecuted">[unex_ce_instagram id="' . $values['id'] . '" count="' . $values['options']['count'] . '" span="' . $values['options']['span'] . '" is_fluid="' . $values['options']['is_fluid'] . '" remove_gutter="' . $values['options']['remove_gutter'] . '" target="' . $values['options']['target'] . '" random="' . $values['options']['random_grid'] . '"][/ce_instagram]</div>';
	
	// shortcode wrapper close
	$e .= '</div>';

	// cs footer
	$e .= $this->view_foot($values);

	// output
	return $e;

}
