/*
 * semplice custom js
 * semplice.theme
 */

(function ($) {
    "use strict";

    /* show thumbs */
    $.fn.showdelay = function(max){
        var delay = 0;
		var num = 0;
        return this.each(function(){
            $(this).delay(delay).transition({ opacity: '1' }, 700, 'ease');
            delay += 200;
			num++;
			if(num === max) {
				/* fade out progress bar */
				NProgress.done();
			}
        });
    };
	
	/* show menu items */
    $.fn.showMenuItems = function(){
        var delay = 0;
		var num = 0;
        return this.each(function(){
			$(this).delay(delay).transition({ translate: ['0px','0px'], opacity: 1 }, 350);
            delay += 80;
        });
    };


    /* function for the menu fadein */
    function showNav(method, duration) {
		
        var headerHeight = $('header').height();
        var headerBarHeight = $('#navbar').height();
        if (method === 'slide-up') {
            $("header").transition({ opacity: 1, top: -headerHeight, }, duration, 'snap');
        } else if (method === 'slide-down') {
            $("header").transition({ opacity: 1, top: 0, }, duration, 'snap');
        }
    }
	
	/* is mobile device or tablet? */
	function isMobile() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|android|ipad|playbook|silk|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
		return check; 
	}
	
	/* site transitions */
	var no_transitions = $('body').hasClass('no-transitions');
	
	/* menu */
	var menu = '#fullscreen-menu';
	
	/* image zoom */
	var imageZoom = $('.cover-image').data('image-zoom');
	
	/* parallax scrolling */
	var parallaxScrolling = $('.cover-image').data('parallax-scrolling');
	
	/* full height menu */
	var fullHeightMenu = $(menu).hasClass('full-height');
	
	/* menu height */
	var menuHeight = 0;
	var menuTransitionDuration = 750;
	var menuTopOffset = $('header').height();
		
	if(!fullHeightMenu) {
		menuHeight = '-' + $(menu).height() + 'px';
		menuTransitionDuration = 550;
	}
	
	/* hide menu */
	$(menu).css('top', menuHeight);
	
    $(document).ready(function () {   

		/* append fastclick */
		if(isMobile()) {
			FastClick.attach(document.body);
		}
	
		if(!no_transitions) {
		
			/* fade in Menu */
			var effect = 'slide-down';
			
			if($('body').hasClass('is-cover-slider') && $('body').hasClass('start-at-content')) {
				showNav(effect, 0);
			} else {
				showNav(effect, 900);
			}
			
		}
		
		/* header bar opacity and transparency mode */
		var headerBarOpacity = $('#navbar-bg').data('navbar-opacity');
		
		if ($(window).scrollTop() >= $('.fullscreen-cover').height() - ( $('#navbar-bg').height() + 20) ) {
			$('#navbar-bg').removeClass('transparent')
							.addClass('navbar')
							.css('opacity',headerBarOpacity);
		}
		
		/* responsive full height menu */
		function responsiveFullHeightMenu() {
			var navHeight = $('.menu-inner nav').height();
			var navPadding = parseInt($('.menu-inner nav').css('paddingTop')) * 2;
			var socialBarHeight = $('.follow-links').height();
			var bottom = $('.menu-inner nav').position().top+$('.menu-inner nav').outerHeight(true)

			/* real menu height */
			navHeight = navHeight + navPadding + socialBarHeight + menuTopOffset;
			
			
			if(navHeight >= $(window).height()) {
				
				if(!fullHeightMenu) {
					$(menu).css('overflowY', 'scroll');
				}
				
				$('.menu-inner nav').addClass('align-top');
				$('.follow-links').addClass('no-align');
				
			} else {

				if(!fullHeightMenu) {
					$(menu).css('overflowY', 'auto');
				}
				
				$('.menu-inner nav').removeClass('align-top');
				$('.follow-links').removeClass('no-align');
			}
		}
		
		function menuToggle(status) {
			
			if(status === 'open') {
				/* change header position to absolte */
				$('header').appendTo(menu).css('position', 'absolute');
				
				if(fullHeightMenu) {
					
					/* get vp width with scrollbar */
					var widthScrollbar = $(window).width();

					/* set body overflow to hidden */
					$('body').addClass('open-nav');
					
					/* get vp width without scrollbar */
					var widthNoScrollbar = $(window).width();

					/* calculate % width */
					var wrapperWidth = widthScrollbar * 100 / widthNoScrollbar;
					
					$('#wrapper').css('width', wrapperWidth + '%');
				}

				/* re-enable overlay button */
				$('.overlay').removeAttr('disabled');
				
				/* active button again */
				$('.close-nav').removeAttr('disabled');
			} else {
				/* hide menu again */
				$(menu).css('z-index', '-1');
				
				/* add vertical offset back to the menu items */
				if(fullHeightMenu) {
					$('.menu-inner nav ul li').css({'transform' : 'translate(0px,30px)', 'opacity' : 0});
				}
				
				/* active button again */
				$('.open-nav').removeAttr('disabled');
			}
			
		}
		
		var headerBarClass;
		var headerBarOpacity;

		/* open menu */
        $(document).on('click', 'div.controls a.open-nav', function() {
			
			/* switch menu button and disabled it while animating */
			$('div.controls a.open-nav').attr({ 'class' : 'close-nav', 'disabled' : 'disabled' });
			
			/* also disable overlay button */
			$('.overlay').attr('disabled', 'disabled');
		
			/* get header bar class */
			headerBarClass = $('#navbar-bg').attr('class');
			
			/* get header bar opacity */
			headerBarOpacity = $('#navbar-bg').css('opacity');
			
			/* set non transparent class */
			if($('#navbar-bg').data('dropdown-transparent') === 'enabled') {
				$('#navbar-bg').attr('class', 'navbar').css('opacity', 0);
			} else {
				$('#navbar-bg').attr('class', 'navbar').css('opacity', 1);
			}
			
			
			/* hide follow links if empty */
			if($('.follow-links ul li').length === 0) {
				$('.follow-links').hide();
			}
			
			/* hide other menu icons */
			$('.menu-icon').hide();
			
			/* call responsive full height menu */
			responsiveFullHeightMenu();
			
			/* fade in menu */
			if(!fullHeightMenu) {
				
				/* overlay position fixed */
				$('.overlay').css('position', 'fixed');
			
				/* add close-menu class to overlay */
				$('.overlay').css('display', 'block').transition({ opacity: '0.6' }, 300, 'ease').addClass('close-menu');
				
				/* fade in menu */
				$(menu).stop().css('z-index', '101').transition({ top: 0, opacity: 1}, menuTransitionDuration, 'easeOutQuart', function() {
					
					menuToggle('open');
					
				});
				
			} else {
				
				/* fade in fullscreen menu bg */
				$(menu).stop().css('z-index', '101').transition({ opacity: 1 }, 350, function() {

					menuToggle('open');
					
				});
				
				/* fade in menu items */
				setTimeout(function() {
					$('.menu-inner nav ul li').showMenuItems();
				}, 50);
				
			}
		});
		
		/* close menu */
		$(document).on('click', '.close-menu, div.controls a.close-nav', function() {
			
			if($(this).attr('disabled') !== 'disabled') {
			
				/* switch menu button and disable it while animating */
				if($('.nav-wrapper .standard, .fluid-menu .standard').length > 0) {
					$('div.controls a.close-nav').attr({ 'class' : 'open-nav menu-responsive', 'disabled' : 'disabled' });
				} else {
					$('div.controls a.close-nav').attr({ 'class' : 'open-nav', 'disabled' : 'disabled' });
				}
	
				var duration = menuTransitionDuration - 200;

				/* revert header Class */
				$('#navbar-bg').attr('class', headerBarClass).css('opacity', headerBarOpacity);
				
				/* show other menu icons */
				$('.menu-icon').show();
				
				/* change header position to absolte */
				$('header').insertBefore(menu);
				
				/* change back header position */
				if(!$('header').hasClass('non-sticky-nav') && isMobile() !== true) {
					$('header').css('position', 'fixed');
				}
				
				/* fade in menu */
				if(!fullHeightMenu) {
					
					/* remove close-menu class */
					$('.overlay').removeClass('close-menu');
					
					/* fade out overlay */
					$('.overlay').transition({ opacity: '0' }, 300, 'ease', function() {
						
						/* fade out overlay */
						$('.overlay').css({ display: 'none', position: 'absolute' });
						
					});
					
					$(menu).stop().transition({ top: menuHeight, opacity: 0 }, menuTransitionDuration, 'ease', function() {
						
						menuToggle('close');
						
					});
					
				} else {
					
					/* set body overflow back to scroll */
					$('body').removeClass('open-nav');
					
					/* set wrapper back to 100% */
					$('#wrapper').css('width', '100%');
					
					/* fade out fullscreen menu bg */
					$(menu).stop().transition({ opacity: 0 }, 350, function() {
						
						menuToggle('close');
						
					})
					
				}
			}
		});
				
		/* advanced media querys */
		$('.content-container, .mc-content-container, .mc-sub-content-container, .spacer, .menu-inner nav, .menu-inner nav ul li a').each(function() {
			
			// reference
			var _this = $(this);
			
			var paddingTop = $(this).css('padding-top').replace('px','');
			var paddingRight = $(this).css('padding-right').replace('px','');
			var paddingBottom = $(this).css('padding-bottom').replace('px','');
			var paddingLeft = $(this).css('padding-left').replace('px','');
			
			// spacer
			var marginTop = $(this).css('margin-top').replace('px','');
			var marginBottom = $(this).css('margin-bottom').replace('px','');
			
			// divider
			var divider;
			
			function paddings(divider) {
			
				$(_this).css('padding-top', paddingTop / divider);
				$(_this).css('padding-right', paddingRight / divider);
				$(_this).css('padding-bottom', paddingBottom / divider);
				$(_this).css('padding-left', paddingLeft / divider);
				
				// spacer margins
				$(_this).css('margin-top', marginTop / divider);
				$(_this).css('margin-bottom', marginBottom / divider);

				// apply this chances to the masonry contents */
				$('#content-holder > div').each(function() {

					// is fluid?
					var fluid = '';

					if($(this).find('.masonry-full-inner')) {
						var fluid = ' .masonry-full-inner';
					}

					if($(this).attr('class') === 'multi-column') {
						var $grid = $('#masonry-' + $(this).attr('id') + fluid);
						$grid.masonry('layout');
					}
				});
				
			}
			
			var nineSixty = {
			
				match : function() {
					divider = 1.2;
					paddings(divider);
				},      
											
				unmatch : function() {
					paddings(1);
				}
			}
			
			var tabletWide = {
			
				match : function() {
					divider = 1.4;
					paddings(divider);
				}
			}
			
			var tabletPortrait = {
			
				match : function() {
					divider = 1.6;
					paddings(divider);
				}
			}
			
			var mobile = {
				
				match : function() {
					divider = 1.8;
					paddings(divider);
				}  
			}
			
			/* register */
			enquire
			.register('(min-width: 980px) and (max-width: 1199px)', nineSixty)
			.register('(min-width: 768px) and (max-width: 979px)', tabletWide)
			.register('(max-width: 767px)', tabletPortrait)
			.register('(max-width: 567px)', mobile);
		});
		
        /* scale ratio */
        var scaleRatio;
        
        /* ios background cover viewport bugfix */
        if(isMobile() === true) {
            $('.cover-image, .cover-video-responsive').css('backgroundSize', 'cover');
            $('.cover-image, .cover-video-responsive').css('background-attachment', 'scroll');
            $('.controls a, .project-panel-button').addClass('ios-no-hover');
        }

		/* make blog videos responsive */
		if($('body').hasClass('is-blog')) {
			$('iframe').wrap('<div class="responsive-video"></div>');
			$('.wp-video, .wp-audio').css('width', '100%');
			$(".featured-video video, .featured audio").mediaelementplayer();
		}

        /* get bg img src */
        function getFullScreenImgSrc(input) {
            return input.replace(/"/g, "").replace(/url\(|\)$/ig, "");
        }
        
		/* get cover num */
		var covers_num = $('.fullscreen-cover').length;
		
		/* slow bg scrolling */
        var $bgobj = $('.cover-image'); // assigning the object

        /* trigger scroll event if scrollbar is not on top */
        if($bgobj && $(window).scrollTop() > 0) {
			onWindowScroll();
		}

        /* look if fullscreen cover exists */
        if(covers_num) {
			/* start nprogress if transitions enabled */
			if(!no_transitions) {
				NProgress.start();
			}
            /* get cover */
			if(covers_num > 1) {
				$('.fullscreen-cover').each(function(index) {
					index++;
					// call cover function
					cover($(this).data('cover-id'), index);
				});
			} else {
				cover($('.fullscreen-cover').data('cover-id'), 1);
			}
        } else {
            /* no fullscreen cover, start afterCover animations right away */
            afterCover();
        }

        /* after cover */
        function cover(id, index) {
			
            var cover = $('.cover-' + id);

            if($(cover).data('bg-type') === 'image') {

                $(cover).find('.cover-video').hide();
                
                /* get bg img src */
                var fullScreenImgSrc = getFullScreenImgSrc($(cover).find(".cover-image").css("background-image"));

                /* load bg and fade in */
                $.loadImages(fullScreenImgSrc, function () {
                    $(cover).transition({ opacity: 1 }, 1000, 'ease', function() {
                        afterCover(index);
                    });
					headline(id);
                });
				
            } else if($(cover).data('bg-type') === 'video') {

                $(cover).find('.cover-image').hide();
				
				var vid_w_orig;
				var vid_h_orig;

				vid_w_orig = parseInt($(cover).find('video').attr('width'));
				vid_h_orig = parseInt($(cover).find('video').attr('height'));

				$(window).resize(function () { resizeToCover(id, vid_w_orig, vid_h_orig, 300); });
				$(window).trigger('resize');
				
                $(cover).transition({ opacity: 1 }, 1000, 'ease', function() {
					
					// fade in video-overlay
					$(cover).find('.video-fadein').transition({ opacity: 0 }, 1500, 'ease');
					
                    afterCover(index);
					
                });

                headline(id);
                
            } else {

                $(cover).transition({ opacity: 1 }, 1000, 'ease', function() {
                    afterCover(index);
                });
                headline(id);
            }
        }
        
        /* vertical align and display headline */
        function headline(id) {
            /* if is image, load it */
            if($('.cover-' + id + ' .cover-headline').data('headline-format') === 'image') {		
                imagesLoaded($('.cover-' + id + ' .cover-headline'), function() {
					$('.cover-' + id + ' .cover-headline').transition({ opacity: 1, delay: 300 }, 800, 'ease' );
                });
				
            } else {
				$('.cover-' + id + ' .cover-headline').transition({ opacity: 1, delay: 300 }, 800, 'ease' );
            }
        }
        
        /* after cover content transitions */
        function afterCover(index) {
			/* is cover slider */
			if(index === covers_num && covers_num > 1) {
				/* fade out progress bar */
				NProgress.done();
			} else {
				if(!no_transitions && $('.fade-content').length > 0) {
					$('.fade-content').showdelay($('.fade-content').length);
				} else {
					NProgress.done();
				}
			}	
        }
        
		/* vertical or horizontal coverslider arrows */
		if($('body').hasClass('vertical-arrows')) {
			
			// add next / prev functions
			$(document).on('click', '.fp-vert-nav .next', function() {
				$.fn.fullpage.moveSectionDown();
			});
			
			$(document).on('click', '.fp-vert-nav .prev', function() {
				$.fn.fullpage.moveSectionUp();
			});
			
		} else if($('body').hasClass('horizontal-arrows')) {
			
			// add next / prev functions
			$(document).on('click', '.fp-hor-nav .next', function() {
				$.fn.fullpage.moveSlideRight();
			});
			
			$(document).on('click', '.fp-hor-nav .prev', function() {
				$.fn.fullpage.moveSlideLeft();
			});
			
		}
		
		/* trigger scroll down if covers slider */
		if($('body').hasClass('is-cover-slider')) {
			scrollToContent(0);
		}
		
		/* scroll to see more animation */
		$('.see-more').click(function() {
			scrollToContent(1100);
		});
		
		function scrollToContent(duration) {

			var scrollHeaderHeight;
			
			/* is sticky? */
			if($('header').css('position') === 'absolute') {
				scrollHeaderHeight = 0;
			} else {
				scrollHeaderHeight = $('header').height() - 1;
			}
			
			/* is transparent? */
			if($('#navbar-bg').data('navbar-opacity') !== 1) {
				scrollHeaderHeight = 0;
			}
		
			var tabletPortrait = {
				match : function() {
					scrollHeaderHeight = 0;
				}
			}
			
			var mobile = {
				match : function() {
					scrollHeaderHeight = 0;
				}  
			}
			
			/* register */
			enquire
			.register('(max-width: 767px)', tabletPortrait)
			.register('(max-width: 567px)', mobile);
		
		
			$($.browser.webkit ? "body" : "html").animate({
                    scrollTop: $('.fullscreen-cover').height() - scrollHeaderHeight
            }, duration, 'easeInOutExpo');
			
		}
		
		/* responsive full height menu */
		function responsiveProjectPanel() {
			var ppHeight = $('#project-panel-header').height();
			if(ppHeight >= $(window).height()) {
				$('#project-panel-header').css({ overflowY: 'scroll' });
			} else {
				$('#project-panel-header').css({ overflowY: 'hidden' });
			}
		}
		
		var ppSlideDuration = 600;
		
		if(isMobile()) {
			ppSlideDuration = 0;
		}
		
		$(document).on('click', '.project-panel-button', function() {
			
			/* scroll top animation duration */
			var duration = 0;
			
			if($(window).scrollTop() === 0) {
				duration = 0;
			} else if($(window).scrollTop() > 0 && $(window).scrollTop() < 300) {
				duration = 300;
			} else {
				duration = 700;
			}

			/* fade in panel */
            $($.browser.webkit ? "body" : "html").animate({
                    scrollTop: 0
                }, duration, 'easeInOutExpo', function () {

				/* fade in overlay */
				$('.overlay').css('display', 'block').transition({ opacity: '0.6' }, 400, 'ease').addClass('close-panel').css('position', 'fixed');
				
                $('header').appendTo('#wrapper').css('position', 'absolute');
				$('#project-panel-header').slideDown(ppSlideDuration, 'easeInOutExpo', function() {
					/* scrollbar if vertical slider */
					if($('body').hasClass('dedicated-slider')) {
						responsiveProjectPanel();
					}
				});
                $('body').addClass('project-panel-active');
            });
        });

        /* thumb nav close slide */
		$(document).on('click', '.close-project-panel, .close-panel', function() {
		
            $('.overlay').transition({ opacity: '0' }, 400, 'ease', function() {
				$('.overlay').css('display', 'none').removeClass('close-panel');
			});
            $('#project-panel-header').slideUp( ppSlideDuration, 'easeInOutExpo', function () {
                $('header').insertAfter('#project-panel-header');
				/* is sticky? */
				if(!$('header').hasClass('non-sticky-nav') && isMobile() !== true) {
					$('header').css('position', 'fixed');
				}
                $('.overlay').css('position', 'absolute');
                $('body').removeClass('project-panel-active');
            });
        });
        
        /* blog search */
        $('.search-button').click(function() {
            $($.browser.webkit ? "body" : "html").animate({
                scrollTop: 0
            }, 400, 'easeInOutExpo');
            $('.blog-search').slideDown(700, 'easeInOutExpo');
            $('.search-field').focus();
        });
        
        $('.search-close').click(function(){
            $('.blog-search').slideUp(700, 'easeOutExpo');
        });
        
        /* archives and categories */
        $('.archives-button').click(function() {
            $($.browser.webkit ? "body" : "html").animate({
                scrollTop: 0
            }, 400, 'easeInOutExpo');
            $('#category-archives').slideDown(700, 'easeInOutExpo');
        });
        
        $('.archives-close').click(function(){
            $('#category-archives').slideUp(700, 'easeOutExpo');
        });
        
		/* thanks to seron from stack.overflow for this script */
		function resizeToCover(id, vid_w_orig, vid_h_orig, min_w) {

			var scale_h = $(window).width() / vid_w_orig;
			var scale_v = $(window).height() / vid_h_orig;
			var scale = scale_h > scale_v ? scale_h : scale_v;

			if (scale * vid_w_orig < min_w) {scale = min_w / vid_w_orig;};

			$('.cover-' + id + ' .cover-video video').width(scale * vid_w_orig);
			$('.cover-' + id + ' .cover-video video').height(scale * vid_h_orig);

			$('.cover-' + id + ' .cover-video').scrollLeft(($('.cover-' + id + ' .cover-video video').width() - $(window).width()) / 2);
			$('.cover-' + id + ' .cover-video').scrollTop(($('.cover-' + id + ' .cover-video video').height() - $(window).height()) / 2);
		};

		/* scroll */
        function onWindowScroll(_event) {

        	/* parallax */
            if(imageZoom !== 'zoom' && $('#cover-slider').length <= 0 && parallaxScrolling !== 'disabled' ) {
				var yPos = $(window).scrollTop() / 3;
				$bgobj.css({ 
					'transform' : 'translate3d(0px, ' + yPos + 'px, 0px)' 
				});
            }
            
            /* fade in navbar bg */
            if ($('#navbar-bg').data('transparent-bar') === true) {
				if ($(menu).css('opacity') != 1) {
					/* get opacity */
					var headerBarOpacity = $('#navbar-bg').data('navbar-opacity');
					if ($(this).scrollTop() >= $('.fullscreen-cover').height() - ( $('#navbar-bg').height() + 20) ) {
						$('#navbar-bg').removeClass('transparent')
										   .addClass('navbar')
										   .css('opacity',headerBarOpacity);
					} else {
						$('#navbar-bg').addClass('transparent')
										   .removeClass('navbar');
					}
				}
            }
            
            /* beam me up */
            if ($(this).scrollTop() > 400) {
                $('.to-the-top').fadeIn(700);
                
            } else {
                $('.to-the-top').fadeOut(700);
            }
        }
		
		/* resize */
		function onWindowResize(_event) {
			responsiveFullHeightMenu();
			if($('body').hasClass('dedicated-slider')) {
				responsiveProjectPanel();
			}
		}
		
        /* Beam me up */
        $('.top-button').click(function () {
            $($.browser.webkit ? "body" : "html").animate({
                scrollTop: 0
            }, 900, 'easeInOutExpo');
        });
		
		/* scroll */		
		$(window).scroll(onWindowScroll);

		/* resize */
		$(window).resize(onWindowResize);
		
        /* fade out everything on url change */
		if(!no_transitions) {
			$('.logo a, .title h1 a, .title a, .thumb a, li.menu-item a, li.page_item a, h2 a, a.more-link, .meta a, .project-panel-link, .fullscreen-cover a, .fwt-link, .secondary a, .featured a, #fullscreen-menu a, a.ce-image-link, a.cover-slider-link, a.cover-link, .view-project a').click(function (a) {
				/* no animation on ios devices */
				if($(this).attr('target') !== '_blank') {

					if(isMobile() !== true && !a.ctrlKey && a.which !== 2 && $(this).parent().hasClass('no-transition') !== true) {
						var delay;
						
						if ($(this).data('project-panel') === true) {
							$('#project-panel-header').slideUp(800, 'easeInOutExpo', function () {
								$('header').css('position', 'fixed');
								$('.overlay').css('position', 'absolute');
								$('body').removeClass('project-panel-active');
								$('.overlay').fadeOut('slow');
							});
							delay = 800;
						} else {
							delay = 0;
						}
						
						var href = $(this).attr('href');
						
						var effect = 'slide-up';
						
						showNav(effect, 900);
						
						if($(menu).is(':visible')) {
						
							// fade out menu
							$(menu).fadeOut(500, function() {
							
								// fade out overlay
								$('.overlay').transition({ opacity: 0 }, 500, 'ease');
								
								$('#content').transition({ opacity: 0 }, 500, 'ease', function() {
									window.location = href;
								});
							});
							
							
						} else {
							$('#content').transition({ opacity: 0, delay: delay }, 700, 'ease', function() {
								window.location = href;
							});
						}
					
						return false;
					}
				}
			});
		}

        /* show hidden element if user using the browser back button */
        window.onunload = function(){};
    });
})(jQuery); 