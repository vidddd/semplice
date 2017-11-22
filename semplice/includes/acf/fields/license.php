<?php

class acf_field_license extends acf_field
{
        // vars
        var $settings, // will hold info such as dir / path
            $defaults; // will hold default field options


        /*
        * __construct
        *
        * Set name / label needed for actions / filters
        *
        * @since        3.6
        * @date        23/01/13
        */

        function __construct()
		{
                // vars
                $this->name = 'license';
                $this->label = __('License');
                $this->category = __("Layout",'acf'); // Basic, Content, Choice, etc
                $this->defaults = array(
					'unit'		=>	'percent'
				);
				
                // do not delete!
			    parent::__construct();
			
			    // settings
                $this->settings = array(
                        'path' => apply_filters('acf/helpers/get_path', __FILE__),
                        'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
                        'version' => '1.0.0'
                );

        }


        /*
        * create_options()
        *
        * Create extra options for your field. This is rendered when editing a field.
        * The value of $field['name'] can be used (like bellow) to save extra data to the $field
        *
        * @type        action
        * @since        3.6
        * @date        23/01/13
        *
        * @param        $field        - an array holding all the field's data
        */

        function create_options($field)
        {
        		isset($field['value']['key']) ? $field['value']['key'] : '';

                // key is needed in the field names to correctly save the data
                $key = $field['name'];

        }


        /*
        * create_field()
        *
        * Create the HTML interface for your field
        *
        * @param        $field - an array holding all the field's data
        *
        * @type        action
        * @since        3.6
        * @date        23/01/13
        */

        function create_field( $field )
        {

                // defaults?
				if(!isset($field['value']['key'])) : $field['value']['key'] = ''; endif;
				if(!isset($field['value']['product'])) : $field['value']['product'] = ''; endif;
				if(!isset($field['value']['is_valid'])) : $field['value']['is_valid'] = ''; endif;
				if(!isset($field['value']['error'])) : $field['value']['error'] = ''; endif;
				
				// font style
				$field['choices']['product'] = array(
		            'studio' 				=> 'Studio License',
		            'single-to-studio'		=> 'Studio License (Upgrade from Single)',
		            'business'				=> 'Business License (former Agency)',
		            'single-to-business'	=> 'Business License (Upgrade from Single)',
		            'studio-to-business'	=> 'Business License (Upgrade from Studio)'
		        );
				
				$valid_class = '';
				$registered_to = '';
				
				$key_value = '';

				// set default valid class
				if(isset($field['value']['error']) && $field['value']['error']) {

					// output error
					$registered_to = '<p>Error: ' . $field['value']['error'] . '</p>';

				} else if(isset($field['value']['is_valid']) && $field['value']['is_valid']) {
					
					// set valid class
					$valid_class = 'valid-key';
					$key_value = '****-****-****-****';
					
					// registered to
					$registered_to = '<p>Thank You! Registered to: ' . $field['value']['name'] . ' (' . $field['value']['email'] . ')</p>';
					
				} else if(!empty($field['value']['key'])) {
					$valid_class = 'invalid-key';
				}
				
				// input wrap
				echo '<div class="responsive-wrap">';
				
				echo '<select id="' . $field['id'] . '" class="select product-select ' . $field['class'] . '" name="' . $field['name'] . '[product]" value="' . $field['value']['product'] . '">';
					
				// loop through values and add them as options
				if( is_array($field['choices']['product']) )
				{
					foreach( $field['choices']['product'] as $key => $value )
					{
						if($key === $field['value']['product']) {
							$selected = 'selected';
						} else {
							$selected = '';
						}
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				}
				echo '</select>';
				echo '<div class="select-arrow"></div>';

				
				// license key input field
				echo '<input type="text" id="' . $field['id'] . '" placeholder="XXXX-XXXX-XXXX-XXXX" class="text semplice-key ' . $valid_class . '" name="' . $field['name'] . '[key]" value="' . $key_value . '">';
				
				// registered to
				echo '<div class="registered-to">' . $registered_to . '</div>';
				
				// acf input wrap close
				echo '</div>';
        }

        /*
        * update_value()
        *
        * This filter is appied to the $value before it is updated in the db
        *
        * @type        filter
        * @since        3.6
        * @date        23/01/13
        *
        * @param        $value - the value which will be saved in the database
        * @param        $post_id - the $post_id of which the value will be saved
        * @param        $field - the field array holding all the field options
        *
        * @return        $value - the modified value
        */

        function update_value($value, $post_id, $field)
        {

			// get current license data
			$current_license = get_field('license', 'options');

			// only check license if no corrent or the input changed
			if(!$current_license['is_valid'] || empty($value['key']) || $value['key'] !== $current_license['key'] && $value['key'] !== '****-****-****-****' || $value['product'] !== $current_license['product']) {

				// check license
				$check_license = wp_remote_get('http://update.semplicelabs.com/update.php?key=' . $value['key'] . '&product=' . $value['product'] . '&action=check_key');

				if(!is_wp_error($check_license) && empty($check_license->errors)) {

					// get array
					$license = json_decode($check_license['body'], true);

					if($license['license'] === 'valid') {

						// set license to valid
						$value['is_valid'] = true;
						
						// set name
						$value['name'] = $license['name'];
						
						// and email
						$value['email'] = $license['email'];

						// reset error
						$value['error'] = false;
						
					} else {
						
						// set license to invalid
						$value['is_valid'] = false;
						
					}
				} else {
					$value['error'] = $check_license->get_error_message();
				}
				
			} else {
				$value = $current_license;
			}

			return $value;
        }
}


// create field
new acf_field_license();

?>