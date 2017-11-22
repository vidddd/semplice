<?php

/*
 * code shortcode
 * semplice.theme
 */

 
class ce_code {

	function __construct() {
	
		// add shortcode
		add_shortcode('ce_code', array(&$this, 'ce_code_shortcode'));

	}
	
	function ce_code_shortcode($options) {

		$e = '';
		$content = '';
		
		// attributes
		extract( shortcode_atts(
			array(
				'content_id'			=> '',
				'post_id'				=> '',
				'use_responsive_video'	=> '',
				'in_column'				=> '',
				'column_id'				=> '',
				'column_content_id' 	=> '',
			), $options )
		);

		// content id
		$content_id = '#' . $content_id;

		// make sure to use the correct post id and check if this is a block or dynamic block
		if(!is_admin()) {
			global $post;
			// is first save or dynamic block?
			if($post->ID !== $post_id) {
				global $wpdb;
				$table_name = $wpdb->prefix . 'semplice_blocks';
				$block_type = $wpdb->get_var("SELECT block_type FROM $table_name WHERE block_id = '$content_id'");
				// if not dynamic, change the post id to the currect post id
				if($block_type !== 'dynamic') {
					$post_id = $post->ID;
				}
			}
		}
			
		$rom = json_decode(get_post_meta( $post_id, 'semplice_ce_rom', true), true);

		if(isset($rom)) {
			// get code block from rom
			if(!$in_column) {
				$content = $rom[$content_id]['content'];
			} else {
				if(isset($rom[$content_id])) {
					$content = $rom[$content_id]['columns'][$column_id][$column_content_id]['content'];
				}
			}
		}
		
		// code wrapper start
		$e .= '<div class="ce-code">';
		
		$e .= $content;
		
		// code wrapper close
		$e .= '</div>';
		
		// output es
		return $e;
	}
}

// call instance of module class
global $ce_code;
$ce_code = new ce_code();

?>