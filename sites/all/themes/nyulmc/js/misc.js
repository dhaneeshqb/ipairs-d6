/**
 * We don't like the printemail module's print function.  It takes you to a new page, gets interfered with by popup blockers, doesn't let you get
 * back properly...
 *
 * So we just want the link to be "window.print()" with a print stylesheet.
 *
 * But we're leaving the module around for display purposes.
 *
 * And there seems to be a bug in printemail which doesn't let you select it with a simple class selector, because it can't get one.
 * 
 * So this is a trifle kludgey.
 */

$(document).ready(function() {
	$('#node_links li.first a').attr("href", "#");
	
	$('#node_links li.first a').click(function() {
	  window.print();
	});
	
	//
	// Also add a hover class for a view.  TODO: abstract this and put it in another JS file!
	//
	
	$('.view-display-media-spotlight td').hover(
		function () {
			$(this).addClass("hover");
			$(this).siblings().addClass("hover");
		},
		function () {
			$(this).removeClass("hover");
			$(this).siblings().removeClass("hover");
		}
	);
	
	if ($.browser.msie) { $('.hoverteasercontainer').css('position', 'static'); }

	$('.view-display-news td').hoverIntent(
		function () {
			if ($.browser.msie && $(this).find('.hoverteaser').length > 0) {
				$(this).css("position", "relative");
				$(this).siblings().css("position", "relative");
				$(this).css("min-height", "0");
				$(this).siblings().css("min-height", "0");
			}
			
			$(this).addClass("hover");
			$(this).siblings().addClass("hover");
			$(this).find('.hoverteaser').show();
		},
		function () {
			if ($.browser.msie && $(this).find('.hoverteaser').length > 0) {
				$(this).css("position", "static");
				$(this).siblings().css("position", "static");
				$(this).css("min-height", "0");
				$(this).siblings().css("min-height", "0");
			}
			
			$(this).removeClass("hover");
			$(this).siblings().removeClass("hover");
			$(this).find('.hoverteaser').hide();
		}
	);
	
	//
	// Add showhide links
	//
	
	$(".showhide_link").click( function() {
		$(this).parent().parent().next('.showhide').toggle('fast');
		
		if ($(this).parent().next('.showhide_toggle').hasClass('expanded')) {
			$(this).parent().next('.showhide_toggle').removeClass('expanded');
		} else { 
			$(this).parent().next('.showhide_toggle').addClass('expanded');
		}
		
		return false;
	});
	
	//
	// Show the first
	//
	
	$(".showhide_link:first").parent().parent().next('.showhide').show();
	$(".showhide_link:first").parent().next('.showhide_toggle').addClass('expanded');
	
});
