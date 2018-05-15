
$(function () {
    
			$('#block-views-display_milestones-block_1').anythingSlider({
				easing: 							"easeInOutExpo", 	// Anything other than "linear" or "swing" requires the easing plugin
				autoPlay: 						false,            // This turns off the entire FUNCTIONALY, not just if it starts running or not.
				animationTime: 				1000,            	// How long the slide transition takes
        hashTags:             false,
				buildNavigation: 			true          		// If true, builds and list of anchor links to link to each slide
			});
      // Navigation is a problem for this slider, since it's nothing close to what we want
      // We manually control the left and right buttons, which are pre rendered for us,
      // Finally, we move the rendered by anythingslider navigation up to where the buttons are.
			var as = $('#block-views-display_milestones-block_1').data('AnythingSlider');
      $('#block-views-display_milestones-block_1').find('a.pagination-next').click(function(e) {
        as.goForward();
        return false;
      });
      $('#block-views-display_milestones-block_1').find('a.pagination-prev').click(function(e) {
        as.goBack();
        return false;
      });
      $('.nav-holder').append($('#thumbNav > a').detach());
      as.$nav = $('.nav-holder');
    });

//hello