<?php
ob_start();
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');

$registration_id	=	intval(filter($_REQUEST['registration_id']));
$app_id				=	intval(filter($_REQUEST['app_id']));
$exhibition_type 	= getExhibitionType($_REQUEST['app_id'],$conn);
?>
<?php
 if(isset($_REQUEST['submit']))
 {
	$emailid = fetch('select email_id from registration_master where id='.$registration_id);
	$email_id = $emailid[0]['email_id'] ;
	$idarray = $_SESSION['idarray'] ;
	 $message1 = '';
	 for($i=0;$i<count($idarray);$i++)
		{
		 $exh_id = $_POST['exh_id'][$i];
		 $exhibition_id=$_POST['exhibition_1'][$i];
		
		 $exhibitionName_1=$_POST['exhibitionName_1'][$i];
		
		 $dateFrom_1=$_POST['dateFrom_1'][$i];
		 $dateTo_1=$_POST['dateTo_1'][$i];
		 $organizer_address=$_POST['organizer_address'][$i];
		 $venue_address=$_POST['venue_address'][$i];
		 if($_POST['exh_status'][$i]=="Y") { $_POST['reason'][$i] = "" ; }
		 $exh_status=$_POST['exh_status'][$i];
		 if($exh_status=="N") { $exh_status1 = 'Disapproved' ;}
		 if($exh_status=="Y") { $exh_status1 = 'Approved' ;}
		 
		$reason=$_POST['reason'][$i];
		$message1 .= $exhibitionName_1.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$exh_status1.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$reason.'<br/>' ;	
		 
		$sql = "UPDATE `trade_exhibition_info` SET 
						`exhibition_id`     = '$exhibitionName_1',			 
						`exhibition_date_from`     = '$dateFrom_1',
						`exhibition_date_to`     = '$dateTo_1',
						`organizer_address`     = '$organizer_address',
						`venue_address`     = '$venue_address',
						`exh_status`     = '$exh_status',
						`reason`     = '$reason'";	
					 
		$sql .= "WHERE `exh_id` 	= '$exh_id'  ;";
		$result = $conn ->query($sql); 	 
 }
    $message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td width="150" align="left"><img src="http://www.gjepc.org/images/logo_gjepc.png" width="150" height="91" /></td>
          <td width="85%" align="right"><img src="http://www.gjepc.org/images/logo_in.png" width="105" height="91" /></td>
        </tr>
      </table>
	 </td>
  </tr>
  
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>  
	<tr>
		<td>&nbsp; </td>
	</tr>
	
 <tr>
    <td align="left"  style="text-align:justify;"><strong>Exhibition &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; status   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;reason</strong> </td>
  </tr>
  
  <tr>
    <td align="left"  style="text-align:justify;">'. $message1 .' </td>
  </tr>
    
  <tr>
    <td>&nbsp; </td>
  </tr>
  
  <tr>
    <td>&nbsp; </td>
  </tr>
  
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>
 </table>';
	
	 $to =$email_id;
	 $subject = "exhibition approval/disapproval report for trade application"; 
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <admin@gjepc.org>' . "\r\n";
  
    mail($to, $subject, $message, $headers);
    header('location:trade_approval_documents.php?app_id='.$app_id."&registration_id=".$registration_id);
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

<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" />
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
/*$(function() {
	$('.dateTo_1').datepick();
	$('.dateFrom_1').datepick();
	
});*/

function validate()
{
	/*var multi_members=[];


	$("input[name='exhibition_1[]']").each(function() {
    //alert($(this).val());
	multi_members=$(this).val();
	
	if(multi_members=="")
	{
		alert('please select Exhibition Name');
		return false;
	}
	
	});*/
//alert(multi_members);
	return false;
}
</script>
<link rel="stylesheet" type="text/css" href="css/trade_approval.css"/>
</head>

<body>
<div id="header_wrapper">
  <?php include("include/header.php");?>
</div>
<div id="nav_wrapper">
  <div class="nav">
    <?php include("include/menu.php");?>
</div>
</div>
<div class="clear"></div>
<div class="breadcome_wrap">
  <div class="breadcome"><a href="admin.php">Home</a> > Manage Trade permission</div>
</div>
<div id="main">
<?php
$exh = fetch("select * from trade_exhibition_info where app_id='$app_id'  order by exh_id ASC");
//echo "select * from trade_exhibition_info where app_id='$app_id'  order by exh_id ASC";
(count($exh)==0)? $exhcount = count($exh)+1 : $exhcount = count($exh);
?>
  <div class="content">
    <div class="padding_width_head">Exhibition </div>
    <div class="admin_trade_wrap">
      <div class="trade_title">
        <ul>
          <li><a href="trade_approval.php?app_id=<?php echo $app_id; ?>&&registration_id=<?php echo $registration_id;?>">General</a></li>
          <?php if($exhibition_type=="exhibition" || $exhibition_type==""){ ?>
        	<li class="active"><a href="trade_exhibition.php?app_id=<?php echo $_REQUEST['app_id'] ; ?>&&registration_id=<?php echo $_REQUEST['registration_id'] ; ?>">Exhibition</a></li>
           <?php }?>
          <li><a href="trade_approval_documents.php?app_id=<?php echo $_REQUEST['app_id'] ; ?>&&registration_id=<?php echo $registration_id ;?>">Documents</a></li>
        </ul>
      </div>
	  
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="exh_from" method="post">
        <div class="exhibitionContainer">
        <?php
		$idarray = array() ;
		for($i=0;$i<$exhcount;$i++)
		{ 
		$idarray[] = $exh[$i]['exh_id'];	
		?>
          <div class="exhibitionGrp">
            <?php $sql_exh = fetch('select * from trade_exhibition_master  where Exhibition_Id='.$exh[$i]['exhibition_id']);?>
            <div class="padding_width_head"><?php echo $sql_exh[0]['Exhibition_Name']; ?></div>
            <div class="clear"></div>
            <div class="trade_form_field">
                <div class="trade_lable1"> Exhibition Name </div>			   
                <div class="trade_input">			
                <?php $exh_list  = fetch('select * from trade_exhibition_master'); ?>
                <select name="exhibitionName_1[]" id="exhibitionName_1[]" class="trade_input_text">
                <?php
                for($j=0;$j<count($exh_list);$j++)
                {  
				$sql_exh = fetch('select * from trade_exhibition_master where Exhibition_Id='.$exh[$i]['exhibition_id']);
                ?>
                <option value=<?php echo $exh_list[$j]['Exhibition_Id']; ?> <?php if($sql_exh[0]['Exhibition_Name']==$exh_list[$j]['Exhibition_Name']) echo 'selected="selected"'; ?>><?php echo $exh_list[$j]['Exhibition_Name']; ?></option>
                <?php } ?>
                </select>
              </div>
            </div>
            <input type="hidden" class="trade_input_text" name="exh_id[]"  value="<?php echo $exh[$i]['exh_id']; ?>" >
            <div class="clear"></div>
            <div class="trade_form_field">
              <div class="trade_lable1">Exhibition Date From </div>
              <div class="trade_input">
                <input type="text" class="trade_input_text datepicker fromdate" name="dateFrom_1[]" id="dateFrom_1[]" value="<?php echo $exh[$i]['exhibition_date_from']; ?>">
              </div>
            </div>
            <div class="clear"></div>
            <div class="trade_form_field">
              <div class="trade_lable1">Exhibition Date To </div>
              <div class="trade_input">
                <input type="text" class="trade_input_text datepicker todate" name="dateTo_1[]" id="dateTo_1[]" value="<?php echo $exh[$i]['exhibition_date_to']; ?>">
              </div>
            </div>
            <div class="clear"></div>
            <div class="trade_form_field">
              <div class="trade_lable1">Organizer address </div>
              <div class="trade_input">
                <input type="text" class="trade_input_text" name="organizer_address[]" id="organizer_address[]" value="<?php echo $exh[$i]['organizer_address']; ?>" >
              </div>
            </div>
            <div class="clear"></div>
            <div class="trade_form_field">
              <div class="trade_lable1">Venue address </div>
              <div class="trade_input">
                <input type="text" class="trade_input_text" name="venue_address[]" id="venue_address[]" value="<?php echo $exh[$i]['venue_address']; ?>">
              </div>
            </div>
            <div class="clear"></div>
            <div class="trade_form_field">
              <div class="trade_lable1">Status</div>
              <select name="exh_status[]" id="myselect">
                <option value="P" <?php if($exh[$i]['exh_status']=="P") echo 'selected="selected"' ; ?>>Pending</option>
                <option value="Y" <?php if($exh[$i]['exh_status']=="Y") echo 'selected="selected"' ; ?>>Approved</option>
                <option value="N" <?php if($exh[$i]['exh_status']=="N") echo 'selected="selected"' ; ?>>Disapproved</option>
              </select>
            </div>
            <div class="clear"></div>
            <div class="trade_form_field">
              <div class="trade_lable1">Reason</div>
              <textarea name="reason[]"><?php echo $exh[$i]['reason'];?></textarea>
            </div>
            <div class="clear"></div>
          </div>
          <?php } $_SESSION['idarray'] = $idarray;?>
        </div>
        <input type="hidden" name="exhcount" value="<?php echo $exhcount; ?>">
        <input type="hidden" name="app_id" value="<?php echo $app_id; ?>">
        <input type="hidden" name="registration_id" value="<?php echo $registration_id; ?>">
        <input type="hidden" name="idarray" value="<?php echo $_SESSION['idarray']; ?>">
        <div class="trade_form_field">
        <div class="register-button">
        <input type="submit" name="submit" value="Update" id="BtnSubmit">
        </div>
        <div class="register-button"><a href="trade_approval_documents.php?app_id=<?php echo $app_id; ?>&&registration_id=<?php echo $registration_id; ?>">
        <input type="button" name="next" value="Next" id="BtnCancel">
        </a> 
		</div>
          <div class="clear"> </div>
        </div>
      </form>
    </div>

<!-- Right Table -->
<script type="text/javascript">
(function($){
	/*var duplicate = $('.exhibitionGrp').last();*/
	$('[id="exhibitionName_1[]"]').change(function(){
				//alert($( this ).val());
				 var exh_id = $(this).val();
				//var reg_id =$('#registration_id').val();
			
			  $.ajax({ type: 'POST',
					url: 'ajax_trade.php',
					data: "actiontype=exh_option&&exh_id="+exh_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						 if($.trim(data)!=""){
							 //$('#selected_area').html(data);
							 data=data.split("#");
							 //alert(data);
							$('[id="dateFrom_1[]"]').val(data[0]);
							  $('[id="dateTo_1[]"]').val(data[1]);
							   $('[id="organizer_address[]"]').val(data[2]);
							   $('[id="venue_address[]"]').val(data[3]);
							   //$("#pincode").val(data[4]);
							 	//$("#communication_id").val(data[6]);
						 }
					}
		});
		
		});
		
	$('.add_field_button').live('click',function(e){ 
		e.preventDefault();

		$('.exhibitionGrp').each(function(index,element){
			$(this).find('.datepicker').datepick('destroy');
		});

		var duplicate = $('.exhibitionGrp').last();

		var cloned = duplicate.clone()
			.appendTo('.exhibitionContainer');
		
		$('.exhibitionGrp').each(function(index,element){
			$(this).find('.datepicker').datepick({dateFormat: "yyyy-mm-dd"});
		});
	
		cloned.find('div.trade_lable1, div.head,input').each(function(index, element){

			var currText = $(this).text();
			var labelData = currText.split(' ');
			var lastspace = currText.lastIndexOf(' ');
			var stripText = currText.substring(0, lastspace);

			var replaceLabel = stripText +' '+ currText.replace(currText, parseInt(labelData[labelData.length-1])+1);
			
			$(this).text(replaceLabel);
			
			var elem = $(this);
			
			if(elem.attr('type')=="text")
			 	elem.val('');
			else
				elem.removeAttr('checked');
		});		
	});

	$('.remove_field_button').bind('click',function(e){ 
		e.preventDefault();
		var exhibitorDiv = $('.exhibitionGrp');

		if(exhibitorDiv.length > 1){
			exhibitorDiv.last().remove();
		}
	});

	$('.datepicker').datepick({
	dateFormat: 'yyyy-mm-dd'
	});	
	
	$("#sub").click(function(e){
		e.preventDefault();
		//alert(myElements = document.getElementsByName("exhibition_1[]").length );		
		j=1;
		for (i=0; i<document.getElementsByName("exhibition_1[]").length; i++) { 
		//alert(document.getElementsByName("exhibition_1[]")[i].value);
		  if (!document.getElementsByName("checkbox_1[]")[i].checked) { 
		   alert("please Select Under Council "+j);
		   return false; 
		  } 
		  
		  if (document.getElementsByName("exhibition_1[]")[i].value=='') { 
		   alert("please enter Exhibition Id "+j);
		   return false; 
		  } 
		  
		  if (document.getElementsByName("exhibitionName_1[]")[i].value=='') { 
		   alert("please enter Exhibition Name "+j);
		   return false; 
		  } 
		  
		  if (document.getElementsByName("dateFrom_1[]")[i].value=='') { 
		   alert("please enter Date From "+j);
		   return false; 
		  } 		  
		  
		  if (document.getElementsByName("dateTo_1[]")[i].value=='') { 
		   alert("please enter Date To "+j);
		   return false; 
		  }
		  
		date_from=Date.parse(document.getElementsByName("dateFrom_1[]")[i].value);
		date_to=Date.parse(document.getElementsByName("dateTo_1[]")[i].value);
		  
		function daydiff(date_from, date_to) {
  			  return (date_to-date_from)/(1000*60*60*24);
		 }
		// alert(daydiff(date_from,date_to));
		  
		  date3 = date_to - date_from;
		  daysDiff = Math.floor(date3 / (24*60*60*1000));

  			//alert(daysDiff);
			// if(daysDiff>45)
			// {
			// 	alert("The from date and to date should not exceed 45 days");
			// 	return false;				
			// }
		
			//return false;
  			if(document.getElementsByName("organizer_address[]")[i].value=='') { 
		     alert("please enter Organizer Address "+j);
		     return false; 
		    } 
		  
		  if (document.getElementsByName("venue_address[]")[i].value=='') { 
		   alert("please enter Venue Address "+j);
		   return false; 
		  } 
		  j++;
 		} 
	});
}(jQuery));

</script>
  </div>
</div>
</div>
<div id="footer_wrap">
  <?php include("include/footer.php");?>
</div>
</body>
</html>
