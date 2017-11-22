<?php
/*
 * ce index
 * semplice.theme
 * 
 */
 
global $post;

// if is smp ce link in page row actions start the editor right away
if(isset($_GET['smp_ce'])) {
	
	$e = '
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function() {
	';
	
	if(get_field('use_semplice') === 'active' || get_post_type($post->ID) === 'work' || get_post_type($post->ID) === 'footer') {
		$e .= '$(".add-semplice-editor").trigger("click");';
	} else {
		$e .= 'alert("Please activate Semplice on this site to start the content editor")';
	}
	
	$e .= '
				});
			})(jQuery);
		</script>
	';
	
	// output
	echo $e;

}
 
// get default fontset id
$fontset_object = get_field('custom_fontset', 'options'); 

if($fontset_object) {
	$fontset_id = $fontset_object->ID;
} else {
	$fontset_id = 'default';
}

// get branding
$styles = json_decode(get_post_meta( get_the_ID(), 'semplice_ce_branding', true ), true);

// select boxes
function select($arr, $active_key) {
	echo $active_key;
	if( is_array($arr) )
	{
		foreach( $arr as $key => $value )
		{
			if($key === $active_key) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		}
	}
}

?>
<script type="text/javascript">
	/* set default fontset */
	var default_fontset = '<?php echo $fontset_id; ?>';
</script>
<?php
	// adder
	require get_template_directory() . '/content-editor/partials/adder.php';
	
	// dialogs
	require get_template_directory() . '/content-editor/partials/dialogs.php';
?>