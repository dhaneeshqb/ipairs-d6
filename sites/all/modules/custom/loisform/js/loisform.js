// $Id: loisform.js,v 1.1.2.5 2010/08/30 16:58:02 quicksketch Exp $

/**
 * JavaScript behaviors for the front-end display of loisforms.
 */

(function ($) {

Drupal.behaviors.loisform = function(context) {
  // Calendar datepicker behavior.
  Drupal.loisform.datepicker(context);
};

Drupal.loisform = Drupal.loisform || {};

Drupal.loisform.datepicker = function(context) {
  $('div.loisform-datepicker').each(function() {
    var $loisformDatepicker = $(this);
    var $calendar = $loisformDatepicker.find('input.loisform-calendar');
    var startYear = $calendar[0].className.replace(/.*loisform-calendar-start-(\d+).*/, '$1');
    var endYear = $calendar[0].className.replace(/.*loisform-calendar-end-(\d+).*/, '$1');
    var firstDay = $calendar[0].className.replace(/.*loisform-calendar-day-(\d).*/, '$1');

    // Ensure that start comes before end for datepicker.
    if (startYear > endYear) {
      var greaterYear = startYear;
      startYear = endYear;
      endYear = greaterYear;
    }

    // Set up the jQuery datepicker element.
    $calendar.datepicker({
      dateFormat: 'yy-mm-dd',
      yearRange: startYear + ':' + endYear,
      firstDay: parseInt(firstDay),
      onSelect: function(dateText, inst) {
        var date = dateText.split('-');
        $loisformDatepicker.find('select.year, input.year').val(+date[0]);
        $loisformDatepicker.find('select.month').val(+date[1]);
        $loisformDatepicker.find('select.day').val(+date[2]);
      },
      beforeShow: function(input, inst) {
        // Get the select list values.
        var year = $loisformDatepicker.find('select.year, input.year').val();
        var month = $loisformDatepicker.find('select.month').val();
        var day = $loisformDatepicker.find('select.day').val();

        // If empty, default to the current year/month/day in the popup.
        var today = new Date();
        year = year ? year : today.getFullYear();
        month = month ? month : today.getMonth() + 1;
        day = day ? day : today.getDate();

        // jQuery UI Datepicker will read the input field and base its date off
        // of that, even though in our case the input field is a button.
        $(input).val(year + '-' + month + '-' + day);
      }
    });

    // Prevent the calendar button from submitting the form.
    $calendar.click(function(event) {
      $(this).focus();
      event.preventDefault();
    });
  });
}

})(jQuery);