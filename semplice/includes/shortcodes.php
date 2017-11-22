<?php
/*
 * shortcodes
 * semplice.theme
 */

// image shortcode
function ceimage_func($atts) {

	//vars
	$e = '';
	$image_link = '';
	$neg_margin = '';

	// attributes
	extract( shortcode_atts(
		array(
			'id'					=> '',
			'class'					=> '',
			'alt'					=> '',
			'data_is_image_link' 	=> '',
			'data_image_link' 		=> '',
			'data_link_target' 		=> '',
			'style'					=> '',
			'lightbox'				=> '',
		), $atts )
	);

	// is lightbox?
	$lightbox = filter_var($lightbox, FILTER_VALIDATE_BOOLEAN);

	// check if image id is local (id) or remote asset (url)
	if(!is_numeric($id)) {
		$image_src[0] = $id;
	} else {
		// get image src
		$image_src = wp_get_attachment_image_src($id, 'full');

		// has no image or image was deleted?
		if(empty($image_src[0])) {
			$image_src[0] = get_bloginfo('template_directory') . '/content-editor/images/no_image.png';
		}
	}
	
	// has neg margin?
	if(isset($style)) {
		$neg_margin = 'style="' . $style . '"';
	}
	
	// has image link?
	if($lightbox) {
		$e .= '<a data-rel="lightbox" class="' . $class . '" href="' . $image_src[0] . '">';
		$e .= '<img class="' . $class . '" src="' . $image_src[0] . '" alt="' . $alt . '" ' . $neg_margin . ' />';
		$e .= '</a>';
	} elseif(!empty($data_image_link)) {
		// target = self?
		if($data_link_target === '_self') {
			$link_class = 'ce-image-link';
		} else {
			$link_class = 'extern';
		}
		
		$e .= '<a class="' . $link_class . '" href="' . $data_image_link . '" target="' . $data_link_target . '">';
		$e .= '<img class="' . $class . '" src="' . $image_src[0] . '" alt="' . $alt . '" ' . $neg_margin . ' />';
		$e .= '</a>';
	} else {
		$e .= '<img class="' . $class . '" src="' . $image_src[0] . '" alt="' . $alt . '" ' . $neg_margin . ' />';
	}

	return $e;
}

// video shortcode
function cevideo_func($atts) {

	// attributes
	extract( shortcode_atts(
		array(
			'src'					=> '',
			'type'					=> '',
			'poster'				=> '',
			'loop' 					=> '',
			'muted'					=> '',
			'autoplay'				=> '',
			'masonry_id'			=> false,
			'ratio'					=> ''
		), $atts )
	);

	// set video dim to false per default
	$video_dim = false;

	// poster image
	if(isset($poster)) {
		// get image src
		$poster_src = wp_get_attachment_image_src($poster, 'full');
		$poster_src = 'poster="' . $poster_src[0] . '"';
	}

	// masonry
	if($masonry_id) {
		$masonry_id = 'data-masonry-id="' . $masonry_id . '"';
	}

	// aspect ratio
	if(!empty($ratio)) {
		$video_dim = explode(':', $ratio);
		$video_dim = 'width="' . $video_dim[0] . '" height="' . $video_dim[1] . '"';
	}

	// output
	$e = '';

	$e .= '<video class="video" ' . $video_dim . ' preload="none" ' . $poster_src . ' ' . $loop . ' ' . $muted . ' ' . $autoplay . ' ' . $masonry_id . '>';
	$e .= '<source src="' . $src . '" type="' . $type . '">';
	$e .= '<p>If you are reading this, it is because your browser does not support the HTML5 video element.</p>';
	$e .= '</video>';

	return $e;
}

// audio shortcode
function ceaudio_func($options) {

	//output
	$e = '';

	$e .= '<audio class="audio" style="max-width: 100%;" preload="none">';
	$e .= '<source src="' . $options['src'] . '" type="' . $options['type'] . '">';
	$e .= '<p>If you are reading this, it is because your browser does not support the HTML5 audio element.</p>';
	$e .= '</audio>';
	
	return $e;
}

