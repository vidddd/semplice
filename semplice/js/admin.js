(function ($) {
    "use strict";
    $(document).ready(function () {

    	/* add dropdown arrows */
    	$('<div class="select-arrow"></div>').insertAfter($('div.field > select'));

		/* delete cover slider arrow */
		$('#acf-field-cover_slider').next().remove();
		
    	/* wysiwyg editor in full width */
    	$('.row_layout .field_type-wysiwyg').each(function() {
    	   $(this).children('td.label').remove();
    	   $(this).children('td:first-child').attr('colspan', '2');
    	});

    	$('.field ul.acf-checkbox-list li label').each( function() {
    	    if($(this).children('.checkbox').prop('checked')) {
    	        $(this).css('backgroundPosition', '0px -21px');
                $(this).addClass('checked');
    	    }
    	});
    	
    	/* include the content editor in the workview content editor tab */
    	$('#acf_3362, #acf_acf_content-editor').insertAfter('.field_key-field_52af1e0e9d2d9');
    	
    	/* include the content editor in the page tab */
        $('#acf_3362, #acf_acf_content-editor').insertAfter('.field_key-field_530238f0d553c');
    	
    	/* include the custom header in the page custom header tab */
        $('#acf_1307, #acf_acf_fullscreen-cover').insertAfter('.field_key-field_52f2469819e07');
    	
    	/* include the custom header in the workview project header tab */
    	$('#acf_1307, #acf_acf_fullscreen-cover').insertAfter('.field_key-field_51ef0717531f2');
		
    	/* deactive preview changes */
    	if($('.semplice-content').val() && $('.semplice-content').val() != '<div id="content-holder"></div>') {
    		$('#post-preview').attr('href', '').css({
    			pointerEvents: 'none',
    			opacity: '.4',
    		}).after('<div class="why-deactivated"><a href="http://help.semplicelabs.com/customer/en/portal/articles/2346038-why-is-the-preview-changes-button-disabled-" target="_blank">Why deactivated?</div></div>');
    	}

		/* show help video */
		$('.smp-video-button').click(function() {
			
			/* video and vimeo id */
			var videoId = '.' + $(this).attr('data-video-id');
			var vimeoId = $(this).attr('data-vimeo-id');
			
			if(!$(this).hasClass('smp-open')) {
				$(videoId).find('.responsive-video').append('<iframe src="https://player.vimeo.com/video/' + vimeoId + '" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
				$(videoId).stop().slideDown(500);
				$(this).addClass('smp-open');
			} else {
				$(videoId).stop().slideUp(500, function() {
					$(videoId).find('.responsive-video').html('');
				});
				$(this).removeClass('smp-open');
			}
		});

		/* close video on tab change */
		$(document).on('click', '.acf-tab-button', function() {
			/* get video id */
			var videoId = '.' + $('.smp-video-button').attr('data-video-id');

			$(videoId).css('display', 'none');

			$(videoId).find('.responsive-video').html('');

			$('.smp-video-button').removeClass('smp-open');
		})
		
		/* torn off discard changes notice for publish and save draft button */
		$('#publish, #save-post').click(function() {
			window.onbeforeunload = null;
		});
				
		/* import */
		$('.install-demo-portfolio').click(function(){

			var import_true = confirm('Please note that it\'s recommended to install the demo portfolio on top of a fresh wordpress installation.\n\nAre you sure you want to import the demo portfolio?');
			
			if(import_true === false) {
				return;
			} 
			
			$('.import-portfolio').fadeOut('fast', function() {
				$('.import-state').fadeIn('fast');
			});
			
			var data = {
				'action': 'semplice_import'       
			};

			$.post(ajaxurl, data, function(response) {
				$('.import-state .import-loader').remove();
				/* is successfull import? */
				if(response.search('All done.') >= 0) {
					$('.import-state').hide();
					$('.import-success').fadeIn('fast');
				} else {
					$('.import-state').fadeIn('fast').append('<div class="import-response">' + response + '</div>');
				}				
			});
		});
		
		/* close import */
		$('body').on('click', '.close-import', function() {
			$('.import-assets').remove();
		});
	});
})(jQuery);