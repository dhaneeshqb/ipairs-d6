
function formatText(index, panel) {
	  	return index + "";
}
  
$(function () {
    
			$('.slider').anythingSlider({
				easing: 							"easeInOutExpo", 	// Anything other than "linear" or "swing" requires the easing plugin
				autoPlay: 						true,            // This turns off the entire FUNCTIONALY, not just if it starts running or not.
				delay: 								7000,             // How long between slide transitions in AutoPlay mode
				startStopped: 				false,            // If autoPlay is on, this can force it to start stopped
				animationTime: 				1000,            	// How long the slide transition takes
				hashTags: 						true,             // Should links change the hashtag in the URL?
				buildNavigation: 			true,          		// If true, builds and list of anchor links to link to each slide
				pauseOnHover: 				true,             // If true, and autoPlay is enabled, the show will pause on hover
				startText: 						"Go",             // Start text
				stopText: 						"Stop",						// Stop text
				navigationFormatter: 	formatText 				// Details at the top of the file on this use (advanced use)
			});
			
      // Monkey patch so we can have a custom effect
      var as = $('.slider').data("AnythingSlider");
      var asSetCurrentPage = as.setCurrentPage;

      as.gotoPage = function(page, autoplay) {
        // When autoplay isn't passed, we stop the timer
        if(autoplay !== true) autoplay = false;
        if(!autoplay) as.startStop(false);

        // Just check for bounds
        if(page > as.pages) page = 1;
        if(page < 1 ) page = as.pages;

        // animate here
        if( as.currentPage != page ) {
          var oldEl = $(as.$items[as.currentPage]);
          var newEl = $(as.$items[page]);

          // To handle interrupting the animation, first we hide all animating elements.
          // One of these is the previously hiding slide, which we don't have a pointer to anymore.
          as.$items.filter(':animated').hide();
          // Next we take the slide that is currently trying to appear and finish it's animation manually.
          oldEl.stop().css({ opacity: 1});

          // Finally, we can just do our animation
          oldEl.fadeOut(as.options.animationTime / 5);
          newEl.css({ top: 0, 'z-index': 1 });
          newEl.fadeIn(as.options.animationTime);
        }

        as.setCurrentPage(page, false);
      }
      as.setCurrentPage = function(page, move) {
        var oldEl = $(as.$items[as.currentPage]);
        var newEl = $(as.$items[page]);

        asSetCurrentPage(page, false);
        if(move !== false) {
          // make it show up here, no animation
          oldEl.css({ 'z-index': '' });
          newEl.css({ 'z-index': 1, 'display': 'list-item' });
//          newEl.css({ 'display': 'list-item' });
        }
      }
      as.setCurrentPage(1, true);
});
