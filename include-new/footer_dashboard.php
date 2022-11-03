<footer>
  
      <div class="col-auto text-center align-self-end copyright">       
                  Copyright &copy; 2019 GJEPC Content - Karsin | Designed & Developed by <a href="https://www.kwebmaker.com/" target="_blank"> Kwebmaker™ </a>                
        </div> 
</footer> <!-- footer ss-->

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>

<script src="assets/js/bootstrap.min.js"></script>

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="assets/js/FontAwesome.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/slick-animation.min.js"></script>
<script src="assets/js/chartjs.init.js"></script>
<script src="assets/js/Chart.min.js"></script>
<script src="assets/js/sidebarmenu.js"></script>


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
$(".event_slider").slick({slidesToShow:1,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!1,dots:!0,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});

// logo ticker slider
$(".logo_ticker").slick({slidesToShow:4,slidesToScroll:1,autoplay:!0,autoplaySpeed:200,arrows:!1,dots:!1,pauseOnHover:!0,responsive:[{breakpoint:768,settings:{slidesToShow:4}},{breakpoint:600,settings:{slidesToShow:2}}]});

  $('[data-toggle="tooltip"]').tooltip();

// language
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})

</script>
</body>
</html>