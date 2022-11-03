
<link href="css/gjpec.css" rel="stylesheet" type="text/css" />

<!-- Menu -->
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!-- Menu -->

<!-- Banner-->
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
<script type="text/javascript" src="js/script.js"></script>
<!-- Banner-->

<!-- Home Thum Popup-->
<!--<link type="text/css" href="landing-1.05.01.2013.css" rel="stylesheet" media="all" />-->
<!--<link type="text/css" href="css/landing-1.05.01.2013.css" rel="stylesheet" media="all" />
<link type="text/css" href="site-1.05.01.2013.css" rel="stylesheet" media="all" />-->


<!-- Home Thum Popup-->

<!--Acordin-->  
<link href="css/acordin.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript">
$(document).ready(function(){
$('.acc_container').hide(); 
$('.acc_trigger:first').addClass('active').next().show(); 
$('.acc_trigger').click(function(){
	if( $(this).next().is(':hidden') ) { 
		$('.acc_trigger').removeClass('active').next().slideUp(); 
		$(this).toggleClass('active').next().slideDown(); 
	}
	return false;
});
});
</script>
<!--Acordin-->

<!-- click More slide-->
<script type="text/javascript" src="js/switchcontent1.js"></script>
<script type="text/javascript" src="js/switchicon.js"></script>
<!-- click More slide-->

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="jquery.fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="jquery.fancybox/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="jquery.fancybox/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("div.fancyDemo a").fancybox();
});
</script>
<!-- lightbox Thum -->



<!-- Zoom -->
	<!--<script type="text/javascript" src="js/jquery_002.js"></script>-->
	<link rel="stylesheet" href="contact_popup/reveal.css">
	<script type="text/javascript" src="contact_popup/jquery.reveal.js"></script>
<!-- Zoom -->



<!-- Tab-->
<script src="js/jquery-1.6.3.min.js"></script>
<script>
$(document).ready(function() {
	$("#content div").hide(); // Initially hide all content
	$("#tabs li:first").attr("id","current"); // Activate first tab
	$("#content div:first").fadeIn(); // Show first tab content
    
    $('#tabs a').click(function(e) {
        e.preventDefault();        
        $("#content div").hide(); //Hide all content
        $("#tabs li").attr("id",""); //Reset id's
        $(this).parent().attr("id","current"); // Activate this
        $('#' + $(this).attr('title')).fadeIn(); // Show content for current tab
    });
})
</script>
<!-- Tab-->




<!-- Scroll Top-->
<script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
</script>
<!-- Scroll Top-->
<script type="text/javascript">
function PrintContent(){
	var DocumentContainer = document.getElementById("divtoprint");
	var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	setTimeout(function() { // wait until all resources loaded 
       
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
     }, 2000);		
}
</script>
