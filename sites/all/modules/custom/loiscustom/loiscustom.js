// altering the loisform to put instructions up higher (giving it a low weight) is not working, no matter what I do.
// so I'm having javascript do this one thing. desperately want to take this out.
function moveInstructions(context) {
    $('#loisform-components-form fieldset').prependTo('#webform-components-form');
}

// trying to figure out a good way to hide the 'Results" tab on the event node pages
// without disabling them entirely. 
function alterSurveyResultsLink(context) {
    var link;
    $('ul.primary li a').each(function() {
        link = $(this).attr('href')
        if (link.indexOf("loisform-results") >= 0) {
            $(this).hide();
        }
    });
}

Drupal.behaviors.initLoisCustom = function(context) {
    moveInstructions(context);
    alterSurveyResultsLink(context);
}