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
				 <?php
   					 $query1 = "select * from gallary_master where status=1";
					 $result1 = mysql_query($query1);
					 while($row1 = mysql_fetch_array($result1))
					{
						$g_id=$row1['id'];	
					 $query2 = "select * from images_master where g_id='$g_id' and status=1";
					 $result2 = mysql_query($query2);
					 
				?>				  
		$("#fancybox-manual-c<?php echo $row1['id'];?>").click(function() {
					
					$.fancybox.open(
			[			 
				<?php while($row2 = mysql_fetch_array($result2)) { ?>
				{href : 'gallary_images/<?php echo $row2['img_name'];?>'},
				<?php  } ?>
				/*{href : 'images/album/b.jpg'},
				{href : 'images/album/c.jpg'},
				{href : 'images/album/d.jpg'},
				{href : 'images/album/e.jpg'}*/
			], {
				helpers : {
					thumbs : {width: 50,height: 50}
				}
			});
			
		});
		<?php } ?>
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
<?php
include 'include/header.php'; ?>



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
    $query = "select * from gallary_master where status=1";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
		$g_id=$row['id'];
		$sql_i="select * from images_master where g_id='$g_id' and status=1 limit 1";
		$result_i=mysql_query($sql_i);
		$row_i=mysql_fetch_array($result_i);
		
	?>
    	<div class="photo_box">
        <a id="fancybox-manual-c<?php echo $row['id'];?>" href="javascript:;">
        <span><img src="gallary_images/<?php echo $row_i['img_name'];?>" /> <img src="images/album.png" class="album_btn" /></span>
                <?php echo $row['gallary_name'];?>
        </a>        
        </div>
    <?php } ?>
    
            
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
