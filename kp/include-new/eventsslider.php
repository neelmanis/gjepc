<script type="text/javascript" src="js/jquery.bxSlider.js"></script>

<div class="carousel">
  <ul id="slider" class="carouselTicker__list">
    <li> <a href="https://iijs.org" target="_blank"><img src="images/events/iijs.jpg"></a> </li>
    <li> <a href="https://gjepc.org/igjme/"><img src="images/events/iigme_logo.png"></a> </li>
    <!-- <li> <a href="mines_to_market.php"> <img src="images/events/m2m.jpg"> </a></li> -->
    <li> <a href="https://www.iijs-signature.org/"><img src="https://iijs-signature.org/images/ticker.jpg"></a> </li>
<!--    <li> <a href="https://iijw.org/"><img src="images/events/iijw.jpg" ></a> </li>
-->    <li> <a href="https://gjepc.org/about_swasthya_ratna_policy.php"> <img src="images/events/abcswast.jpg"> </a> </li>
    <!-- <li> <a href="http://gjepc.org/emailer_gjepc/Mailer/v367/regform.pdf" target="_blank"><img src="images/events/idws.jpg" /></a> </li> -->
    <!--<li> <a href="https://www.gjepc.org/sdb.php" target="_blank"><img src="images/events/sdb.jpg" /></a> </li>-->
    <li> <a href="https://www.mykycbank.com/" target="_blank"><img src="images/events/kyc.jpg"  /></a></li>
      <li> <a href="https://awards.gjepc.org/" target="_blank"><img src="https://www.iijs.org/images/newsticker/igja.jpg"  /></a></li>
<!--    <li> <a href="https://gjepc.org/jp.php"> <img src="images/events/jp.jpg"> </a> </li>
-->	<!--<li> <a href="https://awards.gjepc.org/"> <img src="images/events/igja.jpg"> </a> </li>-->
    <!--<li> <a href="http://gjepc.org/images/DI/form.pdf"> <img src="images/events/design.jpg"> </a> </li>
	<li> <a href="http://gjepc.org/emailer_gjepc/mailer/v356/index.html"> <img src="images/events/df.jpg"> </a> </li>-->
  </ul>
</div>

        <script type="text/javascript">
            
           $(document).ready(function(){
            $('#slider').bxSlider({
                ticker: true,
                tickerSpeed: 3000,
                tickerHover: true
                });
            });
        </script>
<style type="text/css">
#slider {
    list-style:none;
    padding:0px
}

.slider-container { 
    background:#222; 
    width:105px; 
    height:150px; 
    padding:20px; 
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px; 
}

#slider img { 
    /*width:178px; 
    height:70px; */
    max-width: 100%;
    margin:0px 10px; 
    display:inline-block  
}

#slider li {
    width:25%;
}    
</style>
