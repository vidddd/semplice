<?php

class acf_field_include extends acf_field
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
                $this->name = 'include';
                $this->label = __('include');
                $this->category = __("Layout",'acf'); // Basic, Content, Choice, etc
				$this->defaults = array(
					'filename'	=>	'filename.php',
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
                // defaults?
                isset($field['value']['filename']) ? $field['value']['filename'] : '';
				
				// key is needed in the field names to correctly save the data
                $key = $field['name'];
				
				?>

				<tr class="field_option field_option_<?php echo $this->name; ?>">
					<td class="label">
						<label><?php _e("Include Filename",'acf'); ?></label>
						<p><?php _e("Enter the filename of your include page",'acf') ?></p>
					</td>
					<td>
						<?php 
						do_action('acf/create_field', array(
							'type'	=>	'text',
							'name'	=>	'fields[' .$key.'][filename]',
							'value'	=>	$field['filename'],
						));
						?>
					</td>
				</tr>
				
				<?php
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
			// include include
			require get_template_directory() . '/includes/' . $field['filename'] . '.php';
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
			
				return $value;
        }
}


// create field
new acf_field_include();

?>