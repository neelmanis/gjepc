<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Registration ||GJEPC||</title>

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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Registration</div>
</div>

<div id="main"> 
	<div class="content">
    	<div class="content_head">Manage Registration
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_registration.php?action=view">Back to Registration</a></div>
        <?php }?>
        </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="1" class="detail_txt" >
  	<tr class="orange1">
        <td width="90%" >Page Name</td>
        <td width="10%" align="center">Action</td>
    </tr>

<tr bgcolor='#CCCCCC'>
    <td>GJEPC</td>
    <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
</tr>
	<tr>
        <td style="padding-left:35px;">About GJEPC</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">Committee of administration</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    
        <tr>
            <td style="padding-left:70px;">Committee of administration</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        </tr>
    
         <tr>
            <td style="padding-left:70px;">Exhibition Sub - Committee</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        </tr>
    
             <tr>
                <td style="padding-left:105px;">National</td>
                <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
            </tr>
    
             <tr>
                <td style="padding-left:105px;">International</td>
                <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
            </tr>
    
     <tr>
        <td style="padding-left:70px;"> PM & BD</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    
    <tr>
        <td style="padding-left:35px;">Ideal Cut News Letter</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">Regional Office</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">Tenders</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">Holiday List for the Year 2013</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">Archives</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">40th Annual Awards</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    
<tr bgcolor='#CCCCCC'>
    <td>Council Initiatives</td>
    <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
</tr>    
     <tr>
        <td style="padding-left:35px;">Event Channel</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    	<tr>
            <td style="padding-left:70px;">Indo Russian Diamond BSM</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IIJS</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IIJW-India Int'l Jewellery Week-Delhi 2013</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IIJS-Signature</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">WSC-World Skills Competition</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">Annual Award</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">TJF-Trends Jewellery Forecasting Seminar</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">WCC-Int'l Jewellery Summit</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">Anant - India Diamond Jewellery Promotion</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">Mines to Market - Int'l Diamond Conference</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">Mines to Market - Int'l Colored Gemstone Conference</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        
        
    <tr>
        <td style="padding-left:35px;">International</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    <tr>
        <td style="padding-left:35px;">Education Initiatives</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    	<tr>
            <td style="padding-left:70px;">IDI Surat</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">GII Mumbai</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IIGJ Mumbai</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IIGJ Delhi</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IIGJ Jaipur</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
    <tr>
        <td style="padding-left:35px;">Seminars</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    	<tr>
            <td style="padding-left:70px;">Banking Symposuim</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">India International Gold Convention 2013</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
    <tr>
        <td style="padding-left:35px;">Value Added Services</td>
        <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 	</tr>
    	<tr>
            <td style="padding-left:70px;">GTL Jaipur</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        <tr>
            <td style="padding-left:70px;">IGI - Delhi</td>
            <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
 		</tr>
        
<tr bgcolor='#CCCCCC'>
    <td>News</td>
    <td align="center"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
</tr>    

</table>
</div>
<?php } ?>        
 </div> 
</div> 


<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
