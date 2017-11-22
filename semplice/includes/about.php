<?php 
/*
 * about
 * semplice.theme
*/

// get currect license
$current_license = get_field('license', 'options');

// get semplice metadata
global $semplice;

// define licenses
$licenses = array(
	'single'				=> 'Single',
	'studio'				=> 'Studio',
	'single-to-studio'		=> 'Studio',
	'business'				=> 'Business',
	'single-to-business'	=> 'Business',
	'studio-to-business'	=> 'Business'
);

// license
$license = array();

if(!$current_license['is_valid']) {
	$license['registered-to'] = 'Registered to: Not registered';
	$license['license-type'] = 'Not registered';
} else {
	$license['registered-to'] = 'Registered to: ' . $current_license['name'];
	$license['license-type'] = $licenses[$current_license['product']] . ' License';
}
?>

<div class="acf-semplice-about">
	<p>
		Installed Theme Edition: Semplice <?php echo ucfirst($semplice['edition']); ?><br />
		License type:  <?php echo $license['license-type']; ?><br />
		<?php echo $license['registered-to']; ?><br />
		Version: <?php echo $semplice['version']; ?> (<a href="http://www.semplicelabs.com/changelog-studio" target="_blank">Studio Changelog</a>)<br />
		PHP Version: <?php echo $semplice['php_version']; ?><br />
		Support: <a href="http://help.semplicelabs.com" target="_blank">Helpdesk</a>
	</p>
	<p>
		For updates please follow<br />
		<a target="_blank" href="http://www.twitter.com/semplicelabs">twitter.com/semplicelabs</a><br />
		<a target="_blank" href="http://www.facebook.com/semplicelabs">facebook.com/semplicelabs</a>
	</p>
	<p>
		Made in the <a href="http://www.semplicelabs.com" target="_blank">Semplice Labs</a>
	</p>
</div>