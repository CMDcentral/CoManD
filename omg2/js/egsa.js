$(window).load(function() {
        $('.ds').each(function() {
	    $(this).dropShadow();
	});

	Cufon.replace('h1');
        Cufon.replace('h2');
        Cufon.replace('h3');

 $('#slider').nivoSlider({
        effect:'sliceDown', // Specify sets like: 'fold,fade,sliceDown'
        slices:15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed:500, // Slide transition speed
        pauseTime:3000, // How long each slide will show
        startSlide:0, // Set starting Slide (0 index)
        directionNav:true, // Next & Prev navigation
        directionNavHide:true, // Only show on hover
        controlNav:false, // 1,2,3... navigation
        controlNavThumbs:false, // Use thumbnails for Control Nav
        controlNavThumbsFromRel:false, // Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', // Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
        keyboardNav:true, // Use left & right arrows
        pauseOnHover:true, // Stop animation while hovering
        manualAdvance:false, // Force manual transitions
        captionOpacity:0.8, // Universal caption opacity
        prevText: 'Prev', // Prev directionNav text
        nextText: 'Next', // Next directionNav text
        beforeChange: function(){}, // Triggers before a slide transition
        afterChange: function(){}, // Triggers after a slide transition
        slideshowEnd: function(){}, // Triggers after all slides have been shown
        lastSlide: function(){}, // Triggers when last slide is shown
        afterLoad: function(){} // Triggers when slider has loaded
    });
});

    $(document).ready(function() {
        $('img').each(function() {
            $(this).hover(function() {
                $(this).stop().animate({ opacity: 0.5 }, 500);
            },
           function() {
               $(this).stop().animate({ opacity: 1.0 }, 500);
           });
        });

	$(function(){
                       //$('form').jqTransform({imgPath:'/forms/jqtransform/jqtransformplugin/img/'});
        });


    });


this.tooltip = function(){
        /* CONFIG */
                xOffset = 10;
                yOffset = 20;
                // these 2 variable determine popup's distance from the cursor
                // you might want to adjust to get the right result
        /* END CONFIG */
        $("a.tooltip").hover(function(e){
                this.t = this.title;
                this.title = "";
                $("body").append("<p id='tooltip'>"+ this.t +"</p>");
                $("#tooltip")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px")
                        .fadeIn("fast");
    },
        function(){
                this.title = this.t;
                $("#tooltip").remove();
    });
        $("a.tooltip").mousemove(function(e){
                $("#tooltip")
                        .css("top",(e.pageY - xOffset) + "px")
                        .css("left",(e.pageX + yOffset) + "px");
        });
};



// starting the script on page load
$(document).ready(function(){
        tooltip();
});


$(document).ready(function() {

$(".confirmClick").click( function() {
    if ($(this).attr('title')) {
        var question = 'Are you sure you want to delete ' + $(this).attr('title').toLowerCase() + '?';
    } else {
        var question = 'Are you sure you want to do this action?';
    }
    if ( confirm( question ) ) {
 	[removed].href = this.src;
    } else {
        return false;
    }   
});

        jQuery(function() {
                jQuery( "#tabs" ).tabs({
                        spinner: 'Retrieving data...',
                        cookie: 1,
                        ajaxOptions: {
                                error: function( xhr, status, index, anchor ) {
                                        jQuery( anchor.hash ).html("Couldn't load this tab. We'll try to fix this as soon as possible.");
                                }
                        }
                });
        });
	$(".popup").fancybox({
	        'scrolling'             : 'no',
	        'titleShow'             : true
	});

        $(function() {
                        $( "#accordion" ).accordion({
                        autoHeight: false,
                        navigation: true
                });
        });


$('#dob').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: "-70:-5", showButtonPanel: true });
$('#datepicker').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: "-70:+0", showButtonPanel: true });
$('.datepicker').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: "-70:+0", showButtonPanel: true });


if( jQuery.isFunction(jQuery.fn.ckeditor) ){
	$( '.editor' ).ckeditor();
}

});

jQuery(document).ready(function() {
        $(".video").click(function() {
                $.fancybox({
                        'padding'               : 0,
                        'autoScale'             : true,
                        'transitionIn'  : 'none',
                        'transitionOut' : 'none',
                        'title'                 : this.title,
                        'width'                 : 720,
                        'height'                : 430,
                        'href'                  : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
                        'type'                  : 'swf',
                        'swf'                   : {
                        'wmode'                         : 'transparent',
                        'allowfullscreen'	: 'true'
                        }  
                });
  
                return false;
        });


		var options = {};
		// set effect from select menu value
		$( "#addComment" ).click(function() {
		 $( "#commentForm" ).toggle( "blind", options, 500 );			
		return false;
		});


});
