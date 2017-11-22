<?php

/*
 * gallerygrid shortcode
 * semplice.theme
 */

class ce_gallerygrid {

	function __construct() {
	
		// add shortcode
		add_shortcode('ce_gallerygrid', array(&$this, 'ce_gallerygrid_shortcode'));

	}
	
	function ce_gallerygrid_shortcode($atts) {
		
		// attributes
		extract( shortcode_atts(
			array(
				'id'							=> '',
				'images'						=> '',
				'is_fluid'						=> '',
				'remove_gutter' 				=> '',
				'span'		 					=> '',
				'lightbox'						=> '',
				'random'						=> 'disabled',
				'mouseover'						=> '',
				'mouseover_color'				=> '',
				'mouseover_opacity'				=> '',
			), $atts )
		);

		//output
		$e = '';

		// content
		$masonry_content = '';

		// get images
		$images = explode(',', $images);

		// get boolean values
		$is_fluid = filter_var($is_fluid, FILTER_VALIDATE_BOOLEAN);
		$remove_gutter = filter_var($remove_gutter, FILTER_VALIDATE_BOOLEAN);
		
		// is remove gutter?
		if($remove_gutter) {
			$pre = 'no-gutter-';
			$thumb_class = 'remove-gutter-yes masonry-';
		} else {
			$pre = '';
			$thumb_class = '';
		}
		
		// index
		$index = 0;

		// random
		if($random !== 'disabled') {
			$span_array = explode('.', $random);
			$small_span = $span_array[0];
			$big_span   = $span_array[1];
		}

		if(!function_exists('HexToRGB')) {
			// hex to rgb
			function HexToRGB($hex) {
				$hex = str_replace("#", "", $hex);
				$color = array();
				 
				if(strlen($hex) == 3) {
					$color['r'] = hexdec(substr($hex, 0, 1) . $r);
					$color['g'] = hexdec(substr($hex, 1, 1) . $g);
					$color['b'] = hexdec(substr($hex, 2, 1) . $b);
				}
				else if(strlen($hex) == 6) {
					$color['r'] = hexdec(substr($hex, 0, 2));
					$color['g'] = hexdec(substr($hex, 2, 2));
					$color['b'] = hexdec(substr($hex, 4, 2));
				}
				 
				return $color;
			}
		}

		// get shots
		if(is_array($images)) {

			foreach ($images as $image) {

				// get image
				$img = wp_get_attachment_image_src($image, 'full');

				// mouseover
				if($mouseover == 'color') {
					if(strpos($mouseover_color, '#') !== false) {
						$rgba = HexToRGB($mouseover_color);
						$mouseover_html = '<div class="gg-hover" style="background: rgba(' . $rgba['r'] . ', ' . $rgba['g'] . ', ' . $rgba['b'] . ', ' . $mouseover_opacity . ');"></div>';
					} else {
						$mouseover_html = '';
					}
				} elseif($mouseover == 'shadow') {
					$mouseover_html = '<div class="gg-hover" style="box-shadow: 0px 0px 30px rgba(0,0,0,' . $mouseover_opacity . ');"></div>';
				} else {
					$mouseover_html = '';
				}

				// image html
				if($lightbox == 'yes') {
					$image = '<a href="' . $img[0] . '" class="mouseover-' . $mouseover . '" data-rel="lightbox"><img src="' . $img[0] . '">' . $mouseover_html . '</a>';
				} else {
					$image = '<a class="mouseover-' . $mouseover . '"><img src="' . $img[0] . '">' . $mouseover_html . '</a>';
				}
				
				if($random !== 'disabled' && $index % 4 == 0 && $index > 0) {
					$span = $big_span;
				} elseif($random !== 'disabled') {
					$span = $small_span;
				}
				
				// add thumb to holder
				$masonry_content .= '<div class="grid-item ' . $thumb_class . $span . ' masonry-' . $id . '-item masonry-' . $id . '-item-' . $index . '">';
				$masonry_content .= $image;
				$masonry_content .= '</div>';
				
				// increment index
				$index ++;

			}

			// get grid
			$e .= semplice_grid($id, $masonry_content, $is_fluid, $remove_gutter, $index, $pre);
			
		}

		return $e;

	}
}

// call instance of ce_instagram
global $ce_gallerygrid;
$ce_gallerygrid = new ce_gallerygrid();

?>