	jQuery(window).bind("load", function() {
		jQuery("#intro.slabheader").slabText({
            // Don't slabtext the headers if the viewport is under 380px
            "viewportBreakpoint":380
        });

		jQuery("#intro.slabheader").show();
	});

	jQuery('.menu-toggle').click(function() {
		jQuery('#mainnav').toggleClass('show');
	});
