<?php include('header_include.php');?>
<?php include('chk_login.php');?>
<?php
if($_REQUEST['Close']=="Close")
{
	$_SESSION['member_no']="";
	$_SESSION['name']="";
  header("Location: kimberley_process_search_applications.php");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  
  $_SESSION['member_no']=$_REQUEST['member_type'];
  
  $_SESSION['name']=$_REQUEST['name'];
  
  if($action=='search')
  {
  	if($_SESSION['agent_id']=="")
	{
	$_SESSION['error_msg']="Please select Agent Name";
	}
	
	if($_SESSION['member_no']=="")
	{
	$_SESSION['error_msg1']="Please select Member Type";
	}
	
  }
}


?> 
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
$(document).ready(function(){
	
	$("#Close").click(function(){
	//alert(11);
		//window.location.href="kimberley_process_search_applications.php";
	
	});
	$("#add").click(function(){
	//alert(11);
		//window.location.href='kimberley_process_search_applications.php';
		
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
<div class="text_heading">Add Member/Non Member</div>

<div class="text_bread1"><a href="kimberley_process_search_applications.php">Home</a> > Kimberley Process > Search Applications</div>



<div class="clear"></div>

<!-- Midle -->
<div class="midletext">

<!-- Left Table -->
<div class="righttable_css">

<div class="clear"></div>

<!-- div -->
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />
<div class="search_app_div">
<div class="search_app_text1">Type:</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="member_type" id="member_type">
<option selected="selected" value="">--Select--</option>
`
<?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='7'";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_ID']==$_SESSION['member_no'])
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
?>	

</select>
</div>
<div class="search_app_text1">(Member / Non-Member)</div>
<div class="clear"> </div>
</div>


<div class="search_app_div">
<div class="search_app_text1">Name ( First 3 letters ) : </div>
<div class="search_app_bg"><input type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>" class="search_app_bg_text"/></div>

<div class="clear"> </div>
</div>




<br>
<div class="clear"></div>
<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Find" name="find" id="find" /></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Close" name="Close" id="Close" /></div>

</form>
</div>
<div class="clear"></div>
<div style="height:20px;"></div>
<form name="confirm" action="confirmation_member_add.php" method="post">
<?php if($_REQUEST['add']=='Add') {
$co_id=$_REQUEST['check_name'];
	if(isset($co_id)){
//print_r($co_id);
//$co_name=$_REQUEST['co_name'];
?>
<input type="hidden" name="m_type" value="<?php echo $_REQUEST['type']; ?>">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="detail_txt" style="text-align:center">
  <tr class="orange1"  >
<td width="50%" style="padding:3px;"><strong>Company Name</strong></td>
    <td width="50%" style="padding:3px;"><strong>IEC NO</strong></td></tr>

<?php
foreach($co_id as $val)
{
	$co_name=explode("-",$val);
	//echo $co_name[1];
	?>

<tr bgcolor="#ededed">
<td style="padding:3px"><?php echo $co_name[1];?></td>
<td style="padding:3px"><?php echo $co_name[2];?><input type="hidden" name="company_id[]" id="company_id" value="<?php echo $co_name[0];?>"><input type="hidden" name="company_name[]" id="company_name" value="<?php echo $co_name[1];?>"></td>
</tr>



<?php }?></table>
<br>
<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Submit" name="submit" id="submit" /></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="button" value="Close" name="Close" id="Close" /></div>
</div>

<?php } }?>




</form>


<div style="height:27px;"></div>



<!-- div -->
<div class="clear"></div>

</div>
<!-- Left Table -->
<!-- Right Table -->
<div class="left_table_gjepc">
<img src="images/advertise_here_1.png" />

</div>
<!-- Right Table -->
<div class="clear"></div>

<?php
	

 if($_REQUEST['find']=='Find' && $_SESSION['member_no']!="" && $_REQUEST['name']!="") {?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
 

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="detail_txt">
  <tr class="orange1"  >
  
    <td width="20%" style="padding:3px;"><strong>Company Name</strong></td>
    <td width="30%" style="padding:3px;"><strong>Address</strong></td>
    <td width="20%" style="padding:3px;"><strong>IEC No</strong></td>
    <td width="20%" style="padding:3px;"><strong></strong></td>
    
   
  </tr>
  <?php
  
/*	$page=1;//Default page 
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;*/
  
  $member_type=intval($_SESSION['member_no']);
  $name= $_REQUEST['name'];
  	if(isset($member_type) && $member_type=='18')
	{
		 $sql="SELECT * FROM `kp_member_master` WHERE MEMBER_CO_NAME like '$name%'";
	}
	else
	{
		 $sql="SELECT * FROM `kp_non_member_master` WHERE NON_MEMBER_NAME like '$name%'";
	}	
	//exit;
 	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);	

	
		
  if($rCount>0)
  {	
  	while($rows=mysql_fetch_array($result))
 	 {
	 	/*echo "<pre>";
		print_r($rows);
		echo "<pre>";*/
	   ?>
		
  	<tr bgcolor="#ededed">
    
    <?php if($member_type=='18') {?>
    
    <td  style="padding:3px;"><?php  echo $rows['MEMBER_CO_NAME'];?></td>
    <td  style="padding:3px;"><?php echo $rows['MEMBER_ADDRESS1']." ".$rows['MEMBER_ADDRESS2']." ".$rows['MEMBER_ADDRESS3'];?></td>
    <td align="left"  style="padding:3px;"><?php echo $rows['IEC_NO'];?></td>
    <td align="left"  style="padding:3px;"><input type="checkbox" name="check_name[]" id="check_name" value="<?php  echo $rows['MEMBER_ID']."-".$rows['MEMBER_CO_NAME']."-".$rows['IEC_NO'];?>"></td>
    
	<?php }elseif($member_type=='19' || $member_type!=18){ ?>
    
    	<td  style="padding:3px;"><?php echo $rows['NON_MEMBER_NAME'];?></td>
        <td  style="padding:3px;"><?php echo $rows['ADDRESS1']." ".$rows['ADDRESS2']." ".$rows['ADDRESS3'];?></td>
    <td align="left"  style="padding:3px;"><?php echo $rows['IEC_NO'];?></td>
    <td align="left"  style="padding:3px;"><input type="checkbox" name="check_name[]" id="check_name" value="<?php echo $rows['NON_MEMBER_ID']."-".$rows['NON_MEMBER_NAME']."-".$rows['IEC_NO'];?>"></td>
    <?php } ?>
    
    
   
  </tr>
  

    <!--<tr>
    <td colspan="11"><input type="submit" name="Change Location" value="Change Location"  class="input_submit" /></td>
   </tr>-->
   <?php 
	}
	  
	}
	else
	{
	?>
     <tr>
     <td colspan="9" style="padding:3px;">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="6">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
	<?php } ?>
	 
</table>
<br>
<?php if($rCount>0){ ?>
<input type="hidden" name="type" value="<?php if($member_type=='18'){ echo "member";}else{ echo "nonmember"; } ?>">
<input class="input_bg" type="submit" value="Add" name="add" id="add" />
<input class="input_bg" type="submit" value="Cancel" name="cancel" />

<?php } ?>
</form>
</form>
</div>  

<?php } ?> 




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
