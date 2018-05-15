// Requires jquery_v1.4.2.min.js

$(function() {
  function gotoTab(nav_element) {
    nav_element = $(nav_element);
    if( nav_element.length == 0 )
      return false;
    var slide = $(nav_element.attr('href'));
    if( slide.length == 0 )
      return false;

    $('#about_slider > h2.selected').removeClass('selected');
    nav_element.closest('h2').addClass('selected');
   
    $('#about_slider > div:not(:hidden)').animate({
        top: '50px',
        opacity: 'hide'
      }, 400);
    slide.stop();
    slide.css({ top: 0 });
    slide.fadeIn(700);

    return false;
  }
  $('#about_slider > h2 > a[href]').click(function(e) {
    return gotoTab(this);
  });
});
