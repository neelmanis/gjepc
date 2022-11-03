<?php
session_start();
ob_start();
include('db.inc.php');
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" href="css/liteaccordion.css">

<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<!-- fancy box -->

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>

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


<!--   <script>
$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
});
</script>-->

</head>
<body>

<div class="header">
	<div class="logo"><a href="index.php"><img src="images/logo.png" title="GJEPC" /></a></div>
    <div class="profile">
    	<div class="name"><img src="images/idris.jpg" /> Idris Nagari</div>
        <div class="logout">Logout</div>
    </div>
</div>
<!------------------------------------------- header ends ----------------------------------------->

<!------------------------------------------- menu starts --------------------------------------->
<div class="nav_wrap">
	<div class="nav">
    	<ul>
        	<li><a href="index.php">Home</a></li>
            <li><a href="verticals.php">Verticals</a></li>
            <li><a href="policies.php">Policies</a></li>
            <li><a href="training_calendar.php">Training Calendar</a></li>
            <li><a href="polls.php">Polls</a></li>
            <li><a href="forum.php">Forum</a></li>
            <li><a href="suggetions.php">Suggestions</a></li>
            <li><a href="mis.php">MIS</a></li>
            <li class="active"><a href="#">Gallery</a></li>
        </ul>
    </div>
</div>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Gallery</div>

    <div class="gallery">
    	<a href="gallery_photos.php">PHOTOS</a>
        <a href="gallery_videos.php" class="active">VIDEOS</a>
        <div class="clear"></div>
    </div>

<div class="gallery_main_div">
    	<?php
        $query = "select * from videos_master where status=1";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		
		?>
    	<div class="photo_box">
        <a class="fancybox" href="#inline1">
        <span><!--<img src="/gallary_videos/<?php echo $row['img_name'];?>" class="video_thumb" /> <img src="images/play_btn.png" class="play_btn" />--><!--<iframe width="555" height="300" src="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>?autoplay=0" frameborder="0" allowfullscreen></iframe>--><!--<object width="555" height="300"><param name="movie" value="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>?version=3&amp;autoplay=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>?version=3&amp;autoplay=0" type="application/x-shockwave-flash" width="185" height="150" allowscriptaccess="always" allowfullscreen="true"></embed></object>--> <!--<embed src="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>"
 autostart="false" width="185" height="150" />--><video width="320" height="240" controls>
  <source src="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>" type="video/mp4">
  <!--<source src="movie.ogg" type="video/ogg">-->
  Your browser does not support the video tag.
</video></span>
        </br>
		<?php echo $row['img_name'];?>
        </a>        
        </div>
    <?php // }?>
    	<!--<div class="photo_box">
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
        </div>-->
            
    </div>
</div>  
    
<div class="clear"></div>
    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->

<?php include 'include/footer.php';?>

<div id="inline1" style="display: none; background:#000;">
   <?php
        $query = "select * from videos_master where status=1";
		$result = mysql_query($query);
		$row=mysql_fetch_array($result);
		
		?>
   <!--<iframe width="800" height="500" src="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>?autoplay=0" frameborder="0" allowfullscreen></iframe>-->
   <!--<object width="800" height="500"><param name="movie" value="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="//kwms/Gjepc_intranet/gallary_videos/<?php echo $row['img_name'];?>" type="application/x-shockwave-flash" width="185" height="150" allowscriptaccess="always" allowfullscreen="true"></embed></object>-->
 
  
 <!-- <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="800" height="500" id="FLVPlayer">
		  <param name="movie" value="FLVPlayer_Progressive.swf" />
		  <param name="quality" value="high" />
		  <param name="wmode" value="opaque" />
		  <param name="scale" value="noscale" />
		  <param name="salign" value="lt" />
		  <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=Clear_Skin_2&amp;streamName=gallary_videos/<?php echo $row['img_name'];?>&amp;autoPlay=false&amp;autoRewind=false" />
		  <param name="swfversion" value="8,0,0,0" />-->
		  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
		 <!-- <param name="expressinstall" value="Scripts/expressInstall.swf" />-->
		  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
		  <!--[if !IE]>-->
		 <!-- <object type="application/x-shockwave-flash" data="FLVPlayer_Progressive.swf" width="800" height="500"-->>
		    <!--<![endif]-->
		   <!-- <param name="quality" value="high" />
		    <param name="wmode" value="opaque" />
		    <param name="scale" value="noscale" />
		    <param name="salign" value="lt" />
		    <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=Clear_Skin_2&amp;streamName=gallary_videos/<?php echo $row['img_name'];?>&amp;autoPlay=false&amp;autoRewind=false" />
		    <param name="swfversion" value="8,0,0,0" />
		    <param name="expressinstall" value="Scripts/expressInstall.swf" />-->
		    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
		    <!--<div>
		      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
		      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
	        </div>-->
		    <!--[if !IE]>-->
    <!--</object>-->
		  <!--<![endif]-->
  <!--</object>-->
 
  
  
</div>
<script type="text/javascript">
<!--
swfobject.registerObject("FLVPlayer");
swfobject.registerObject("FLVPlayer");
//-->
</script>

</body>
</html>
