<?php

class acf_field_instagram extends acf_field
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
                $this->name = 'instagram';
                $this->label = __('Instagram');
                $this->category = __("Layout",'acf'); // Basic, Content, Choice, etc
                $this->defaults = array();
				
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
				if(!isset($field['value']['access_token'])) : $field['value']['access_token'] = ''; endif;
				if(!isset($field['value']['user_id'])) : $field['value']['user_id'] = ''; endif;

				echo '<div class="responsive-wrap">';
				
					// input fields
					echo '<input type="text" id="' . $field['id'] . '" class="instagram-token text" name="' . $field['name'] . '[access_token]" value="' . $field['value']['access_token'] . '">';
					echo '<input type="hidden" class="instagram-user-id" name="' . $field['name'] . '[user_id]" value="' . $field['value']['user_id'] . '">';
					
					// get access token
					echo '<a href="https://instagram.com/oauth/authorize/?client_id=944a6351b93041c5a62a6e88d7acaed6&redirect_uri=http://redirect.semplicelabs.com/?uri=' . admin_url('admin.php?page=acf-options-general-settings') . '&response_type=token" class="smp-access-token">Get Access Token</a>';				
				
				// acf input wrap close
				echo '</div>';
				
				?>
				<script type="text/javascript">
					(function($) {
						$(document).ready(function () {
							// get hash
							var hash = window.location.hash;
							// get access token
							var access_token = hash.substring(14);
							// split access token and id
							var user_id = access_token.split('.')[0];
							if(hash) {
								// assign token to textfield
								$('.instagram-token').val(access_token);
								// assign user id to hidden field
								$('.instagram-user-id').val(user_id);
							}
						});
					})(jQuery);
				</script>
				<?php
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
new acf_field_instagram();

?>