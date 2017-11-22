<?php
/*
 * Content Editor 2.0
 * semplice.theme
 * 
 */

// include content class
include('class.editor.php'); 

// get content type
$content_type = isset($_POST['content_type']) ? $_POST['content_type'] : '';

// get edit mode
$edit_mode = isset($_POST['edit_mode']) ? $_POST['edit_mode'] : ''; 

// post id
$post_id = isset($_POST['post_id']) ? $_POST['post_id'] : ''; 

// is column content?
$is_column_content = isset($_POST['is_column_content']) ? $_POST['is_column_content'] : '';

// single edit dynamic block
$single_edit_db = isset($_POST['single_edit_db']) ? $_POST['single_edit_db'] : '';

// content class
$editor = new editor();

// Edit mode
if($edit_mode === 'edit' || $edit_mode === 'new' || $edit_mode === 'single-edit') {
	
	// if content is new or empty, set index false
	if(!isset($editor->rom['content'])) {
		$editor->rom['content'] = false;
	}
	
	// is single edit and dynamic block?
	if(!empty($single_edit_db)) {
		$editor->rom['dynamic_block'] = $single_edit_db;
	}

	// is dynamic block?
	if(isset($editor->rom['dynamic_block'])) {

		// block id
		$block_id = $editor->rom['dynamic_block'];

		// query
		$db_rom = $editor->db->get_var("SELECT rom FROM $editor->table_name WHERE block_id = '$block_id'");

		$db_rom = json_decode($db_rom, true);

		// if single edit dynamic block, add only content id rom
		if(!empty($single_edit_db)) {
			$editor->rom = $db_rom['columns'][$editor->column_id]['#' . $editor->id];

		} else {
			$editor->rom = $db_rom;
		}

	}

	// normal values
	$values = array(
		'styles'		=> isset($editor->rom['styles']) ? $editor->rom['styles'] : '', 
		'style_class'	=> 'is-style', 
		'in_column'		=> false, 
		'id'			=> $editor->id,
		'post_id'		=> $post_id,
		'column_id'		=> $editor->column_id,
		'content_type'	=> $editor->content_type,
		'options'		=> isset($editor->rom['options']) ? $editor->rom['options'] : '',
		'options_class' => 'is-option',
		'cm_class'		=> 'is-custom-module',
		'dynamic_block' => isset($editor->rom['dynamic_block']) ? $editor->rom['dynamic_block'] : '',
	);
	
	if($is_column_content) {
		$values['styles'] = isset($editor->rom['columns'][$editor->column_id]['#' . $editor->id]['styles']) ? $editor->rom['columns'][$editor->column_id]['#' . $editor->id]['styles'] : '';
		$values['style_class'] = 'is-cc-style';
		$values['in_column'] = true;
		$values['options_class'] = 'is-cc-option';
		$values['options'] = isset($editor->rom['columns'][$editor->column_id]['#' . $editor->id]['options']) ? $editor->rom['columns'][$editor->column_id]['#' . $editor->id]['options'] : '';
		$values['cm_class'] = 'is-cc-custom-module';
	}

	// single edit styles and column mode
	if($edit_mode === 'single-edit') {
		$values['styles'] = isset($editor->rom['styles']) ? $editor->rom['styles'] : '';
		$values['style_class'] = 'is-cc-style';
		$values['in_column'] = false;
		$values['options_class'] = 'is-cc-option';
		$values['options'] = isset($editor->rom['options']) ? $editor->rom['options'] : '';
		$values['cm_class'] = 'is-cc-custom-module';
	}
	
	#----------------------------------
	# load edit
	#----------------------------------
	
	if($content_type === 'multi-column') {
		// load multi column
		$editor->mc_edit($values);
	} elseif($content_type === 'add-column') {

		// column values

		$column_values = array(
			'column_id'			=> str_replace('#', '', $editor->id),
			'parent_id'			=> str_replace('#', '', $editor->parent_id),
			'column_styles'		=> isset($editor->rom['columns']['#' . $editor->id]['styles']) ? $editor->rom['columns']['#' . $editor->id]['styles'] : '',
			'column_width'		=> 'span6',
			'column_offset'		=> 'no-offset',
			'column_count'		=> $editor->column_count,
			'column_name'		=> '',
			'is_new'			=> true
		);
		// add column
		$editor->add_column($column_values);
	} else {
		// load standard edit
		$editor->load_module(stripcslashes($editor->rom['content']), $values, $editor->content_type);
	}
	
} elseif ($edit_mode === 'custom-fontset') {
	
	// get custom fontset
	$editor->custom_fontset();
	
} elseif ($edit_mode === 'load-template') {
	
	// load semplice preset
	$editor->load_template();

} elseif ($edit_mode === 'save-block') {

	// save block
	$editor->save_block(false);	

} elseif ($edit_mode === 'remove-block') {

	// remove block
	$editor->remove_block();

} elseif ($edit_mode === 'preview-block') {

	// preview block
	$editor->preview_block();

} elseif ($edit_mode === 'add-block') {

	// save block
	$editor->add_block();

} elseif ($edit_mode === 'code-editor') {

	// code mirror
	$editor->code_editor();
	
} elseif ($edit_mode === 'init') {

	function strposOffset($search, $string, $offset)
	{

		$arr = explode($search, $string);

		switch( $offset )
		{
			case $offset == 0:
			return false;
			break;
		
			case $offset > max(array_keys($arr)):
			return false;
			break;

			default:
			return strlen(implode($search, array_slice($arr, 0, $offset)));
		}
	}

	// encode unescaped unice < php 5.3. Thanks to mpyw from stack.overflow
	function raw_json_encode($matches) {
		return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
	}

	// rom
	$rom = stripcslashes(get_post_meta( $post_id, 'semplice_ce_rom', true ));

	// search strings
	$content_start = '{"content":"';
	$content_end = '","styles":{';
	
	// vars
	$offset_start = 0;
	$offset_end = 0;
	
	// offset array
	$offset_arr = array();
	
	// size
	$size = substr_count($rom, $content_start);

	for( $i = 1; $i <= $size; $i++) {
		
		// start and end offset
		$offset_start = strposOffset($content_start, $rom, $i);
		$offset_end = strposOffset($content_end, $rom, $i);
		
		$offset_arr['start'][$i] = $offset_start;
		$offset_arr['length'][$i] = $offset_end - $offset_start;

		if($offset_arr['length'][$i] > 12) {

			$search  = substr($rom, $offset_arr['start'][$i] + 12, $offset_arr['length'][$i] - 12);

			// strip slashes if available to avoid double slashes
			$replace = stripcslashes($search);

			// json encode the replace string
			if(version_compare(PHP_VERSION, '5.4.0') >= 0) {
				$replace = json_encode($replace, JSON_UNESCAPED_UNICODE);
			} else if(get_field('ce_safe_mode', 'options') !== 'enabled') {
				$replace = preg_replace_callback( "/\\\\u([0-9a-zA-Z]{4})/", "raw_json_encode", json_encode($replace));	
			} else {
				$replace = json_encode($replace);
			}

			// cut quotes from the json string
			$replace = substr($replace, 1, -1);
			
			// output
			$rom = str_replace($search, $replace, $rom);
		}
		
	}

	// output array
	$json_output = array();
	$json_output['rom'] = $rom;
	
	// get dynamic block ids
	$temp_rom = json_decode($rom, true);
	$deleted_blocks = array();
	$block_count = 0;

	foreach ($temp_rom as $key => $value) {
		if (strpos($key, '#content_') === 0) {
			if(!empty($value['dynamic_block'])) {

				// get block id
				$block_id = $value['dynamic_block'];

				// looks if the block is still active
				$is_alive = $editor->db->get_var("SELECT id FROM $editor->table_name WHERE block_id = '$block_id'");

				// if not alive, add to removal list
				if(empty($is_alive)) {
					$deleted_blocks[$block_count] = $block_id;
					$block_count++;
				}

			}
		}	
	}

	// output content
	remove_filter('the_content', 'wpautop');

	// get content			
	$content = get_post_meta( $post_id, 'semplice_ce_content', true );

	// remove bg image escaped quotes
	$content = remove_esc_bg_quotes($content);
	
	// prevent embed codes from getting executed
	$content = str_replace('[embed]', '[unex_embed]', $content);

	// apply the ce shortcodes whitelist
	$output = apply_filters('ce_shortcodes', $content, $post_id);
	
	// apply the_content filter
	$output = apply_filters('the_content', $content);

	// temporary shortcode texturize fix for wordpress 4.0.1
	// $quotes = array('&#8220;', '&#8221;', '&#8243;', '&Prime;', '&#x2033;', '″');
	// $output = str_replace($quotes, '"', $output);

	// output in array
	$json_output['html'] = $output;

	// dynamic block content ids
	$json_output['deleted_blocks'] = $deleted_blocks;
	
	echo json_encode($json_output);
	
} else {
	
	// normal values
	$view_values = array(
		'has_container'	=> true,
		'id'			=> $editor->id,
		'styles'		=> isset($editor->rom['styles']) ? $editor->rom['styles'] : '',
		'options'		=> isset($editor->rom['options']) ? $editor->rom['options'] : '',
		'in_column'		=> false,
		'post_id'		=> $post_id,
		'module_id'		=> isset($editor->rom['custom_module']) ? $editor->rom['custom_module'] : '',
		'dynamic_block' => isset($editor->rom['dynamic_block']) ? $editor->rom['dynamic_block'] : '',
	);
	
	#----------------------------------
	# load view
	#----------------------------------
	
	if($content_type !== 'multi-column') {
	
		// dynamic blocks
		if(isset($editor->block_update) && $editor->block_update === true) {
			
			// html
			$html = $editor->load_module(stripslashes($editor->rom['content']), $view_values, $editor->content_type);
			
			// update block in database
			$editor->save_block($html);

			echo $html;
			
		} else {
			
			// load standard view
			echo $editor->load_module(stripslashes($editor->rom['content']), $view_values, $editor->content_type);
		}
	
	} else {

		// load multi column view
		// masonry prefix
		$pre = '';

		// output
		$mc_html = '';
	
		// remove gutter and fluid layout
		$remove_gutter = filter_var($editor->rom['options']['remove-gutter'], FILTER_VALIDATE_BOOLEAN);
		$is_fluid = filter_var($editor->rom['options']['show-fullscreen'], FILTER_VALIDATE_BOOLEAN);
	
		if($remove_gutter) {
			$pre = 'masonry-';
		}

		// row container head
		$mc_html .= $editor->row_header($editor->rom['styles'], $editor->rom['options'], $remove_gutter, $is_fluid, $view_values);
		
		foreach($editor->rom['columns'] as $mc_column_id => $mc_columns) {
		
			// column width
			$column_width = $mc_columns['options']['column-width'];

			// offset
			$column_offset = $mc_columns['options']['column-offset'];

			if(!empty($column_offset) && $column_offset !== 'no-offset') {
				$mc_html .= '<div class="' . $pre . $column_offset . ' masonry-item remove-gutter-' . $remove_gutter . ' masonry-offset" style="' . container_styles($mc_columns['styles']) . '"><!-- Masonry offset --></div>';
			}
			
			// column div open
			$mc_html .= '<div class="' . $pre . $column_width . ' masonry-item remove-gutter-' . $remove_gutter . '" style="' . container_styles($mc_columns['styles']) . '">';
			
			foreach($mc_columns as $mc_content_id => $mc_content) {
				
				// content type index
				$mc_content['content_type'] = isset($mc_content['content_type']) ? $mc_content['content_type'] : '';
				
				// content index
				$mc_content['content'] = isset($mc_content['content']) ? $mc_content['content'] : '';
				
				// custom module
				$mc_content['custom_module'] = isset($mc_content['custom_module']) ? $mc_content['custom_module'] : '';
				
				// single edit values
				$view_se_values = array( 
					'has_container' 		 	=> false,
					'id'						=> $mc_content_id,
					'options'					=> isset($mc_content['options']) ? $mc_content['options'] : '',
					'styles' 				 	=> isset($mc_content['styles']) ? $mc_content['styles'] : '', 
					'in_column'	 			 	=> true, 
					'single_edit_content_id' 	=> $mc_content_id, 
					'single_edit_column_id'  	=> $mc_column_id, 
					'single_edit_content_type'	=> $mc_content['content_type'],
					'module_id'					=> $mc_content['custom_module'],
					'post_id'					=> $post_id,
				);

				#----------------------------------
				# multi column view
				#----------------------------------
				
				if($mc_content['content_type']) {
					$mc_html .= $editor->load_module(stripslashes($mc_content['content']), $view_se_values, $mc_content['content_type']);
				}
			}
			
			// column div close
			$mc_html .= '</div>';
		}
		
		// row container footer
		$mc_html .= $editor->row_footer($remove_gutter, $is_fluid);

		// dynamic blocks
		if(isset($editor->block_update) && $editor->block_update === true) {
						
			// update block in database
			$editor->save_block($mc_html);

			echo $mc_html;
			
		} else {

			// load standard view
			echo $mc_html;
		}
		
	}
}

