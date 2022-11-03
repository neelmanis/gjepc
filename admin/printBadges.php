<?php
ob_start();
session_start();
include('../db.inc.php');

if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
{
$id=$_REQUEST['id'];
$sqlx="select * from igjs_summit_registration where id='$id'";
$query=mysql_query($sqlx);
$result=mysql_fetch_array($query);

$name=stripslashes($result['name']);
$category=htmlentities(strip_tags($result['category']));
$company=htmlentities(strip_tags($result['company']));
$print_category=htmlentities(strip_tags($result['print_category']));
}
?>
<a onClick="PrintContent();" target="_blank" class="no-print" style="cursor:pointer;float:left;color:#FF0000;font-size:15px;">Print</a>
<div id="divtoprint">
<table cellpadding="0" cellspacing="0" style="width:299px; height:218px; margin:0 auto; border-bottom:6px solid #6d1810; font-family:Arial, Helvetica, sans-serif;" >
  <tr>
    <td colspan="3" style="border:1px solid #6d1810; height:139px; padding:0; "><img src="banner.jpg"></td>
  </tr>
  <tr>
    <td  colspan="3" style="border:1px solid #6d1810; border-right:none; font-family:Arial, Helvetica, sans-serif; text-align:right; padding-right:20px; font-size:16px;"> <?php echo $name;?> </td>
  </tr>
  <tr>
    <td ><img src="https://chart.googleapis.com/chart?chs=60x60&cht=qr&chl=<?php echo $id;?>"/></td>
    
    <?php if($category=='Organiser'){?>
    	<td style="background:#6fc490;"><img src="line.png"> </td>
    	<td style="background:#6fc490; height:37px; font-size:16px; padding-bottom:4px; padding-right:5px;"> 
    <?php } else if($category=='Speaker'){?>
    	<td style="background:#b83626;"><img src="line.png"></td>
    	<td style="background:#b83626; height:37px; font-size:16px; padding-bottom:4px; color:#ededed; padding-right:40px;">
     <?php } else if($category=='Guest'){?>
     <td style="background:#b83626;"><img src="line.png"></td>
     <td style="background:#b83626; height:37px; font-size:16px; padding-bottom:4px; color:#ededed; padding-right:50px;">
     <?php } else if($category=='Delegate'){?>
     <td style="background:#e5e515;"><img src="line.png"></td>
     <td style="background:#e5e515; height:37px; font-size:16px; padding-bottom:4px; padding-right:40px;">
     <?php } else if($category=='Partner'){?>
     <td style="background:#f7941e;"><img src="line.png"></td>
     <td style="background:#f7941e; height:37px; font-size:16px; padding-bottom:4px; padding-right:40px;">
     <?php } else if($category=='Media'){?>
     <td style="background:#e70581;"><img src="line.png"></td>
     <td style="background:#e70581; height:37px; font-size:16px; padding-bottom:4px; padding-right:45px;">
     <?php } else if($category=='VIP'){?>
     <td style="background:#8b8d90;"><img src="line.png"></td>
     <td style="background:#8b8d90; height:37px; font-size:16px; padding-bottom:4px; padding-right:65px;">
     <?php } else if($category=='Committe Member'){?>
     <td style="background:#a0cd4d;"><img src="line.png"></td>
     <td style="background:#a0cd4d; height:37px; font-size:16px; padding-bottom:4px; padding-right:5px;">
    	<?php }?>
		<?php if($print_category!=''){echo $print_category;}else {echo $category;}?> 
    </td>
  </tr>
</table>
</div>
<script type="text/javascript">
function PrintContent(){
	var DocumentContainer = document.getElementById("divtoprint");
	var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);	
	setTimeout(function() { // wait until all resources loaded        
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
     }, 2000);	
}
</script>