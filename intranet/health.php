<?php 
//include_once('include/header_include.php');
session_start();
ob_start();
include_once('db.inc.php');
include_once('functions.php');

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
  /* function showonlyone(thechosenone) {
     $('.newboxes').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).show(400);
          }
          else {
               $(this).hide(600);
          }
     });
}*/

$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
	
	$("#poll").click(function(){
	//alert(11);
	var ischecked=$('input:radio[name="ans"]').is(':checked');
	if(ischecked==false)
	{
		alert("Please Select Answer");
		return false;
	}
	});
	
	/*$(".comment_button").click(function(){
		
		var element = $(this);
		var I = element.attr("id");
		//alert(element);
		alert(I);
		//alert($(this));
		alert($(this).attr("id"));
		if($(this).attr("id")==I)
		{
			$(this).show(200);
		}
		else
		{
		$(this).hide(200);
		}
		//$("#slidepanel"+I).slideToggle(300);
		//$(this).toggleClass("active"); 

		return false;
	});*/
});
</script>
<style>
/*.ans{
display:none;

}*/
.ans a:hover{
color:#b94888 ;
}
</style>
</head>

<body>

<?php include 'include/header.php';?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Health Tip Of The Day</div>



<?php 
$query = "select * from health_master where status=1 order by id desc ";
$result = mysql_query($query);
$x=1;
while($row = mysql_fetch_array($result))
{
	$q_id=$row['id'];
 

?>

<div class="question">
<span><a href="javascript:showonlyone('newboxes<?php echo $q_id; ?>')" class="comment_button" id="<?php echo $q_id; ?>"><?php echo stripslashes( $row['name']); ?></a></span>
<!--<span><a href="health.php?data=<?php echo $q_id; ?>" class="comment_button" id="<?php echo $q_id; ?>"><?php echo stripslashes( $row['name']); ?></a></span>-->
</div>

<div class="ans newboxes" id="newboxes<?php echo $q_id; ?>">
<span><b>Description :</b></span><br/><br/>
<?php
 
 	echo "<p style='width:600px;'>".stripslashes($row['long_desc'])."&nbsp;&nbsp;&nbsp;&nbsp;";
	if($row['h_file']!='')
		echo "<a href='health/".$row['h_file']."' class='comment_button' target='_blank'>More</a></p>";
	else
		echo "</p>";	
 ?>


<br/>
</div>


<?php

$x++;
} ?>







</div>  
    

    
    
    
    
    
    
    
    
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
