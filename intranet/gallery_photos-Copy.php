<?php 
session_start();
ob_start();
include('db.inc.php');

include 'include/header.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" href="css/liteaccordion.css">

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


<script type="text/javascript">
	$(document).ready(function() {
							  
		$(".fancybox-manual-c").click(function() {
					
					$.fancybox.open(
			[			 
		
				{href : 'images/album/a.jpg'},
				{href : 'images/album/b.jpg'},
				{href : 'images/album/c.jpg'},
				{href : 'images/album/d.jpg'},
				{href : 'images/album/e.jpg'}
			], {
				helpers : {
					thumbs : {width: 50,height: 50}
				}
			});
			
		});
		
	});
</script>


   <script>
$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
});
</script>
</head>

<body>





<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Gallery</div>

    <div class="gallery">
    	<a href="#" class="active">PHOTOS</a>
        <a href="gallery_videos.php">VIDEOS</a>
        <div class="clear"></div>
    </div>

<div class="gallery_main_div">
    
    <?php
    $query = "select * from images_master where status=1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
	?>
    	<div class="photo_box">
        <a id="fancybox-manual-c<?php echo $row['id'];?>" href="javascript:;">
        <span><img src="gallary_images/<?php echo $row['img_name'];?>" /> <img src="images/album.png" class="album_btn" /></span>
                <?php echo $row['Name'];?>
        </a>        
        </div>
    <?php } ?>
    
            
    </div>
    
    <div class="gallery_main_div">
    
    
    	<div class="photo_box">
        <a class="fancybox-manual-c" href="javascript:;">
        <span><img src="images/album/a.jpg"/><img src="images/album.png" class="album_btn" /></span>
               hdhdhdghdghdghdhdhdhdhdhddhdhhdhdhd
        </a>        
        </div>
   
    
            
    
    
    	<div class="photo_box">
        <a class="fancybox-manual-c" href="javascript:;">
        <span><img src="images/album/b.jpg"/><img src="images/album.png" class="album_btn" /></span>
               hdhdhdghdghdghdhdhdhdhdhddhdhhdhdhd
        </a>        
        </div>
   
    
            
  
    
    
    	<div class="photo_box">
        <a class="fancybox-manual-c" href="javascript:;">
        <span><img src="images/album/c.jpg"/><img src="images/album.png" class="album_btn" /></span>
               hdhdhdghdghdghdhdhdhdhdhddhdhhdhdhd
        </a>        
        </div>
   
    
            
    </div>
</div>  
    
<div class="clear"></div>
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
