<?php 
/*
 * footer
 * semplice.theme
 */
?>
			<?php echo semplice_footer(); # semplice footer ?>
			<!-- content -->
			</div>
		<!-- wrapper -->
		</div>
		<div class="to-the-top">
			<a class="top-button"><?php echo setIcon('arrow_up'); ?></a>
		</div>
		<div class="overlay fade"></div>
		<?php wp_footer(); # include wordpress footer ?>
		<script type="text/javascript">
			(function($) {

				// back button fix (firefox) thx to Jesse from stack overfllow
				$(window).unload(function () { $(window).unbind('unload'); });
				// back button fix (safari)
				$(window).bind('pageshow', function(event) {
					if (event.originalEvent.persisted) {
						window.location.reload() 
					}
				});
				
				$(document).ready(function () {

					/* ce images */
					$('.ce-image').each(function(){ var parentTag = $(this).parent().get(0).tagName; if(parentTag == 'A') { $(this).parent().remove(); } else { $(this).remove(); }});

					/* remove single edit div */
					$('.single-edit').remove();

					/* delete gallery brs */
					$('.gallery br').each(function() {
						$(this).remove();
					});

					/* image lightbox */
					var showOverlay = function() {
						$('<div class="lightbox-overlay"></div>').appendTo('body');
					};

					var hideOverlay = function() {
						$('.lightbox-overlay').remove();
					};

					/* arrows */

					var arrowsOn = function(instance, selector) {

						var $arrows = $('<div class="lightbox-arrows"><a type="button" class="imagelightbox-arrow imagelightbox-arrow-left">' + semplice.lightbox_prev + '</a><a type="button" class="imagelightbox-arrow imagelightbox-arrow-right">' + semplice.lightbox_next + '</a></div>');

						$arrows.appendTo('body');

						// fade in
						$('.lightbox-arrows').delay(200).fadeIn('slow');

						$('.imagelightbox-arrow').on('click touchend', function(e) {
							e.preventDefault();

							var $this	= $(this),
								$target	= $( selector + '[href="' + $('#imagelightbox').attr('src') + '"]'),
								index	= $target.index(selector);

							if( $this.hasClass('imagelightbox-arrow-left'))
							{
								index = index - 1;
								if(!$(selector).eq(index).length)
									index = $(selector).length;
							}
							else
							{
								index = index + 1;
								if( !$(selector).eq(index).length)
									index = 0;
							}

							instance.switchImageLightbox(index);
							return false;
						});
					};

					var arrowsOff = function() {
						$('.lightbox-arrows').fadeOut('fast', function() {
							$('.lightbox-arrows').remove();
						});
					};

					/* blog gallery */
					$('.gallery-icon a').each(function () {

						/* check if attachment or media file type */
						var isAttachment = $(this).attr('href').slice(-1);

						if(isAttachment !== '/') {
							$(this).attr('data-rel', 'lightbox');
						}

					});

					var selectorG = 'a[data-rel^=lightbox]';
					var instanceG = $(selectorG).imageLightbox(
					{
						selector:       'id="imagelightbox"',
						allowedTypes:   'png|jpg|jpeg|gif|svg',
						animationSpeed: 250,
						preloadNext:    true,
						enableKeyboard: true,
						quitOnEnd:      false,
						quitOnImgClick: false,
						quitOnDocClick: true,
						onStart:        function() { arrowsOn(instanceG,selectorG); showOverlay(); },
						onEnd:          function() { arrowsOff(); hideOverlay(); },
						onLoadStart:    false,
						onLoadEnd:      false
					});
		
					
					// content editor self hosted video and blog video
					$(".live-video video, .live-audio audio, .wysiwyg video, .wysiwyg audio, .cover-video video").mediaelementplayer({
						
						// options
						pauseOtherPlayers: false,

						success:  function (mediaElement, domObject) { 

							// get media element
							var $thisMediaElement = (mediaElement.id) ? $("#"+mediaElement.id) : $(mediaElement);

							if($thisMediaElement.attr('data-masonry-id')) {
								// layout masonry to avoid overlapping
								$('#masonry-' + $thisMediaElement.attr('data-masonry-id')).masonry('layout');
							}

							// empty poster image to avoid double images
							$thisMediaElement.attr('poster', '');

							// resize multicolumn on play if needed
					        mediaElement.addEventListener('canplay', function(e) {
								$('#masonry-' + $thisMediaElement.attr('data-masonry-id')).masonry('layout');
							}, false);

							// show poster image after video finished
				            mediaElement.addEventListener("ended", function(e){
				                $thisMediaElement.parents(".mejs-inner").find(".mejs-poster").show();
				            });
				        }
					});
				});
			})(jQuery);
		</script>
		<?php 
			// custom javascript
			if(get_field('skinoptions_custom_js', 'options')) {
				echo '<script type="text/javascript" id="semplice-custom-js">' . get_field('skinoptions_custom_js', 'options') . '</script>';
			}
		?>
	</body>
</html>