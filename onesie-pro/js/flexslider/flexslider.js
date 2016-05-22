/*
 * jQuery FlexSlider v2.2.0
 * Copyright 2012 WooThemes
 * Contributing Author: Tyler Smith
 */
jQuery(function($) {
	$(window).load(function() {
		$('.flexsliders').flexslider({
			animation: "fade",
			animationSpeed: 1300,
			slideshow: false,
			directionNav: false,
	    controlNav: "thumbnails"
		});
	});
});