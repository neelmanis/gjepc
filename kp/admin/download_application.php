<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if(isset($_REQUEST['Download']) || $_REQUEST['Download']=="Download")
 		{
			 $_SESSION['location']=$_REQUEST['location_id'];
			$_SESSION['type']=$_REQUEST['doc_type'];
			$_SESSION['filter']=$_REQUEST['filter'];
			$_SESSION['from_date']=date("Y-m-d",strtotime($_REQUEST['from_date']));
			$_SESSION['to_date']=date("Y-m-d",strtotime($_REQUEST['to_date']));
 		header("location:export_application.php");
 		}
 elseif(isset($_REQUEST['hs_Download'])|| $_REQUEST['hs_Download']=="Download_HS" )
 		{
 			$_SESSION['location']=$_REQUEST['location_id'];
			$_SESSION['type']=$_REQUEST['doc_type'];
			$_SESSION['filter']=$_REQUEST['filter'];
			$_SESSION['from_date']=date("Y-m-d",strtotime($_REQUEST['from_date']));
			$_SESSION['to_date']=date("Y-m-d",strtotime($_REQUEST['to_date']));
 		header("location:export_HS.php");
	    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download Application || KP ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />





<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script> 
<!--<script type="text/javascript" src="js/jquery.js">
    </script>  -->  
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

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


<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
    
	<script type="text/javascript">
	
	function validation()
	{
		if($("#location_id").val()=="")
			{
				alert("Please select Location");
				return false;
			}
							var selected = $("input[type='radio'][name='doc_type']:checked");
			if (selected.length == 0)
			{
				alert("Please select type");
				return false;
			}
							
			var filter1 = $("input[type='radio'][name='filter']:checked");
			if (filter1.length == 0) 
			{
				alert("Please select filter");
				return false;
			}
			
			var value=$("input[name=filter]:checked").val();
    //var value = $(this).val();
	//alert(value);
	//return false;
			if(value=="2")
			{
				var dt1=$("#popupDatepicker").val();
									//alert(dt1);
									//return false;
				if(dt1=="From")
				{
					alert("please select from Date");
					return false;
				}
				var dt=$("#popupDatepicker1").val();
									
				if(dt=="To")
				{
					alert("please select To Date");
					return false;
				}
			}	
	}
	
	
	
	
	$(document).ready(function() {
			$("#date1").css("display","none");					   
			
			$(".filter1").change(function(){
				//var ans=$(this).val();
				//alert(ans);
					if($(this).val()=="2")
					{
						$("#date1").show();
					//alert(2);
					}
					else if($(this).val()=="1")
					{
						$("#date1").hide();
						//alert(1);
					}
				
			});
			
			
			
		});
		
		
		
		
	</script>
<!-- lightbox Thum -->
</head>

<body> 


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Download Application</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Download Application</div></div>
    	
      
<div class="content_details1">
<form name="search" id="search" action="" method="post" onsubmit="return validation()"> 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg1']."</span>";
$_SESSION['error_msg1']="";
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td width="19%" ><strong>Location</strong></td>
    <td width="81%"><select name="location_id" id="location_id" class="input_txt">
      <option value="">Please Select Location</option>
       <?php 
	   $sql="select * from kp_location_master";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   echo "<option value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
	   }
	   ?>	
     </select></td>
</tr>	
    
    
<tr >
  <td><strong>Type</strong></td>
  <td><input type="radio" name="doc_type" id="doc_type" class="doc_type" value="1" />Individual Files 
  <input type="radio" name="doc_type" id="doc_type" class="doc_type" value="2" />Supported Documents</td>
  </tr>

<tr >
  <td><strong>Filter</strong></td>
  <td><input type="radio" name="filter" id="filter" class="filter1"  value="1" />Not Downloaded
  <input type="radio" name="filter" id="filter" class="filter1"  value="2" />Downloaded</td>
  </tr>    
    
   
<tr class="onsearch" id="date1">
  <td><strong>From Date</strong></td>
  <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "From";}else{echo $_SESSION['from_date'];}?>"  class="input_date" />
      <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
  </tr>
  
  
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Download" id="Download" value="Download"  class="input_submit" /> <input type="submit" id="hs_Download" name="hs_Download" value="Download HS"  class="input_submit" /> <input type="submit" name="Close" value="Close"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>
	</div>
</div>
  


<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>



