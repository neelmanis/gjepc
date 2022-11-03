<?php include('header_include.php');
	if(!isset($_SESSION['USERID'])){
			header("location:login.php");
			exit;
	}
	$uid=$_SESSION['USERID'];
	$gid=intval($_REQUEST['gid']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>IIJS - Exhibitor Registration - Print Application</title>

<link rel="shortcut icon" href="images/fav.png" />

<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />

<link rel="stylesheet" type="text/css" href="css/responsive.css" />
<link rel="stylesheet" type="text/css" href="css/media_query.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

<!--NAV-->
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--NAV-->


 


<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>

<script language="javascript">
function first_alert()
{
	alert("Coming Soon !!!");
}

function second_alert()
{
	alert("Coming Soon !!!");
}
</script>

</head>

<body>

<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">

	<div class="breadcrum"><a href="index.php">Home</a> > Exhibitor Registration - Print Application</div>    
    <div class="clear"></div>
    
    <div class="content_form_area">
      <div class="pg_title">
        <div class="title_cont"> <span class="top">Exhibitor <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span> <span class="below">Registration</span>
            <div class="clear"></div>
        </div>
      </div>
      
      <div class="clear"></div>
    
    <div class="form_main">
    
    	<!--<div style="width:auto; padding: 10px; margin-bottom:30px; border: 1px solid #8873bd; background:#f5f1ff; font-size:16px; font-weight:bold; text-align:center">
        Application status updated successfully.
        </div>-->
        
        <div class="form_title">Print Acknowledgement
        
        <div class="clear"></div>
        </div>
      	<div class="clear"></div>
        <?php 
		$sql="select * from  exh_registration where uid='$uid' and gid='$gid' and `show`='iijs 2017'";
		$query=mysql_query($sql);		
		$result=mysql_fetch_array($query);
		if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND")
		  $currency="";
		else
			$currency="USD";
		?>   
        
        <strong style="text-transform:uppercase; font-size:14px;">Application For <?php echo $result['section'];?> on <?php echo date('jS F Y',strtotime($result['created_date']));?></strong>
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <div class="clear"></div>
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php echo $result['gid'];?>)</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong>&nbsp; <?php echo $result['last_yr_participant'];?> <br />
        <strong>Option :</strong>&nbsp; <?php echo $result['options'];?> <br />
        <strong>Section :</strong>&nbsp; <?php echo $result['section'];?> <br />
        <strong>Area :</strong>&nbsp; <?php echo $result['selected_area'];?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription($result['selected_scheme_type']);?> <br />
        <strong>Premium :</strong>&nbsp; <?php echo $result['selected_premium_type'];?></p>
        </div>
        
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['tot_space_cost_rate'];?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_scheme_rate'];?> <br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_premium_rate'];?> <br />
        <strong>Mezzanine rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['mezzanine_space_charges'];?> <br />
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['sub_total_cost'];?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['security_deposit'];?> <br />
        <strong>Govt. Tax (15% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['govt_service_tax'];?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['grand_total'];?></p>
        </div>
		
		<?php 
		$sqlx=mysql_query("select * from exh_reg_payment_details where uid='$uid' and `show`='IIJS 2017'");
		$resultx=mysql_fetch_array($sqlx);
		$tds_holder=$resultx['tds_holder'];
		if($tds_holder == 'Yes') {
		?>
		<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">TDS Deducted Summary</strong> <br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Gross Amount :</strong>&nbsp; <?php echo $resultx['cheque_tds_gross_amount'];?> <br />
        <strong>TDS Percentage :</strong>&nbsp;<?php echo $resultx['cheque_tds_per'];?> <br />
        <strong>TDS Amount :</strong>&nbsp; <?php echo $resultx['cheque_tds_amount'];?> <br />
        <strong>Net Amount :</strong>&nbsp; <?php echo $resultx['cheque_tds_Netamount'];?> <br />
        <strong>TDS Deducted for FY :</strong>&nbsp; <?php echo $resultx['cheque_tds_deducted'];?></p>
        </div>
		<?php } ?>
		
    	<div class="clear" style="height:10px;"></div>
        <?php 
		$query1=mysql_query("select * from exh_reg_payment_details where uid='$uid' order by payment_id desc limit 0,1");
		$result1=mysql_fetch_array($query1);
		
		?>
        
            <p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong> <br />
            <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
           <div style="height:10px; display:block; padding:10px;"><div style="margin-right:50px; float:left; width: 212px;">
            <strong >Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?></div> 
            <div style="margin-right:50px; float:left; width: 212px;"> <strong>Manual Document Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?>  </div>
        
            <div style="margin-right:50px; float:left; width: 212px;">
             <strong >Manual Payment  Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?>  </div></div>
             
             <?php 
			 $sexh="SELECT  kweb_iijs_manual.iijs_exhibitor.Exhibitor_HallNo,kweb_iijs_manual.iijs_exhibitor.Exhibitor_Section,kweb_iijs_manual.iijs_exhibitor.Exhibitor_DivisionNo,kweb_iijs_manual.iijs_exhibitor. Exhibitor_StallNo1 ,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo2,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo3,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo4,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo5 FROM kweb_iijs_manual.iijs_exhibitor where kweb_iijs_manual.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and kweb_iijs_manual.iijs_exhibitor.Exhibitor_Gid='$gid'";
			 $qexh=mysql_query($sexh);
			 $rexh=mysql_fetch_array($qexh);
			 ?>
             
             <div class="clear" style="height:10px;"></div>
             <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
            <div style="height:50px; display:block; padding:10px;">
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Hall No.: </strong>&nbsp; <?php echo $rexh['Exhibitor_HallNo'];?></div>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Section No.:</strong>&nbsp; <?php echo $rexh['Exhibitor_Section'];?></div>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Zone.: </strong>&nbsp;<?php echo $rexh['Exhibitor_DivisionNo'];?></div>
            <div style="margin-right:50px; float:left; width: 212px; padding-top:10px;">
            <strong >Booth No.: </strong>&nbsp; <?php echo $rexh['Exhibitor_StallNo1'];echo $rexh['Exhibitor_StallNo2'];echo $rexh['Exhibitor_StallNo3'];echo $rexh['Exhibitor_StallNo4'];$rexh['Exhibitor_StallNo5']?></div></div>
            
			<?php 
				$sql_manager = "select kweb_iijs_manual.zone_manager_detail.Zone_manager,kweb_iijs_manual.zone_manager_detail.Contact_no from kweb_iijs_manual.zone_manager_detail where kweb_iijs_manual.zone_manager_detail.Hall='".$rexh['Exhibitor_HallNo']."' and kweb_iijs_manual.zone_manager_detail.Zone='".$rexh['Exhibitor_DivisionNo']."'";
				$query_manager = mysql_query($sql_manager);
				$result_manager = mysql_fetch_array($query_manager);
            ?>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Zone Manager.: </strong>&nbsp; <?php echo $result_manager['Zone_manager'];?></div></div>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >contact details: </strong>&nbsp; <?php echo $result_manager['Contact_no'];?></div></div>
      
        <?php
		if($result1['application_status']=="approved"){?>
        <div class="field_input" >
        	<a href="manual/index.php?uid=<?php echo $uid;?>&gid=<?php echo $gid;?>" class='select_dash_btn'>Online Exhibitor Manual</a>
			<!--<a href="javascript: void(0)" onclick = "first_alert()" class='select_dash_btn'>Online Exhibitor Manual</a>-->
       	 </div>
        <?php } else {?>
         <div class="field_input" >
        	<a href="javascript: void(0)" onclick = "first_alert()" class='select_dash_btn'>Online Exhibitor Manual</a>
       	 </div>
         <?php }?>
        <?php if($result['section']=="machinery"){?>
         <div class="field_input" >&nbsp;<a href="print_acknowledge/iijs_print_acknowledgement_machinery.php?gid=<?php echo $gid; ?>" class='select_dash_btn' target="_blank">Download/Print Acknowledgement</a></div>
       
        <?php } else { ?>
        <div class="field_input" >&nbsp;<a href="print_acknowledge/iijs_print_acknowledgement.php?gid=<?php echo $gid; ?>" class='select_dash_btn' target="_blank">Download/Print Acknowledgement</a></div>
        <?php }?>
        
        <div class="clear" style="height:10px;"></div>       
    
<!----------------------------------Second Application----------------------------------->
<?php 
		$sql="select * from  exh_registration where uid='$uid' and gid!='$gid' and `show`='iijs 2017'";
		$query=mysql_query($sql);		
		$result=mysql_fetch_array($query);
		$second_application=mysql_num_rows($query);
		$check_gid=$result['gid'];
		
		$check_query=mysql_query("select * from exh_reg_payment_details where gid='$check_gid'");
		$check_num=mysql_num_rows($check_query);
		
		if(strtoupper($_SESSION['COUNTRY'])=="INDIA" || strtoupper($_SESSION['COUNTRY'])=="IND")
		{
		  $currency="";
		}
		else
		{
			$currency="USD";
		}
		if($second_application>0 && $check_num>0){
?>
		<span class="clear" style="height:1px; background:#ccc; display:block;"></span>  
  		<div class="clear" style="height:10px;"></div>
          <strong style="text-transform:uppercase; font-size:14px;">Application For <?php echo $result['section'];?> on <?php echo date('jS F Y',strtotime($result['created_date']));?></strong>
          <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <div class="clear"></div>
    	<div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Summary(Exh<?php echo $result['gid'];?>)</strong><br />
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Last Year Participant :</strong>&nbsp; <?php echo $result['last_yr_participant'];?> <br />
        <strong>Option :</strong>&nbsp; <?php echo $result['options'];?> <br />
        <strong>Section :</strong>&nbsp; <?php echo $result['section'];?> <br />
        <strong>Area :</strong>&nbsp; <?php echo $result['selected_area'];?> &nbsp;sqrt<br />
        <strong>Scheme :</strong>&nbsp; <?php echo getSchemeDescription($result['selected_scheme_type']);?> <br />
        <strong>Premium :</strong>&nbsp; <?php echo $result['selected_premium_type'];?></p>
        </div>
        
        <div class="summary_box">
        <p><strong style="text-transform:uppercase; font-size:14px;">Application Payment Summary</strong> <br />
        
        <div class="clear"></div>
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        <strong>Total Space Cost <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['tot_space_cost_rate'];?> <br />
        <strong>Selected scheme rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_scheme_rate'];?> <br />
        <strong>Selected premium rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['selected_premium_rate'];?> <br />
        <strong>Mezzanine rate <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['mezzanine_space_charges'];?> <br />
        <strong>Sub Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['sub_total_cost'];?> <br />
        <strong>Security Deposit (10% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['security_deposit'];?> <br />
        <strong>Govt. Tax (15% on Sub Total) <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['govt_service_tax'];?><br />
        <strong>Grand Total <?php echo $currency;?> :</strong>&nbsp; <?php echo $result['grand_total'];?></p>
        </div>
    	<div class="clear"></div>
        <?php 
		$query1=mysql_query("select * from exh_reg_payment_details where gid='$check_gid' order by payment_id desc limit 0,1");
		$result1=mysql_fetch_array($query1);
		
		?>
        
            <p><strong style="text-transform:uppercase; font-size:14px;">Application Status </strong> <br />
            <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
           <p><div style="height:10px; display:block; padding:10px;">
 <div style="margin-right:50px; float:left; width: 212px;"><strong>Manual Application Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['application_status'];?> </div>
           <div style="margin-right:50px; float:left; width: 212px;"><strong>Manual Document Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['document_status'];?></div> 
            <div style="margin-right:50px; float:left; width: 212px;"><strong>Manual Payment  Status<?php echo $currency;?> :</strong>&nbsp; <?php echo $result1['payment_status'];?> </div></div></p>
       
        <span class="clear" style="height:1px; background:#ccc; display:block;"></span>
        
       <div class="clear"></div>
       <?php 
			 $sexh="SELECT  kweb_iijs_manual.iijs_exhibitor.Exhibitor_HallNo,kweb_iijs_manual.iijs_exhibitor.Exhibitor_Section,kweb_iijs_manual.iijs_exhibitor.Exhibitor_DivisionNo,kweb_iijs_manual.iijs_exhibitor. Exhibitor_StallNo1 ,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo2,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo3,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo4,kweb_iijs_manual.iijs_exhibitor.Exhibitor_StallNo5 FROM kweb_iijs_manual.iijs_exhibitor where kweb_iijs_manual.iijs_exhibitor.Exhibitor_Registration_ID='$uid' and kweb_iijs_manual.iijs_exhibitor.Exhibitor_Gid='$gid'";
			 $qexh=mysql_query($sexh);
			 $rexh=mysql_fetch_array($qexh);
			 ?>
       
       
       <div style="height:50px; display:block; padding:10px;">
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Hall No.: </strong>&nbsp; <?php echo $rexh['Exhibitor_HallNo'];?></div>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Section No.:</strong>&nbsp; <?php echo $rexh['Exhibitor_Section'];?></div>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Zone.: </strong>&nbsp;<?php echo $rexh['Exhibitor_DivisionNo'];?></div>
            <div style="margin-right:50px; float:left; width: 212px; padding-top:10px;">
            <strong >Booth No.: </strong>&nbsp; <?php echo $rexh['Exhibitor_StallNo1'];echo $rexh['Exhibitor_StallNo2'];echo $rexh['Exhibitor_StallNo3'];echo $rexh['Exhibitor_StallNo4'];$rexh['Exhibitor_StallNo5']?></div></div>
             
             
             <?php 
				$sql_manager = "select kweb_iijs_manual.zone_manager_detail.Zone_manager,kweb_iijs_manual.zone_manager_detail.Contact_no from kweb_iijs_manual.zone_manager_detail where kweb_iijs_manual.zone_manager_detail.Hall='".$rexh['Exhibitor_HallNo']."' and kweb_iijs_manual.zone_manager_detail.Zone='".$rexh['Exhibitor_DivisionNo']."'";
				$query_manager = mysql_query($sql_manager);
				$result_manager = mysql_fetch_array($query_manager);
            ?>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >Zone Manager.: </strong>&nbsp; <?php echo $result_manager['Zone_manager'];?></div></div>
            <div style="margin-right:50px; float:left; width: 212px;">
            <strong >contact details: </strong>&nbsp; <?php echo $result_manager['Contact_no'];?></div></div>
         <?php 
		 if($result1['application_status']=="approved"){?>
        <div class="field_input">
        	<a href="manual/index.php?uid=<?php echo $uid;?>&gid=<?php echo $check_gid;?>" class='select_dash_btn'>Online Exhibitor Manual</a>
			<!--<a href="javascript: void(0)" onclick = "first_alert()" class='select_dash_btn'>Online Exhibitor Manual</a>-->
       	 </div>
        <?php } else {?>
         <div class="field_input">
        	<a href="javascript: void(0)" onclick = "second_alert()" class='select_dash_btn'>Online Exhibitor Manual</a>
       	 </div>
         <?php }?>
        <div class="field_input">&nbsp;<a href="print_acknowledge/iijs_print_acknowledgement.php?gid=<?php echo $check_gid; ?>" target="_blank">Download/Print Acknowledgement</a></div>
    	<div class="clear"></div>
        <div class="clear" style="height:10px;"></div>       
 		<?php }?>
    
        <div class="field_box">
       	  <div class="field_name"></div>
          <div class="clear"></div>
           <?php
		   $query=mysql_query("select * from exh_reg_general_info where uid='$uid' and event_for='IIJS 2017'");
		   $num=mysql_num_rows($query);	
		   
		   $query12=mysql_query("select * from exh_reg_payment_details where uid='$uid' and `show`='IIJS 2017'");
		   $num12=mysql_num_rows($query12);	
		   
		   if($num<2){
           ?>
           <div class="field_input" >
        	<a href="exhibitor_registration_step_1.php?Action=ADD" class="button">Add New Application</a>
       	    </div>
           <?php } else if($num12<2) {?>
           <?php 
		   $query11=mysql_query("select * from exh_reg_general_info where uid='$uid' and event_for='IIJS 2017' order by id limit 1,1");
		   $result11=mysql_fetch_array($query11);
		   $gid=$result11['id'];
		   ?>
           
           <div class="field_input" >
        	<a href="exhibitor_registration_step_2.php?gid=<?php echo $gid;?>" class="button">Add New Application</a>
       	   </div>
           
           <?php }?>
        	
        </div>
	  
    <div class="clear"></div>
	</div>
	   
    <div class="clear"></div>
	</div>


 

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>
