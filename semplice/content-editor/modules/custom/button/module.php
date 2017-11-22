<?php

/*
	Button Module
	Made by: Semplicelabs
*/

if($this->edit_mode) {
	
	// edit head
	$this->edit_head($values);

	$button_width = array(
		'auto' => 'Auto',
		'content_width' => 'Content Width',
		'full_width' => 'Full Width'
	);
	
	$button_alignment = array(
		'center' => 'Center',
		'left' => 'Left',
		'right' => 'Right'
	);
	
	$button_font = array(
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
	
	$button_font_size = array(
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
	
	$button_link_type = array(
		'url' => 'Link to a site',
		'email' => 'E-Mail address'
	);
	
	$button_link_target = array(
		'_blank' => 'New Tab',
		'_self' => 'Same Tab'
	);

	// tabs
	$tabs = array(
		'options' 		=> 'Options',
		'mouseover' 	=> 'Mouseover',
		'link'			=> 'Button Link'
	);

	// 2 cols options
	$values['cols'] = true;

	// open tabs
	$this->tabs_open($values, $tabs);
	
		// options tab open
		$this->tab_open('options');
	
			$this->get_option('text', 'Text', 'button_text', 'SEMPLICE BUTTON', '', $values);
			$this->get_option('color', 'Text Color', 'button_text_color', '#000000', '', $values);
			$this->get_option('select', 'Font Weight', 'button_font', 'semibold', $button_font, $values);
			$this->get_option('select', 'Font Size', 'button_font_size', '15px', $button_font_size, $values);
			$this->get_option('select', 'Width', 'button_width', 'auto', $button_width, $values);
			$this->get_option('select', 'Alignment', 'button_alignment', 'center', $button_alignment, $values);
			$this->get_option('text', 'Text Letterspacing', 'button_text_spacing', '2px', '', $values);
			$this->get_option('color', 'Background Color', 'button_bg_color', '#ffd300', '', $values);
			$this->get_option('text', 'Padding <div class="ce-help">(?)<span>Order: Top - Right - Bottom - Left</span></div>', 'padding', '15px 60px 15px 60px', '', $values);
			$this->get_option('text', 'Border Width', 'border_width', '0px', '', $values);
			$this->get_option('color', 'Border Color', 'border_color', '#000000', '', $values);
			$this->get_option('text', 'Border Radius', 'border_radius', '0px', '', $values);

		// options tab open
		$this->tab_close();

		// options tab open
		$this->tab_open('mouseover');

			$this->get_option('color', 'Text Color', 'button_text_hover_color', '#ffffff', '', $values);	
			$this->get_option('text', 'Text Letterspacing', 'button_text_spacing_hover', '2px', '', $values);
			$this->get_option('color', 'Background Color', 'button_bg_hover_color', '#000000', '', $values);
			$this->get_option('color', 'Border Color', 'border_hover_color', '#000000', '', $values);

		// options tab open
		$this->tab_close();

		// options tab open
		$this->tab_open('link');

			$this->get_option('select', 'Link Type', 'button_link_type', 'url', $button_link_type, $values);
			$this->get_option('text', 'Link URL', 'button_link', 'http://www.semplicelabs.com', '', $values);
			$this->get_option('select', 'Link Target', 'button_link_target', '_blank', $button_link_target, $values);

		// options tab open
		$this->tab_close();

	// close tabs
	$this->tabs_close($values);
	
	// custom module id
	$this->custom_module_id('button', $values);
		
	// edit foot
	$this->edit_foot($values);
		
} else {
	
	// output
	$e = '';

	// set column content id for buttons in multi columns
	if($values['in_column']) {
		$button_id = str_replace('#', '', $this->id) . ',' . str_replace('#', '', $values['single_edit_content_id']);
	} else {
		$button_id = str_replace('#', '', $values['id']);
	}

	// full width or content-width
	if($values['options']['button_width'] === 'full_width') {
		$values['has_container'] = false;
	}
	
	// button pre
	$button_ex_open = '[ce_button ';
	$button_unex_open = '[unex_ce_button ';
	
	// button shortcode
	$button  = 'id="' . $button_id . '" ';
	$button .= 'button_text_color="' . $values['options']['button_text_color'] . '" ';
	$button .= 'button_font="' . $values['options']['button_font'] . '" ';
	$button .= 'button_font_size="' . $values['options']['button_font_size'] . '" ';
	$button .= 'button_width="' . $values['options']['button_width'] . '" ';
	$button .= 'button_alignment="' . $values['options']['button_alignment'] . '" ';
	$button .= 'button_text_spacing="' . $values['options']['button_text_spacing'] . '" ';
	$button .= 'button_bg_color="' . $values['options']['button_bg_color'] . '" ';
	$button .= 'button_padding="' . $values['options']['padding'] . '" ';
	$button .= 'button_border_width="' . $values['options']['border_width'] . '" ';
	$button .= 'button_border_color="' . $values['options']['border_color'] . '" ';
	$button .= 'button_border_radius="' . $values['options']['border_radius'] . '" ';
	$button .= 'button_text_hover_color="' . $values['options']['button_text_hover_color'] . '" ';
	$button .= 'button_text_spacing_hover="' . $values['options']['button_text_spacing_hover'] . '" ';
	$button .= 'button_bg_hover_color="' . $values['options']['button_bg_hover_color'] . '" ';
	$button .= 'button_border_hover_color="' . $values['options']['border_hover_color'] . '" ';
	$button .= 'button_link="' . $values['options']['button_link'] . '" ';
	$button .= 'button_link_type="' . $values['options']['button_link_type'] . '" ';
	$button .= 'button_link_target="' . $values['options']['button_link_target'] . '" ';
	$button .= 'has_container="' . $values['has_container'] . '" ';
	$button .= 'in_column="' . $values['in_column'] . '"';
	$button .= ']' . $values['options']['button_text'] . '[/ce_button]';
	
	
	$e .= $this->view_head($values);
	
	// shortcode wrapper start
	$e .= '<div class="is-shortcode">';
	
	// ce grid open
	$e .= '<div class="executed">' . do_shortcode($button_ex_open . $button) . '</div>';

	// unexecuted shortcode
	$e .= '<div class="unexecuted">' . $button_unex_open . $button . '</div>';
	
	// shortcode wrapper close
	$e .= '</div>';

	// view footer
	$e .= $this->view_foot($values);

	// output
	return $e;
	
}
