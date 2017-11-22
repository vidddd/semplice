<?php

#---------------------------------------------------------------------------#
# Content Editor default color palette										#
#---------------------------------------------------------------------------# 

function editor_color_palette($mode) {
	if(get_field('ce_defaults_colors_select', 'options') === 'enabled') {

		// colors array
		$colors = array();

		if(have_rows('ce_defaults_colors', 'options')) {
		
			while (have_rows('ce_defaults_colors', 'options')) {
			
				the_row();

				// add colors to the array
				if($mode === 'php') {
					$colors[] = str_replace('#', '', get_sub_field('color', 'options'));
				} else {
					$colors[] = get_sub_field('color', 'options');
				}
				
			}
		}
		
		// explode array comma seperated
		if($mode === 'php') {
			if(!empty($colors)) {
				return $default_colors = ',{ colorButton_colors: "' . implode(',', $colors) . '" }';	
			} else {
				return false;
			}
			
		} else {
			return $default_colors = implode(',', $colors);
		}

	} else {
		return false;
	}
}

#---------------------------------------------------------------------------#
# Enqueue Admin Scripts and Styles											#
#---------------------------------------------------------------------------# 

function enqueue_semplice_scripts() {

	// get screen
	$screen = get_current_screen();

	// google webfont
	wp_register_style('google_webfonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,400italic,600,600italic,700,700italic');
	wp_enqueue_style('google_webfonts');
	
	// scripts for the content editor
	if($screen->id === 'work' || $screen->id === 'page' || $screen->id === 'footer') {
	
		// masonry
		wp_register_script('masonry-custom', get_template_directory_uri() . '/js/masonry.js', false, '1.0.0');
		wp_enqueue_script('masonry-custom');
		
		// jquery transit
		wp_register_script('jquery-transit', get_template_directory_uri() . '/js/jquery.transit.js', false, '1.0.0');
		wp_enqueue_script('jquery-transit');
		
		// media upload
		wp_enqueue_media();
		wp_register_script('semplice-media-upload', get_template_directory_uri() . '/content-editor/js/media.upload.js', false, '1.0.0');
		wp_enqueue_script('semplice-media-upload');

		// codemirror JS
		wp_register_script('code-mirror', get_template_directory_uri() . '/content-editor/js/codemirror.js', false, '1.0.0');
		wp_enqueue_script('code-mirror');

		// wordpress color picker
		wp_enqueue_style('wp-color-picker');
		// ckeditor
		wp_register_script('ckeditor', get_template_directory_uri() . '/content-editor/ckeditor/ckeditor.js', false, '1.0.0');
		wp_enqueue_script('ckeditor');

		// ckeditor jquery adapter
		wp_register_script('ckeditor-jquery-adapter', get_template_directory_uri() . '/content-editor/ckeditor/adapters/jquery.js', false, '1.0.0');
		wp_enqueue_script('ckeditor-jquery-adapter');
	
		// imagesLoaded
		wp_register_script('jquery-images-loaded', get_template_directory_uri() . '/js/imagesloaded.js', '', '', true);
		wp_enqueue_script('jquery-images-loaded'); 
				
		// sweetAlert
		wp_register_script('sweet-alert', get_template_directory_uri() . '/content-editor/js/sweetalert.min.js', false, '1.0.0');
		wp_enqueue_script('sweet-alert'); 
				
		// semplice-content-editor
		wp_register_script('semplice-content-editor', get_template_directory_uri() . '/content-editor/js/editor.js', false, '1.0.0');		
		wp_enqueue_script('semplice-content-editor');
		
		global $post;
		
		// vars for the editor
		$wordpress_vars = array(
			'template_url' 	=> get_template_directory_uri(),
			'post_id' 		=> $post->ID,
			'color_palette'	=> editor_color_palette('js')
		);
		
		wp_localize_script('semplice-content-editor', 'wordpress', $wordpress_vars );
	
		// content editor css
		wp_register_style('content-editor', get_template_directory_uri() . '/content-editor/css/styles.min.css', false, '1.0.0');

		// enqueue editor
		wp_enqueue_style('content-editor');
	}

	// admin css
	wp_register_style('semplice-admin-css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0');
	wp_enqueue_style('semplice-admin-css');

	// admin javascript
	wp_register_script('semplice-admin-js', get_template_directory_uri() . '/js/admin.js', false, '1.0.0');
	wp_enqueue_script('semplice-admin-js');
}

