<footer>
  
    <div class="container">   
     
      <div class="foot_box_wrp">  
          
          <div class="row">       
           
           		<div class="col-12 mb-3 ">       
                    <ul class="d-flex justify-content-center social">
                        <li><a class="facebook" href="" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a class="twitter" href="" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a class="instagram" href="" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a class="linkedin" href="" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>                
                                  
        		</div>
                
                <div class="col-md-12 mb-3  col-lg foot_box">                
                    <ul class="foot_list">
                        <li><a href="careers.php">Careers</a></li>
                        <li><a href="holiday-list.php">Holiday List</a></li>
                        <li><a href="tenders.php">Tenders</a></li>
                        <li><a href="https://survey.jamoutsourcing.com/gjepc_new/index.php/complaint/complaint" target="_blank">Helpdesk</a></li>
                        <li><a href="contact-us.php">Contact Us</a></li>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    </ul>                    
                </div>
                
                <div class="col-12 text-center copyright">       
        Copyright &copy; 2020 GJEPC Content - Karsin | Designed & Developed by <a href="https://www.kwebmaker.com/" target="_blank"> Kwebmaker™ </a>        
        </div>
            
           </div>
        
              
        </div>        
    </div>    
</footer> <!-- footer -->

<script src="assets/js/jquery.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/slick-animation.min.js" defer></script>
<script src="assets/js/popper.min.js"></script> 
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" defer></script> 
<script src="assets/js/FontAwesome.js" defer></script> 
<script src="assets/js/jquery.fancybox.min.js" defer></script> 
<script src="assets/js/sticky-kit.min.js"></script>
<script src="assets/js/moment-with-locales.js"></script> 
<script src="assets/js/datepicker.js" defer></script>
<script src="assets/js/general.js" defer></script> 

<script type="text/javascript">


// onload popup
//$(window).load(function(){
//if(localStorage.getItem('modalshown')==null ){
//	$("#myModal").modal('show');
//	backdrop: 'static';
//	keyboard: false;
//	localStorage.setItem('modalshown','yes');
//}
//else{
//	
//	
//	}
//	});
	
// banner slider
window.onload=function(){$(".banner_slider").slick({autoplay:!0,fade:!1,speed:1200,arrows:!1,dots:!1,responsive:[{breakpoint:991,settings:{dots:!1}}]}).slickAnimation();};


// news slider
$(".news_slider").slick({
	slidesToShow:4,
	slidesToScroll:1,
	autoplay:!1,
	autoplaySpeed:2e3,
	responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
  adaptiveHeight: true
      }
    }
   
 
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
	});

// event slider
$(".event_slider").slick({slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!1,dots:!0,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});

// logo ticker slider
$(".logo_ticker").slick({slidesToShow:5,slidesToScroll:1,autoplay:!0,autoplaySpeed:2000,arrows:!1,dots:!1,pauseOnHover:!0,responsive:[{breakpoint:768,settings:{slidesToShow:4}},{breakpoint:600,settings:{slidesToShow:2}}]});

// $('[data-toggle="tooltip"]').tooltip();

$("[data-sticky_column]").stick_in_parent({parent:"[data-sticky_parent]",offset_top:10});

$('.tab-content').on('shown.bs.collapse', function () {  
  var panel = $(this).find('[aria-expanded="true"]');  
  $('html, body').animate({
        scrollTop: panel.offset().top-15
  }, 500);  
});

$(".right_box_submenu").click(function(){
  $(this).children('ul').slideToggle();
  $(this).children('ul').parent('li').siblings().children('ul').slideUp();
  $(this).toggleClass("right_box_submenuactive");
});

 $(window).width() < 768 && jQuery(".right_box h2").click(function(e) {
  $(".right_box_list").slideToggle();
});
  
$(".app_slider").slick({slidesToShow:1,slidesToScroll:1,autoplay:!0, fade:true, speed:1500, autoplaySpeed:1500,arrows:!1,dots:!1,});
  
// inner_video slider
$(".inner_video").slick({slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!1,dots:!0,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});

$(".inner_slider").slick({slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:2000,arrows:!0,dots:!1,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});



$(window).load(function(){
    $('.facebook').attr('href','https://www.facebook.com/GJEPC');
    $('.twitter').attr('href','https://twitter.com/GJEPCIndia');
    $('.instagram').attr('href','https://www.instagram.com/gjepcindia/?hl=en');
    $('.linkedin').attr('href','https://www.linkedin.com/in/sabyaray/');
    $('#youtubeLink1').attr('href','https://www.youtube.com/watch?list=PL54gOXLucCYf0z_fuu0xZgd07Juh6ESI1&amp;v=YXBy0B_od0c');
    $('#youtubeLink2').attr('href','https://www.youtube.com/watch?v=bqbdTqc7VVA&amp;feature=youtu.be');
});


</script>

<noscript>
<meta http-equiv="refresh" content="0.0;url=404.php">
<p>Are you using a browser that doesn't support JavaScript?</p><br><br>
<p>If your browser does not support JavaScript, you can upgrade to a newer browser</p><br><br>
<p>If you have disabled JavaScript, you must re-enable JavaScript to use this page. To enable JavaScript</p>
</noscript>
</body>
</html>