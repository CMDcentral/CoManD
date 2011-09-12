$(document).ready(function(){

	// start Superfish for header menu and customization options
		$('ul.sf-menu').superfish({ 
			delay:       0,                            // Delay on mouseout 
			animation:   {opacity:'show',height:'show',filter:'none'},   // Fade-in and slide-down animation 
			speed:       'fast'                          // Animation speed 
		}); 
	
	
	// start tweet timeline feed in footer and customization options
		$(".tweet").tweet({
			username: "envatowebdev",  // Twitter account user.
			avatar_size: 32,  // Size of avatar. Change to, null, to hide avatar
			count: 1,  //  Number of tweets to display from timeline
			loading_text: "loading tweets..."  //  Text displayed while tweet is loading
		});

    $(function()
	{
		// Call stylesheet init so that all stylesheet changing functions
		// will work.
		$.stylesheetInit();

		// This code loops through the stylesheets when you click the link with
		// an ID of "toggler" below.
		$('#toggler').bind(
			'click',
			function(e)
			{
				$.stylesheetToggle();
				return false;
			}
		);

		// When one of the styleswitch links is clicked then switch the stylesheet to
		// the one matching the value of that links rel attribute.
		$('.styleswitch').bind(
			'click',
			function(e)
			{
				$.stylesheetSwitch(this.getAttribute('rel'));
				return false;
			}
		);
	}
);

});  