<?php
/*
 * modules
 * semplice.theme
 */
 
class modules {
	
	// vars
	public $modules;
	public $modules_dir;
	
	function __construct() {
		
		// modules directory
		$this->modules_dir = get_template_directory() . '/content-editor/modules/custom';
		
		// custom modules list
		$this->modules = array(
		
			#--------------------------------------------
			# button									
			#--------------------------------------------
			
			"button" => array(
				"name"				=> "button",
				"mc_compatible"		=> true,
				"assets"			=> array('shortcode'),
			),	
		
			#--------------------------------------------
			# code									
			#--------------------------------------------
			
			"code" => array(
				"name"				=> "code",
				"mc_compatible"		=> true,
				"assets"			=> array('shortcode'),
			),

			#--------------------------------------------
			# dribbble									
			#--------------------------------------------
			
			"dribbble" => array(
				"name"				=> "dribbble",
				"mc_compatible"		=> false,
				"assets"			=> array('shortcode'),
			),

			#--------------------------------------------
			# instagram									
			#--------------------------------------------
			
			"instagram" => array(
				"name"				=> "instagram",
				"mc_compatible"		=> false,
				"assets"			=> array('shortcode'),
			),

			#--------------------------------------------
			# mailchimp								
			#--------------------------------------------
			
			"mailchimp" => array(
				"name"				=> "mailchimp",
				"mc_compatible"		=> true,
				"assets"			=> array('shortcode'),
			),

			#--------------------------------------------
			# gallery grid							
			#--------------------------------------------
			
			"gallerygrid" => array(
				"name"				=> "gallerygrid",
				"mc_compatible"		=> false,
				"assets"			=> array('shortcode'),
			),
		);
    }
	
	public function get_modules() {
		
		// require module shortcode
		$this->get_module_shortcode();
		
		// add module assets
		if(is_admin()) {
			add_action( 'admin_enqueue_scripts', array(&$this,'get_module_assets') );
		} else {
			add_action( 'wp_enqueue_scripts', array(&$this,'get_module_assets') );
		}	
		
	}
	
	public function get_module_shortcode() {
		
		// require shortcode
		foreach($this->modules as $module) {
			
			// shortcode
			if(in_array('shortcode', $module['assets'])) {
			
				// shortcode file
				$shortcode = $this->modules_dir . '/' . $module['name'] . '/' . 'shortcode.php';
				
				//include shortcode
				if(file_exists($shortcode)) {
					require $shortcode;
				}
			}
		}
	}
	
	public function get_module_assets() {

		// require assets
		foreach($this->modules as $module) {
			
			// css
			if(in_array('css', $module['assets'])) {
			
				// css file
				$css = $this->modules_dir . '/' . $module['name'] . '/' . 'module.css';

				// register css
				if(file_exists($css)) {
					wp_register_style('module-' . $module['name'], get_template_directory_uri()  . '/content-editor/modules/custom/' . $module['name'] . '/module.css');
					wp_enqueue_style('module-' . $module['name']);
				}
			}
			
			// javascript
			if(in_array('js', $module['assets'])) {
			
				// css file
				$js = $this->modules_dir . '/' . $module['name'] . '/' . 'module.css';

				// register js
				if(file_exists($js)) {
					wp_register_script('module-' . $module['name'], get_template_directory_uri()  . '/content-editor/modules/custom/' . $module['name'] . '/module.js', '', '', true);
					wp_enqueue_script('module-' . $module['name']);
				}
			}
		}
	}
	
	public function list_modules($is_column, $parent_id, $column_id) {
				
		// output
		$output = '';
		
		if(!empty($this->modules)) {
		
			foreach ($this->modules as $module) {

				// preview image
				$preview_image = get_template_directory_uri() . '/content-editor/modules/custom/' . $module['name'] . '/screenshot_ce.svg';
			
				// is column?
				if($is_column) {
					$content = 'column-content';
					$mc_ids = 'data-content-id="' . $parent_id . '" data-column-id="' . $column_id . '"';
				} else {
					$content = 'content';
					$mc_ids = '';
				}
				
				// temporary output
				$temp_output = '
					<li class="module">
						<a class="add-' . $content . '" data-module-id="' . $module['name'] . '" data-content-type="custom-module" style="background-image: url(' . $preview_image . ');" ' . $mc_ids . '></a>
					</li>
				';
				
				// is in column?
				if($is_column) {
					// is the module multi column compatible?
					if($module['mc_compatible']) {
						$output .= $temp_output;
					}
				} else {
					$output .= $temp_output;
				}
			}
		} else {
			$output = '<h5 class="no-modules">You have no modules installed or activated.<br />Please visit the theme options to activate your modules or re-install the theme.</h5>';
		}
		
		return $output;
		
	}
}

// instance of modules class
$modules = new modules();

// get all modules
$modules->get_modules();

?>