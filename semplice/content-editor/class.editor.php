<?php
/*
 * Class - content
 * semplice.theme
 * 
 */ 
 
class editor {
	
	// vars
	public $id;
	public $ccId;
	public $rom;
	public $column_id;
	public $edit_mode;
	public $parent_id;
	public $content_type;
	public $remove_gutter;
	public $is_fluid;
	public $add_column_foot;
	public $fontset_id;
	public $template_id;
	public $template_type;
	public $block_html;
	public $block_name;
	public $block_id;
	public $block_type;
	public $block_update;
	public $block_content_ids;
	public $code;
	public $module_id;
	public $is_column_content;
	public $column_count;
	public $db;
	public $table_name;

	function __construct() {
		
		// database
		global $wpdb;
        $this->db = $wpdb;
		$this->table_name = $wpdb->prefix . 'semplice_blocks';
		
		// vars
		$this->id 					= isset($_POST['id']) ? $_POST['id'] : '';
		$this->ccId 				= isset($_POST['ccId']) ? $_POST['ccId'] : '';
		$this->rom 					= isset($_POST['rom']) ? $_POST['rom'] : '';
		$this->column_id 			= isset($_POST['column_id']) ? $_POST['column_id'] : '';
		$this->edit_mode 			= isset($_POST['edit_mode']) ? $_POST['edit_mode'] : '';
		$this->parent_id 			= isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
		$this->is_column_content 	= isset($_POST['is_column_content']) ? $_POST['is_column_content'] : '';
		$this->content_type 		= isset($_POST['content_type']) ? $_POST['content_type'] : '';
		$this->add_column_foot 		= '</div></div></div></div>';
		$this->fontset_id 			= isset($_POST['fontset_id']) ? $_POST['fontset_id'] : '';
		$this->template_id 			= isset($_POST['template_id']) ? $_POST['template_id'] : '';
		$this->template_type 		= isset($_POST['template_type']) ? $_POST['template_type'] : '';
		$this->block_html			= isset($_POST['block_html']) ? $_POST['block_html'] : '';
		$this->block_name			= isset($_POST['block_name']) ? $_POST['block_name'] : '';
		$this->block_id				= isset($_POST['block_id']) ? $_POST['block_id'] : '';
		$this->block_content_ids	= isset($_POST['block_content_ids']) ? $_POST['block_content_ids'] : '';
		$this->block_type			= isset($_POST['block_type']) ? $_POST['block_type'] : '';
		$this->block_update			= isset($_POST['block_update']) ? filter_var($_POST['block_update'], FILTER_VALIDATE_BOOLEAN) : false;
		$this->code					= isset($_POST['code']) ? $_POST['code'] : '';
		$this->column_count 		= isset($_POST['column_count']) ? $_POST['column_count'] : '';
	}

	// tabs open
	function tabs_open($values, $tabs) {
		
		echo '
			<div class="tabs" id="' . $values['id'] . '-ui-tabs">
				<ul>
		';
		
		// show tabs
		foreach($tabs as $id => $name) {
			echo '<li><a href="#' . $id . '">' . $name . '</a></li>';
		}
		
		echo '
			</ul>
			<div class="clearfix"></div>
		';
	}
	
