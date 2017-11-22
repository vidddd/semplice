<?php
	// vars
	$e = '';
	$index = 0;
	$is_fluid = filter_var($options['fluid'], FILTER_VALIDATE_BOOLEAN);
	$is_fwt  = filter_var($options['fwt'], FILTER_VALIDATE_BOOLEAN);
	$remove_gutter = filter_var($options['removegutter'], FILTER_VALIDATE_BOOLEAN);
	$hide_title = false;
	$categories = isset($options['categories']) ? $options['categories'] : '';
	$detect = new Mobile_Detect;

	// title and category color
	if($options['titlevisibility'] === 'visible') {
		$title_color = 'style="color:' . $options['titlecolor'] . ';"';
		$category_color = 'style="color:' . $options['categorycolor'] . ';"';
		$margin_fix = 'style="margin-bottom: 30px !important"';
	} elseif($options['titlevisibility'] === 'visible_title') {
		$title_color = 'style="color:' . $options['titlecolor'] . ';"';
		$category_color = 'style="display: none;"';
		$margin_fix = 'style="margin-bottom: 30px !important"';
	} else {
		$margin_fix = 'style="line-height: 0 !important; font-size: 0 !important;"';
		$hide_title = true;
	}

	// is remove gutter?
	if($remove_gutter) {
		$pre = 'no-gutter-';
		$thumb_class = 'remove-gutter-yes masonry-span';
	} else {
		$pre = '';
		$thumb_class = 'span';
	}

	$e = '';
	$masonry_content = '';

	$e .= '<section id="thumbnails">';

	// query args
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'work',
		'category_name' => $categories
	);

	// pass args
	$query = new WP_Query( $args );

	// query posts and get thumbnails
	if ( $query->have_posts() ) {	
		while ( $query->have_posts() ) {
			$query->the_post();
			
			// is fwt?
			if($is_fwt) {
				
				// get fwt styles
				if($is_fwt) {
					$styles = array();
					$styles['background-color'] = get_field('background_color');
					$styles['background-image'] = get_field('background_image');
					$styles['background-size'] = get_field('background_scale');
					$styles['background-repeat'] = get_field('background_repeat');
					$styles['border-bottom'] = get_field('border_bottom');
				}
				
				//fwt header
				$e .= '<a href="' . get_permalink() . '" class="fwt-link" title="' . get_the_title() . '">';
				$e .= '<div class="fwt" style="padding: 0px !important; ' . container_styles($styles) . '">';
				$e .= '<div class="container">';
				$e .= '<div class="row">';
			
				// title format
				if(get_field('fwt_title_format') === 'image') {
					if(get_field('fwt_image')) {
						// get fwt thumbnail
						$image = wp_get_attachment_image_src(get_field('fwt_image'), 'full');
						// check if image is svg
						$filetype = wp_check_filetype($image[0]);

						if($filetype['ext'] !== 'svg') {
							$e .= '<div class="span12 fwt-solo-img"><img class="middle" src="' . $image[0] . '" width="' . $image[1] . '" height="' . $image[2] . '" /></div>';
						} else {
							$e .= '<div class="span12 fwt-solo-img"><img class="middle" src="' . $image[0] . '" /></div>';
						}
						
					}
				} else {
					if(filter_var(get_field('fwt_hide_title'), FILTER_VALIDATE_BOOLEAN) === FALSE) {
						$e .= '<div class="fwt-inner span12 ' . get_field('fwt_title_hor') . ' ' . get_field('fwt_title_ver') . '">';
						$e .= '<h2 class="' . get_field('fwt_title_weight') . ' ' . get_field('fwt_title_font_size') . '" style="color: ' . get_field('fwt_title_color') . ' !important;">' . get_the_title() . '</h2>';
						$e .= '<p class="fwt-category ' . get_field('fwt_category_font_weight') . ' ' . get_field('fwt_category_font_size') . '" style="display: block; color: ' . get_field('fwt_category_color') . ' !important;">' . get_field('category') . '</p>';
						$e .= '</div>';
					}
				}
				
				// fwt footer
				$e .= '</div></div></div></a>';
				
			} else {
				// get thumbnail
				$thumbnail = wp_get_attachment_image_src(get_field('thumbnail_image'), 'full');
				
				#---------------------------------------------------------------------------#
				# Hover																		#
				#---------------------------------------------------------------------------#

				$hover_background = '';
				$hover_h3 = '';
				$hover_h3_span = '';
				$title_font_size = 'fs-22px';
				$title_line_height = 'lh-22px';
				$category_font_size = 'fs-14px';
				$category_line_height = 'lh-14px';
				
				if(get_field('custom_hover') !== 'enabled') {
					$thumb_options = 'options';
				} else {
					$thumb_options = '';
				}	

				if(get_field('hover_title_alignment', $thumb_options)) {
					$title_alignment = get_field('hover_title_alignment', $thumb_options);
					$title_alignment = explode('_', $title_alignment);
					
					if($title_alignment[0] === 'top') {
						$title_alignment[0] = 'top: 0;';
					} else if($title_alignment[0] === 'middle') {
						$title_alignment[0] = '
							top: 50%; 
							-webkit-transform: translateY(-50%);
							-moz-transform: translateY(-50%);
							-ms-transform: translateY(-50%);
							transform: translateY(-50%);
						';
					} else {
						$title_alignment[0] = 'bottom: 0;';
					}
					
					$hover_h3 = 'text-align: ' . $title_alignment[1] . '; ' . $title_alignment[0];
				}
				
				if(get_field('hover_bg_color', $thumb_options)) {
					$rgba = HexToRGB(get_field('hover_bg_color', $thumb_options));
					$hover_background .=  'background-color: rgb(' . $rgba['r'] . ', ' . $rgba['g'] . ', ' . $rgba['b'] . ') !important; background-color: rgba(' . $rgba['r'] . ', ' . $rgba['g'] . ', ' . $rgba['b'] . ', ' . get_field('hover_bg_opacity', $thumb_options) . ') !important;';
				}

				if(get_field('hover_bg_image', $thumb_options)) {
					// if not set to disabled, don't show title and category if background image is active
					if(get_field('hover_title_bg_visiblity', $thumb_options) !== 'disabled') {
						$hover_h3 .= 'display: none;';
					}
					$hover_background .= 'background-image: url(' . get_field('hover_bg_image', $thumb_options) . '); background-repeat: no-repeat; background-position: center center; !important;';
				}

				if(get_field('hover_bg_scale', $thumb_options) === 'cover') {
					$hover_background .= 'background-size: cover !important;';
				}
				
				if(get_field('hover_title_color', $thumb_options)) {
					$hover_h3 .= 'color: ' . get_field('hover_title_color', $thumb_options) . ' !important;';
				}

				if(get_field('hover_category_color', $thumb_options)) {
					$hover_h3_span .= 'color: ' . get_field('hover_category_color', $thumb_options) . ' !important;';
				}

				if(get_field('hover_title_visibility', $thumb_options) === 'hide_both') {
					$hover_h3 .= 'display: none;';
				} elseif(get_field('hover_title_visibility', $thumb_options) === 'hide_category') {
					$hover_h3_span .= 'display: none !important;';
				}
				
				// font size title
				if(get_field('hover_title_font_size', $thumb_options)) {
					$title_font_size = 'fs-' . get_field('hover_title_font_size', $thumb_options) . 'px';
					$title_line_height = 'lh-' . get_field('hover_title_font_size', $thumb_options) . 'px';
				}

				// category size title
				if(get_field('hover_category_font_size', $thumb_options)) {
					$category_font_size = 'fs-' . get_field('hover_category_font_size', $thumb_options) . 'px';
					$category_line_height = 'lh-' . get_field('hover_category_font_size', $thumb_options) . 'px';
				}
				
				// font-weight title
				if(get_field('hover_title_font_weight', $thumb_options)) {
					$title_weight = get_field('hover_title_font_weight', $thumb_options);
				} else {
					$title_weight = 'light';
				}
				
				// font-weight category
				if(get_field('hover_category_font_weight', $thumb_options)) {
					$category_weight = get_field('hover_category_font_weight', $thumb_options);
				} else {
					$category_weight = 'light';
				}
				
				// string for jquery masonry
				$masonry_content .= '<div ' . $margin_fix . ' class="thumb grid-item masonry-thumbs-item masonry-' . $options['masonryid'] . '-item masonry-' . $options['masonryid'] . '-item-' . $index . ' ' . $thumb_class . get_field('thumbnail_width') . '" data-thumb-src="' . $thumbnail[0] . '">';
				$masonry_content .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
				$masonry_content .= '<div class="thumb-inner">';
				// hide hover on mobile devices
				if(!$detect->isMobile()) {
					$masonry_content .= '<div class="thumb-hover" style="' . $hover_background . '"><h3 class="' . $title_weight . ' ' . $title_font_size . ' ' . $title_line_height . '" style="' . $hover_h3 . '">' . get_the_title() . '<br /><span class="' . $category_weight . ' ' . $category_font_size . ' ' . $category_line_height . '" style="' . $hover_h3_span . '">' . get_field('category') . '</span></h3></div>';
				}
				if($thumbnail) {
					$masonry_content .= '<img alt="' . get_the_title() . '" src="' . $thumbnail[0] . '" />';
				} else {
					$masonry_content .= '<img alt="' . get_the_title() . '" height="500" src="' . get_bloginfo('template_directory') . '/images/no_thumb.png" />';
				}
				$masonry_content .= '</div>';
				if(!$hide_title) {
					$masonry_content .= '<h3 class="thumb-title" ' . $title_color . '>' . get_the_title() . '<br /><span ' . $category_color . '>' . get_field('category') . '</span></h3>';
				}
				$masonry_content .= '</a>';
				$masonry_content .= '</div>';
				
				$index ++;
				
			}
		}
	}

	// if normal thumbs append items to jquery
	if(!$is_fwt) {

		// get grid
		$e .= semplice_grid($options['masonryid'], $masonry_content, $is_fluid, $remove_gutter, $index, $pre);
		
	} else {
		// fade in fwt
		$e .= '<script type="text/javascript">(function($){$(document).ready(function(){$(".fwt").showdelay($(".fwt").length);});})(jQuery);</script>';
	}

	// close section
	$e .= '</section>';

	// output
	return $e;
		
	// reset postdata
	wp_reset_postdata();
?>