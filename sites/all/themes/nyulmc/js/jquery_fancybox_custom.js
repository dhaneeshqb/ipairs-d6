

/*========== FancyBox Customizations ==========*/

$(document).ready(function() {
	
	// add class="fbox"
	// default fbox settings
	$(".fbox").fancybox({
		'transitionIn'				: 'fade',
		'transitionOut'				: 'fade',
		'speedIn'							: 600,
		'speedOut'						: 300,
		'overlayOpacity'			: 0.4,
		'overlayColor'				: '#260240'
	});
	
	// add class="fbox_inline"
	// auto-size fbox for inline content - the content div to be displayed must have dimensions set with CSS
	$(".fbox_inline").fancybox({
		//'autoDimensions'			: false,
		'width'								: 680,
		'height'							: 460,
		'autoScale'						: false,
		'transitionIn'				: 'fade',
		'transitionOut'				: 'fade',
		'speedIn'							: 600,
		'speedOut'						: 300,
		'overlayShow'					: true,
		'padding'							: 20,
		'hideOnContentClick'	: false,
		'titleShow'						: false,
		'overlayOpacity'			: 0.4,
		'overlayColor'				: '#260240'
	});
	
	// add class="fbox_inline_fixed_size"
	// a fixed size version for inline fbox content - set to 680px:460px
	$(".fbox_inline_fixed_size").fancybox({
		'autoDimensions'			: false,
		'width'								: 680,
		'height'							: 460,
		'autoScale'						: false,
		'transitionIn'				: 'fade',
		'transitionOut'				: 'fade',
		'speedIn'							: 600,
		'speedOut'						: 300,
		'overlayShow'					: false,
		'padding'							: 20,
		'hideOnContentClick'	: false,
		'titleShow'						: false
	});
	
	// add class="fbox_iframe"
	// default settings for fbox content in an iFrame
	$(".fbox_iframe").fancybox({
		'width'								: '75%',
		'height'							: '75%',
		'autoScale'						: false,
		'transitionIn'				: 'none',
		'transitionOut'				: 'none',
		'type'								: 'iframe',
		'titleShow'						: false
	});
	
	// add class="fbox_video_610x343"
	// fbox for use with a dynamic flash video player on this site (plays .mp4 & .flv videos)
	// for this funtion we're standardizing the dimensions: 610px : 343px, but the vid. player's size is dynamic
	$(".fbox_video_610x343").fancybox({
		'autoDimensions'			: false,
		'width'								: 610,
		'height'							: 343,
		// this script centers the box using javascript (rather than css), which makes it jumpy on some browsers.
		// disabling the vertical centering for now because of that
		//'centerOnScroll'			: true,
		'transitionIn'				:	'fade',
		'transitionOut'				:	'fade',
		'speedIn'							:	200, 
		'speedOut'						:	200, 
		'hideOnContentClick'	: false,
		'padding'							: 5,
		'overlayShow'					: true,
		'overlayOpacity'			: 0.8,
		'overlayColor'				: '#260240',
		'type'								: 'swf',
		'swf'									: {wmode: 'opaque', allowFullScreen:'true', allowScriptAccess:'always'},
		'titleShow'						: false
	});

});