<?php

/*
	Mailchimp Module
	Made by: Semplicelabs
*/

if($this->edit_mode) {
	
	// edit head
	$this->edit_head($values);
	
	$input_width = array();
	
	for($i=1; $i<=12; $i++) {
		$input_width['span' . $i] = $i . ' Col';
	}

	$alignment = array(
		'center' => 'Center',
		'left' => 'Left',
		'right' => 'Right'
	);

	$button_position = array(
		'inline' => 'Inline with Input Field',
		'below' => 'Below the Input Field'
	);
	
	$input_font = array(
		'light' => 'Light',
		'light_italic' => 'Light Italic',
		'regular' => 'Regular',
		'regular_italic' => 'Regular Italic',
		'semibold' => 'Semibold',
		'semibold_italic' => 'Semibold Italic',
		'bold' => 'Bold',
		'bold_italic' => 'Bold Italic',
		'custom_one' => 'Custom One',
		'custom_one_italic' => 'Custom One Italic'
	);
	
	$input_font_size = array(
		'11px' => '11px',
		'12px' => '12px',
		'13px' => '13px',
		'14px' => '14px',
		'15px' => '15px',
		'16px' => '16px',
		'17px' => '17px',
		'18px' => '18px',
		'20px' => '20px',
		'22px' => '22px',
		'24px' => '24px',
		'26px' => '26px',
		'28px' => '28px',
		'30px' => '30px',
		'32px' => '32px',
		'34px' => '34px',
		'36px' => '36px',
		'38px' => '38px',
		'40px' => '40px',
		'42px' => '42px',
		'44px' => '44px',
		'46px' => '46px',
		'48px' => '48px',
		'50px' => '50px',
		'52px' => '52px',
		'54px' => '54px',
		'56px' => '56px',
		'58px' => '58px',
		'60px' => '60px',
		'72px' => '72px',
		'84px' => '84px',
		'96px' => '96px'
	);
	
	// 2 cols options
	$values['cols'] = true;

	// tabs
	$tabs = array(
		'options' 	=> 'Form Options',
		'input' 	=> 'Input Field',
		'submit'	=> 'Submit Button'
	);

	// 2 cols options
	$values['cols'] = true;

	// open tabs
	$this->tabs_open($values, $tabs);
	
		// options tab open
		$this->tab_open('options');
	
			$this->get_option('text', 'Form Action URL <div class="ce-help">(?)<span><a href="http://help.semplicelabs.com/customer/en/portal/topics/861611-guides/articles" target="_blank">Visit our Mailchimp Guides</a></span></div>', 'action_url', '', '', $values);
			$this->get_option('text', 'Placeholder Text', 'placeholder_text', 'E-Mail Address', '', $values);
			$this->get_option('select', 'Form Alignment', 'alignment', 'center', $alignment, $values);
			$this->get_option('select', 'Button Position <div class="ce-help">(?)<span>Note that if the input field is to wide the submit button will positioned below the input field automatically.</span></div>', 'button_position', 'inline', $button_position, $values);
			$this->get_option('text', 'Button Spacing <div class="ce-help">(?)<span>The spacing between the button and the input field. (it\'s either horizontal or vertical depending on your button position)</span></div>', 'button_spacing', '0px', '', $values);

		// options tab open
		$this->tab_close();

		// options tab open
		$this->tab_open('input');

			$this->get_option('select', 'Width', 'input_width', 'span3', $input_width, $values);
			$this->get_option('select', 'Placeholder & Text Align', 'input_text_align', 'left', $alignment, $values);
			$this->get_option('color', 'Placeholder Color', 'input_placeholder_color', '#888888', '', $values);
			$this->get_option('color', 'Text Color', 'input_text_color', '#000000', '', $values);
			$this->get_option('select', 'Font Weight', 'input_font', 'regular', $input_font, $values);
			$this->get_option('select', 'Font Size', 'input_font_size', '18px', $input_font_size, $values);
			$this->get_option('color', 'Background Color', 'input_bg_color', '#f0f0f0', '', $values);
			$this->get_option('text', 'Padding <div class="ce-help">(?)<span>Order: Top - Right - Bottom - Left</span></div>', 'input_padding', '20px 30px 20px 30px', '', $values);
			$this->get_option('text', 'Border Width', 'input_border_width', '0px', '', $values);
			$this->get_option('color', 'Border Color', 'input_border_color', '#000000', '', $values);
			$this->get_option('text', 'Border Radius', 'input_border_radius', '0px', '', $values);

			$this->title_seperator('Mouseover & Focus');

			$this->get_option('color', 'Placeholder Color', 'input_placeholder_color_mouseover', '#444444', '', $values);
			$this->get_option('color', 'Text Color', 'input_text_color_mouseover', '#000000', '', $values);
			$this->get_option('color', 'Background Color', 'input_bg_color_mouseover', '#e6e6e6', '', $values);
			$this->get_option('color', 'Border Color', 'input_border_color_mouseover', '#000000', '', $values);

		// options tab open
		$this->tab_close();

		// options tab open
		$this->tab_open('submit');

			$this->get_option('text', 'Text', 'button_text', 'GO!', '', $values);
			$this->get_option('color', 'Text Color', 'button_text_color', '#000000', '', $values);
			$this->get_option('select', 'Font Weight', 'button_font', 'semibold', $input_font, $values);
			$this->get_option('select', 'Font Size', 'button_font_size', '18px', $input_font_size, $values);
			$this->get_option('text', 'Text Letterspacing', 'button_text_spacing', '0px', '', $values);
			$this->get_option('color', 'Background Color', 'button_bg_color', '#ffd300', '', $values);
			$this->get_option('text', 'Padding <div class="ce-help">(?)<span>Order: Top - Right - Bottom - Left</span></div>', 'button_padding', '20px 30px 20px 30px', '', $values);
			$this->get_option('text', 'Border Width', 'button_border_width', '0px', '', $values);
			$this->get_option('color', 'Border Color', 'button_border_color', '#000000', '', $values);
			$this->get_option('text', 'Border Radius', 'button_border_radius', '0px', '', $values);

			$this->title_seperator('Mouseover');

			$this->get_option('color', 'Text Color', 'button_text_hover_color', '#ffffff', '', $values);	
			$this->get_option('text', 'Text Letterspacing', 'button_text_spacing_hover', '0px', '', $values);
			$this->get_option('color', 'Background Color', 'button_bg_hover_color', '#e6be00', '', $values);
			$this->get_option('color', 'Border Color', 'border_hover_color', '#000000', '', $values);

		// options tab open
		$this->tab_close();

	// close tabs
	$this->tabs_close($values);

	// custom module id
	$this->custom_module_id('mailchimp', $values);

	// edit foot
	$this->edit_foot($values);
		
} else {
	
	// output
	$e = '';

	// set column content id for buttons in multi columns
	if($values['in_column']) {
		$content_id = str_replace('#', '', $this->id) . ',' . str_replace('#', '', $values['single_edit_content_id']);
	} else {
		$content_id = str_replace('#', '', $values['id']);
	}

	// button pre
	$mailchimp_ex_open = '[ce_mailchimp ';
	$mailchimp_unex_open = '[unex_ce_mailchimp ';
	
	// button shortcode
	$mailchimp  = 'id="' . $content_id . '" ';
	$mailchimp .= 'placeholder_text="' . $values['options']['placeholder_text'] . '" ';
	$mailchimp .= 'alignment="' . $values['options']['alignment'] . '" ';
	$mailchimp .= 'button_position="' . $values['options']['button_position'] . '" ';
	$mailchimp .= 'button_spacing="' . $values['options']['button_spacing'] . '" ';
	$mailchimp .= 'input_placeholder_color="' . $values['options']['input_placeholder_color'] . '" ';
	$mailchimp .= 'input_width="' . $values['options']['input_width'] . '" ';
	$mailchimp .= 'input_text_align="' . $values['options']['input_text_align'] . '" ';
	$mailchimp .= 'input_text_color="' . $values['options']['input_text_color'] . '" ';
	$mailchimp .= 'input_bg_color="' . $values['options']['input_bg_color'] . '" ';
	$mailchimp .= 'input_padding="' . $values['options']['input_padding'] . '" ';
	$mailchimp .= 'input_border_width="' . $values['options']['input_border_width'] . '" ';
	$mailchimp .= 'input_border_color="' . $values['options']['input_border_color'] . '" ';
	$mailchimp .= 'input_border_radius="' . $values['options']['input_border_radius'] . '" ';
	$mailchimp .= 'input_placeholder_color_mouseover="' . $values['options']['input_placeholder_color_mouseover'] . '" ';
	$mailchimp .= 'input_text_color_mouseover="' . $values['options']['input_text_color_mouseover'] . '" ';
	$mailchimp .= 'input_bg_color_mouseover="' . $values['options']['input_bg_color_mouseover'] . '" ';
	$mailchimp .= 'input_border_color_mouseover="' . $values['options']['input_border_color_mouseover'] . '" ';
	$mailchimp .= 'input_font_size="' . $values['options']['input_font_size'] . '" ';
	$mailchimp .= 'input_font="' . $values['options']['input_font'] . '" ';
	$mailchimp .= 'button_text="' . $values['options']['button_text'] . '" ';
	$mailchimp .= 'button_text_color="' . $values['options']['button_text_color'] . '" ';
	$mailchimp .= 'button_font="' . $values['options']['button_font'] . '" ';
	$mailchimp .= 'button_font_size="' . $values['options']['button_font_size'] . '" ';
	$mailchimp .= 'button_text_spacing="' . $values['options']['button_text_spacing'] . '" ';
	$mailchimp .= 'button_bg_color="' . $values['options']['button_bg_color'] . '" ';
	$mailchimp .= 'button_padding="' . $values['options']['button_padding'] . '" ';
	$mailchimp .= 'button_border_width="' . $values['options']['button_border_width'] . '" ';
	$mailchimp .= 'button_border_color="' . $values['options']['button_border_color'] . '" ';
	$mailchimp .= 'button_border_radius="' . $values['options']['button_border_radius'] . '" ';
	$mailchimp .= 'button_text_hover_color="' . $values['options']['button_text_hover_color'] . '" ';
	$mailchimp .= 'button_text_spacing_hover="' . $values['options']['button_text_spacing_hover'] . '" ';
	$mailchimp .= 'button_bg_hover_color="' . $values['options']['button_bg_hover_color'] . '" ';
	$mailchimp .= 'button_border_hover_color="' . $values['options']['border_hover_color'] . '" ';
	$mailchimp .= 'has_container="' . $values['has_container'] . '" ';
	$mailchimp .= 'in_column="' . $values['in_column'] . '"';
	$mailchimp .= ']' . $values['options']['action_url'] . '[/ce_mailchimp]';
	
	
	$e .= $this->view_head($values);
	
	// shortcode wrapper start
	$e .= '<div class="is-shortcode">';
	
	// ce grid open
	$e .= '<div class="executed">' . do_shortcode($mailchimp_ex_open . $mailchimp) . '</div>';

	// unexecuted shortcode
	$e .= '<div class="unexecuted">' . $mailchimp_unex_open . $mailchimp . '</div>';
	
	// shortcode wrapper close
	$e .= '</div>';

	// view footer
	$e .= $this->view_foot($values);

	// output
	return $e;
	
}
