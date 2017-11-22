<?php 
/*
 * welcome
 * semplice.theme
*/

?>

<div id="welcome">
	<section id="smp-getting-started" class="welcome-section">
		<div class="getting-started">
			<div class="two-col">
				<div class="import-portfolio">
					<div class="intro-icon">
						<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_demo_portfolio.png">
					</div>
					<h4>Demo Portfolio</h4>
					<p class="intro">The best way to start your journey with Semplice is to install our demo portfolio.</p>
					<a class="install-demo-portfolio gs-button">Install Demo Portfolio</a>
				</div>
				<div class="import-state">
					<div class="import-loader"><p>Installing Portfolio</p></div>
				</div>
				<div class="import-success">
					<div class="intro-icon">
						<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_success.png">
					</div>
					<h4>Import Successfull</h4>
					<p class="intro">Yeah! You're ready to go! We just created a demo project in your <a href="./edit.php?post_type=work" target="_blank">portfolio</a> and a 'Showcase' page which you can edit in your <a href="./edit.php?post_type=page" target="_blank">pages</a>.</p>
				</div>
			</div>
			<div class="two-col no-border">
				<div class="intro-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_custom_navbar.png">
				</div>
				<h4>Custom Navbar</h4>
				<p class="intro">To add your logo and customize the menu you have to create a custom navbar.</p>
				<a class="gs-button" target="_blank" href="./edit.php?post_type=custom_navbar">Create a Navbar</a>
			</div>
			<div class="two-col">
				<div class="intro-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_homepage.png">
				</div>
				<h4>Setup your Homepage</h4>
				<p class="intro">Click on the button below to select the page you want to use as your homepage.</p>
				<a class="gs-button" target="_blank" href="./options-reading.php">Set a homepage</a>
			</div>
			<div class="two-col no-border">
				<div class="intro-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_custom_fontset.png">
				</div>
				<h4>Custom Fontsets</h4>
				<p class="intro">In Semplice you can add fonts from every webfont service available. Try it!</p>
				<a class="gs-button" target="_blank" href="./edit.php?post_type=custom_fontset">Create a Fontset</a>
			</div>
			<div class="two-col">
				<div class="intro-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_activate.png">
				</div>
				<h4>Activate One-click Updates</h4>
				<p class="intro">To use the One-click Update feature from Semplice you have to activate the theme.</p>
				<a class="gs-button" target="_blank" href="./admin.php?page=acf-options-general-settings">Activate One-click Updates</a>
			</div>
			<div class="two-col no-border">
				<div class="intro-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/images/welcome/icon_help.png">
				</div>
				<h4>Help &amp; Support</h4>
				<p class="intro">Still stuck or found a bug? Visit our help desk and we are glad to help you out.</p>
				<a class="gs-button" target="_blank" href="http://help.semplicelabs.com">Visit Helpdesk</a>
			</div>
		</div>
	</section>
</div>