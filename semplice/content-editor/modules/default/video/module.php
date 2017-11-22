<?php

/*
 * Video Module
 * Made by Semplicelabs
 */

if($this->edit_mode) {
	
	// output
	$e = '';

	// edit head
	$this->edit_head($values);
	
	$transparent_controls = array(
		'non_transparent' => 'No',
		'transparent'  => 'Yes'
	);

	$hide_controls = array(
		'' => 'No',
		'hide-controls' => 'Yes'
	);
	
	$autoplay = array(
		'' => 'No',
		'autoplay' => 'Yes'
	);

	$loop = array(
		'' => 'No',
		'loop' => 'Yes'
	);

	$muted = array(
		'' => 'No',
		'muted' => 'Yes'
	);

	// tabs
	$tabs = array(
		'video' 		=> 'Video',
		'options'	 	=> 'Options'
	);

	// options
	
	$values['options']['video_url'] = $content;

	// open tabs
	$this->tabs_open($values, $tabs);
	
		// options tab open
		$this->tab_open('video');

			$this->get_option('video', 'Upload Video (or link to file, only self hosted)', 'video_url', '', '', $values);
			$this->get_option('image-option', 'Upload Poster Image (not required)', 'img', '', '', $values);

		// options tab open
		$this->tab_close();

		// options tab open
		$this->tab_open('options');

			$this->get_option('text', 'Aspect Ratio (optional) <div class="ce-help">(?)<span>This is only required for a special aspect ratio other than 16:9. Example: 4:3. (please always use a colon between the digits like in the 4:3 example) </span></div>', 'ratio', '', '', $values);
			$this->get_option('select', 'Autoplay', 'autoplay', 'no', $autoplay, $values);
			$this->get_option('select', 'Loop Video', 'loop', 'no', $loop, $values);
			$this->get_option('select', 'Muted', 'muted', 'no', $muted, $values);
			$this->get_option('select', 'Use Transparent Controls', 'transparent_controls', 'no', $transparent_controls, $values);
			$this->get_option('select', 'Hide Controls', 'hide_controls', 'no', $hide_controls, $values);

		// options tab open
		$this->tab_close();

	// close tabs
	$this->tabs_close($values);
		
	echo '<div class="clear"></div>';
		
	// output
	echo $e;

	// edit foot
	$this->edit_foot($values);
		
} else {

	// output
	$e = '';
	
	$e .= $this->view_head($values);

	if($values['has_container']) {
		$e .= '<div class="span12">';
	}
	
	$masonry_id = false;

	// get masonry id if needed
	if($values['in_column']) {
		$masonry_id = $this->id;
	}

	// get the video url
	$video_url = $content;
	
	// video extension
	$video_ext = $video_url;
	
	// get the string length
	$length = strlen($video_ext);
	
	// extension length
	$ext = 3;
	
	// start with the last 3 chars
	$start = $length - $ext;
	
	// get the video extension
	$video_ext = substr($video_ext, $start ,$ext);
	
	if($video_ext === 'ogv') {
		$video_ext = 'ogg';
	} elseif ($video_ext === 'ebm') {
		$video_ext = 'webm';
	}
	
	// transparent controls
	$transparent_controls = '';
	
	if($values['options']['transparent_controls'] === 'transparent') {
		$transparent_controls = 'transparent-controls';
	}

	// upload, link or embed
	$e .= '<div class="video-edit"><div class="is-video"></div></div>';
	$e .= '<div class="live-video ' . $transparent_controls . ' ' . $values['options']['hide_controls'] . '" style="width: 100%; max-width: 100%">';
	$e .= '[cevideo masonry_id="' . $masonry_id  . '" src="' . $content . '" type="video/' . $video_ext . '" poster="' . $values['options']['img'] . '" loop="' . $values['options']['loop'] . '" autoplay="' . $values['options']['autoplay'] . '" muted="' . $values['options']['muted'] . '" ratio="' . $values['options']['ratio'] . '"][/cevideo]';
	$e .= '</div>';
	
	if($values['has_container']) {
		$e .= '</div>';
	}
	
	// cs footer
	$e .= $this->view_foot($values);

	// output
	return $e;

}
