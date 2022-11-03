<?php include('header_include.php');?>
<?php include('chk_login.php');?>

 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>About GJEPC | Kimberly Process | Search Applications </title>

<!-- Main css -->
<?php include ('maincss.php') ?>

<!-- Member lightbox Thum -->
<script type="text/javascript">
		$(document).ready(function() {
			$("#example1-1").imgbox();

			$("#example1-2").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-4").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-5").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-6").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-7").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-8").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-9").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-10").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			})
			;$("#example1-11").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-12").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-13").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-14").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});

			//$("#example1-3").imgbox({
//				'speedIn'		: 0,
//				'speedOut'		: 0
//			});
//
//			$("#example2-1, #example2-2").imgbox({
//				'speedIn'		: 0,
//				'speedOut'		: 0,
//				'alignment'		: 'center',
//				'overlayShow'	: true,
//				'allowMultiple'	: false
//			});
		});
	</script>
<script type="text/javascript" src="imgbox/jquery.min.js"></script>
<script type="text/javascript" src="imgbox/jquery.imgbox.pack.js"></script>
<link rel="stylesheet" href="imgbox/imgbox.css" /> 
<!-- Member lightbox Thum -->

<!-- Main css -->
<script src="jsvalidation/jquery.js" type="text/javascript"></script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" /> 
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {  
			newpassword: {
				required: true,
				minlength: 6
			},  
			cnfrmpassword:{
			 required: true,
			 equalTo: "#newpassword"
			}
		},
		messages: {
			newpassword: {
				required: "Please enter your new password",
				minlength: "password should not less than 6 characters"
			},
			cnfrmpassword: {
				required: "Please enter your confirm password",
				equalTo: "Please enter the same password as above"
			} 
	 }
	});
});
</script>
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>





</head>

<body>
<!-- main -->
<div class="main">

<!-- Top -->
<?php include ('top.php') ?>
<!-- Top -->


<div class="inner_mainwidth">


<div class="online_business_banner">

<!-- Midle Bg -->
<div class="midletable_img"><img src="images/inner_top_bg_new.png" /></div>
<div class="inner_midle_bg">
<div class="text_heading">Agent - Member / Non-Member Link Confirmation</div>

<div class="text_bread1"><a href="kimberley_process_search_applications.php">Home</a> > Kimberley Process > Add Member</div>



<div class="clear"></div>

<!-- Midle -->
<div class="midletext">

<!-- Left Table -->
<div class="righttable_css">

<div class="clear"></div>
<?php
	$_SESSION['member_type']="";
	$_SESSION['name']=""; 
	$company_id=$_REQUEST['company_id'];
	$company_name=$_REQUEST['company_name'];
	$member_type=$_REQUEST['m_type'];
	//print_r($company_id);
	//print_r($company_name);
	$agent_id=$_SESSION['AGENT_ID'];
	$agent_name=$_SESSION['USERNAME'];
	// $_SESSION['AGENT_NO'];
		
		if($member_type=="member")
		{
			$i=0;
			foreach($company_id as $co_id)
			{
				
					 $sql="select * from kp_agent_member_link where MEMBER_ID=$co_id";
					$result=mysql_query($sql);
					 $cnt=mysql_num_rows($result);
					if($cnt==0)
					{
						$sqlinsert="insert into kp_agent_member_link (AGENT_ID,MEMBER_ID,STATUS,ENTERED_BY,ENTERED_ON,MODIFIED_BY,MODIFIED_ON) values ('$agent_id','$co_id','22','$agent_name',now(),'$agent_name',now())";
						$result1=mysql_query($sqlinsert);
						if(!$result)
							echo mysql_error();
							
							
						$insert_id[]=$company_name[$i];
					}
					else
					{
						$ninsert_id[]=$company_name[$i];
					}
					$i++;
				
			}
		}
		elseif($member_type=="nonmember")
		{
			$i=0;
			foreach($company_id as $co_id)
			{
				  $sql="select * from kp_agent_member_link where NON_MEMBER_ID=$co_id";
					$result=mysql_query($sql);
					  $cnt=mysql_num_rows($result);
					//exit;
					if($cnt==0)
					{
						 $sqlinsert="insert into kp_agent_member_link (AGENT_ID,NON_MEMBER_ID,STATUS,ENTERED_BY,ENTERED_ON,MODIFIED_BY,MODIFIED_ON) values ('$agent_id','$co_id','22','$agent_name',now(),'$agent_name',now())";
						//exit;
						$result1=mysql_query($sqlinsert);
						if(!$result)
							echo mysql_error();
							
							
						$insert_id[]=$company_name[$i];
					}
					else
					{
						$ninsert_id[]=$company_name[$i];
					}
					$i++;
			}
		}
		

?>
<div style="margin-left:30px">
<strong>Thank You For Adding Member/Non Member in your List. </strong><br> 
<?php if($insert_id!="")
	{ ?> You have added the following Members.
<table width="40%" border="0" cellspacing="1" cellpadding="0" class="detail_txt" style="text-align:center">
 <tr class="orange1">
 <td>COMPANY</td>
 </tr>
 <?php foreach($insert_id as $add_id)
 {?>
 <tr bgcolor="#ededed"><td><?php echo $add_id;?><td></tr>
 <?php } } ?>
 </table><br>
 <?php if($ninsert_id!="")
	{ ?>

<b style="color:#FF3333">The Following Members are not add in your list.<br>Because this Members are Added in another Agent list.</b><br><br>
<table width="40%" border="0" cellspacing="1" cellpadding="0" class="detail_txt" style="text-align:center">
 <tr class="orange1">
 <td>COMPANY</td>
 </tr>
 <?php
 	
  foreach($ninsert_id as $nadd_id)
 {?>
 <tr bgcolor="#ededed"><td><?php echo $nadd_id;?><td></tr>
 <?php } } ?>
 </table>
 <br>
 <p>The Gem & Jewellery Export Promotion Council <br>
 (KP Import / Export Authority)<br>
 319-A , Dr DB Marg Diamond Plaza, V Floor,<br>
 Mumbai - 400 004 <br>
 Tel: +91-22-23821801<br>
 Fax: +91-22-2380 8752<br>
 Email: sumatiloindia.com, ramdas@gjepcindia.com<br>
 Website:www.gjepc.org</p>
<br>
<form name="ok" action="" method="post">
<input class="input_bg" type="submit" value="OK" name="ok" id="ok" />
</form>
<?php if($_REQUEST['ok']=='OK'){

header("Location: kimberley_process_search_applications.php");
//header(location:"");
}
?>
</div>
<!-- div -->
</div>
<!-- Left Table -->
<!-- Right Table -->
<div class="left_table_gjepc">
<img src="images/advertise_here_1.png" />

</div>
<!-- Right Table -->
<div class="clear"></div>




<div class="clear"></div>
</div>
<!-- Midle -->

<div class="clear"></div>

</div>
<div class="midletable_img"><img src="images/inner_bottom_bg_new.png" /></div>
<!-- Midle Bg -->
<div class="innerbg_bottom"></div>
<div class="clear"></div>
</div>

<div class="clear"></div>




<!-- Fotter -->
<?php include ('fotter.php') ?>
<!-- Fotter -->
<div class="clear"></div>

</div>

</div>
<!-- main -->

</body>
</html>
