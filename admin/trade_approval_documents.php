<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>

<?php
$registration_id = intval($_REQUEST['registration_id']);
$app_id = intval($_REQUEST['app_id']);
$exhibition_type = getExhibitionType($_REQUEST['app_id'],$conn); 
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
    // $(document).ready(function(){
        // $('select').change(function(){
            // $( "select option:selected").each(function(){
            
                // if($(this).attr("value")=="N"){
                    
                    // $(".reason").show();
                // }
				 // if($(this).attr("value")=="P" || $(this).attr("value")=="Y" ){
                    
                    // $(".reason").hide();
                // }
            // });
        // }).change();
    // });
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
$app_status = fetch('select application_status , app_reason ,app_reason_other  from trade_general_info where app_id='.$app_id);

?>
<div class="padding_width">
<div class="admin_trade_wrap">

<form action="trade_approval_documents_action.php" method="post" id="form1" name="form1" enctype='multipart/form-data'>
<div class="padding_width_head">Documents </div>
	<input type="hidden"  name="app_id" value="<?php echo $app_id; ?>">
	<input type="hidden"  name="registration_id" value="<?php echo $registration_id; ?>">
	<div class="trade_wrap">
	
    	<div class="trade_title">
        	<ul>
            <li><a href="trade_approval.php?app_id=<?php echo $_REQUEST['app_id'] ; ?>&&registration_id=<?php echo $_REQUEST['registration_id'] ; ?>">General</a></li>
            <?php if($exhibition_type=="exhibition" || $exhibition_type==""){ ?>
        	<li><a href="trade_exhibition.php?app_id=<?php echo $_REQUEST['app_id'] ; ?>&&registration_id=<?php echo $_REQUEST['registration_id'] ; ?>">Exhibition</a></li>
            <?php } ?>
            <li class="active"><a href="#">Documents</a></li>
            </ul>
        </div>
        <div class="trade_form">
				<div class="trade_form_field">
            	<div class="trade_lable1">Indian Pavilion</div>
                <input type="checkbox" class="check_box" id="indian_pavilion" <?php if($document[0]['indian_pavilion']=='Y') echo 'checked="checked"';?> name="indian_pavilion"/>
            	</div>
				
				<div class="clear"><br/></div>
                <div class="trade_form_field">
            	<div class="trade_lable1">Copy of Valid IEC No.</div>                 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="iec_status" <?php if($document[0]['iec_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 				<div class="admin_trade_redio"><input type="radio" name="iec_status" <?php if($document[0]['iec_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
            	 <?php if($document[0]['indian_pavilion']=='N' && $document[0]['iec_no_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;"  href="../images/Tradephoto/ieccopy/<?php echo $document[0]['iec_no_upload'] ; ?>">view file</a>
				 <?PHP } ?>				
				</div>                
                 <div class="clear"><br/></div>
                 
                <div class="trade_form_field">
            		<div class="trade_lable1">Copy of Valid Mem Cer.</div>                   
            	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="member_status" <?php if($document[0]['member_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved </div>
 				<div class="admin_trade_redio"><input type="radio" name="member_status" <?php if($document[0]['member_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved </div>
            	
				<?php if($document[0]['indian_pavilion']=='N' && $document[0]['member_cer_upload']!='') { ?>
				<a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/member_cer_copy/<?php echo $document[0]['member_cer_upload'] ; ?>">view file</a>
				 <?PHP } ?>					
				</div>
                
                 <div class="clear"><br/></div>    
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Letter from Fair Organi.</div>                             	
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="fair_status" <?php if($document[0]['fair_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 				<div class="admin_trade_redio"><input type="radio" name="fair_status" <?php if($document[0]['fair_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['fair_org_upload']!='') { ?>
				<a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/fair_org_copy/<?php echo $document[0]['fair_org_upload']; ?>">view file</a>
				 <?PHP } ?>				
				</div>                
                <div class="clear"><br/></div>                 
                <div class="trade_form_field">
            	<div class="trade_lable1">3 Years Past Exports Ex.</div>                 
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="past_status" <?php if($document[0]['past_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 				<div class="admin_trade_redio"><input type="radio" name="past_status" <?php if($document[0]['past_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['past_org_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/past_org_copy/<?php echo $document[0]['past_org_upload'];?>">view file</a>
				 <?PHP } ?>
				</div>                
                <div class="clear"><br/></div>
                 
                <div class="trade_form_field">
            		<div class="trade_lable1">Passport Photocopy of.</div>
                   
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="passport_status" <?php if($document[0]['passport_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 				<div class="admin_trade_redio"><input type="radio" name="passport_status" <?php if($document[0]['passport_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				<?php if($document[0]['indian_pavilion']=='N' && $document[0]['passport_upload']!='') { ?>
				<a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/passport_copy/<?php echo $document[0]['passport_upload'] ; ?>">view file</a>
				<?PHP } ?>					
				</div>
                
                <div class="clear"><br/></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable1">Brand Regs Certificate.</div>
                 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="brand_status" <?php if($document[0]['brand_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 				<div class="admin_trade_redio"><input type="radio" name="brand_status" <?php if($document[0]['brand_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				<?php if($document[0]['indian_pavilion']=='N' && $document[0]['brand_cer_upload']!='') { ?>
				<a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/brand_cer_copy/<?php echo $document[0]['brand_cer_upload'] ; ?>">view file</a>
				 <?PHP } ?>				
				</div>                
                <div class="clear"><br/></div>
                 
                <div class="trade_form_field">
            	<div class="trade_lable1">Proof of Authenticity o.</div>
                 
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					
				<div class="admin_trade_redio"><input type="radio" name="proof_status" <?php if($document[0]['proof_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
 				<div class="admin_trade_redio"><input type="radio" name="proof_status" <?php if($document[0]['proof_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['proof_authenticity_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/proof_authenticity_copy/<?php echo $document[0]['proof_authenticity_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				</div>
                
                 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Proof of Contract with.</div>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio"><input type="radio" name="contract_status" <?php if($document[0]['contract_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
<div class="admin_trade_redio"><input type="radio" name="contract_status" <?php if($document[0]['contract_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
				 <?php  if($document[0]['indian_pavilion']=='N' && $document[0]['contract_with_upload']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/contract_with_copy/<?php echo $document[0]['contract_with_upload'] ; ?>">view file</a>
				 <?PHP } ?>
				</div>
                 <div class="clear"><br/></div>  
				 <div class="trade_form_field">
            		<div class="trade_lable1">Application status</div>
				 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio"><input type="radio" name="application_status" <?php if($app_status[0]['application_status']=="Y") { ?> checked <?php } ?> value="Y"></div><div class="admin_trade_lable">Approved</div>
                    <div class="admin_trade_redio"><input type="radio" name="application_status" <?php if($app_status[0]['application_status']=="C") { ?> checked <?php } ?> value="C"></div><div class="admin_trade_lable">Cancelled</div>
					<div class="admin_trade_redio"><input type="radio" name="application_status" <?php if($app_status[0]['application_status']=="N") { ?> checked <?php } ?> value="N"></div><div class="admin_trade_lable">Disapproved</div>
                    <div class="clear"><br/></div>
      					<div class="admin_trade_lable"><b>Disapproved Reason:</b></div>
                        <div class="admin_trade_redio">    
                        <!--<textarea name="app_reason"><?php echo $app_status[0]['app_reason'] ; ?></textarea>-->
                        <select multiple name="app_reason[]" style="width:450px;">
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
                    	<textarea name="app_reason_other"><?php echo $app_status[0]['app_reason_other']?></textarea>
                    </div>
				</div>
				 <div class="clear"><br/></div>
                 <div class="trade_form_field">
            		<div class="trade_lable1">shipment from (City)</div>
					<div class="admin_trade_redio">
                    	<textarea name="shipment_city"><?php echo $document[0]['shipment_city'];?></textarea>
                    </div>
				</div>
				 <div class="clear"><br/></div>
                 
                 <div class="trade_form_field">
            		<div class="trade_lable1">Copy To:</div>
				 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio">
                      <select name="copyto">
                        <option value="Deputy Commissioner of Customs" <?php if($document[0]['copyto']=="Deputy Commissioner of Customs"){?> selected="selected"<?php }?>>Deputy Commissioner of Customs</option>
						<option value="Asst. Development Commissioner" <?php if($document[0]['copyto']=="Asst. Development Commissioner"){?> selected="selected"<?php }?>>Asst. Development Commissioner</option>
						<option value="Asst Commissioner of Customs" <?php if($document[0]['copyto']=="Asst Commissioner of Customs"){?> selected="selected"<?php }?>>Asst. Commissioner of Customs</option>
                      </select>
                    </div>
					<div class="admin_trade_redio">
                    	<div class="admin_trade_lable">City</div>
                    	<input type="text" name="city"  value="<?php echo $document[0]['city'];?>">
                    </div>
				 </div>
                 
				 <div class="trade_form_field">
            		<div class="trade_lable1">Signing Authority:</div>
				 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="admin_trade_redio">
                       <select name="signature_authority" id="signature_authority">
						<option value="">--Select Authorised Person--</option>
						<?php 
						$query = $conn ->query("select * from trade_signing_authority where status='1' order by region_id");
						while($result = $query->fetch_assoc()){ ?>
                        <!--<option value="<?php echo $result['signature_authority']; ?>" ><?php echo $result['signature_authority']?></option>-->						
						<option value="<?php echo $result['signature_authority']; ?>" <?php if($result['signature_authority']==$document[0]['signature_authority'])echo 'selected="selected"';?>><?php echo $result['signature_authority']?></option>
                        <?php }?>    
                        </select>
                    </div>
                    <input type="text" id="other_sign" name="other_sign" placeholder="Signing Authority, Designation" style="display: none;"/>
                 <div class="clear"><br/></div>
            <!--<div class="admin_trade_redio">
                    	<div class="trade_lable1">Other Signing Authority </div>
                <input type="text" name="other_sign"  value="<?php echo $document[0]['other_sign'];?>">
            </div>-->		
				</div>				 
				<input type="hidden" id="approved_by" name="approved_by" value="<?php echo $_SESSION['curruser_contact_name'];?>"/>				 
                <div class="clear"><br/></div>                 
                <div class="trade_form_field">
				<div class="register-button">
				<input type="submit" name="submit" value="Submit" />
				</div>
				</div>
			</div>
            
        <div class="clear"></div>
      
        </div>
        </form>
    
    </div>
</div>

<!-- Right Table -->
<script type="text/javascript">
(function($){
	/*var duplicate = $('.exhibitionGrp').last();*/
	
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
			if(daysDiff>45)
			{
				alert("The from date and to date should not exceed 45 days");
				return false;				
			}
		
			//return false;
  			if(document.getElementsByName("organizer_address[]")[i].value=='') { 
		     alert("please enter Organizer Address "+j);
		     return false; 
		    } 
		  
			if(document.getElementsByName("venue_address[]")[i].value=='') { 
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
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>