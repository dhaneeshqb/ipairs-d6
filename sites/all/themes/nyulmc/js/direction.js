// Requires jquery_v1.4.2.min.js

$(function() {
					 
  $('div.display-directions > div.field-content:not(.selected)').hide();

  $('div.display-directions > div.field-content').each(function(index) {
																																
    var tab = $(this).prev();
    var href = tab.find('a').attr('href');

		if (href.length < 1)
		return false;
		
		// This matches Drupal View > display_directions > Customfield PHP Code declaration
		href = href.replace(/[^a-z-]/g, '');
		
		$(this).attr('id', href);		
		
  });
	
	var tab = $('div.display-directions > h2.selected');
	
  if (tab.length < 1 ) {
    $('div.display-directions > h2:first').addClass('selected');
		$('div.display-directions > div.field-content:first').show();
	}
	
  $('div.display-directions').prepend($('div.display-directions > h2'));
  $('div.display-directions > h2').wrapAll('<div id="direction-tabs" />');
	
  $('div.display-directions > div#direction-tabs > h2 > a[href]').click(function(e) {
    return gotoTab(this);
  });
	
	
	
  function gotoTab(nav_element) {
  	var element = $(nav_element);
    if (element.length == 0)
      return false;
      
    var href = element.attr('href');
    //alert(href);
		if (href.length < 1)
  		return false;
  	
  	href = href.replace(/[^a-z-]/g, '');
  	//alert(href);
  	
  	$('div.display-directions > div#direction-tabs > h2.selected').removeClass('selected');
  	$('div.display-directions div.field-content').hide();
  	$(element).parent('h2').addClass('selected');
  	$('div.display-directions > div#'+href).show();
  	
  	return false;
  }
		
});