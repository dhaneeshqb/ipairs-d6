// $Id: select-admin.js,v 1.1.2.1 2010/04/10 22:02:08 quicksketch Exp $

/**
 * @file
 * Enhancements for select list configuration options.
 */

(function ($) {

Drupal.behaviors.loisformSelectLoadOptions = function(context) {
  settings = Drupal.settings;

  $('#edit-extra-options-source', context).change(function() {
    var url = settings.loisform.selectOptionsUrl + '/' + this.value;
    $.ajax({
      url: url,
      success: Drupal.loisform.selectOptionsLoad,
      dataType: 'json'
    });
  });
}

Drupal.loisform = Drupal.loisform || {};

Drupal.loisform.selectOptionsOriginal = false;
Drupal.loisform.selectOptionsLoad = function(result) {
  if (Drupal.optionsElement) {
    if (result.options) {
      // Save the current select options the first time a new list is chosen.
      if (Drupal.loisform.selectOptionsOriginal === false) {
        Drupal.loisform.selectOptionsOriginal = $(Drupal.optionElements[result.elementId].manualOptionsElement).val();
      }
      $(Drupal.optionElements[result.elementId].manualOptionsElement).val(result.options);
      Drupal.optionElements[result.elementId].disable();
      Drupal.optionElements[result.elementId].updateWidgetElements();
    }
    else {
      Drupal.optionElements[result.elementId].enable();
      if (Drupal.loisform.selectOptionsOriginal) {
        $(Drupal.optionElements[result.elementId].manualOptionsElement).val(Drupal.loisform.selectOptionsOriginal);
        Drupal.optionElements[result.elementId].updateWidgetElements();
        Drupal.loisform.selectOptionsOriginal = false;
      }
    }
  }
  else {
    if (result.options) {
      $('#' + result.elementId).val(result.options).attr('readonly', 'readonly');
    }
    else {
      $('#' + result.elementId).attr('readonly', '');
    }
  }
}

})(jQuery);
