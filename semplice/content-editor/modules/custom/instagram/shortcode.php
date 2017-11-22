<?php

/*
 * instagram shortcode
 * semplice.theme
 */

 
class ce_instagram {

	// public vars
	public $instagram;

	function __construct() {
	
		// add shortcode
		add_shortcode('ce_instagram', array(&$this, 'ce_instagram_shortcode'));

	}
	
	function ce_instagram_shortcode($atts) {
		
		// attributes
		extract( shortcode_atts(
			array(
				'id'							=> '',
				'is_fluid'						=> '',
				'remove_gutter' 				=> '',
				'span'		 					=> '',
				'target'						=> '',
				'count'							=> '',
				'random'						=> 'disabled',
			), $atts )
		);

		//output
		$e = '';

		// options
		$instagram = get_field('instagram', 'options');

		// get 15 pictures if count is empty
		if(empty($count)) {
			$count = 15;
		}	

		$options = array(
			'access_token'	=> $instagram['access_token'],
			'user_id'		=> $instagram['user_id'],
			'count'			=> $count
		);
		
		// content
		$masonry_content = '';
		
		// get instagram json
		if(!function_exists('_isCurl')) {
			function _isCurl(){
			    return function_exists('curl_version');
			}
		}

		if(_isCurl()) {
			$media = json_decode($this->exec_curl($options), true);
			$meta = $media['meta'];
		} else {
			$media = 'curl';
		}

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

		// get shots
		if(isset($meta['code']) && $meta['code'] === 200) {

			foreach ($media['data'] as $posts => $post) {

				if($target === 'lightbox') {
					$href = $post['images']['standard_resolution']['url'];
					$href = explode('?', $href);
					$href = $href[0];
					$href_target = 'data-rel="lightbox"';
				} else {
					$href = $post['link'];
					$href_target = 'target="_blank"';
				}
				
				if($random !== 'disabled' && $index % 4 == 0 && $index > 0) {
					$span = $big_span;
				} elseif($random !== 'disabled') {
					$span = $small_span;
				}
				
				// add thumb to holder
				$masonry_content .= '<div class="grid-item ' . $thumb_class . $span . ' masonry-' . $id . '-item masonry-' . $id . '-item-' . $index . '">';
				$masonry_content .= '<a href="' . $href . '" ' . $href_target . '><img src="' . $post['images']['standard_resolution']['url'] . '"></a>';
				$masonry_content .= '</div>';
				
				// increment index
				$index ++;

			}

			// get grid
			$e .= semplice_grid($id, $masonry_content, $is_fluid, $remove_gutter, $index, $pre);
			
		} else if($media === 'curl') {
			$e .= '
				<div class="instagram-error">
					<img src="' . get_bloginfo('template_directory') . '/images/icons/instagram.svg">
					<p>cURL Extension not installed. Please advise your host to install / activate the cURL Extension for you.</p>
				</div>
			';
		} else {
			$e .= '
				<div class="instagram-error">
					<img src="' . get_bloginfo('template_directory') . '/images/icons/instagram.svg">
					<p>It looks like you either have no or a wrong access token.<br />Please go to Semplice -> General Settings and setup your access token. <br />Error Message from Instagram: <i>' . $meta['error_message'] . '</i></p>
				</div>
			';
		}
		
		return $e;

	}
	
	function exec_curl($options) {
			
		// curl init
		$ch = curl_init();

		// url
		curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/users/' . $options['user_id'] . '/media/recent/?access_token=' . $options['access_token'] . '&count=' . $options['count']);
		
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
		
		curl_close($ch);
		
		return $response;
	}
}

// call instance of ce_instagram
global $ce_instagram;
$ce_instagram = new ce_instagram();

?>