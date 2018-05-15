		$(function () {
    
			$('.slider').anythingSlider({
				easing: 							"easeInOutExpo", 	// Anything other than "linear" or "swing" requires the easing plugin
				autoPlay: 						true,            // This turns off the entire FUNCTIONALY, not just if it starts running or not.
				delay: 7000,
				animationTime: 				1000,            	// How long the slide transition takes
        hashTags:             false,
				buildNavigation: 			true          		// If true, builds and list of anchor links to link to each slide
			});
    });
