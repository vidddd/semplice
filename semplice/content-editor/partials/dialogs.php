<div id="grid"></div>
<div id="semplice-content"></div>
<div class="semplice-ce-default">
	<div class="container">
		<div class="row">
			<div class="span12">
				<h2 class="get-started">Get started by<br />adding some content</h2>
				<div class="black-bar"></div>				
				<div class="default-adder">
					<ul>
						<li><a class="add-content p" data-content-type="content-p"><span>Text</span></a></li>
						<li><a class="add-content img" data-content-type="content-img"><span>Image</span></a></li>
						<li><a class="add-content gallery" data-content-type="content-gallery"><span>Gallery</span></a></li>
						<li><a class="add-content video" data-content-type="content-video"><span>Video</span></a></li>
						<li><a class="add-content audio" data-content-type="content-audio"><span>Audio</span></a></li>
						<li><a class="add-content oembed" data-content-type="content-oembed"><span>Embed</span></a></li>
						<li><a class="add-content spacer" data-content-type="content-spacer"><span>Spacer</span></a></li>
						<li><a class="add-content thumbnails" data-content-type="content-thumbnails"><span>Portfolio</span></a></li>
						<li><a class="add-content mc" data-content-type="multi-column"><span>Columns</span></a></li>
					</ul>
					<a class="load-template" data-template-id="ce-default">Or load some demo content</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	// blocks instance
	$blocks = new blocks();
	// Generate Blocks
	echo '<div id="blocks">' . $blocks->generate_blocklist() . '</div>';
?>
<div class="block-edit">
	<div class="block-overlay"></div>
	<div class="block-confirm">
		<div class="text text-static">
			<p>Are you sure?</p>
		</div>
		<div class="text text-dynamic">
			<p>Are you sure?<br /><span>Please note that if you remove a dynamic block this block will also get deleted on all pages the block is being used.</span></p>
		</div>
		<ul>
			<li><a class="remove-block-decline">No</a></li>
			<li><a class="remove-block-confirm" data-content-id="" data-is-column="" data-parent-id="">Yes</a></li>
		</ul>
	</div>
</div>
<div class="loader">
	<svg class="semplice-spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
		<circle class="path" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
	</svg>
</div>
<div class="confirm">
	<div class="text">
		<h4>Confirm</h4>
		<p>Are you sure you want to<br />delete this content?</p>
	</div>
	<ul>
		<li><a class="remove-decline decline-button">No</a></li>
		<li><a class="remove-confirm confirm-button" data-content-id="" data-is-column="" data-parent-id="">Yes</a></li>
	</ul>
</div>
<div class="cancel">
	<div class="text">
		<h4>Confirm</h4>
		<p>Do you want to<br />exit without saving?</p>
	</div>
	<ul>
		<li><a class="cancel-decline decline-button">No</a></li>
		<li><a class="cancel-confirm confirm-button">Yes</a></li>
	</ul>
</div>
<div class="confirm-template">
	<div class="text">
		<h4>Are you sure?</h4>
		<p>Your current progress<br />will be overwritten!</p>
	</div>
	<ul>
		<li><a class="template-decline decline-button">No</a></li>
		<li><a class="template-confirm confirm-button">Yes</a></li>
	</ul>
</div>
<div class="confirm-save-block">
	<div class="text">
		<h4>Save Block</h4>
		<div class="block-name">
			<input type="text" placeholder="Enter your block name" value="" class="save-block-name">
		</div>
		<div class="block-type">
			<select class="ce-select-box save-block-type">
				<option value="static">Static</option>
				<option value="dynamic">Dynamic</option>
			</select>
		</div>
		<div class="desc-dynamic-block">
			<p></p>
			<p><span>Static or Dynamic Block?</span><br />Please visit our little <a href="https://vimeo.com/143198710" target="_blank">guide</a> on wether to save your block as static or dynamic.</p>
		</div>
	</div>
	<ul>
		<li><a class="save-block-decline decline-button">Cancel</a></li>
		<li><a class="save-block-confirm confirm-button">Save</a></li>
	</ul>
</div>
<div id="block-preview"></div>
<div class="overlay"><!-- overlay --></div>
<div class="overlay-transparent"><!-- overlay --></div>
<div class="overlay-preview"><!-- overlay --></div>
<div class="no-images"><p><strong>No Images on edit?</strong> If you can't see any images after you click on an image to edit it please import the templates.xml from your theme folder into wordpress and make sure to download the attachments!</p><br /><a class="ce-dismiss">Close</a></div>