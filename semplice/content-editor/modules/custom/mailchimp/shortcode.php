<?php

/*
 * dribbble shortcode
 * semplice.theme
 */

 
class ce_mailchimp {

	function __construct() {
	
		// add shortcode
		add_shortcode('ce_mailchimp', array(&$this, 'ce_mailchimp_shortcode'));
	}
	
	function ce_mailchimp_shortcode($atts, $content = null) {

		// attributes
		extract( shortcode_atts(
			array(
				'id'									=> '',
				'placeholder_text'						=> '',
				'alignment'								=> '',
				'button_position'						=> '',
				'button_spacing'						=> '',
				'input_width'							=> '',
				'input_text_align'						=> '',
				'input_placeholder_color'				=> '',
				'input_text_color'						=> '',
				'input_bg_color'						=> '',
				'input_padding'							=> '',
				'input_font_size'						=> '',
				'input_font'							=> '',
				'input_border_width'					=> '',
				'input_border_color'					=> '',
				'input_border_radius'					=> '',
				'input_placeholder_color_mouseover'		=> '',
				'input_text_color_mouseover'			=> '',
				'input_bg_color_mouseover'				=> '',
				'input_border_color_mouseover'			=> '',
				'button_text'							=> '',
				'button_text_color' 					=> '',
				'button_font' 							=> '',
				'button_font_size' 						=> '',
				'button_width' 							=> '',
				'button_alignment' 						=> '',
				'button_text_spacing' 					=> '',
				'button_bg_color' 						=> '',
				'button_padding' 						=> '',
				'button_border_width' 					=> '',
				'button_border_color' 					=> '',
				'button_border_radius' 					=> '',
				'button_text_hover_color' 				=> '',
				'button_text_spacing_hover' 			=> '',
				'button_bg_hover_color' 				=> '',
				'button_border_hover_color' 			=> '',
				'button_link' 							=> '',
				'button_link_type'						=> '',
				'button_link_target' 					=> '',
				'has_container' 						=> '',
				'in_column' 							=> ''
			), $atts )
		);

		$mobile = '';

		#--------------------------------------------
		# form css							
		#--------------------------------------------

		$form_css = '';

		if($input_text_align) {
			$form_css .= 'text-align: ' . $input_text_align . ';';
		}
		if($input_bg_color) {
			$form_css .= 'background-color: ' . $input_bg_color . ';';
		}
		if($input_text_color) {
			$form_css .= 'color: ' . $input_text_color . ';';
		}
		if($input_padding) {
			$form_css .= 'padding: ' . $input_padding . ' !important;';
		}
		if($input_border_width) {
			$form_css .= 'border-width: ' . $input_border_width . ';';
		}
		if($input_border_color) {
			$form_css .= 'border-color: ' . $input_border_color . ';';
		}
		if($input_border_radius) {
			$form_css .= 'border-radius: ' . $input_border_radius . ';';
		}

		#--------------------------------------------
		# button css								
		#--------------------------------------------

		$button_css = '';
		
		// button spacing
		if($button_position) {
			if($button_position === 'inline') {
				$button_css .= 'margin-left:' . $button_spacing . ' !important;';
			} else {
				$button_css .= 'margin-top:' . $button_spacing . ' !important;';
				// button position below
				$form_css .= 'display: block !important;';
			}
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

		// output css
		$output_css = '<style type="text/css">';

		// cc id
		$cc_id = '';

		#--------------------------------------------
		# placeholder								
		#--------------------------------------------
		if($in_column && strpos($id,',') !== false) {
			// get id array
			$ids = explode(',', $id);
			$id = '#' . $ids[0] . ' #mailchimp_' . $ids[1];
			// make the column content id the main mailchimp id
			$cc_id = ' id="mailchimp_' . $ids[1] . '"';
		} else {
			$id = '#' . $id;
		}

		if(!function_exists('placeholder')) {
			function placeholder($id, $color, $mouseover_color) {

				// placeholder css
				$placeholder_css = '';
				$placeholder_css .= $id . ' ::-webkit-input-placeholder { color: ' . $color . ' !important; opacity: 1; line-height: normal; }';
				$placeholder_css .= $id . ' ::-moz-placeholder { color: ' . $color . ' !important; opacity: 1; }';
				$placeholder_css .= $id . ' :-ms-input-placeholder { color: ' . $color . ' !important; opacity: 1; }';
				$placeholder_css .= $id . ' :-moz-placeholder { color: ' . $color . ' !important; opacity: 1; }';
				$placeholder_css .= $id . ' input:hover::-webkit-input-placeholder { color: ' . $mouseover_color . ' !important; opacity: 1; line-height: normal; }';
				$placeholder_css .= $id . ' input:hover::-moz-placeholder { color: ' . $mouseover_color . ' !important; opacity: 1; line-height: normal; }';
				$placeholder_css .= $id . ' input:hover:-ms-input-placeholder { color: ' . $mouseover_color . ' !important; opacity: 1; line-height: normal; }';
				$placeholder_css .= $id . ' input:hover:-moz-placeholder { color: ' . $mouseover_color . ' !important; opacity: 1; line-height: normal; }';

				return $placeholder_css;
			}
		}

		if($input_placeholder_color) {
			$output_css .= placeholder($id, $input_placeholder_color, $input_placeholder_color_mouseover);
		}

		#--------------------------------------------
		# alignment						
		#--------------------------------------------

		if($alignment && !empty($cc_id)) {
			$output_css .= $id . ' { text-align: ' . $alignment . ' !important; }';
		} elseif($alignment) {
			$output_css .= $id . ' .mailchimp-newsletter { text-align: ' . $alignment . ' !important; }';
		}

		#--------------------------------------------
		# input field mouseover & focus							
		#--------------------------------------------

		if($input_bg_color_mouseover) {
			$output_css .= $id . ' .mailchimp-input:hover, ' . $id . ' .mailchimp-input:focus { background-color: ' . $input_bg_color_mouseover . ' !important; }';
		}

		if($input_text_color_mouseover) {
			$output_css .= $id . ' .mailchimp-input:hover, ' . $id . ' .mailchimp-input:focus { color: ' . $input_text_color_mouseover . ' !important; }';
		}

		if($input_border_color_mouseover) {
			$output_css .= $id . ' .mailchimp-input:hover, ' . $id . ' .mailchimp-input:focus { border-color: ' . $input_border_color_mouseover . ' !important;}';
		}

		#--------------------------------------------
		# button hover					
		#--------------------------------------------

		$output_css .= $id . ' .mailchimp-submit-button:hover {';

		if($button_bg_hover_color) {
			$output_css .= 'background-color:' . $button_bg_hover_color . ' !important;';
		}
		if($button_text_hover_color) {
			$output_css .= 'color:' . $button_text_hover_color . ' !important;';
		}
		if($button_border_hover_color) {
			$output_css .= 'border-color:' . $button_border_hover_color . ' !important;';
		}
		if($button_text_spacing_hover) {
			$output_css .= 'letter-spacing:' . $button_text_spacing_hover . ' !important;';
		}
		
		$output_css .= '}';

		// close style tag
		$output_css .= '</style>';

		// button text
		if(!$button_text) {
			$button_text = 'Subscribe!';
		}

		if(!$in_column) {
			$in_column = 'span12';
		} else {
			$in_column = '';
		}

		// Output
		$e = '';

		$e .= '
			<div class="mailchimp-newsletter ' . $in_column . '"' . $cc_id . '>
				<form action="' . $content . '" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate">
					<input type="email" value="" name="EMAIL" id="mce-EMAIL" class="mailchimp-input ' . $input_font . ' ' . $input_width . '" size="16" placeholder="' . $placeholder_text . '" style="' . $form_css .'" data-font-size="' . $input_font_size . '">
					<button class="mailchimp-submit-button ' . $button_font . '" type="submit"  value="Subscribe" name="subscribe" id="mc-embedded-subscribe" style="' . $button_css . '" data-font-size="' . $button_font_size . '">' . $button_text . '</button>
				</form>
			</div>
		';

		$e .= '<script type="text/javascript">(function($){$(document).ready(function(){$("head").append(\'' . $output_css . '\');});})(jQuery);</script>';


		return $e;
	}

}

// call instance of module class
global $ce_mailchimp;
$ce_mailchimp = new ce_mailchimp();

?>