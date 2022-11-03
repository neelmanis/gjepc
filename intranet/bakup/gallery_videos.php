<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC - - Gallery Videos</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon"/>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!-- Add jQuery library -->
<script type="text/javascript" src="lib/jquery-1.9.0.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="source/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-buttons.css" />
<script type="text/javascript" src="source/helpers/jquery.fancybox-buttons.js"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="source/helpers/jquery.fancybox-thumbs.css" />
<script type="text/javascript" src="source/helpers/jquery.fancybox-thumbs.js"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="source/helpers/jquery.fancybox-media.js"></script>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
							   
		$('.fancybox').fancybox();
		
	});
</script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>

</head>

<body>

<div class="front_box">

<div class="header">
	<div class="logo"><img src="images/logo.png" width="350px" /></div>
    
    <div class="logged_name">
    Welcome <strong>Idris Nagari</strong><br />
    <a href="#" class="logout_btn">Logout</a>
    </div>
</div>

<div class="main_wrapper">

<div class="page_container">

	<div class="page_title">Gallery</div>
    
    <div class="gallery">
    	<a href="gallery_photos.php">PHOTOS</a>
        <a href="#" class="active">VIDEOS</a>
        <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
    <div class="gallery_main_div">
    
    	<div class="photo_box">
        <a class="fancybox" href="#inline1">
        <span><img src="images/album/a.jpg" class="video_thumb" /> <img src="images/play_btn.png" class="play_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>        
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/b.jpg" class="video_thumb" /> <img src="images/play_btn.png" class="play_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/c.jpg" class="video_thumb" /> <img src="images/play_btn.png" class="play_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/d.jpg" class="video_thumb" /> <img src="images/play_btn.png" class="play_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/e.jpg" class="video_thumb" /> <img src="images/play_btn.png" class="play_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
            
    </div>
    
    <div id="inline1" style="display: none; background:#000;">
    
		
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="800" height="500" id="FLVPlayer">
          <param name="movie" value="FLVPlayer_Progressive.swf" />
          <param name="quality" value="high" />
          <param name="wmode" value="transparent" />
          <param name="scale" value="noscale" />
          <param name="salign" value="lt" />
          <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=Clear_Skin_2&amp;streamName=video/test&amp;autoPlay=true&amp;autoRewind=false" />
          <param name="swfversion" value="8,0,0,0" />
          <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
          <param name="expressinstall" value="Scripts/expressInstall.swf" />
          <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
          <!--[if !IE]>-->
          <object type="application/x-shockwave-flash" data="FLVPlayer_Progressive.swf" width="800" height="500">
            <!--<![endif]-->
            <param name="quality" value="high" />
            <param name="wmode" value="transparent" />
            <param name="scale" value="noscale" />
            <param name="salign" value="lt" />
            <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=Clear_Skin_2&amp;streamName=video/test&amp;autoPlay=true&amp;autoRewind=false" />
            <param name="swfversion" value="8,0,0,0" />
            <param name="expressinstall" value="Scripts/expressInstall.swf" />
            <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
            <div>
              <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
              <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
            </div>
            <!--[if !IE]>-->
          </object>
          <!--<![endif]-->
        </object>
    </div>
    
    
</div>



<div class="nav_box">
<div class="clear" style="height:30px; background: url(images/nav_bg.png);"></div>
    <ul>
       <li><a href="profile.php">Employee Profile</a></li>
        <li><a href="policies.php">Policies</a></li>
        <li class="active"><a href="#">Gallery</a></li>
        <li><a href="polls.php">Polls</a></li>
        <li><a href="#">Birthday and Anniversaries</a></li>
        <li><a href="training_calendar.php">Training Calendar</a></li>
        <li><a href="forum.php">Forum</a></li>
        <li><a href="suggestion.php">Suggestion</a></li>
    </ul>
<div style="background: url(images/nav_bg.png); height:100%;"></div>
</div>

<div class="clear"></div>
</div>

<div class="footer">
<span style="float:left;">&copy; 2014 GJEPC.</span>
<span style="float:right;"><a href="http://www.kwebmaker.com" target="_blank">Kwebmaker &trade;</a></span>
<div class="clear"></div>
</div>

</div>
<script type="text/javascript">
<!--
swfobject.registerObject("FLVPlayer");
//-->
</script>
</body>
</html>