<?php
session_start();
ob_start();
//echo $username = $_SESSION['username'];
include_once('db.inc.php');

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

<?php include('include/header.php');?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	
	<!--------------------- BANNER STARTS -------------->
		<div class="banner">
    	 <div id="one" class="accordion">
		    <ol>
				<li>
				    <h2><div class="slide_title"><img src="images/forum_btn.png" /></div></h2>
				    <div>
						<a href="forum.php"><figure><img src="images/1.jpg" alt="image"/></figure></a>
					</div>
				</li>
                
				<li>
				    <h2><div class="slide_title"><img src="images/polls_btn.png" /></div></h2>
				    <div>
						<a href="polls.php"><figure><img src="images/polls.jpg" alt="image"/></figure></a>
					</div>
				</li>
                
				<li>
				    <h2><div class="slide_title"><img src="images/policies_btn.png" /></div></h2>
				    <div>
						<a href="policies.php"><figure><img src="images/policies.jpg" alt="image"/></figure></a>
					</div>
				</li>
               <li>
				    <h2><div class="slide_title"><img src="images/gallery_btn.png" /></div></h2>
				    <div>
						<a href="gallery_photos.php"><figure><img src="images/photo-gallery.jpg" alt="image"/></figure></a>
					</div>
				</li>
		    </ol>
			
	</div>

		<script src="js/jquery.min.js"></script>
		<script src="js/liteaccordion.jquery.js"></script>
		
		<script>
			// liteAccordion demos
			$('#one').liteAccordion({
					onActivate : function() {
						this.find('figcaption').fadeOut();
					},
					slideCallback : function() {	
						this.find('figcaption').fadeIn();
					},
					autoPlay : true,
					pauseOnHover : true,
					theme : 'dark',
					rounded : true,
					enumerateSlides : true					
			}).find('figcaption:first').show();
			$('#two').liteAccordion();
			$('#three').liteAccordion({ theme : 'dark', containerWidth : 694, containerHeight : 314, slideSpeed : 600, firstSlide : 2 });
		    </script>
    
    </div>
    
    <!--------------------- BANNER ENDS -------------->
    
    <div class="announcement">
    	<div class="announcement_title">Announcements</div>
       
        <ul>
        	
            <?php
	    $query ="select * from employee_details";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{
		$ans = explode('-',$row['dob']);
		  $date = date('d');
		 //print_r($ans);
		
	   	 //$month = date('m');
		//echo $month_str = date('F');
		 $birth_date = date('jS F Y');
		//echo $written_month = date("F", strtotime("date]"));
			$month = date('M');
			 $year = date('y');
			if($date==$ans[0] && $month==$ans[1])
			{
			echo "<li>".$birth_date."<br />";	
			echo "<span>Happy Birthday-".$row['employee_name']."</span></li>";
			
			}
		
		}
		
		$query1 = "select * from announcement_master where status=1 order by post_date desc";
		$result1 = mysql_query($query1);
		$ann_cnt=mysql_num_rows($result1);
		if($ann_cnt>0)
		{
		while($row1 = mysql_fetch_array($result1))
		{
			//print_r($row1);".date('jS F Y',$ann_date)."<br/>
		 $ann_date = strtotime($row1['post_date']);
	   echo "<li>";
	   echo "<span>".stripcslashes($row1['announcement'])."</span></li>";
	   //echo date('D M j Y h:i A');
		}
		}
      ?>
            	<!--13 May 2014 
				<span>Happy Birthday</span> - Mr. Nitin Pandey-->
           
           <!-- <li>
            	13 May 2014 <br />
				<span>Happy Anniversery</span> - Mr. Mukesh Singh
            </li>-->
        </ul>
    </div>
    
    <div class="clear" style="height:25px;"></div>
    
    <div class="box">
    	<div class="strip orange_strip">Policies</div>
         <ul class="orange_bullet">
    	<?php $sql_policy="select * from policy_master where 1 order by post_date desc limit 0,3";
	$result_policy=mysql_query($sql_policy);
	$cnt=mysql_num_rows($result_policy);
if($cnt>0)
{
	while($row=mysql_fetch_array($result_policy))
	{
		$id = $row['p_file'];
        	echo "<a href='policy/$id' target='_blank'><li>".$row['p_name']."</li></a>";
            
            }} ?>
        </ul>
        
        
        <span class="box_btn orange_btn"><a href="policies.php">View All</a></span>
        
    </div>
    
    <div class="box pink">
    	<div class="strip pink_strip">Health Tip of the Day</div>
        
        <ul class="pink_bullet">
        <?php $sql_health="select * from health_master where 1 order by post_date desc limit 0,3";
	$result_health=mysql_query($sql_health);
	$cnt=mysql_num_rows($result_health);
if($cnt>0)
{
	while($row=mysql_fetch_array($result_health))
	{
			//echo $id = $row['id'];
        	echo "<a href='health.php'><li>".stripslashes($row['name'])."</li></a>";
            
            }} ?>
        	<!--<li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been </li>
            <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </li>-->
        </ul>
        
        <span class="box_btn pink_btn"><a href="health.php">View All</a></span>
        
    </div>
    
    <div class="box_purple" style="margin-right:0;">
    	<div class="strip purple_strip">Forum</div>
        <?php $sql_forum="select * from forum_master where 1 order by post_date desc limit 1";
	$result_forum=mysql_query($sql_forum);
	$row_forum=mysql_fetch_array($result_forum);
		echo "<a href='forum.php'><p>".$row_forum['q_name']."</p></a>";
 ?>
        <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been </p>
        -->
        <span class="box_btn purple_btn"><a href="forum.php">Join the conversation</a></span>
    </div>
    
    
    
    <div class="clear"></div>
    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
