$(document).ready(function(){ 
	// MENU
	var touch 	= $('#touch-menu');
	var menu 	= $('.menu');
	$(touch).on('click', function(e) {
		e.preventDefault();
		menu.slideToggle();
	});	
	$(function () {
		$("ul li").on('click', function (event) {
			$(this).children('ul').stop().slideToggle();
			event.stopPropagation();
		});
	});	
	$(window).resize(function(){
		var w = $(window).width();
		if(w > 768 && menu.is(':hidden')) {
			menu.removeAttr('style');
		}
	});
	
	// FOOTER
	function toggle_visibility(id) {
	 $(id).stop().animate({height:'toggle'}, 500);
	}	
	$('.clicker').on('click', function() {
	 toggle_visibility('#' + $(this).attr('name'));
	});	
	$("#open").css('display','none');	
	
	$('.clicker').on('click',function(){	
		var span = $('.clicker')		
		if(span.hasClass('up')){
			span.removeClass('up');
		}
		else
		{
			span.addClass('up');
		}
							  
	})
	
	// MARGIN TOP
	var topSpace = $('#header').height()
	$('#body').css('padding-top', topSpace + 10)
	
	$.fn.raty.defaults.path = 'images/raty';
	$('#halfShow-true').raty({ score: 3.26 });
		
		//COLORBOX
		$(".job").colorbox({
			inline:true,
			width:"32.5%"
		});
		
		// Responsive Footer With Accordion
		var winIsSmall;
		$(window).on('load resize', footerAccordion );

		function footerAccordion() {
		    winIsSmall = window.innerWidth < 601;
		    $('#footer .collapse').toggle(!winIsSmall);
		}	
		
		$('#footer').find('.fooHead').each(function(index, elem){
			$(elem).attr('data-elemHead', index).css('cursor', 'pointer') ;
		}).end().find('.collapse').each(function(index, elem){
			$(elem).attr('data-elemUl', index);
		});		

		$('#footer').find('.fooHead').click(function () {
		    if(winIsSmall){
				var headPosition = $(this).data('elemhead');
				$('#footer').find('.collapse').removeClass('slide').end().find('.collapse').eq(headPosition).addClass('slide');
				$('#footer').find('.collapse').slideUp().end().find('.slide').slideDown();
		    }
		});
		
	
		// TAB
		$(".tab_cont").hide(); //Hide all content
		$("ul.postTab li:first").addClass("active").show(); //Activate first tab
		$(".tab_cont:first").show(); //Show first tab content
	
		//On Click Event
		$("ul.postTab li").click(function() {
			$("ul.postTab li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_cont").hide(); //Hide all tab content
			var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active content
			return false; 
		});
		
		// DATE PICKER
		new Pikaday({field: document.getElementById('datepicker-auto')});
		
		// CHAT DEMO
		$("#chatData").focus(); 
  		$('<audio id="chatAudio"><source src="sound/notify.ogg" type="audio/ogg"><source src="sound/notify.mp3" type="audio/mpeg"><source src="sound/notify.wav" type="audio/wav"></audio>').appendTo('body');
		$("#trig").on("click",function(){
			var a = $("#chatData").val().trim();
			if(a.length > 0){
				$("#chatData").val('');   
				$("#chatData").focus(); 
				$("<li></li>").html('<img src="images/amit-tambe-linked.jpg"/><span>'+a+'</span>').appendTo("#chatMessages");
				$("#chat").animate({"scrollTop": $('#chat')[0].scrollHeight}, "slow");
				$('#chatAudio')[0].play();
		}
		});
});
	
$(window).load(function(){		
// init Isotope
    var $grid = $('#masonry-list').isotope({
      itemSelector: '.item'
      //layoutMode: 'fitRows'
    });
	 var $grid1 = $('#about-list').isotope({
      itemSelector: '.about_item'
      //layoutMode: 'fitRows'
    });
    // filter functions
    var filterFns = {
      // show if number is greater than 50
      numberGreaterThan50: function() {
        var number = $(this).find('.number').text();
        return parseInt( number, 10 ) > 50;
      },
      // show if name ends with -ium
      ium: function() {
        var name = $(this).find('.name').text();
        return name.match( /ium$/ );
      }
    };
    // bind filter on select change
    $('.filters-select').on( 'change', function() {
      // get filter value from option value
      var filterValue = this.value;
      // use filterFn if matches value
      filterValue = filterFns[ filterValue ] || filterValue;
      $grid.isotope({ filter: filterValue });
    });
});
var icons = {
	"faq_close":"fa-plus-square",
	"faq_open":"fa-minus-square"
};

// EQUAl HEIGHT
(function($){
	function fixButtonHeights() {
		var heights = new Array();
		
		// Loop to get all element heights
		$('.equalHeight').each(function() {	
			// Need to let sizes be whatever they want so no overflow on resize
			$(this).css('min-height', '0');
			$(this).css('max-height', 'none');
			$(this).css('height', 'auto');
			
			// Then add size (no units) to array
			heights.push($(this).height());
		});
		
		// Find max height of all elements
		var max = Math.max.apply( Math, heights);
		
		// Set all heights to max height
		$('.equalHeight').each(function() {
			$(this).css('height', max + 'px');
			// Note: IF box-sizing is border-box, would need to manually add border and padding to height (or tallest element will overflow by amount of vertical border + vertical padding)
		});	
	}
	
	$( document ).ready(function() {
		// Fix heights on page load
		fixButtonHeights();
		
		// Fix heights on window resize
		$(window).resize(function() {
			// Needs to be a timeout function so it doesn't fire every ms of resize
			setTimeout(function() {
				fixButtonHeights();
			}, 120);
		});






	});
})(jQuery);

