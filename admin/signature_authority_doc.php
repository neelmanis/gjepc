<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
 <?php $app_id = $_REQUEST['app_id'] ;
   $registration_id = $_REQUEST['registration_id'] ;
   $exhibition_type=getExhibitionType($_REQUEST['app_id']);
   $ref_no = $_REQUEST['ref_no'];
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

<script type="text/javascript">   
$(document).ready(function() {   
$('#signature_authority').change(function(){
var type=$(this).val();	
if(type=="Other") 
   {   
   $('#other_sign').show();    
   }   
else 
   {   
   $('#other_sign').hide();      
   }   
});   
});   
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
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Trade permission</div>
</div>

<div id="main">
 
	<div class="content">
 <?php
$document = fetch('select * from trade_documents where app_id='.$app_id);
$app_status = fetch('select app_id,registration_id,permission_type, application_status , app_reason , app_reason_other  from trade_general_info where app_id='.$app_id);
?>
<div class="padding_width">
<div class="admin_trade_wrap">
<form action="trade_approval_documents_action.php" method="post" id="form1" name="form1" enctype='multipart/form-data' >

	<input type="hidden"  name="app_id" value="<?php echo $app_id ; ?>">
	<input type="hidden"  name="registration_id" value="<?php echo $registration_id ; ?>">
	<div class="trade_wrap">
	
    	<div class="trade_title">
        	<ul>
                <li class="active"><a href="#">Documents</a></li>
            </ul>
        </div>
        <div class="trade_form">
				<div class="trade_form_field">
            		<div class="trade_lable1">Indian Pavilion</div>
                    <input type="checkbox" class="check_box" id="indian_pavilion" <?php if($document[0]['indian_pavilion']=='Y') echo 'checked="checked"' ;?> name="indian_pavilion"  />
            	</div>
				
				<div class="clear"><br/></div>
                   <div class="trade_form_field">
            		<div class="trade_lable1">Copy of Valid IEC No.</div>
                 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="iec_status" disabled <?php if($document[0]['iec_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 					<div class="admin_trade_redio"><input type="radio" name="iec_status" disabled <?php if($document[0]['iec_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
            	 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['iec_no_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;"  href="../images/Tradephoto/ieccopy/<?php echo $document[0]['iec_no_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Copy of Valid Mem Cer.</div>
                   
            	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="member_status" disabled <?php if($document[0]['member_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved </div>
 					<div class="admin_trade_redio"><input type="radio" name="member_status" disabled <?php if($document[0]['member_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved </div>
            	
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['member_cer_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/member_cer_copy/<?php echo $document[0]['member_cer_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				
				
				</div>
                
                 <div class="clear"><br/></div>    
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Letter from Fair Organi.</div>
                  
            	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="fair_status" disabled <?php if($document[0]['fair_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 					<div class="admin_trade_redio"><input type="radio" name="fair_status" disabled <?php if($document[0]['fair_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['fair_org_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/fair_org_copy/<?php echo $document[0]['fair_org_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">3 Years Past Exports Ex.</div>
                 
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="past_status" disabled <?php if($document[0]['past_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 					<div class="admin_trade_redio"><input type="radio" name="past_status" disabled <?php if($document[0]['past_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['past_org_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/past_org_copy/<?php echo $document[0]['past_org_upload'];?>">view file</a>
				 <?PHP } ?>
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Passport Photocopy of.</div>
                   
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="passport_status" disabled <?php if($document[0]['passport_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 					<div class="admin_trade_redio"><input type="radio" name="passport_status" disabled <?php if($document[0]['passport_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
             <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['passport_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/passport_copy/<?php echo $document[0]['passport_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				
				
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Brand Regs Certificate.</div>
                  
            	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="brand_status" disabled <?php if($document[0]['brand_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 					<div class="admin_trade_redio"><input type="radio" name="brand_status" disabled <?php if($document[0]['brand_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['brand_cer_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/brand_cer_copy/<?php echo $document[0]['brand_cer_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				
				
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Proof of Authenticity o.</div>
                  
            	
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
					<div class="admin_trade_redio"><input type="radio" name="proof_status" disabled <?php if($document[0]['proof_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 					<div class="admin_trade_redio"><input type="radio" name="proof_status" disabled <?php if($document[0]['proof_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['proof_authenticity_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/proof_authenticity_copy/<?php echo $document[0]['proof_authenticity_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Proof of Contract with.</div>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio"><input type="radio" name="contract_status" disabled <?php if($document[0]['contract_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
<div class="admin_trade_redio"><input type="radio" name="contract_status" disabled <?php if($document[0]['contract_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['contract_with_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/contract_with_copy/<?php echo $document[0]['contract_with_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				</div>
				 <div class="clear"><br/></div>
				 
				<div class="trade_form_field">
            		<div class="trade_lable1">Print Acknowledgement.</div>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				
				
				<?php if($app_status[0]['permission_type']=="exhibition") { ?>
				<div class="admin_trade_redio">
        <a href="trade_exh_print_ack.php?app_id=<?php echo $app_status[0]['app_id']; ?>&&registraton_id=<?php echo $app_status[0]["registration_id"]; ?>&ref_no=<?php echo $ref_no;?>" target="_blank" style="color:#000000">Print</a>
        </div>
        <?php }?>
        <?php if($app_status[0]['permission_type']=="promotional_tour"){?>
       <div class="admin_trade_redio">
        <a href="trade_other_print_ack.php?app_id=<?php echo $app_status[0]['app_id']; ?>&&registraton_id=<?php echo $app_status[0]["registration_id"]; ?>&ref_no=<?php echo $ref_no;?>" target="_blank" style="color:#000000">Print</a>
        </div>
        <?php }?>
				</div>
				
                 <div class="clear"><br/></div>  
				 <div class="trade_form_field">
            		<div class="trade_lable1">Application status</div>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio"><input type="radio" name="application_status" disabled <?php if($app_status[0]['application_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
                    <div class="admin_trade_redio"><input type="radio" name="application_status" disabled <?php if($app_status[0]['application_status']=="C") { ?> checked <?php } ?> value="C"></div><div class="admin_trade_lable">Cancelled</div>
					<div class="admin_trade_redio"><input type="radio" name="application_status" disabled <?php if($app_status[0]['application_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
                    <div class="clear"><br/></div>
      					<div class="admin_trade_lable"><b>Disapproved Reason:</b></div>
                        <div class="admin_trade_redio">    
                        <!--<textarea name="app_reason"><?php echo $app_status[0]['app_reason'] ; ?></textarea>-->
                        <select multiple name="app_reason[]" style="width:450px;" disabled>
                            <option value="Kindly attach an IEC Certificate" <?php if (preg_match("/Kindly attach an IEC Certificate/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly attach an IEC Certificate</option>
                            
                            <option value="Kindly attach annual membership certificate of GJEPC" <?php if (preg_match("/Kindly attach annual membership certificate of GJEPC/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly attach annual membership certificate of GJEPC</option>
                            
                            <option value="Kindly attach all documents stamped & signed by authorized signatory" <?php if (preg_match("/Kindly attach all documents stamped & signed by authorized signatory/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly attach all documents stamped & signed by authorized signatory</option>
                            
                            <option value="Invoice value is exceeding the limit of 1 Million for Promotion Tour" <?php if (preg_match("/Invoice value is exceeding the limit of 1 Million for Promotion Tour/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Invoice value is exceeding the limit of 1 Million for Promotion Tour</option>
                            
                            <option value="Kindly Attach Export performance for past 3 years" <?php if (preg_match("/Kindly Attach Export performance for past 3 years/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly Attach Export performance for past 3 years</option>
                            
                            <option value="Kindly attach passport copy of person carrying goods for Exhibition/Promotion tour" <?php if (preg_match("/Kindly attach passport copy of person carrying goods for Exhibition/Promotion tour/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly attach passport copy of person carrying goods for Exhibition/Promotion tour</option>
                            
                            <option value="Kindly provide proper communication Email-Id" <?php if (preg_match("/Kindly provide proper communication Email-Id/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly provide proper communication Email-Id</option>
                            
                            <option value="Kindly attach organizers invitation letter printed on the letter head of organizer containing exhibition details like: show dates, venue address & organizer address" <?php if (preg_match("/Kindly attach organizers invitation letter printed on the letter head of organizer containing exhibition details like: show dates, venue address & organizer address/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>> Kindly attach organizers invitation letter printed on the letter head of organizer containing exhibition details like: show dates, venue address & organizer address</option>
                            
                            <option value="Kindly provide proper description of your goods" <?php if (preg_match("/Kindly provide proper description of your goods/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Kindly provide proper description of your goods</option>
                            
                            <option value="other" <?php if (preg_match("/other/", $app_status[0]['app_reason'])){?> selected="selected" <?php }?>>Others</option> 
                        </select> 
                        </div>
				</div>
                <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Application disapprove reason if others</div>
					<div class="admin_trade_redio">
                    	<textarea name="app_reason_other" readonly="readonly"><?php echo $app_status[0]['app_reason_other']?></textarea>
                    </div>
				</div>
				 <div class="clear"><br/></div>
                 
				 <div class="trade_form_field">
            		<div class="trade_lable1">Application Approved By:</div>
				 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio">
                    	<?php echo $document[0]['approved_by'];?>
                    </div>
				 </div>				 
                 <div class="clear"><br/></div>
			</div>
            
        <div class="clear"></div>
        </div>
        </form>    
    </div>
</div>

</div>    
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>