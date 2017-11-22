<?php

/*
 * grid
 * semplice.theme
 */

// semplice grid
function semplice_grid($id, $content, $is_fluid, $remove_gutter, $index, $pre) {

	// output
	$grid = '';
	
	// masonry id
	$masonry = 'masonry-' . $id;
	
	// fit width
	$fit_width = '';

	// percent position
	$percent_position = '';
	
	// fluid
	$fluid = '';
	
	if($is_fluid) {
		$container_class = '';
		// if gutter, center masonry
		if(!$remove_gutter) {
			$fit_width = 'isFitWidth: true';
			$container_class = 'class="masonry-full"';
			$fluid = ' .masonry-full-inner';
		}
	} else {
		$container_class = 'class="container"';
	}
	
	// output masonry container
	$grid .= '<div id="' . $masonry . '" ' . $container_class . '>';
	
	if($is_fluid && !$remove_gutter) {
		// masonry inner
		$grid .= '<div class="masonry-full-inner">';
	}

	// remove gutter
	if($remove_gutter) {
		$grid .= '<div class="no-gutter-grid-sizer"></div>';
		$grid .= '<div class="no-gutter-gutter-sizer"></div>';
		$percent_position = 'percentPosition: true,';
	} else {
		$grid .= '<div class="grid-sizer"></div>';
		$grid .= '<div class="gutter-sizer"></div>';
	}
	
	// content
	$grid .= $content;

	// close masonry inner
	if($is_fluid && !$remove_gutter) {
		$grid .= '</div>';	
	}

	// index
	$index = $index - 1;
	
	// close masonry container
	$grid .= '</div>';
	
	// javascript
	$grid .= '
		<script type="text/javascript">
			(function ($) {
				$(document).ready(function () {
					
					/* init masonry */
					var $grid = $("#' . $masonry . $fluid . '");
					$grid.masonry({
						itemSelector: ".' . $masonry . '-item",
						columnWidth: ".' . $pre . 'grid-sizer",
						gutter: ".' . $pre . 'gutter-sizer",
						transitionDuration: 0,
						isResizable: true,
						' . $percent_position . '
						' . $fit_width . '
					});

                	var index = 0;

                	/* layout Masonry after each image loads */
                	$grid.imagesLoaded().progress(function() {
	                  	$(".' . $masonry . '-item-" + index).css("opacity", 1);
	                  	$grid.masonry("layout");
	                  	index++;
                	});
				});
			})(jQuery);
		</script>
	';
		
	// output
	return $grid;
}

?>