add_action('admin_enqueue_scripts', 'enqueue_semplice_scripts');

#---------------------------------------------------------------------------#
# Source Code Sans Pro														#
#---------------------------------------------------------------------------# 

function source_code_pro() {

	$fonts_url = '';

	// font family array
	$font_families[] = 'Source Code Pro:400';

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

function source_code_pro_scripts_styles() {
	wp_enqueue_style( 'source-code-pro-font', source_code_pro(), array(), null );
}

add_action( 'admin_enqueue_scripts', 'source_code_pro_scripts_styles' );

#---------------------------------------------------------------------------#
# Meta Box																	#
#---------------------------------------------------------------------------# 

// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/includes/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/includes/meta-box' ) );

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

// Include content editor meta boxes
require get_template_directory() . '/content-editor/meta_boxes.php';

// content editor ajax
if(is_admin()) {
	function semplice_ce_ajax() {
		if (isset($_REQUEST)) {
			// include content editor
			require get_template_directory() . '/content-editor/editor.php';
		}
		// stop script here after ajax request
		die();
	}
}

add_action( 'wp_ajax_semplice_ce_ajax', 'semplice_ce_ajax' );

#---------------------------------------------------------------------------#
# Content Editor Quickstart													#
#---------------------------------------------------------------------------# 

// add the content editor to row actions
function ce_link_pages($actions, $page) {

	global $post;
	if(get_post_type($post->ID) === 'page') {
		$actions['ce_link'] = "<a class='smp_ce_link' href='" . admin_url( "post.php?post=$post->ID&action=edit&smp_ce=true") . "'>" . __( 'Content Editor', 'semplice' ) . "</a>";
	}
 
   return $actions;
}

function ce_link_portfolio($actions, $project) {

	global $post;
	if(get_post_type($post->ID) === 'work' || get_post_type($post->ID) === 'footer') {
		 $actions['ce_link'] = "<a class='smp_ce_link' href='" . admin_url( "post.php?post=$post->ID&action=edit&smp_ce=true") . "'>" . __( 'Content Editor', 'semplice' ) . "</a>";
	}
 
   return $actions;
}

add_filter('page_row_actions', 'ce_link_pages', 10, 2);
add_filter('post_row_actions', 'ce_link_portfolio', 10, 2);

// add content editor button to the admin toolbar, but only on the frontend
function semplice_editor_button($wp_admin_bar) {

	// post & screen
	global $post;

	if(isset($post) && !is_admin()) {
		if(get_post_type($post->ID) === 'page' && get_field('use_semplice') === 'active' || get_post_type($post->ID) === 'work') {
			$args = array(
				'id'    => 'semplice-editor',
				'title' => 'Content Editor',
				'href'  => get_edit_post_link($post->id) . '&smp_ce=true',
				'meta'  => array( 'class' => 'semplice-editor-button' )
			);
			$wp_admin_bar->add_node($args);
		}
	}
}

add_action('admin_bar_menu', 'semplice_editor_button', 999);

#---------------------------------------------------------------------------#
# Container Styles															#
#---------------------------------------------------------------------------# 

// container styles
function container_styles($styles) {

	$css = '';

	if(!empty($styles['padding-top']) && $styles['padding-top'] !== '0px') {
		$css .= 'padding-top: ' . $styles['padding-top'] . ';';
	}
	if(!empty($styles['padding-bottom']) && $styles['padding-bottom'] !== '0px') {
		$css .= 'padding-bottom: ' . $styles['padding-bottom'] . ';';
	}
	if(!empty($styles['padding-right']) && $styles['padding-right'] !== '0px') {
		$css .= 'padding-right: ' . $styles['padding-right'] . ';';
	}
	if(!empty($styles['padding-left']) && $styles['padding-left'] !== '0px') {
		$css .= 'padding-left: ' . $styles['padding-left'] . ';';
	}
	if(!empty($styles['background-image'])) {			
		$css .= 'background-image: url(' . $styles['background-image'] . ');';
		$css .= 'background-repeat: ' . $styles['background-repeat'] . ';';
		if(!empty($styles['background-size']) && $styles['background-size'] === 'cover') {
			$css .= 'background-size: cover;';	
		} else if(!empty($styles['background-repeat']) && $styles['background-repeat'] !== 'no-repeat') {
			$css .= 'background-size: auto !important;';
		}
		if(!empty($styles['background-position'])) {
			$css .= 'background-position: ' . $styles['background-position'] . ';';
		} else {
			$css .= 'background-position: top center;';
		}
	}
	if(preg_match('/^#[a-f0-9]{6}$/i', $styles['background-color'])) {
		$has_color = true;
	} 
	if(!empty($has_color) && $has_color === true) {
		$css .= 'background-color: ' . $styles['background-color'] . ';';
	} else {
		$css .= 'background-color: transparent;';
	}
	
	// fwt border bottom
	if(!empty($styles['border-bottom'])) {
		$css .= 'border-color: ' . $styles['border-bottom'] . ' !important;';
	} 

	return $css;
}

#---------------------------------------------------------------------------#
# Modules																	#
#---------------------------------------------------------------------------# 

// include modules class
require get_template_directory() . '/content-editor/modules.php';

// ce shortcode whitelist
if(is_admin()) {	

	add_filter('ce_shortcodes', 'ce_shortcode_whitelist', 0, 2);

	function ce_shortcode_whitelist($content, $post_id) {
		
		// modules array
		$modules_array = json_decode(get_post_meta( $post_id, 'semplice_ce_modules', true));
	
		// whitelist
		$ce_shortcode_whitelist = array();

		if(isset($modules_array)) {
			foreach($modules_array as $module) {
				$ce_shortcode_whitelist[] = 'ce_' . $module;
			}
		}

		// add dynamic blocks
		$ce_shortcode_whitelist[] = 'ce_dynamic_block';

		global $shortcode_tags;

		foreach($shortcode_tags as $tag => $func) {
			if(!in_array($tag, $ce_shortcode_whitelist)) {
				remove_shortcode($tag);
			}
		}

		// manually remove some shortcodes from the whitelist
		remove_shortcode('ce_code');

		// Return the post content
		return $content;
	}
}

#---------------------------------------------------------------------------#
# blocks 																	ä
#---------------------------------------------------------------------------#

class blocks {

	public $db;
	public $table_name;
	public $db_version;

	function __construct() {

		// database
		global $wpdb;
        $this->db = $wpdb;
		$this->table_name = $wpdb->prefix . 'semplice_blocks';

		// db version
		$this->db_version = get_option("semplice_blocks_db_version");

		// add action
		add_action('after_switch_theme', array(&$this, 'setup_blocks'));

		// check status
		$this->status();

	}

	function status() {

		// atts
		$atts = array(
			'db_version' => '1.0',
			'is_update'  => false
		);

		// check if table is already created
		if($this->db->get_var("SHOW TABLES LIKE '$this->table_name'") !== $this->table_name || $this->db_version !== $atts['db_version']) {
			
			// setup blocks (install or update)
			$this->setup_blocks($atts);
		}

	}

	function setup_blocks($atts) {

		// charset
		$charset_collate = $this->db->get_charset_collate();

		// database tables
		$atts['sql'] = "CREATE TABLE $this->table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				name tinytext NOT NULL,
				block_id varchar(20) NOT NULL,
				block_type tinytext NOT NULL,
				content_type tinytext NOT NULL,
				module_id tinytext NOT NULL,
				rom longtext NOT NULL,
				html longtext NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";

		// install or update table
		if (!function_exists('blocks_db_install')) {
			function blocks_db_install($atts) {
		
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				
				dbDelta($atts['sql']);

				if($atts['is_update'] !== true) {
					// add db version to wp_options
					add_option('semplice_blocks_db_version', $atts['db_version']);
				} else {
					// update db version in wp_optionss
					update_option('semplice_blocks_db_version', $atts['db_version']);
					echo "ist ein update!!";
				}
			}
		}
		
		// check if table exists, if not install table
		if($this->db->get_var("SHOW TABLES LIKE '$this->table_name'") !== $this->table_name) {

			blocks_db_install($atts);
			
		}

		if ($this->db_version !== $atts['db_version']) {

			// is update
			$atts['is_update'] = true;
			
			// update db
			blocks_db_install($atts);
			
		}
	}

	function generate_blocklist() {

		// output
		$e = '';

		// error message
		$remote_error_message = '';

		// remote blocks
		$get_remote_blocklist = wp_remote_get('http://blocks.semplicelabs.com/index.php?action=list_blocks');

		if(is_wp_error($get_remote_blocklist) && !empty($get_remote_blocklist->errors)) {

			$remote_error_message = '<p>Error Message: <br />' . $get_remote_blocklist->get_error_message() . '</p>';

			// wp_remote_get - failure
			$remote_blocklist = '
				<div class="no-connection">
					<h4>Not connected!</h4>
					<p>Either you or we are offline!<br />Please try again later.</p>
					' . $remote_error_message . '
				</div>
			';

		} else {

			// get array
			$remote_blocklist = json_decode($get_remote_blocklist['body'], true);

			// wp_remote_get - success
			$remote_blocklist = $remote_blocklist['content'];
		}

		$e .= '
		<ul class="blocks-sub">
			<div id="block-tabs">
				<ul>
					<li><a href="#made-by-semplice">By Semplice</a></li>
					<li><a href="#user-defined">My Blocks</a></li>
				</ul>
				<div id="made-by-semplice" class="block-tab">
					' . $remote_blocklist . '
				</div>
				<div id="user-defined" class="block-tab">
				';					
					// table name
					$this->table_name = $this->db->prefix . 'semplice_blocks';
					
					// get row
					$blocks = $this->db->get_results( 
						"
						SELECT * 
						FROM $this->table_name
						"
					);

					if(!empty($blocks)) {
						$e .= '<h4>Add & Customize your<br />personal blocks.</h4>';
						$e .= '<ul class="user-defined">';
						foreach($blocks as $block) {
							
							if($block->block_type === 'dynamic') {
								$block_type = 'dynamic';
							} else {
								$block_type = 'static';
							}
							
							$e .= '
								<li data-block-id="' . $block->id . '">
									<div class="pre ' . $block->content_type . ' ' . $block->module_id . '"></div>
									<a class="add-block" data-block-id="' . $block->id . '" data-content-id="' . str_replace('#', '', $block->block_id) . '" data-block-type="' . $block_type . '" data-content-type="' . $block->content_type . '" data-module-id="' . $block->module_id . '">
										<h5>' . $block->name . '</h5>
									</a>
									<a class="remove-block" data-block-id="' . $block->id . '" data-content-id="' . $block->block_id . '" data-block-type="' . $block_type . '"></a>
									<div class="' . $block_type . '"></div>
								</li>
							';
							
						}
						echo '</ul>';
					} else {
						$e .= '
							<div class="no-blocks">
								<div class="inner">
									<p>Hey! You can also<br />create your own blocks.<br />See how it works.</p>
									<a class="blocks-help-video" href="https://vimeo.com/143198710" target="_blank"><img src="' . get_template_directory_uri() . '/content-editor/images/no_blocks.png"></a>
								</div>
							</div>
						';
					}
				$e .= '
				</div>
			</div>
			<script type="text/javascript">
				(function ($) {
					$(document).ready(function () {
						/* blocks tabs */
						$( "#block-tabs" ).tabs();
					});
				})(jQuery);
			</script>
		</ul>';

		//output
		return $e;
	}

} 

// blocks instance
$blocks = new blocks();

// semplice svg icons
function set_ce_icon($icon) {
	//include();
	$svg = file_get_contents(get_template_directory() . '/content-editor/images/icons/' . $icon . '.svg', true);
	
	return $svg;
}
?>