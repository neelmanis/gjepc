<?php 
//include_once('include/header_include.php');
session_start();
ob_start();
include_once('db.inc.php');
include_once('functions.php');

?>
<?php

if(isset($_REQUEST['action']) && $_REQUEST['action']='save')
{
	//print_r($_POST);
	//$opt4 = $_POST['ans4'];
	//$query1 = "insert into pollans_master (q_id,opt1,opt2,opt3,opt4) 	
	//values()";
	if(isset($_REQUEST['ans']) && $_REQUEST['ans']!="")
	{
			$post_date=date('Y-m-d');
			 $ans=$_POST['ans']."<br/>";
			 $q_id=$_POST['q_id']."<br/>";
			 $user_id=$_SESSION['user_id']."<br/>";
			
			 $user_query="select * from pollanswer_master where user_id='$user_id' and q_id='$q_id'";
			$result_user=mysql_query($user_query);
			 $cnt=mysql_fetch_array($result_user);
			
				if($cnt==0)
				{
					 $ans_query="insert into pollanswer_master (q_id,user_id,o_id,status,post_date) values ('$q_id','$user_id','$ans','1','$post_date')";
					 
					 $result=mysql_query($ans_query);
					 if(!$result)
					 {
						echo mysql_error();
					 }
					 else
					 {
						header('location:polls.php');
					 }
			 
			 }else
			 {
				echo "<script>alert('You Already Give Answer');
					window.location.href='polls.php';
				</script>";
			 }
	}
	else
	{
		echo "<script>alert('Please Select Answer');
					window.location.href='polls.php';
				</script>";
	}		 
}
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
		
		$("#slidepanel"+I).slideToggle(300);
		$(this).toggleClass("active"); 

		return false;
	});*/
});
</script>
<style>
/*.ans{
display:none;
}*/
</style>
</head>

<body>

<?php include 'include/header.php';?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Polls</div>



<?php 
$query = "select * from poll_master where status=1 order by id desc ";
$result = mysql_query($query);
$x=1;
while($row = mysql_fetch_array($result))
{
	$q_id=$row['id'];
 $op_query="select * from polloption_master where q_id=".$row['id'];
$result_op=mysql_query($op_query);

?>
<form method="post" id="form1" name="form1" action="" >
<div class="question">

<span><a href="javascript:showonlyone('newboxes<?php echo $q_id; ?>')" class="comment_button" id="<?php echo $q_id; ?>"><?php echo "Q".$x.") ". $row['question']; ?></a></span>
</div>
<input type="hidden" id="q_id" name="q_id" value="<?php echo $q_id;?>">
<input type="hidden" id="action" name="action" value="save">
<div class="ans newboxes" id="newboxes<?php echo $q_id; ?>">
<span><b>Options :</b></span><br/><br/>
<?php
 while($row_op=mysql_fetch_array($result_op))
 {
 ?>

<input type="radio" class="radioBtn" name="ans" id="ans" value="<?php echo $row_op['id'];?>"><?php echo $row_op['option_name'];?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php  }
?>
<br/><br/><input type="submit" name="poll" id="poll" class="submitBtn" value="Submit" />
</div>
</form>

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
