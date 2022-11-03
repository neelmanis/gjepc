<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC - Gallery Photos</title>
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


<script type="text/javascript">
	$(document).ready(function() {
		$("#fancybox-manual-c").click(function() {
			$.fancybox.open(
			[			 
				{href : 'images/album/a.jpg',title : 'My title'},
				{href : 'images/album/b.jpg',title : '2nd title'},
				{href : 'images/album/c.jpg'},
				{href : 'images/album/d.jpg'},
				{href : 'images/album/e.jpg'}
			], {
				helpers : {
					thumbs : {width: 75,height: 50}
				}
			});
		});
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
    	<a href="#" class="active">PHOTOS</a>
        <a href="gallery_videos.php">VIDEOS</a>
        <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
    <div class="gallery_main_div">
    
    	<div class="photo_box">
        <a id="fancybox-manual-c" href="javascript:;">
        <span><img src="images/album/a.jpg" /> <img src="images/album.png" class="album_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.        
        </a>        
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/b.jpg" /> <img src="images/album.png" class="album_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/c.jpg" /> <img src="images/album.png" class="album_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/d.jpg" /> <img src="images/album.png" class="album_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
    
    	<div class="photo_box">
        <a href="#">
        <span><img src="images/album/e.jpg" /> <img src="images/album.png" class="album_btn" /></span>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </a>
        </div>
            
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

</body>
</html>