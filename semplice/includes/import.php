<?php
/*
 * semplice importer
 * semplice.theme
 */


// add ajax action 
add_action('wp_ajax_semplice_import', 'semplice_import');

function semplice_import() {
	
	// database
    global $wpdb; 

    if(!defined('WP_LOAD_IMPORTERS')) define('WP_LOAD_IMPORTERS', true);

    // load importer API
    require_once ABSPATH . 'wp-admin/includes/import.php';

    if(!class_exists('WP_Importer')) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if (file_exists($class_wp_importer )) {
            require $class_wp_importer;
        }
    }

    if(!class_exists('WP_Import')) {
        $class_wp_importer = get_template_directory() . '/includes/wp-importer/wordpress-importer.php';
        if ( file_exists( $class_wp_importer ) )
            require $class_wp_importer;
    }


    if(class_exists('WP_Import')) { 
	
		// import file
        $import_filepath = get_template_directory() .'/includes/wp-importer/demo_portfolio.xml' ; // Get the xml file from directory 

        $wp_import = new WP_Import();
        $wp_import->fetch_attachments = true;
        $wp_import->import($import_filepath);

    }
    
	die();
}
?>