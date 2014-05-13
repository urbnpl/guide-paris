// fix for ipad resizing content on orientation change -- updated version of jeremy keith's fix
// useful for making responsive sites, if your site isn't responsive you can remove this bit of code
(function(doc) {

	var addEvent = 'addEventListener',
	type = 'gesturestart',
	qsa = 'querySelectorAll',
	scales = [1, 1],
	meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];

	function fix() {
		meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
		doc.removeEventListener(type, fix, true);
	}

	if ((meta = meta[meta.length - 1]) && addEvent in doc) {
		fix();
		scales = [0.25, 1.6];
		doc[addEvent](type, fix, true);
	}

}(document));


// DOCUMENT READY FUNCTION: uses noConflict to work with other libraries
jQuery(document).ready(function($) {


/* ::: SHOW AND HIDE ::::::::::::::::::::::::::::::::: */

	$(".toggle")
		.addClass('make-link') // make headings look like links
		.addClass('header-hidden')
		.click(function(){
			var $this = $(this);
			if( $this.is('.header-shown') ) {
				$this.next().slideToggle('normal');
				$this.removeClass('header-shown');
				$this.addClass('header-hidden');
			} else {
				$this.next().slideToggle('normal');
				$this.removeClass('header-hidden');
				$this.addClass('header-shown');
			}
		return false;
	});



/* ::: MOBILE NAV ::::::::::::::::::::::::::::::::: */

	$(function() {
		var mobileBtn = $('.icon-list');
		var menu = $('.topnav-links');
		//unused// var menuHeight  = menu.height();
		$(mobileBtn).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});
	});

	// If the browser size gets bigger than 500px make the nav visible again
	$(window).resize(function(){
		var w = $(window).width();
		var menu = $('.topnav-links');
		if(w > 900 && menu.is(':hidden')) {
			menu.css( "display", "block" );
		}
	});




// sticky nav
jQuery(document).ready(function($) {

  var winwidth = $(window).width();

  $(window).resize(function() {
      clearTimeout(this.id);
      this.id = setTimeout(doneResizing, 500);
  });

  function doneResizing(){
    if ($(window).width() != winwidth) {
      window.location.reload();
    }
  };

  if (winwidth >= 659) {

    var el = $(".nav-menu");
    var elwidthpx = el.css('width');
    var elleftmar = el.css('margin-left');
    var eltop;
    var elheight;
    var elleft = el.offset().left;

    $('<div/>').attr('id', 'clone').css('width',elwidthpx).insertAfter( $('.nav-menu') );

    var style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.sticky { position: fixed; top: 0; width: 100%; }';
    document.getElementsByTagName('head')[0].appendChild(style);

    $(window).scroll(function() {

      if (typeof eltop === "undefined" ) {
        eltop = el.offset().top;
      }
      elheight = el.outerHeight();

      var end = $(".footer");
      endtop = end.offset().top;
      var winscroll = $(window).scrollTop();

      if (winscroll > eltop) {
        $(".nav-menu").addClass('sticky');
        $(".nav-menu").css("left", elleft);
        $(".nav-menu").css("margin-left", 0);
        $('#clone').css('height',elheight);
      } else {
        $(".nav-menu").removeClass('sticky');
        $(".nav-menu").css("left", "auto");
        $(".nav-menu").css("margin-left", elleftmar);
        $('#clone').css('height',0);
      }

      if (winscroll + elheight > endtop) {
        var amount = endtop - (winscroll + elheight);
        $(".nav-menu").css("top", amount + "px");
      } else {
        var amount = endtop - (winscroll + elheight);
        $(".nav-menu").css("top", "");
      }

    });
  }

});

// scroll to anchor
				jQuery.noConflict();
				(function( $ ) {
					$(function() {
						// More code using $ as alias to jQuery
						$("area[href*=#],a[href*=#]:not([href=#]):not([href^='#tab']):not([href^='#quicktab']):not([href^='#pane'])").click(function() {
							if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
								var target = $(this.hash);
								target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
								if (target.length) {
								$('html,body').animate({
								scrollTop: target.offset().top - 20  
								},900 ,'easeInCubic');
								return false;
								}
							}
						});
					});
				})(jQuery);	
				
// nice scroll
jQuery(document).ready(function() {  
    jQuery("html").niceScroll({
	    cursorcolor:"#ff3f3f",
	    cursorwidth:"10px",
	    cursorborder:"0px",
	    cursorborderradius:"0px",
	    scrollspeed:140,
    });
});
				
});//<--- this is the end of the document ready function don't delete it