// Gallery
function cegallery_func($atts) {
	
	// attributes
	extract( shortcode_atts(
		array(
			'id'					=> '',
			'images'				=> '',
			'data_autoplay'			=> '',
			'data_timeout' 			=> '',
			'nav'					=> 'true',
			'pagination'			=> 'false',
			'nav_color'				=> '#ffffff',
			'pagination_color'		=> '#000000',
			'in_column'				=> '',
		), $atts )
	);
	
	//output
	$e = '';
	
	// id
	if($in_column && strpos($id,',') !== false) {
		// get id array
		$ids = explode(',', $id);

		// id for responsive dlies
		$id = $ids[0] . ' #slider-' . $ids[1];

		// id for the slider list
		$slider_single_id = 'slider-' . $ids[1];

		// css id
		$css_id = $ids[0] . ' [data-gallery-mc-id="' . $ids[1] . '"]';

	} else {
		// first replace slider- if there from old ids
		$id = str_replace('slider-', '', $id);

		// responsive slider id
		$id = 'slider-' . $id;

		// id for the slider list
		$slider_single_id = $id;

		// css id
		$css_id = str_replace('slider-', '', $id);
	}


	$e .= '<ul class="slider" id="' . $slider_single_id . '">';
	
	$images = explode(',', $images);
	
	foreach($images as $image) {
	
		$img = wp_get_attachment_image_src($image, 'full');
		
		$e .= '<li>';
		$e .= '<img src="' . $img[0] . '" alt="gallery-image" />';
		$e .= '</li>';
	}
	
	$e .= '</ul>';
	
	// custom css for nav and pagination
	$gallery_css = '<style id="gallery_css_' . $id . '">#' . $css_id . ' .slider_nav svg { fill: ' . $nav_color . ' !important; }#' . $css_id . ' .slider_tabs li a { background: ' . $pagination_color . ' !important; }</style>';
	
	$e .='
		<script>
			(function($) {
				$(document).ready(function () {
					$("head").append(\'' . $gallery_css . '\');
					$("#' . $id . '").responsiveSlides({
						auto: ' . $data_autoplay . ',
						nav: ' . $nav . ',
						pager: ' . $pagination . ',
						speed: 500,
						timeout: ' . $data_timeout . ',
						namespace: "slider"
					});
				});
			})(jQuery);
		</script>
	';

	return $e;

}

// Thumbnails Shortcode
function thumbnails_func($options){
	require get_template_directory() . '/includes/thumbnails.php';
	return $e;
}

// Dynamic Blocks
function dynamic_blocks_func($atts) {
	
	// attributes
	extract( shortcode_atts(
		array(
			'id'	=> '',
		), $atts )
	);
	
	global $wpdb;
	
	// table name
	$table_name = $wpdb->prefix . 'semplice_blocks';
	
	// query
	$html_output = $wpdb->get_var("SELECT html FROM $table_name WHERE block_id = '$id'");

	if(!empty($html_output)) {
		// output content
		remove_filter('the_content', 'wpautop');
		
		// prevent embed codes from getting executed
		if(is_admin()) {
			$html_output = str_replace('[embed]', '[unex_embed]', $html_output);
		}
		
		// apply the_content filter
		$html_output = apply_filters('the_content', $html_output);

		// output
		return $html_output;
	}
}

add_shortcode( 'ce_dynamic_block', 'dynamic_blocks_func' );
add_shortcode( 'thumbnails', 'thumbnails_func' );
add_shortcode( 'ceimage', 'ceimage_func' );
add_shortcode( 'cevideo', 'cevideo_func' );
add_shortcode( 'ceaudio', 'ceaudio_func' );
add_shortcode( 'cegallery', 'cegallery_func' );

?>