	// tabs open
	function tabs_close($values) {
		echo '
			</div>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function () {
						$("#' . $values['id'] . '-ui-tabs").tabs();
					});
				})(jQuery);
			
			</script>
		';
	}
	
	// tab open
	function tab_open($id) {
		echo '
			<div id="' . $id . '">
				<div class="options">
		';
	}
	
	// tab close
	function tab_close() {
		echo '
				</div>
			</div>
		';
	}
	
	// tab title
	function tab_title($title) {
		echo '
			<div class="module-meta">
				<h3>' . $title[0] . '</h3>
				<p>' . $title[1] . '</p>
			</div>
		';
	}

	// get options
	function get_option($type, $title, $name, $default, $val, $values) {
	
		// option head
		if(isset($values['cols'])) {
			echo '<div class="two-col-option">';
		}
		
		// special option
		if(isset($values['special-option'])) {
			$option_class = $values['special-option'];
		} else {
			$option_class = '';
		}
		
		echo '<div class="option-wrapper ' . $option_class . '"><div class="option-left"><div class="option"><h4>' . $title . '</h4></div></div><div class="option-right"><div class="option">';
		
		// select
		if($type === 'select') {
		
			// set default value
			if(!isset($values['options'][$name])) {
				$values['options'][$name] = $default;
			}

			// output field
			echo '<div class="ce-select-box big-box"><select name="' . $name . '" class="' . $values['options_class'] . ' select-box" data-content-id="' . $values['id'] . '">';
			
			// output options
			$this->select($val, $values['options'][$name]);
			
			// footer
			echo '</select></div>';
		
		// multiple select
		} else if($type === 'multiple-select') {
			
			// set default value
			if(!isset($values['options'][$name])) {
				$values['options'][$name] = $default;
			}

			// output field
			echo '<div class="ce-multi-select-box"><select name="' . $name . '" class="' . $values['options_class'] . ' multiple-select-box" data-content-id="' . $values['id'] . '" size="5" multiple>';
			
			// output options
			$this->select($val, $values['options'][$name]);
			
			// footer
			echo '</select></div>';
			
		} else if($type === 'color') {
			if(!isset($values['options'][$name])) {
				$values['options'][$name] = $default;
			}
			echo '<div class="wp-color"><input type="text" value="' . $values['options'][$name] . '" class="color-picker ' . $values['options_class'] . '" data-default-color="' . $default . '" name="' . $name . '" /></div>';
		} else if($type === 'text') {
			if(!isset($values['options'][$name])) {
				$values['options'][$name] = $default;
			}
			echo '<input type="text" value="' . $values['options'][$name] . '" class="' . $values['options_class'] . '" name="' . $name . '" />';
		} else if($type === 'video') {
			if(!isset($values['options']['video-filename'])) {
				$values['options']['video-filename'] = 'Upload Video';
			}
			echo 
				'<div class="media-upload-box video-upload-box">
					<a class="media-upload semplice-button video-upload" data-content-id="' . $values['id'] . '" data-upload-type="video">' . $values['options']['video-filename'] . '</a><a class="remove-video remove-media" data-content-id="' . $values['id'] . '" data-media="video"></a>
					<div class="clear"></div>
					<input type="text" name="' . $name . '" class="is-content is-video media-field-margin" placeholder="Select Video or enter url manually here." value="' . $values['options'][$name] . '">
					<input type="hidden" name="video-filename" class="' . $values['options_class'] . '" value="' . $values['options']['video-filename'] . '">
				</div>';
		} else if($type === 'image-option') {

			if(!isset($values['options']['image-filename'])) {
				$values['options']['image-filename'] = 'Upload Image';
			}
			
			if(!isset($values['options']['img'])) {
				$values['options']['img'] = '';
			}

			echo 
				'<div class="media-upload-box image-option image-option-upload-box">
					<a class="media-upload semplice-button image-upload" data-content-id="' . $values['id'] . '" data-upload-type="image">' . $values['options']['image-filename'] . '</a><a class="remove-image remove-media" data-content-id="' . $values['id'] . '" data-media="image"></a>
					<div class="clear"></div>
					<input type="hidden" name="img" class="' . $values['options_class'] . ' is-image" value="' . $values['options']['img'] . '">
					<input type="hidden" name="image-filename" class="' . $values['options_class'] . '" value="' . $values['options']['image-filename'] . '">
				</div>';
		} else if($type === 'audio') {
			if(!isset($values['options']['audio-filename'])) {
				$values['options']['audio-filename'] = 'Upload Audio';
			}
			echo 
				'<div class="media-upload-box video-upload-box">
					<a class="media-upload semplice-button audio-upload" data-content-id="' . $values['id'] . '" data-upload-type="audio">' . $values['options']['audio-filename'] . '</a><a class="remove-video remove-media" data-content-id="' . $values['id'] . '" data-media="audio"></a>
					<div class="clear"></div>
					<input type="text" name="' . $name . '" class="is-content is-audio media-field-margin" placeholder="Select Audio or enter url manually here." value="' . $values['options'][$name] . '">
					<input type="hidden" name="audio-filename" class="' . $values['options_class'] . '" value="' . $values['options']['audio-filename'] . '">
				</div>';
		} else if($type === 'message') {
			echo
				'<div class="module-messsage">
					' . $name . '
				</div>';
		}
		
		// option footer
		echo '</div></div></div>';
		
		if(isset($values['cols'])) {
			echo '</div>';
		}
	}
	
	// select boxes
	function select($arr, $active_key) {

		if(is_array($arr)) {
			// is multiselect?
			if(is_array($active_key)) {
				foreach( $arr as $key => $value ) {
					if(in_array($key, $active_key)) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
			} else {
				foreach( $arr as $key => $value ) {
					if($key === $active_key) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
			}
		}
	}
	
	// options seperator
	function option_seperator() {
		echo '<div class="hr"></div>';
	}
	
	// title seperator
	function title_seperator($title) {
		echo '<div class="title-seperator"><p>' . $title . '</p></div>';
	}
	
	// fullscreen codemirror
	function code_editor() {
		// textfields
		echo '
			<div id="code-editor">
				<div class="code-editor-save">
					<a class="code-cancel"></a>
					<a class="code-save" data-content-id="' . $this->id . '"></a>
				</div>
				<textarea id="code_mirror">' . stripslashes(htmlentities($this->code)) . '</textarea>
				<script type="text/javascript">
					(function($) {
						$(document).ready(function () {
							var cm = CodeMirror.fromTextArea(code_mirror, {
								lineNumbers: true,
								mode: "htmlmixed",
								indentWithTabs: true,
								theme: "semplice",
							});

							function updateTextArea() {
							    cm.save();
							}

							cm.on("change", updateTextArea);
						});
					})(jQuery);
				</script>
			</div>
		';
	}

	// horizontal rule styles
	function hr_styles($values) {
		
		$css = '';
		
		if($values['options']['height']) {
			$css .= 'height:' . $values['options']['height'] . ';';
		}
		if($values['options']['margin_top']) {
			$css .= 'margin-top:' . $values['options']['margin_top'] . ';';
		}
		if($values['options']['margin_bottom']) {
			$css .= 'margin-bottom:' . $values['options']['margin_bottom'] . ';';
		}
		if($values['options']['color']) {
			$css .= 'background-color:' . $values['options']['color'] . ';';
		}
		
		return $css;
	}

	function styles($values) {
		// include the legendary atts
		include('styles.php');
	}
	
	function save_block($update_html) {
		
		// html
		$html = stripcslashes($this->block_html);
		
		// module id
		$module_id = isset($this->rom['custom_module']) ? $this->rom['custom_module'] : false;

		// strip slashes for the rom content
		if($this->rom['content_type'] === 'multi-column') {
			foreach($this->rom['columns'] as $mc_column_id => $mc_columns) {				
				foreach($mc_columns as $mc_content_id => $mc_content) {

					$this->rom['columns'][$mc_column_id][$mc_content_id]['content'] = isset($this->rom['columns'][$mc_column_id][$mc_content_id]['content']) ? $this->rom['columns'][$mc_column_id][$mc_content_id]['content'] : '';

					// strip slashes for the rom content
					$this->rom['columns'][$mc_column_id][$mc_content_id]['content'] = stripcslashes($this->rom['columns'][$mc_column_id][$mc_content_id]['content']);

				}
			}
		} else {
			
			$this->rom['content'] = stripcslashes($this->rom['content']);
		}
		
		// insert or update block
		if(isset($this->block_update) && $this->block_update === true) {
			$this->db->update(
				$this->table_name,
				array(
					"rom"	=> json_encode($this->rom),
					"html" 	=> trim(preg_replace('/\t+/', '', $update_html))
				), 
				array( 'block_id' => $this->rom['dynamic_block'] ), 
				array(
					'%s',
					'%s'
				), 
				array( '%s' ) 
			);			
		} else {
			// block id
			if(isset($this->rom['dynamic_block'])) {
				$type = 'dynamic';
			} else {
				$type = 'static';
			}

			$this->db->insert(
				$this->table_name, 
				array(
						"name"			=> $this->block_name,
						"block_id" 		=> $this->id,
						"block_type"	=> $type,
						"content_type"	=> $this->content_type,
						"module_id"		=> $module_id,
						"rom"  			=> json_encode($this->rom),
						"html" 			=> trim(preg_replace('/\t+/', '', $html))
				)
			);

			// blocks instance
			$blocks = new blocks();
			echo $blocks->generate_blocklist();
		}
		
	}

	function preview_block() {

		// get block preview
		$get_block_preview = wp_remote_get('http://blocks.semplicelabs.com/index.php?action=block_preview&block_id=' . $this->block_id);

		// get block preview body
		$get_block_preview = json_decode($get_block_preview['body'], true);

		if(is_array($get_block_preview)) {
			$block_preview = $get_block_preview['content'];
		} else {
			$block_preview = 'noconnection';
		}

		echo $block_preview;

	}
	
	function add_block() {
	
		// block array
		$block = array();

		// get block row
		if($this->block_type === 'remote') {

			// get remote block
			$get_remote_block = wp_remote_get('http://blocks.semplicelabs.com/index.php?action=get_block&block_id=' . $this->block_id);

			// get body
			$get_remote_block = json_decode($get_remote_block['body'], true);

			// get content
			$get_remote_block = json_decode($get_remote_block['content'], true);

			if(is_array($get_remote_block)) {
				// get remote response body
				$block['rom'] = $get_remote_block['rom'];
				$block['html'] = $get_remote_block['html'];
			} else {
				$block['rom'] = 'noconnection';
			}
			
		} else {

			// get block from db
			$block = $this->db->get_row( "SELECT rom, html FROM $this->table_name WHERE id = $this->block_id", ARRAY_A );

		}

		if($this->block_type !== 'dynamic') {
			// change ids to new id in html
			$block['html'] = str_replace($this->block_content_ids[0], $this->block_content_ids[1], $block['html']);
		}		

		// send json string
		echo json_encode($block);
		
	}

	function remove_block() {

		// delete block from db
		$this->db->delete($this->table_name, array('id' => $this->block_id));

	}

	
	function custom_fontset() {
		if($this->edit_mode === 'custom-fontset') {
			
			// include webfonts
			include('webfonts.php');
			
			// if fontset is default, look if there is a default in the theme options
			if($this->fontset_id === 'default') {
				if(get_field('custom_fontset', 'options')) {
					$fontset_object = get_field('custom_fontset', 'options');
				} else {
					$fontset_object = false;
				}
			} else {
				// get fontset object
				$fontset_object = get_post($this->fontset_id);
			}
			
			// call webfonts
			echo webfonts($fontset_object, true);
		}
	}

	function load_template() {

		// is edit mode load template?
		if($this->edit_mode === 'load-template') {
			
			if($this->template_type !== 'object') {
			
				// include the template file
				include('templates/custom/' . $this->template_id . '/template.php');
				
			} else {
			
				// object
				$template = array();
				
				// output content
				remove_filter('the_content', 'wpautop');

				// get content			
				$template_content = get_post_meta( $this->template_id, 'semplice_ce_content', true );

				// prevent embed codes from getting executed
				$template_content = str_replace('[embed]', '[unex_embed]', $template_content);

				// apply the ce shortcodes whitelist
				$template_content = apply_filters('ce_shortcodes', $template_content, $this->template_id);
				
				// applay the_content filter
				$template_content = apply_filters('the_content', $template_content);

				// get rom		
				$template_rom = get_post_meta( $this->template_id, 'semplice_ce_rom', true );
				
				// get branding	
				$template_branding = get_post_meta( $this->template_id, 'semplice_ce_branding', true );
				
				// get modules
				$template_modules = get_post_meta( $this->template_id, 'semplice_ce_modules', true );
				
				$template['html']		= $template_content;
				$template['rom']		= $template_rom;
				$template['branding']	= $template_branding;
				$template['modules']	= $template_modules;
				
				echo json_encode($template);
				
				// reset postdata
				wp_reset_postdata();
			}
			
		}
		
	}
	
	// set custom module id
	function custom_module_id($id, $values) {
		echo '<input type="hidden" class="' . $values['cm_class'] . '" value="' . $id . '" name="custom_module">';
	}
	
	// custom modules
	function load_module($content, $values, $content_type) {

		// output
		$e = '';

		// define standard modules
		$standard_modules = array(
			'content-p' 				=> 'paragraph',
			'column-content-p' 			=> 'paragraph',
			'content-img' 				=> 'image',
			'column-content-img' 		=> 'image',
			'content-gallery' 			=> 'gallery',
			'column-content-gallery' 	=> 'gallery',
			'content-video' 			=> 'video',
			'column-content-video'		=> 'video',
			'content-audio' 			=> 'audio',
			'column-content-audio' 		=> 'audio',
			'content-oembed' 			=> 'oembed',
			'column-content-oembed' 	=> 'oembed',
			'content-spacer'			=> 'spacer',
			'column-content-spacer'		=> 'spacer',
			'content-thumbnails' 		=> 'portfolio-grid',
			'column-content-thumbnails' => 'portfolio-grid',
			'multi-column'				=> 'multi-column',
			'add-column'				=> 'multi-column'
		);

		// get module
		if($content_type !== 'custom-module') {
			foreach($standard_modules as $module_type => $module) {
				if($module_type === $content_type) {
					
					// get module id
					$module_id = $module;
					
					// include module
					include('modules/default/' . $module_id . '/module.php');
				}
			}
		} else {
			// if new multi column content
			if($this->is_column_content) {
				$module_id = $this->rom['columns'][$this->column_id]['#' . $this->id]['custom_module'];
			// if edit in multi column
			} elseif($values['in_column']) {
				$module_id = $values['module_id'];
			// non multi column
			} else {
				$module_id = $this->rom['custom_module'];
			}
			
			if(file_exists(get_template_directory() . '/content-editor/modules/custom/' . $module_id . '/module.php')) {
				// include module
				include('modules/custom/' . $module_id . '/module.php');
			} else {
				// module not found
				echo 'ModuleNotFound';
			}
			
		}
		
		// output module generated content
		return $e;
	}
	
	function edit_head($values) {
		
		// single edit class and dynamic block
		$single_edit_class = '';

		// is new or edit		
		if($this->edit_mode === 'new' || $this->edit_mode === 'single-edit' || $values['in_column']) {
			if($this->edit_mode === 'single-edit') {
				$single_edit_class = "single-edit-cc";
			}
			echo '<div id="' . $values['id'] . '" class="' . $values['content_type'] . ' ' . $single_edit_class . '" data-sort="1">';
		}

		if(!$values['in_column']) {
			echo '
				<div class="container edit-content fadein">';
				// sticky atts
				if($values['content_type'] === 'multi-column') {
					echo '
						<div class="sticky-mc-atts">
							<ul>
								<li><a class="save-mc" data-content-id="' . $this->id . '" data-content-type="' . $this->content_type . '">Save</a></li>
								<li><a class="add-column add-column-sticky" data-content-id="' . $this->id . '">Add New Column</a></li>
							</ul>
						</div>
					';
				}
			echo '
					<div class="row">
						<div class="span12">
							<div class="atts-holder">
			';
		} else {
			echo '
				<div class="edit-content fadein column-content in-edit-mode" data-content-id="' . $values['id'] . '" data-content-type="' . $values['content_type'] . '" data-in-column="' . str_replace('#', '', $values['column_id']) . '">
					<div class="atts-holder">
			';
		}
		
		$this->styles($values);
		
		if(!$values['in_column']) {
			echo '
							</div>
						</div>
					</div>
			';
		} else {
			echo '
					</div>
			';

		}
	}

	function edit_foot($values) {
		// is new or edit
		if($this->edit_mode !== 'edit' || $values['in_column']) {
			echo '</div>';
		}
		echo '</div>';
	}
	
	function view_head($values) {
		
		// single edit popup
		$single_edit_popup = '';
		
		if($values['in_column']) {
			$column_pre = 'column-';
		}
		
		if(isset($values['single_edit_content_id'])) {
			$single_edit = 'data-single-edit-content-id="' . str_replace('#', '', $values['single_edit_content_id']) . '" data-single-edit-column-id="' . $values['single_edit_column_id'] . '" data-single-edit-content-type="' . $values['single_edit_content_type'] . '"';
			$single_edit_popup = '
				<div class="single-edit">
					<ul>
						<li><a class="edit-single" ' . $single_edit . '>Single Edit</a></li>
						<li><a class="edit-column">Column Edit</a></li>
					</ul>
				</div>
			';
		}
		
		// content container class
		if($this->content_type === 'multi-column') {
			$cc_class = 'mc-sub-content-container';
		} else {
			$cc_class = 'content-container';
		}

		// is custom module?
		if($values['module_id']) {
			$custom_module = 'data-modules-array="' . $values['module_id'] . '"';
		} else {
			$custom_module = '';
		}

		// is dynamic block?
		if(isset($values['dynamic_block']) && !empty($values['dynamic_block'])) {
			$dynamic_block = 'data-dynamic-block="' . $values['dynamic_block'] . '" ';
		} else {
			$dynamic_block = '';
		}
		
		// get css output
		$e = '<div class="' . $cc_class . '" style="' . container_styles($values['styles']) . '" data-content-id="' . $this->id . '" data-content-type="' . $this->content_type . '" ' . $custom_module . ' ' . $dynamic_block . '>';
		$e .= $single_edit_popup;
		
		// has container?
		if($values['has_container']) {
			$e .= '<div class="container">';
			$e .= '<div class="row">';
		}
		
		// output
		return $e;
	}
	
	function view_foot($values) {
		$e = '</div>';
		// has container?
		if($values['has_container']) {
			$e .= '</div>';
			$e .= '</div>';
		}

		//output
		return $e;
	}
	
	// row header
	function row_header($styles, $options, $remove_gutter, $is_fluid, $values) {

		// output
		$e = '';
	
		// inner background
		$inner_background = '';
	
		// is dynamic block?
		if($values['dynamic_block']) {
			$dynamic_block = 'data-dynamic-block="' . $values['dynamic_block'] . '" ';
		} else {
			$dynamic_block = '';
		}

		// get css output
		$e .= '<div class="mc-content-container" style="' . container_styles($styles) . '" data-content-id="' . $this->id . '" data-content-type="' . $this->content_type . '" ' . $dynamic_block . '>';
		
		// has inner background?
		if($options['row-inner-background']) {
			$inner_background = 'style="background-color: ' . $options['row-inner-background'] . ';"';
		}

		// check if layout is fluid or non-fluid
		if($is_fluid) {
			$container_class = '';
			// if gutter, center masonry
			if(!$remove_gutter) {
				$fit_width = 'isFitWidth: true';
				$masonry = '.masonry-full-inner';
				$container_class = 'class="masonry-full"';
			}
		} else {
			$container_class = 'class="container"';
		}

		$e .= '<div id="masonry-' . $this->id . '" ' . $container_class . ' ' . $inner_background . '>';
		
		// open masonry inner
		if($is_fluid && !$remove_gutter) {
			// masonry inner
			$e .= '<div class="masonry-full-inner">';
		}
		
		if($remove_gutter) {
			$e .= '<div class="no-gutter-grid-sizer"></div>';
			$e .= '<div class="no-gutter-gutter-sizer"></div>';
		} else {
			$e .= '<div class="row"><div class="grid-sizer"></div>';
			$e .= '<div class="gutter-sizer"></div>';
		}
		
		// output
		return $e;
	}
	
	// row footer
	function row_footer($remove_gutter, $is_fluid) {
		
		// masonry container
		$masonry = '';
		
		// masonry prefix
		$pre = '';
		
		// fit width
		$fit_width = '';

		// percent position
		$percent_position = '';

		// outpout
		$e = '';
		
		// check if layout is fluid or non-fluid
		if($is_fluid && !$remove_gutter) {
			$fit_width = 'isFitWidth: true';
			$masonry = ' .masonry-full-inner';
		}

		// is masrony layout mode?
		if($remove_gutter) {
			$pre = 'no-gutter-';
			$e .= '</div>';
			$percent_position = 'percentPosition: true,';
		} else {
			$e .= '</div></div>';
		}
		
		// close masonry inner
		if($is_fluid && !$remove_gutter) {
			$e .= '</div>';	
		}
		
		// javascript
		$e .= '
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					/* init masonry */
					var $grid = $("#masonry-' . $this->id . $masonry . '");

					$grid.masonry({
						itemSelector: ".masonry-item",
						columnWidth: ".' . $pre . 'grid-sizer",
						gutter: ".' . $pre . 'gutter-sizer",
						transitionDuration: 0,
						isResizable: true,
						' . $percent_position . '
						' . $fit_width . '
					});

                	/* layout Masonry after each image loads */
                	$grid.imagesLoaded().progress(function() {
	                  	$grid.masonry("layout");
                	});

				});
			})(jQuery);
		</script>
		';
		
		$e .= '</div>';
		
		// output
		return $e;
	}
	
	// paragraph edit
	function mc_edit($values) {

		// edit head
		$this->edit_head($values);

		// remove Gutter
		$remove_gutter = array('no' => 'No', 'yes' => 'Yes');
		
		// show fullscreen
		$show_fullscreen = array('no' => 'No', 'yes' => 'Yes');
		
		// sticky atts
		echo '<div class="sticky-atts-beginn"></div>';

		// open multi column options
		echo '<div class="multi-column-options">';
		
		// options
		$this->get_option('select', 'Remove Gutter', 'remove-gutter', 'no', $remove_gutter, $values);
		
		// options
		$this->get_option('select', 'Fluid Layout', 'show-fullscreen', 'no', $show_fullscreen, $values);
		
		// row inner background
		$this->get_option('color', 'Row Inner Background', 'row-inner-background', 'transparent', false, $values);
		
		// close multi column options
		echo '</div>';

		// content area
		echo '
			<div class="row">
				<div class="span12">
					<div class="edit-elements">
						<div class="add-column-box">
							<a class="add-column" data-content-id="' . $this->id . '"></a>
						</div>
					</div>
				</div>
			</div>
			<div class="row"><div class="span12"><div class="hr"></div></div></div>
			<div class="row">
				<div class="span12">
					<div class="columns" data-sortable-id="' . $this->id . '">';
						
						if($this->edit_mode === 'edit') {
							
							// column count
							$column_count = 1;
							
							foreach($this->rom['columns'] as $mc_column_id => $mc_columns) {								

								// column values
								$column_values = array(
									'column_id'			=> str_replace('#', '', $mc_column_id),
									'parent_id'			=> str_replace('#', '', $this->id),
									'column_styles'		=> $mc_columns['styles'],
									'column_width'		=> $mc_columns['options']['column-width'],
									'column_offset'		=> $mc_columns['options']['column-offset'],
									'column_count'		=> $column_count,
									'column_name'		=> $mc_columns['options']['column-name'],
									'is_new'			=> false
								);

								// add column
								$this->add_column($column_values);
								
								// column inner start
								echo '<div class="column-inner">';

								foreach($mc_columns as $mc_content_id => $mc_content) {

									// content type index
									$mc_content['content_type'] = isset($mc_content['content_type']) ? $mc_content['content_type'] : '';
									
									// content index
									$mc_content['content'] = isset($mc_content['content']) ? $mc_content['content'] : '';
									
									// custom module
									$mc_content['custom_module'] = isset($mc_content['custom_module']) ? $mc_content['custom_module'] : '';
									
									// values
									$values = array(
										'styles'		=> isset($mc_content['styles']) ? $mc_content['styles'] : '', 
										'options'		=> isset($mc_content['options']) ? $mc_content['options'] : '',
										'style_class'	=> 'is-cc-style', 
										'in_column'		=> true, 
										'id'			=> str_replace('#', '', $mc_content_id),
										'column_id'		=> $mc_column_id,
										'content_type'	=> $mc_content['content_type'],
										'options_class' => 'is-cc-option',
										'cm_class'		=> 'is-cc-custom-module',
										'module_id'		=> $mc_content['custom_module']
									);
									
									// edit module
									if($mc_content['content_type']) {
										$this->load_module(stripslashes($mc_content['content']), $values, $mc_content['content_type']);
									}
									
								}
								
								// column inner stop
								echo '</div>';

								// collapse button
								echo '<div class="collapse-button">';
								echo '<a class="column-collapse-hide-only" data-column-id="' . str_replace('#', '', $mc_column_id) . '">' . set_ce_icon('collapse_up') . '</a>';
								echo '</div>';

								// show add column footer
								echo $this->add_column_foot;
								
								// increase column count
								$column_count++;
							}
						}
					echo '
					</div>
					<script type="text/javascript">
						(function ($) { 
							$(document).ready(function () { 
								$("[data-sortable-id=' . $this->id . ']").sortable({ axis: "y", cancel: ".column-body, .column-input, .set-col-width, .column-collapse, .background, .background-sub, .remove-column" });
							});
						})(jQuery);
					</script>
				</div>
			</div>
		';
		
		// edit foot
		$this->edit_foot($values);
	}
	
	// add column
	function add_column($values) {

		// col width
		$col_width = array();
		$col_offset = array();

		for($i=1; $i<=12; $i++) {
			$col_width['span' . $i] = $i . ' Col';
		}
		
		for($i=0; $i<=12; $i++) {
			if($i < 1) {
				$col_offset['no-offset'] = 'None';
			} else {
				$col_offset['span' . $i] = $i . ' Col';
			}
		}

		$modules = new modules();

		// display column name if available
		if(!isset($values['column_name']) || empty($values['column_name'])) {
			$values['column_name'] = 'Column Name';
		}
		
		// toggle status
		if($values['is_new']) {
			$toggle_status = 'open';
			$toggle_text = 'Collapse';
		} else {
			$toggle_status = 'closed';
			$toggle_text = 'Expand';
		}

		// adder start
		echo '
			<div id="' . $values['column_id'] . '" class="column" data-order="' . $values['column_count'] . '">
				<div class="container nbp fadein ntp">
					<div class="row">
						<div class="span10 offset1 column-head">
							<ul class="column-meta">
								<li><a class="remove-column" data-content-id="' . $values['parent_id'] . '" data-column-id="' . $values['column_id'] . '" data-parent-id="' . $values['parent_id'] . '">' . set_ce_icon('remove') . '</a></li>
								<li class="drag">' . set_ce_icon('drag_icon_mc') . '</li>
								<!-- <li><div class="column-count">' . $values['column_count'] . '</div></li> -->
								<li><input class="column-input is-option" name="column-name" type="text" value="' . $values['column_name'] . '"></li>
								<li>
									<div class="set-col-width">
										<span class="label">Width:</span>';
										if(!isset($values['column_width'])) {
											$values['column_width'] = 'span6';
										}
										echo '<div class="ce-select-box col-width-box"><select name="column-width" class="is-option select-box">';
										$this->select($col_width, $values['column_width']);
										echo '</select></div>';
									echo '
									</div>
								</li>
								<li>
									<div class="set-col-width">
										<span class="label">Offset:</span>';
										if(!isset($values['column_offset'])) {
											$values['column_offset'] = 'no-offset';
										}
										echo '<div class="ce-select-box col-width-box"><select name="column-offset" class="is-option select-box">';
										$this->select($col_offset, $values['column_offset']);
										echo '</select></div>';
									echo '
									</div>
								</li>';
								// column background
								?>
								<li>
									<a class="background get-id">Background</a>
									<ul class="background-sub">
										<div class="semplice-arrow">
											<?php echo set_ce_icon('arrow'); ?>
										</div>
										<li>
											<div class="ce-label">Background Color</div>
											<?php
											
												// has color?
												$bg_color = isset($values['column_styles']['background-color']) ? $values['column_styles']['background-color'] : '';
												$has_color = false;

												if(preg_match('/^#[a-f0-9]{6}$/i', $bg_color)) {
													  $has_color = true;
												} 
											
											?>
											<div class="wp-color"><input type="text" value="<?php if($has_color === true) : echo $values['column_styles']['background-color']; else : echo 'transparent'; endif; ?>" class="color-picker is-column-style" data-default-color="transparent" name="background-color" /></div>
										</li>
										<li>
											<div class="background-upload-box">
												<div class="ce-label">Bg Image</div>
												<a class="remove-media remove-bg" data-content-id="<?php echo $values['column_id']; ?>" data-media="column-bg-image"></a>
												<img src="<?php if($values['column_styles']['background-image']) : echo $values['column_styles']['background-image']; endif; ?>" class="column-bg-image-preview">
												<a class="media-upload semplice-button bg-image-upload" data-column-id="<?php echo $values['column_id']; ?>" data-column-bg="columnbg" data-upload-type="background" data-content-id="<?php echo $values['id']; ?>">Upload image</a>
												<input type="hidden" name="background-image" class="is-column-bg-image is-column-style" value="<?php if($values['column_styles']['background-image']) : echo $values['column_styles']['background-image']; endif; ?>">
											</div>
										</li>
										<li>
											<div class="ce-label">Background Scale</div>
											<?php	
												$bg_scale = array(
													'auto' 	=> 'No Scale',
												    'cover' => 'Cover (full-width)'
												);
											?>
											<div class="ce-select-box">
												<select name="background-size" class="is-column-style select-box">
													<?php $this->select($bg_scale, $values['column_styles']['background-size']); ?>
												</select>
											</div>
										</li>
										<li>
											<div class="ce-label">Background Position</div>
											<?php
												$bg_pos = array(
													'0% 0%' 	=> 'Top Left',
												    '50% 0%' 	=> 'Top Center',
												    '100% 0%' 	=> 'Top Right',
												    '0% 50%' 	=> 'Middle Left',
												    '50% 50%' 	=> 'Middle Center',
												    '100% 50%' 	=> 'Middle Right',
												    '0% 100%' 	=> 'Bottom Left',
												    '50% 100%' 	=> 'Bottom Center',
												    '100% 100%' => 'Bottom Right'
												); 
											?>
											<div class="ce-select-box">
												<select name="background-position" class="is-column-style select-box">
													<?php $this->select($bg_pos, $values['column_styles']['background-position']); ?>
												</select>
											</div>
										</li>
										<li>
											<div class="ce-label">Background Repeat</div>
											<?php
												$bg_repeat = array(
													'no-repeat' => 'No Repeat',
												    'repeat-x' 	=> 'Repeat horizontal',
												    'repeat-y' 	=> 'Repeat vertical',
												    'repeat' 	=> 'Repeat both'
												);
											?>
											<div class="ce-select-box">
												<select name="background-repeat" class="is-column-style select-box">
													<?php $this->select($bg_repeat, $values['column_styles']['background-repeat']); ?>
												</select>
											</div>
										</li>
									</ul>
								</li>
								<?php
								// adder continue
								echo '
							</ul>
							<div class="column-meta-right">
								<a class="column-collapse ' . $toggle_status . '" data-column-id="' . $values['column_id'] . '" data-status="' . $toggle_status . '">' . $toggle_text . '</a>
							</div>
						</div>
					</div>
				</div>
				<div class="container column-body">
					<div class="row">
						<div class="span10 offset1">
							<div class="column-content-adder adder">
								<ul class="types">
									<li>
										<a class="add-column-content p" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-p" data-column-id="' . $values['column_id'] . '">
											' . set_ce_icon('paragraph') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add Paragraph</div>
										</div>
									</li>
									<li>
										<a class="add-column-content img" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-img" data-column-id="' . $values['column_id'] . '">
										' . set_ce_icon('image') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add Image</div>
										</div>
									</li>
									<li>
										<a class="add-column-content gallery" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-gallery" data-column-id="' . $values['column_id'] . '">
											' . set_ce_icon('gallery') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add Gallery</div>
										</div>
									</li>
									<li>
										<a class="add-column-content video" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-video" data-column-id="' . $values['column_id'] . '">
										' . set_ce_icon('video') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add Video</div>
										</div>
									</li>
									<li>
										<a class="add-column-content audio" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-audio" data-column-id="' . $values['column_id'] . '">
											' . set_ce_icon('audio') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add Audio</div>
										</div>
									</li>
									<li>
										<a class="add-column-content oembed" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-oembed" data-column-id="' . $values['column_id'] . '">
											' . set_ce_icon('oembed') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add oEmbed</div>
										</div>
									</li>
									<li>
										<a class="add-column-content spacer" data-content-id="' . $values['parent_id'] . '" data-content-type="column-content-spacer" data-column-id="' . $values['column_id'] . '">
											' . set_ce_icon('spacer') . '
										</a>
										<div class="tooltip">
											<div class="tt-arrow">' . set_ce_icon('tt-arrow') . '</div>
											<div class="tt-text">Add Spacer</div>
										</div>
									</li>
									<li>
										<a class="show-modules" data-in-column="true" data-column-id="' . $values['column_id'] . '">Modules</a>
										<ul class="modules-sub modules-sub-' . $values['column_id'] . '">
											<div class="semplice-arrow">
												' . set_ce_icon('arrow') , '
											</div>
											' . $modules->list_modules(true, $values['parent_id'], $values['column_id']) . '
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="span10 offset1">
		';
		
		// is new or edit
		if($this->edit_mode !== 'edit') {
			// show column foot and column inner on new content
			echo '
				<div class="column-inner"></div>
				<div class="collapse-button">
					<a class="column-collapse-hide-only" data-column-id="' . $values['column_id'] . '">' . set_ce_icon('collapse_up') . '</a>
				</div>
			';
			echo $this->add_column_foot;
		}
	}
}
?>