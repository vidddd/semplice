<?php

/*
 * dummy module
 * semplice.theme
 */

if($this->edit_mode) {
	
	// output
	$e = '';

	// edit head
	$this->edit_head($values);

	$yes_no = array(
		'no' => 'No',
		'yes' => 'Yes'
	);
	
	// width, offset
	$width = array(
		'full-width' => 'Full Width'
	);
	$offset = array();
	
	for($i=1; $i<=12; $i++) {
		$width['span' . $i] = $i . ' Col';
	}
	
	for($i=0; $i<=12; $i++) {
		if($i < 1) {
			$offset['no-offset'] = 'No Offset';
		} else {
			$offset['offset' . $i] = $i . ' Col';
		}
	}

	if(!$content) {
		$content = '<!-- Paste your HTML / JS Code here. Please note that this is a module to embed code not to showcase it -->';
	}

	// options open
	echo '<div class="options">';

	$this->option_seperator();
	
	$this->get_option('select', 'Is this a shortcode?', 'is_shortcode', 'no', $yes_no, $values);
	
	$this->get_option('select', 'Use Responsive Video', 'use_responsive_video', 'no', $yes_no, $values);

	// show options only in non multi columns
	if(!$values['in_column'] && $this->edit_mode !== 'single-edit') {
		// paragraph width
		$this->get_option('select', 'Width', 'width', 'full-width', $width, $values);
		
		// paragraph offset
		$this->get_option('select', 'Offset <div class="ce-help">(?)<span>Please note that the offset only applies if your width is not full width.</span></div>', 'offset', 'no-offset', $offset, $values);
	}
	
	// code editor button
	echo '<div class="code-editor-button">';
	
	// code holder
	echo '<textarea id="code_mirror_' . $values['id'] . '" class="is-content code-mirror-hide">' . htmlentities($content) . '</textarea>';

	// start code mirror button
	echo '<a class="code-editor" data-content-id="' . $values['id'] . '"></a>';

	// close code editor button
	echo '</div>';

	// options close
	echo '</div>';

	// custom module id
	$this->custom_module_id('code', $values);
	
	// display paragraph
	echo $e;
	
	// edit foot
	$this->edit_foot($values);
		
} else {
	// output
	$e = '';
	
	// fluid
	$values['has_container'] = false;
	
	// edit content
	$edit_content = '<div class="code-edit"><div class="is-code"></div></div>';

	// wrap around grid if needed
	if(!$values['in_column'] && $values['options']['width'] !== 'full-width') {
		$values['has_container'] = true;
		$edit_content = '<div class="span12">' . $edit_content . '</div>';
	}
	
	$e .= $this->view_head($values);

	if(!$values['in_column']) {
		$values['single_edit_column_id'] = false;
		$values['single_edit_content_id'] = false;
	} else {
		// multi column container id
		$values['id'] = $this->id;
	}

	$e .= $edit_content;
	
	// is this a shortcode?
	if($values['options']['is_shortcode'] !== 'yes') {
		// unexecuted shortcode
		$content = '[ce_code content_id="' . $values['id'] . '" post_id="' . $values['post_id'] . '" use_responsive_video="' . $values['options']['use_responsive_video'] . '" in_column="' . $values['in_column'] . '" column_id="' . $values['single_edit_column_id'] . '" column_content_id="' . $values['single_edit_content_id'] . '"][/ce_code]';
	}
	
	if($values['options']['use_responsive_video'] === 'yes') {
		$content = '<div class="responsive-video">' . $content . '</div>';
	}
	
	if(!$values['in_column'] && $values['options']['width'] !== 'full-width') {
		$content = '<div class="' . $values['options']['width'] . ' ' . $values['options']['offset'] . '">' . $content . '</div>';
	}
	
	// unexecuted shortcode / code
	$e .= '<div class="code-content">' . $content . '</div>';

	// cs footer
	$e .= $this->view_foot($values);

	// output
	return  $e;

}
