(function($) {
    "use strict";
	$(window).on("scroll", function(e){
    if ($(window).scrollTop() >= 66) {
        $('.ren-navbar').addClass('fixed-header');
        $('.ren-navbar').addClass('visible-title');
    }
    else {
        $('.ren-navbar').removeClass('fixed-header');
        $('.ren-navbar').removeClass('visible-title');
    }
    });
	// ______________ PAGE LOADING
	$(window).on("load", function(e) {
		$("#global-loader").fadeOut("slow");
		
		// ______________ countUp
		$('.counter').countUp();
		
			
	// ______________ Vector Map
	// 	jQuery( '#vmap' ).vectorMap( {
	// 		map: 'world_en',
	// 		backgroundColor: null,
	// 		color: '#ffffff',
	// 		hoverOpacity: 0.7,
	// 		selectedColor: '#1de9b6',
	// 		enableZoom: true,
	// 		showTooltip: true,
	// 		values: sample_data,
	// 		scaleColors: [ '#1de9b6', '#03a9f5' ],
	// 		normalizeFunction: 'polynomial'
	// 	} );
	})
	
	
	// ______________ BACK TO TOP BUTTON

	$(window).on("scroll", function(e) {
    	if ($(this).scrollTop() > 300) {
            $('#back-to-top').fadeIn('slow');
        } else {
            $('#back-to-top').fadeOut('slow');
        }
    });

    $("#back-to-top").on("click", function(e){
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
	var ratingOptions = {
		selectors: {
			starsSelector: '.rating-stars',
			starSelector: '.rating-star',
			starActiveClass: 'is--active',
			starHoverClass: 'is--hover',
			starNoHoverClass: 'is--no-hover',
			targetFormElementSelector: '.rating-value'
		}
	};
	$(".vscroll").mCustomScrollbar();
	$(".app-sidebar").mCustomScrollbar({
		theme:"minimal",
		autoHideScrollbar: true
	});
	$(".rating-stars").ratingStars(ratingOptions);
})(jQuery);

$(function(e) {
		  /** Constant div card */
	  const DIV_CARD = 'div.card';
	  /** Initialize tooltips */
	  $('[data-toggle="tooltip"]').tooltip();

	  /** Initialize popovers */
	  $('[data-toggle="popover"]').popover({
		html: true
	  });
			 /** Function for remove card */
	  $('[data-toggle="card-remove"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);

		$card.remove();

		e.preventDefault();
		return false;
	  });

	  /** Function for collapse card */
	  $('[data-toggle="card-collapse"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);

		$card.toggleClass('card-collapsed');

		e.preventDefault();
		return false;
	  });
	  $('[data-toggle="card-fullscreen"]').on('click', function(e) {
		let $card = $(this).closest(DIV_CARD);

		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');

		e.preventDefault();
		return false;
	  });
  });

alertify.defaults = {
	// dialogs defaults
	autoReset: true,
	basic: false,
	closable: true,
	closableByDimmer: true,
	invokeOnCloseOff: false,
	frameless: false,
	defaultFocusOff: false,
	maintainFocus: true, // <== global default not per instance, applies to all dialogs
	maximizable: true,
	modal: true,
	movable: true,
	moveBounded: false,
	overflow: true,
	padding: true,
	pinnable: true,
	pinned: true,
	preventBodyShift: false, // <== global default not per instance, applies to all dialogs
	resizable: true,
	startMaximized: false,
	transition: 'fade',
	transitionOff: false,
	tabbable: 'button:not(:disabled):not(.ajs-reset),[href]:not(:disabled):not(.ajs-reset),input:not(:disabled):not(.ajs-reset),select:not(:disabled):not(.ajs-reset),textarea:not(:disabled):not(.ajs-reset),[tabindex]:not([tabindex^="-"]):not(:disabled):not(.ajs-reset)',  // <== global default not per instance, applies to all dialogs

	// notifier defaults
	notifier: {
		// auto-dismiss wait time (in seconds)
		delay: 3,
		// default position
		position: 'bottom-right',
		// adds a close button to notifier messages
		closeButton: false,
		// provides the ability to rename notifier classes
		classes: {
			base: 'alertify-notifier',
			prefix: 'ajs-',
			message: 'ajs-message',
			top: 'ajs-top',
			right: 'ajs-right',
			bottom: 'ajs-bottom',
			left: 'ajs-left',
			center: 'ajs-center',
			visible: 'ajs-visible',
			hidden: 'ajs-hidden',
			close: 'ajs-close'
		}
	},

	// language resources
	glossary: {
		// dialogs default title
		title: 'AlertifyJS',
		// ok button text
		ok: 'OK',
		// cancel button text
		cancel: 'Cancel'
	},

	// theme settings
	theme: {
		// class name attached to prompt dialog input textbox.
		input: 'ajs-input',
		// class name attached to ok button
		ok: 'ajs-ok',
		// class name attached to cancel button
		cancel: 'ajs-cancel'
	},
	// global hooks
	hooks: {
		// invoked before initializing any dialog
		preinit: function (instance) {
		},
		// invoked after initializing any dialog
		postinit: function (instance) {
		},
	},
};
alertify.set('notifier', 'position', 'top-right');


