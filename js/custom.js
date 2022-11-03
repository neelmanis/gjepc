jQuery(document).ready(function($){
	//open the Menu panel
	$('.cd-btn').on('click', function(event){
		event.preventDefault();
		$('.cd-panel').addClass('is-visible');
		$('body').css('overflow','hidden');
	});
	//clode the Menu panel
	$('.cd-panel').on('click', function(event){
		if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) { 
			$('.cd-panel').removeClass('is-visible');
			$('body').css('overflow','visible');
			event.preventDefault();
		}
	});

	// ACCORDION MENU
	$(".cd-menu").vmenuModule({
		Speed: 200,
		autostart: false,
		autohide: true
	});
	
	// ISOTOPE
	 setInterval(function() {
		 $('.isotope').isotope({
			layoutMode: 'packery',
			itemSelector: '.grid'
		});	
	}, 1000);	
	
	// CAROUSEL
	$(".carousel").carouselTicker();


	//trade_show,events,institutes.php etc.
	if (jQuery(window).width()>=768) {
	  jQuery(".showData").each(function(index, el) {
	      var showBoxnewHeight = jQuery(this).outerHeight();
	      jQuery(this).closest('.showbox').height(showBoxnewHeight);
	      console.log(showBoxnewHeight);
	      var showBoxnewHeight = 0;
	  });      
	}


	jQuery("ul.whtsdLinks").append('<li><a href="https://gjepc.org/pdf/notice.pdf">Advisory on Circulation of Fraudulent Email Circulations</a></li>');

	
});

$(document).ready(function(){

	$(".slidingDiv").hide();
	$(".show_hide").show();

	jQuery(".show_hide").click(function(event) {
		event.preventDefault();
		// jQuery(".slidingDiv").slideUp('slow');
		jQuery(this).next(".slidingDiv").slideToggle();
	});



});

function showSpeaker(speakerID){
	jQuery(".speaker").slideUp();
	jQuery("."+speakerID).slideDown();
	console.log(speakerID);
}
