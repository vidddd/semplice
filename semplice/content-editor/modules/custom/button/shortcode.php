<?php

/*
 * dribbble shortcode
 * semplice.theme
 */

 
class ce_button {

	function __construct() {
	
		// add shortcode
		add_shortcode('ce_button', array(&$this, 'ce_button_shortcode'));
	}
	
	function ce_button_shortcode($atts, $content = null) {

		// attributes
		extract( shortcode_atts(
			array(
				'id'							=> '',
				'button_text_color' 			=> '',
				'button_font' 					=> '',
				'button_font_size' 				=> '',
				'button_width' 					=> '',
				'button_alignment' 				=> '',
				'button_text_spacing' 			=> '',
				'button_bg_color' 				=> '',
				'button_padding' 				=> '',
				'button_border_width' 			=> '',
				'button_border_color' 			=> '',
				'button_border_radius' 			=> '',
				'button_text_hover_color' 		=> '',
				'button_text_spacing_hover' 	=> '',
				'button_bg_hover_color' 		=> '',
				'button_border_hover_color' 	=> '',
				'button_link' 					=> '',
				'button_link_type'				=> '',
				'button_link_target' 			=> '',
				'has_container' 				=> '',
				'in_column' 					=> ''
			), $atts )
		);

		// Button CSS
		$button_css = '';
		
		if($button_width !== 'auto') {
			$button_css .= 'width: 100% !important;';
		} else {
			$button_css .= 'width: auto !important;';
		}
		if($button_text_color) {
			$button_css .= 'color:' . $button_text_color . ';';
		}
		if($button_text_spacing) {
			$button_css .= 'letter-spacing:' . $button_text_spacing . ';';
		}
		if($button_bg_color) {
			$button_css .= 'background-color:' . $button_bg_color . ';';
		}
		if($button_padding) {
			$button_css .= 'padding:' . $button_padding . ' !important;';
		}
		if($button_border_width) {
			$button_css .= 'border-width:' . $button_border_width . ' !important;';
		}
		if($button_border_color) {
			$button_css .= 'border-color:' . $button_border_color . ';';
		}
		if($button_border_radius) {
			$button_css .= 'border-radius:' . $button_border_radius . ' !important;';
			$button_css .= '-moz-border-radius:' . $button_border_radius . ' !important;';
			$button_css .= '-webkit-border-radius:' . $button_border_radius . ' !important;';
		}
	
		// hover css
		// open style tag
		$hover_css = '<style type="text/css">';

		// open class
		if($in_column && strpos($id,',') !== false) {
			// get id array
			$id = explode(',', $id);
			$hover_css .= '#' . $id[0] . ' #button_' . $id[1] . ':hover {';
			// make the main id the button id
			$id = $id[1];
		} else {
			$hover_css .= '#button_' . $id . ':hover {';
		}
		
		
		if($button_bg_hover_color) {
			$hover_css .= 'background-color:' . $button_bg_hover_color . ' !important;';
		}
		if($button_text_hover_color) {
			$hover_css .= 'color:' . $button_text_hover_color . ' !important;';
		}
		if($button_border_hover_color) {
			$hover_css .= 'border-color:' . $button_border_hover_color . ' !important;';
		}
		if($button_text_spacing_hover) {
			$hover_css .= 'letter-spacing:' . $button_text_spacing_hover . ' !important;';
		}
		
		// link type
		if($button_link_type === 'email') {
			$prefix = 'mailto:';
		} else {
			$prefix = false;
		}

		// button text
		if(empty($content)) {
			$content = 'SEMPLICE BUTTON';
		}
		
		// close class
		$hover_css .= '}';
		
		// close style tag
		$hover_css .= '</style>';
	
		//output
		$e = '';
		
		// button pre
		if($button_width !== 'full_width' && !$in_column) {
			$button_open = '<div class="span12"><div class="button-wrapper" style="width: 100%; text-align: ' . $button_alignment . ';">';
			$button_close = '</div></div>';
		} else {
			$button_open = '<div class="button-wrapper" style="width: 100%; text-align: ' . $button_alignment . ';">';
			$button_close = '</div>';
		}
		
		// button hover
		$e .= '<script type="text/javascript">(function($){$(document).ready(function(){$("head").append(\'' . $hover_css . '\');});})(jQuery);</script>';
		
		$e .= $button_open . '<a id="button_' . $id . '" href="' . $prefix . $button_link . '" target="' . $button_link_target . '" data-font-size="' . $button_font_size . '" class="ce-button  ' . $button_font . '" style="' . $button_css . '">' . $content . '</a>' . $button_close;
		
		return $e;
	}

}

// call instance of module class
global $ce_button;
$ce_button = new ce_button();

?>