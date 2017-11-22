<?php

/*
	oEmbed Module
	Made by: Semplicelabs
*/

if($this->edit_mode) {
	
	// edit head
	$this->edit_head($values);
	
	// media type array
	$media_type = array(
		'video' => 'Video',
		'other' => 'Other'
	);
	
	echo '<div class="options">';

	// options
	$this->get_option('text', 'oEmbed Link (<a href="https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">Supported Sites</a>)', 'oembed', 'https://www.youtube.com/watch?v=TwaMFVfXPwA', '', $values);
	$this->get_option('text', 'Aspect Ratio (optional, read info) <div class="ce-help">(?)<span>If you experience black bars (mostly with non 16:9 aspect ratios), please add your aspect ratio here.<br />Examples: 16:9. You can even just use your resolution like: 1280:720. (don\'t forget the colon between width and height)</span></div>', 'ratio', '', '', $values);

	// media type
	$this->get_option('select', 'Media Type', 'media_type', 'video', $media_type, $values);

	// option
	
	echo '<div class="clear"></div>';

	echo '</div>';
	
	// edit foot
	$this->edit_foot($values);
		
} else {

	// output
	$e = '';

	$e .= $this->view_head($values);

	// padding
	$padding = '';
	
	// responsive class
	$responsive_class_div = '';
	$responsive_class_div_close = '';
	
	if($values['options']['media_type'] === 'video') {

		// has custom aspect ratio
		if(!empty($values['options']['ratio'])) {

			// eleminate any spaces
			$ratio = str_replace(' ', '', $ratio);
			// make array
			$ratio = explode(':', $values['options']['ratio']);
			// padding
			$padding = ' style="padding-bottom: ' . ($ratio[1] / $ratio[0] * 100) . '%"';

		}

		$responsive_class_div = '<div class="responsive-video"' . $padding . '>';
		$responsive_class_div_close = '</div>';
	}
	
	if($values['has_container']) {
		$e .= '<div class="span12">' . $responsive_class_div;
	} else {
		$e .= $responsive_class_div;
	}
	
	// get the audio url
	$url = $values['options']['oembed'];

	//$htmlcode = wp_oembed_get($url);
	
	$e .= '<div class="oembed-edit"><div class="is-oembed"></div></div>';
	$e .= '<div class="oembed-content">[embed]' . $url . '[/embed]</div>';
	
	if($values['has_container']) {
		$e .=  '</div>' . $responsive_class_div_close;
	} else {
		$e .=  $responsive_class_div_close;
	}
	
	// cs footer
	$e .= $this->view_foot($values);

	// output
	return $e;

}
