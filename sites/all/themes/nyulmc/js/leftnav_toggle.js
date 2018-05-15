$(function() {

  $('#leftNav > li:not(.active-trail) > ol').hide()

  $('#leftNav > li:not(.active-trail) > span.nav_toggle > a').addClass('collapsed');
  $('#leftNav > li:not(.active-trail)').addClass('collapsed');
  $('#leftNav > li:not(.active-trail)').removeClass('expanded');

  $('#leftNav > li > ol a.active').each(function() {

    var node = $(this);

    while( node.length > 0 ) {
			
			// was throwing a "node.closest is not a function" error.  I'm not sure what was going on,
			// but at lesat we can trap the error.  Maybe if there aren't any menu items at the same level?
			if (typeof node.closest != 'function') { return; }

			var li = node.closest('li');

			if( li.length == 0 )
				return;

			var sibsWithChildren = li.siblings().has('ul');

			sibsWithChildren.children('ul').hide();
		
			node = li.parent();
    }
  });
});


$(function() {
	$("li.hasChildren > span > a").click(function() {
		var ol = $(this).parent().nextAll("ol");
		if(!ol) return false;
		ol.slideToggle();
		if ($(this).hasClass('collapsed'))
			$(this).removeClass('collapsed')
		else
			$(this).addClass('collapsed')
		return false;
	});
});
