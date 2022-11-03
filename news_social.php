<?php 
include 'db.inc.php'; 
?>

<link href="css/jquery-social-share-bar.css" rel="stylesheet" type="text/css">

<?php
$id = 6343;
$sql= "select * from `news_master` WHERE 1 and status='1' and id=?";
$stmt = $conn -> prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();
?>
<div id="share-bar"></div>
<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
		<div class="title">
	        <h4>News</h4>
	     </div>

	     <div class="content">
		     <!-- <h5 class="ab_title">Leading From the Front</h5> -->
		     <div class="ab_description">
	             <div class="news_contentdetail">

	             <h5><?php echo stripslashes($rows['name']);?></h5>
				 <div class="date_social">	
		             <div class="date">
		             	<p style="border:none;"><?php echo date("M d, Y",strtotime($rows['post_date']));?></p>
		             </div>
		             <div class="clear"></div> 
	             </div>
	             <p><span><img src="../admin/images/news_images/<?php echo $rows['news_pic']; ?>" width="40%" align="left" style="padding:10px; padding-left:0px;"/></span><?php echo stripslashes($rows['long_desc']);?></p>
	            </div>  
			 </div>     	
	     </div>
	</div>
</div>

<script src="js/jquery-social-share-bar.js"></script>
<script>
    $('#share-bar').share({popupWidth: 1800});
</script>

<?php include 'include-new/footer.php'; ?>