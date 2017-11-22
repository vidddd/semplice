<?php

class acf_field_responsive extends acf_field
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
                $this->name = 'responsive';
                $this->label = __('Responsive');
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
        		isset($field['value']['tablet_wide']) ? $field['value']['tablet_wide'] : '';
				isset($field['value']['tablet_portrait']) ? $field['value']['tablet_portrait'] : '';
				isset($field['value']['mobile']) ? $field['value']['mobile'] : '';

                // key is needed in the field names to correctly save the data
                $key = $field['name'];
				
                // Create Field Options HTML
                ?>
					<tr class="field_option field_option_<?php echo $this->name; ?>">
						<td class="label">
							<label><?php _e("Unit",'acf'); ?></label>
						</td>
						<td>
							<?php
							do_action('acf/create_field', array(
								'type'		=>	'radio',
								'name'		=>	'fields['.$key.'][unit]',
								'value'		=>	$field['unit'],
								'layout'	=>	'horizontal',
								'choices'	=> array(
									'percent'	=>	__("Percent",'acf'),
									'pixel'	=>	__("Pixel",'acf')
								)
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

                // defaults?
				if(!isset($field['value']['tablet_wide'])) : $field['value']['tablet_wide'] = ''; endif;
				if(!isset($field['value']['tablet_portrait'])) : $field['value']['tablet_portrait'] = ''; endif;
				if(!isset($field['value']['mobile'])) : $field['value']['mobile'] = ''; endif;

				// percent values
				$percent_values = array(
					'auto' => 'Auto',
					'5'    => '5%',
					'10'   => '10%',
					'15'   => '15%',
					'20'   => '20%',
					'25'   => '25%',
					'30'   => '30%',
					'35'   => '35%',
					'40'   => '40%',
					'45'   => '45%',
					'50'   => '50%',
					'55'   => '55%',
					'60'   => '60%',
					'65'   => '65%',
					'70'   => '70%',
					'75'   => '75%',
					'80'   => '80%',
					'85'   => '85%',
					'90'   => '90%',
					'95'   => '95%',
					'100'  => '100%',
				);

				// define value arrays
				$field['choices']['tablet_wide'] = $percent_values;
				$field['choices']['tablet_portrait'] = $percent_values;
				$field['choices']['mobile'] = $percent_values;

				// input wrap
				echo '<div class="responsive-wrap">';

				// tablet landscape
				echo '<div class="responsive-field">';
				echo '<div class="responsive-field-inner"><label>Tablet Landscape</label></div>';
				echo '<select id="' . $field['id'] . '" class="select ' . $field['class'] . '" name="' . $field['name'] . '[tablet_wide]" value="' . $field['value']['tablet_wide'] . '">';

				// loop through values and add them as options
				if( is_array($field['choices']['tablet_wide']) )
				{
					foreach( $field['choices']['tablet_wide'] as $key => $value )
					{	
						if($key == $field['value']['tablet_wide']) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				}
				
				echo '</select>';
				echo '<div class="select-arrow"></div>';
				echo '</div>';

				// tablet Portrait
				echo '<div class="responsive-field">';
				echo '<div class="responsive-field-inner"><label>Tablet Portrait</label></div>';
				echo '<select id="' . $field['id'] . '" class="select ' . $field['class'] . '" name="' . $field['name'] . '[tablet_portrait]" value="' . $field['value']['tablet_portrait'] . '">';
				
				// loop through values and add them as options
				if( is_array($field['choices']['tablet_portrait']) )
				{
					foreach( $field['choices']['tablet_portrait'] as $key => $value )
					{
						if($key == $field['value']['tablet_portrait']) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				}
				
				echo '</select>';
				echo '<div class="select-arrow"></div>';
				echo '</div>';

				// mobile
				echo '<div class="responsive-field">';
				echo '<div class="responsive-field-inner"><label>Phones</label></div>';
				echo '<select id="' . $field['id'] . '" class="select ' . $field['class'] . '" name="' . $field['name'] . '[mobile]" value="' . $field['value']['mobile'] . '">';
				
				// loop through values and add them as options
				if( is_array($field['choices']['mobile']) )
				{
					foreach( $field['choices']['mobile'] as $key => $value )
					{
						if($key == $field['value']['mobile']) {
							$selected = 'selected="selected"';
						} else {
							$selected = '';
						}
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				}
				
				echo '</select>';
				echo '<div class="select-arrow"></div>';
				echo '</div>';
								
				// clear
				echo '<div class="clearfix"></div>';
				
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
			
				return $value;
        }
}


// create field
new acf_field_responsive();

?>