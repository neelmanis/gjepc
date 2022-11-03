<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');
$role = $_SESSION['curruser_role'];
//echo $role;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Application || KP ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />





<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick({ dateFormat: 'yyyy-mm-dd' });
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick({ dateFormat: 'yyyy-mm-dd' });
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

<!--Print table-->
     <script type="text/javascript">
	 var adminrole = "<?php echo $role; ?>"
	 if(adminrole == "bank")
	 { 
        $("#bankb").live("click", function () {
            var divContents = $("#bankt").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>DIV Contents</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
     }
	 else
	 {
	  $("#customb").live("click", function () {
            var divContents = $("#customt").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>DIV Contents</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
	 }
    </script>

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
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
	<div class="breadcome"><a href="report.php">Home</a> > Report generation</div>
</div>

<div id="main">
	     
<div class="content_details1">
<form name="search" action="#" method="post" > 
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

<tr >
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "From";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
     <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
</tr>    
    
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="submit" id="submit" value="Submit"  class="input_submit" /> </td>
   
</tr>	
</table>
</form>    
<?php
 if(isset($_POST))
   { //print_r($_POST);
   $frmdate = $_POST['from_date'];
   $todate  = $_POST['to_date'];
     if($role == 'bank')
	 {
	  	 if(!empty($frmdate) && !empty($todate))
			{
				 $sql = "SELECT kpno, carat, amount FROM kp_admin_erpweb where 
					approved_bank_date between '".$frmdate."'  and '".$todate."'";
			   $result = mysql_query($sql);
			   $num = mysql_num_rows($result);
	   //echo $num;
						if ($num > 0) 
						{
						echo "<div id='bankt'>
							<table border='1' align='center' bgcolor='#e5ecff' width='30%'>
							<tr><th>KP NO</th><th>Carat</th><th>Amount</th></tr>";
							// output data of each row
							while($row = mysql_fetch_array($result)) 
							{
						echo "<tr><td align='center'>".$row["kpno"]."</td><td align='center'>".$row["carat"]."</td><td align='center'> ".$row["amount"]."</td></tr>";
							}
							echo "</table>";
							echo   "</div>";
							echo "<button type='button' id='bankb'>Print</button>";
						} else 
						{
							echo "0 results";
						}
			}
			}
	else
	{
	
		   if(!empty($frmdate) && !empty($todate))
				{
					 $sql = "SELECT kpno, carat, amount FROM kp_admin_erpweb where 
						approved_custom_date between '".$frmdate."'  and '".$todate."'";
				   $result = mysql_query($sql);
				   $num = mysql_num_rows($result);
		   //echo $num;
							if ($num > 0) 
							{
							echo "<div id='bankt'>
								<table border='1' align='center' bgcolor='#e5ecff' width='30%'>
								<tr><th>KP NO</th><th>Carat</th><th>Amount</th></tr>";
								// output data of each row
								while($row = mysql_fetch_array($result)) 
								{
							echo "<tr><td align='center'>".$row["kpno"]."</td><td align='center'>".$row["carat"]."</td><td align='center'> ".$row["amount"]."</td></tr>";
								}
								echo "</table>";
								echo   "</div>";
								echo "<button type='button' id='bankb'>Print</button>";
							} else 
							{
								echo "0 results";
							}
				}
	  
	  		
	 }
  }
  ?>
</div>
</div>


<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
