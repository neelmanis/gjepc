<?php session_start();
	ob_start();
 ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php

if(isset($_REQUEST['actions']) && $_REQUEST['actions']='save')
{
	//print_r($_POST); exit;
	//$opt4 = $_POST['ans4'];
	//$query1 = "insert into pollans_master (q_id,opt1,opt2,opt3,opt4) 	

	if(isset($_REQUEST['ans']) && $_REQUEST['ans']!="")
	{
			$post_date=date('Y-m-d');
			$ans=$_POST['ans'];
			$q_id=$_POST['q_id'];
		$ip_address=$_SERVER['REMOTE_ADDR'];
			
		$user_query="select * from pollanswer_master where IP_address='$ip_address' and q_id='$q_id'";
		$result_user=$conn ->query($user_query);
		$cnt= $result_user->fetch_assoc();
		if($cnt==0)
		{
		$ans_query="insert into pollanswer_master (q_id,o_id,status,IP_address,post_date) values ('$q_id','$ans','1','$ip_address','$post_date')";
		$result=$conn ->query($ans_query);
		if(!$result)
		{
		echo mysql_error();
		}
		else
		{
		 echo "<script>alert('Thank you for participating in our Opinion Poll. The results will be available on the website at the end of each month');
		window.location.href='manage_polls.php?action=view';
		</script>";
		//header('location:index.php');
		}
		}else
		{
		echo "<script>alert('Sorry, you can only vote once during each poll. You have already expressed your opinion on this topic');
		window.location.href='manage_polls.php?action=view';
		</script>";
		}		 
	}
	else
	{
		echo "<script>alert('Kindly select one of the options before voting');
					window.location.href='manage_polls.php?action=view';
				</script>";
	}		 
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>   
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
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

<!--navigation end-->

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_polls.php?action=view"><div class="content_head_button">View question</div></a> </div>

<?php if($_REQUEST['action']=='view') {
	$q_id = $_REQUEST['id'];
/*	$sql_query="SELECT * FROM poll_master where id=$q_id";
	$result = $conn ->query($sql_query);
    $rCount=0;
    $rCount = $result->num_rows;		
	$row = $result->fetch_assoc(); */
?>    	
<div class="whiteBox" >
<?php 
$query_poll = "select * from poll_master where status=1 and id=$q_id order by post_date desc limit 1";
//$query_poll = "select * from poll_master where status=1 order by post_date desc limit 1";
$result_poll = $conn ->query($query_poll);
$row_poll = $result_poll->fetch_assoc();
$q_id=$row_poll['id'];
?>
<p><?php echo $row_poll['question'];?></p>

<form method="post" id="form1" name="form1" action="">
<div class="leftDiv radioBox">
<?php 
$option_query="select * from polloption_master where q_id=".$row_poll['id'];
$option_result=$conn ->query($option_query);
while($option_row= $option_result->fetch_assoc())
{
?>
<div class="radioButton">
<input name="ans" id="ans" type="radio" value="<?php echo $option_row['id'];?>" /> <?php echo $option_row['option_name'];?>
</div>
<?php } ?>
<!--<div class="radioButton">
<input name="ans" id="ans" type="radio" value="2" /> <?php //echo $row_poll['opt2'];?>
</div>

<div class="radioButton">
<input name="ans" id="ans" type="radio" value="3" /> <?php //echo $row_poll['opt3'];?>
</div>

<div class="radioButton">
<input name="ans" id="ans" type="radio" value="4" /> <?php //echo $row_poll['opt4'];?>
</div>-->

</div>

<input type="hidden" id="q_id" name="q_id" value="<?php echo $row_poll['id'];?>">
<input type="hidden" id="actions" name="actions" value="save">
<div class="rightDiv">

<div class="orangeButton">
<input type="submit" name="poll" id="poll" value="Vote" />
</form>
</div>
</div>

<div class="clear"></div><br/>
<!--If No why not/what else can be done? (<a href='feedback.php?pdf_id=<?php echo $q_id; ?>' target='_blank' class='various3'>click here to send feedback</a>)
<div class="clear"></div>-->
<div class="click_here1"><a href="opinion_poll.php">Click here to view results</a></div>

</div>
<?php } ?>        
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>