<?php

/*
 * dribbble shortcode
 * semplice.theme
 */

 
class ce_dribbble {

	function __construct() {
	
		// add shortcode
		add_shortcode('ce_dribbble', array(&$this, 'ce_dribbble_shortcode'));
	
	}
	
	function ce_dribbble_shortcode($atts) {
		
		// attributes
		extract( shortcode_atts(
			array(
				'id'							=> '',
				'shots'							=> '',
				'is_fluid'						=> '',
				'remove_gutter' 				=> '',
				'dribbble_id' 					=> '',
				'span'		 					=> '',
				'target'						=> '',
			), $atts )
		);
		
		//output
		$e = '';

		// content
		$masonry_content = '';
		
		// dribbble username
		if(empty($dribbble_id)) {
			$dribbble_id = 'vanschneider';
		}

		// get boolean values
		$is_fluid = filter_var($is_fluid, FILTER_VALIDATE_BOOLEAN);
		$remove_gutter = filter_var($remove_gutter, FILTER_VALIDATE_BOOLEAN);
		
		// get 15 shots if shots is empty
		if(empty($shots)) {
			$shots = 15;
		}	
		
		// shots array
		if(!function_exists('_isCurl')) {
			function _isCurl(){
			    return function_exists('curl_version');
			}
		}

		if(_isCurl()) {
			if($this->exec_curl($dribbble_id, $shots) !== 'error') {
				$media = json_decode($this->exec_curl($dribbble_id, $shots), true);
			} else {
				$media = 'error';
			}
		} else {
			$media = 'curl';
		}
		
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

		// check if $media is array, if yes get shots
		if(is_array($media) && !empty($media)) {
			foreach ($media as $shots => $shot) {

				// image url
				if(!empty($shot['images']['hidpi'])) {
					$img_url = $shot['images']['hidpi'];
				} else {
					$img_url = $shot['images']['normal'];
				}

				// lightbox vs link to dribbble
				if($target === 'lightbox') {
					$href = $img_url;
					$href_target = 'data-rel="lightbox"';
				} else {
					$href = $shot['html_url'];
					$href_target = 'target="_blank"';
				}
			
				// add thumb to holder
				$masonry_content .= '<div class="grid-item ' . $thumb_class . $span . ' masonry-' . $id . '-item masonry-' . $id . '-item-' . $index . '">';
				$masonry_content .= '<a href="' . $href . '" ' . $href_target . '><img src="' . $img_url . '"></a>';
				$masonry_content .= '</div>';
				
				// increment index
				$index ++;
			}
			
			// get grid
			$e .= semplice_grid($id, $masonry_content, $is_fluid, $remove_gutter, $index, $pre);
		} else if($media === 'curl') {
			$e .= '
				<div class="instagram-error">
					<img src="' . get_bloginfo('template_directory') . '/images/icons/dribbble.svg">
					<p>cURL Extension not installed. Please advise your host to install / activate the cURL Extension for you.</p>
				</div>
			';
		} else {
			$e .= '
				<div class="instagram-error">
					<img src="' . get_bloginfo('template_directory') . '/images/icons/dribbble.svg">
					<p>It looks like you either have no or a wrong access token.<br />Please go to Semplice -> General Settings and setup your access token.</p>
				</div>
			';
		}

		return $e;
		
	}

	function exec_curl($dribbble_id, $shots) {
		
		// get token
		$token = get_field('dribbble_token', 'options');

		if(!empty($token)) {
			// curl init
			$ch = curl_init();

			// url
			curl_setopt($ch, CURLOPT_URL, 'https://api.dribbble.com/v1/users/' . $dribbble_id . '/shots?access_token=' . $token . '&per_page=' . $shots);
			
			// disable ssl
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			
			// accept json
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept: application/json",
				"Content-Type: application/json"
			));
			
			// return content
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);

			// get html code
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);

			if($code === 200) {
				return $response;
			} else {
				return "error";
			}
		} else {
			return "error";
		}
	}
}

// call instance of ce_dribbble
global $ce_dribbble;
$ce_dribbble = new ce_dribbble();

?>