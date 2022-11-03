<footer>
  
    <div class="container">    
      <div class="foot_box_wrp">      
          <div class="row">        
                <div class="col-md-12 col-lg foot_box">                
                    <h2 class="foot_head">Quick Links <i class="fa fa-plus pull-right dropdown_icon" aria-hidden="true"></i></h2>                    
                    <ul class="foot_list">
                        <li><a href="careers.php">Careers</a></li>
                        <li><a href="holiday_list.php">Holiday List</a></li>
                        <li><a href="tenders.php">Tenders</a></li>
                        <li><a href="https://gjepc.org/helpdesk/" target="_blank">Helpdesk</a></li>
                        <li><a href="advertise.php">Advertise</a></li>
                        <li><a href="contact_us.php">Contact Us</a></li>
                        <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    </ul>                    
                </div>
            
                <div class="col-md-12 col-lg foot_box">
                    <h2 class="foot_head">Trade Shows <i class="fa fa-plus pull-right dropdown_icon" aria-hidden="true"></i></h2>
                    <ul class="foot_list">
                        <li><a href="trade_shows.php">Overview</a></li>
                        <li><a href="https://www.iijs.org/" target="_blank">Indian International Jewellery Show (IIJS)</a></li>
                        <li><a href="https://www.iijs-signature.org/" target="_blank">Signature IIJS</a></li>
                        <li><a href="https://www.gjepc.org/igjme/" target="_blank">India Gem &amp; Jewellery Machinery Exhibition (IGJME)</a></li>
                        <li><a href="http://intl.gjepc.org/india-pavilions" target="_blank">India Pavilions</a></li>
                        <li><a href="http://intl.gjepc.org/deligation">Buyer-Seller Meets</a></li>
                        <li><a href="http://intl.gjepc.org/deligation">Intl Diamond Week</a></li>
                        <li><a href="ddes.php">DDES</a></li>
                        <li><a href="road_shows.php">Road Shows</a></li>
                    </ul>
                </div>
            
                <div class="col-md-12 col-lg foot_box">
                    <h2 class="foot_head">Events <i class="fa fa-plus pull-right dropdown_icon" aria-hidden="true"></i></h2>
                    <ul class="foot_list">
                        <li><a href="events.php">Overview</a></li>
                        <li><a href="kp_gallery.php">KP International Session 2019</a></li> 
                        <li><a href="https://www.iijw.org/" target="_blank">India International Jewellery Week (IIJW)</a></li>
                        <li><a href="mines_to_market.php">Mines to market</a></li> 
                        <li><a href="design_inspration.php">Design Inspirations</a></li>
                        <li><a href="wdc.php">World Diamond Conference </a></li>
                        <li><a href="http://awards.gjepc.org/" target="_blank">IGJA 2017</a></li>
                    </ul>
                   
                </div>
            
                <div class="col-md-12 col-lg foot_box">
                    <h2 class="foot_head">Tweets By GJEPC</h2>
                    <a class="twitter-timeline" data-height="350" href="https://twitter.com/GJEPCIndia" style="display:block;">Tweets by GJEPCIndia</a> 
                    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
                </div>
      
          </div>
        
          <div class="row">         
              <div class="col">       
                    <ul class="d-flex mb-3 social">
                        <li><a href="https://www.facebook.com/GJEPC" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/GJEPCIndia" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/GJEPCIndia" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.linkedin.com/in/sabyaray/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>                
                  <div class="d-flex">
                    <div class="mr-4"><a href="https://play.google.com/store/apps/details?id=org.gjepc&hl=en" target="_blank"><img src="assets/images/android.png"></a></div>
                      <div class="mr-4"><a href="https://apps.apple.com/tr/app/gjepc/id1194017236" target="_blank"><img src="assets/images/ios.png"></a></div>
                  </div>                
        </div>
            
              <div class="col-auto align-self-end copyright">       
                  Copyright &copy; 2019 GJEPC Content - Karsin | Designed & Developed by <a href="https://www.kwebmaker.com/" target="_blank"> Kwebmaker™ </a>                
        </div>      
            </div>        
        </div>        
    </div>    
</footer> <!-- footer ss-->

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="assets/js/FontAwesome.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/slick-animation.min.js"></script>
<script src="assets/js/sticky-kit.min.js"></script>


<script src="assets/js/fastselect.standalone.min.js"></script>
<script src="assets/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="assets/js/general.js"></script>
<script>
// onload popup
$(window).load(function(){$("#myModal").modal("show")});

// banner slider
window.onload=function(){
$(".banner_slider").slick({autoplay:!0,fade:!0,speed:1200,arrows:!1,dots:!1,responsive:[{breakpoint:991,settings:{dots:!1}}]}).slickAnimation();
};
  // news slider
$(".news_slider").slick({slidesToShow:1,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,mobileFirst:!0,responsive:[{breakpoint:600,settings:"unslick"}]});
// event slider
$(".event_slider").slick({slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!1,dots:!0,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});
// logo ticker slider
$(".logo_ticker").slick({slidesToShow:4,slidesToScroll:1,autoplay:!0,autoplaySpeed:200,arrows:!1,dots:!1,pauseOnHover:!0,responsive:[{breakpoint:768,settings:{slidesToShow:4}},{breakpoint:600,settings:{slidesToShow:2}}]});

$('[data-toggle="tooltip"]').tooltip();

$("[data-sticky_column]").stick_in_parent({parent:"[data-sticky_parent]",offset_top:50});


// language
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})

</script>
</body>
</html>