// $Id: date_repeat_presets.js,v 1.1 2010/11/13 23:17:10 chaps2 Exp $

Drupal.behaviors.date_repeat_presets = function(context) {
  $('.date-repeat-presets-custom').each(function() {
    var fieldsetId = $(this).attr('id');

    $('#'+fieldsetId+' > fieldset > .form-item:not(drp-processed)')
    .addClass('drp-processed')
    // alter legend text of fieldset
    .filter(':has(option[value=custom],[value=custom])')
    .parents('fieldset:first').find('> legend').text(Drupal.t('Custom repeat options')).end().end().end()
    // initial custom form hide if custom is not set
    .filter(':has(option[value!=custom]:selected,[value!=custom]:checked)')
    .parents('fieldset:first').hide().addClass('collapsed').find('> legend').text(Drupal.t('Custom repeat options')).end().end().end()
    // move preset selection outside the custom form
    .remove().prependTo('#'+fieldsetId)
    // add change event handler to show/hide custom form
    .find(':input')
    .change(function() {
      if(this.value == 'custom') {
        // fieldset show
        $('#'+fieldsetId+' > fieldset').show();
        // trigger un-collapse
        $('#'+fieldsetId+' > fieldset.collapsed').find(' > legend > a').click();
      } else {
        // trigger collapse - queue the fieldset hide so the collapse animation isn't interrupted
        $('#'+fieldsetId+' > fieldset:not(.collapsed)').find(' > legend > a').click().end()
        .find('> div:not(.action)').animate({opacity: 1}, 1, function() {
          $('#'+fieldsetId+' > fieldset').hide();
        });
      }
    });
  });
}