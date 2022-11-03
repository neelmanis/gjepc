<?php
session_start(); ob_start();
include '../db.inc.php';
include '../functions.php';
 
if(isset($_REQUEST['registration_id'])){$registration_id=$_REQUEST['registration_id'];}
else{echo "USER DOES NOT EXIST";exit;}
?>
<?php 
//current challan yr calculation
$cur_year = (int)date('Y');
$curyear  = (int)date('Y');
$cur_month = (int)date('m');
if ($cur_month < 4) {
 $cur_fin_yr = $curyear-1;
 $cur_fin_yr1= $cur_year-1;
 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
}
else {
 $cur_fin_yr = $curyear;
 $cur_fin_yr1= $cur_year;
 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
}

$invoice_date=date('d/m/Y');
$query1 = $conn ->query("select company_name,company_name2,region_id,gst_no from information_master where registration_id='$registration_id'");
$result1= $query1->fetch_assoc();

$query2 = $conn ->query("select * from communication_address_master where registration_id='$registration_id' and type_of_address='2'");
$result2= $query2->fetch_assoc();

$query3 = $conn ->query("select * from challan_master where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr'");
$result3= $query3->fetch_assoc();

$query4 = $conn ->query("select membership_issued_dt,membership_renewal_dt,invoice_no,invoice_date,receipt_no,receipt_date,membership_type from membership_certificate_history where registration_id='$registration_id'");
$result4= $query4->fetch_assoc();

$query5 = $conn ->query("select * from region_master where region_name='".$result1['region_id']."'");
$result5= $query5->fetch_assoc();

$query6 = $conn ->query("select state,sez_member from registration_master where id='$registration_id'");
$result6= $query6->fetch_assoc();
$getStateName = trim($result6['state']);
$sez_member = trim($result6['sez_member']);

/*.............................Calculate Amount....................................*/
if($result4['membership_type']=="N")
{
	$membership_issued_dt=$result4['membership_issued_dt'];
}
else
{
	$membership_issued_dt=$result4['membership_renewal_dt'];
}
/*............................. Calculate Region ....................................*/
//echo '----'.$result1['region_id']; 
/*
echo '<br/> Member Region : '.$result5['region_name']; 
echo "<br/> Member State : ".$getStateName; 
echo "<br/> Member Belongs State Code : ".$result5['state_code']; 
echo "<br/> Member Belongs State ID : ".$result5['state_id']; 

//if($result5['state_code'] == $getStateName)
if($result5['state_id'] == $getStateName)
{
	echo ' <b>YES Match</b>';
} else
{
	echo ' <b>Not match</b>';
}
*/
//echo $result5['state_code'].''.$getStateName;
/*............................. Calculate Region ....................................*/
$subtot=$result3['total'];
$convenience_charges=0;

if($sez_member!='Y'){
if($result5['state_id'] == $getStateName)
{
	$taxRatecgst = '9%';
	$taxRatesgst = '9%';
	$cgst_tax=sprintf("%.2f",($subtot*9)/100);
	$sgst_tax=sprintf("%.2f",($subtot*9)/100);
	$grand_tot=round($subtot+$cgst_tax+$sgst_tax);
} else {
	$taxRateigst = '18%';
	$service_tax=sprintf("%.2f",($subtot*18)/100);
	$grand_tot=round($subtot+$service_tax);
}
} else { $grand_tot=round($subtot); }
/*
if($getStateName=="S")
{
	$taxRatecgst = '0%';
	$taxRatesgst = '0%';
	$cgst_tax=sprintf("%.2f",($subtot*0)/100);
	$sgst_tax=sprintf("%.2f",($subtot*0)/100);
	$grand_tot=round($subtot+$cgst_tax+$sgst_tax);
} 
*/
/*
echo $taxRatecgst = 9;
echo '<br/>';
echo $taxRatesgst = 9;	
echo '<br/>';
echo $cgst_tax=sprintf("%.2f",($subtot*9)/100);
echo $sgst_tax=sprintf("%.2f",($subtot*9)/100);
echo '<hr>';
*/
//$service_tax=sprintf("%.2f",($subtot*18)/100);
//$grand_tot=round($subtot+$service_tax);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<title>Membership Invoice</title>
	<style>
	#divtoprint { width:80%; margin:0 auto;	}
	</style>
</head>
<body>
<!--<table>
<tr><td width="28"><a onClick="PrintContent();" target="_blank" style="cursor:pointer;float:right;color:#FF0000;font-size:13px;">Print</a></td>
</tr>

</table>-->
<div id="divtoprint">
<table style="margin:0 auto; text-align:center; font-family: 'Roboto', sans-serif; font-size:12px;" cellpadding="0" cellspacing="0" align="center"><a onClick="PrintContent();" target="_blank" style="cursor:pointer;float:right;color:#FF0000;font-size:13px;">Print</a>

<tr>
<td><h1 style="font-size:14px;">The Gem and Jewellery Export Promotion Council</h1></td>
</tr>
<tr>
<td><?php echo $result5['region_address'];?><br/> State : <?php echo $result5['state'];?> GST : <?php echo $result5['gst_no'];?></td>
</tr>
<tr>
<td><h1 style="font-size:13px;"><u>Membership Invoice</u></h1></td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>
<table style="text-align:left; font-size:12px;" width="100%" border="0">
<tr>
<td width="68%">
To,<br>
<?php echo strtoupper($result1['company_name']).strtoupper($result1['company_name2']);?><br>
<?php echo strtoupper($result2['address1']).strtoupper($result2['address2']).strtoupper($result2['address3']);?><br>
<?php echo strtoupper($result2['city']);?>- <?php echo strtoupper($result2['pincode']);?><br/>
<!--STATE CODE: <?php echo $getStateName;?><br/>-->
GST : <?php echo strtoupper($result1['gst_no']);?><br/>
POS : <?php echo $getStateName;?><br/>
</td>
<td width="32%"><strong style="display:block; width:90px; float:left;">Invoice No.</strong><span style="display:block;"><?php echo $result4['invoice_no'];?></span><br>
<strong style="display:block; width:90px; float:left;">Date</strong><span style="display:block;"><?php echo $result4['invoice_date'];?></span> 
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td><strong>Amount in Rs.</strong> <?php echo $grand_tot.".00";?></td>
</tr>

</table>

</td>
</tr>

<tr style="height:2px;">
<td><hr></td>
</tr>

<tr>
<td>

<table width="100%" style="text-align:left; font-size:12px;">
<tr>
<td width="247"><strong>DESCRIPTION OF SERVICES</strong></td>
<td ><strong>SAC CODE</strong></td>
<td width="129"><strong>YEAR</strong></td>
<td width="414"><strong>AMOUNT</strong></td>
</tr>
<tr>
<td width="247">Membership Fees for the year</td>
<td width="129">999599</td>
<td width="129"><?php echo $cur_finyr?></td>
<td width="414"><?php echo sprintf("%.2f",$result3['membership_fees']);?></td>
</tr>
<tr>
<td>Admission Fees for the year</td>
<td width="129">999599</td>
<td><?php echo $cur_finyr?></td>
<td><?php echo sprintf("%.2f",$result3['admission_fees']);?></td>
</tr>
<td>2% Convenience Charges</td>
<td width="129">999599</td>
<td><?php echo $cur_finyr?></td>
<td><?php echo sprintf("%.2f",$convenience_charges);?></td>
</tr>
</table>

</td>
</tr>

<tr>
<td>
<table width="100%;" align="left" border='0' style="text-align:left; font-size:12px;">
<tr>
<td width="21%">&nbsp;</td>
<td width="13%">&nbsp;</td>
<td width="34%">&nbsp;</td>
<td width="20%">&nbsp;</td>
<td width="12%">&nbsp;</td>
</tr>
<tr>
<td width="21%"><strong>Sub Total :</strong></td>
<td width="13%">Taxable Value</td>
<td width="34%">&nbsp;</td>
<td width="20%"></td>
<td width="12%" align="right"><?php echo sprintf("%.2f",$subtot);?></td>
</tr>

<tr>
<td width="21%">Add:</td>
<td width="13%"></td>
<td width="34%"></td>
<td width="20%">&nbsp;</td>
<td width="12%"></td>
</tr>

<tr>
<td width="21%"><strong>IGST</strong></td>
<td width="13%"><?php echo $taxRateigst;?></td>
<td width="34%"></td>
<td width="20%">&nbsp;</td>
<td width="12%" align="right"><?php echo $service_tax;?></td>
</tr>

<tr>
<td width="21%"><strong>SGST</strong></td>
<td width="13%"><?php echo $taxRatesgst;?></td>
<td width="34%"></td>
<td width="20%">&nbsp;</td>
<td width="12%" align="right"><?php echo $cgst_tax;?></td>
</tr>

<tr>
<td width="21%"><strong>CGST</strong></td>
<td width="13%"><?php echo $taxRatecgst;?></td>
<td width="34%"></td>
<td width="20%">&nbsp;</td>
<td width="12%" align="right"><?php echo $sgst_tax;?></td>
</tr>

<tr>
<td width="21%"></td>
<td width="13%"></td>
<td width="34%"></td>
<td width="20%">&nbsp;</td>
<td width="12%"><hr></td>
</tr>

<tr>
<td width="21%"><strong>Total</strong></td>
<td width="13%"></td>
<td width="34%"></td>
<td width="20%">&nbsp;</td>
<td width="12%" align="right"><?php echo sprintf("%.2f",$grand_tot);?></td>
</tr>

<tr>
<td width="21%" style="height:28px;"><strong>Rs. in Words</strong></td>
<td align="left" colspan="4">**** <?php number_word($grand_tot);?> <br/>AMOUNT OF TAX SUBJECT TO REVERSE CHARGE : NO</td>
</tr>

</table>
</td>
</tr>

<tr style="height:2px;">
<td><hr></td>
</tr>

<tr>
<td>
<table width="100%" style="font-size:12px;">
<tr>
<td align="left">E.& .O.E.</td>
<td></td>
<td>For The Gem & Jewellery Export Promotion Council</td>
</tr>

<tr>
<td height="2"></td>
<td></td>
<td>Authorized Signatory</td>
</tr>

</table>
</td>
</tr>

<tr>
<td><h1 style="font-size:13px;"><u>Receipt</u></h1></td>
</tr>


<tr style="height:2px;">
<td><hr></td>
</tr>

<tr>
<td>
<table width="100%" style="text-align:left; font-size:12px;">

<tr>
<td width="60%"></td>
<td width="13%"><strong>Receipt No.</strong></td>
<td width="27%"><?php echo $result4['receipt_no'];?></td>
</tr>
<tr>
<td></td>
<td><strong>Date</strong></td>
<td><?php echo $result4['receipt_date'];?></td>
</tr>

<tr>
<td style=" height:10px;"><strong>Received with thanks from</strong> <?php echo strtoupper($result1['company_name']).strtoupper($result1['company_name2']);?></td>
<td colspan="2" align="center"><strong>Amount in Rs.</strong></td>
</tr>

<tr style="height:10px;">
<td colspan="3">**** <?php number_word($grand_tot);?> ONLY</td>
</tr>
<?php 
/*.........................Get Cheque No:........................*/
$chk_query=$conn ->query("select payment_mode,cheque_no from challan_master where registration_id='$registration_id' and challan_financial_year='$cur_year'");
$chk_result=$chk_query->fetch_assoc();
?>
<tr>
<?php if($result3['payment_mode']=="Cheque"){?>
<td><strong>By Cheque No.</strong> <?php echo $result3['cheque_no'];?></td>
<?php }else if($result3['payment_mode']=="DD"){?>
<td><strong>By DD No.</strong> <?php echo $result3['cheque_no'];?></td>
<?php }else if($result3['payment_mode']=="Cash"){?>
<td><strong>By Cash.</strong></td>
<?php }?>
<td colspan="2" align="center"><strong><?php echo sprintf("%.2f",$grand_tot);?></strong></td>
</tr>

<tr>
<td><strong>against invoice no. </strong><?php echo $result4['invoice_no'];?>.</td>
<td colspan="2" align="center"><strong></strong></td>
</tr>
</table>
</td>
</tr>
<tr>
<td style="height:2px;"><hr></td>
</tr>


<tr>
<td>
<table width="100%" style="font-size:12px;">
<tr>
<td align="left"><strong style="margin-right:25px;">Rs. in Figures</strong><?php echo sprintf("%.2f",$grand_tot);?></td>
<td></td>
<td>For The Gem &amp; Jewellery Export Promotion Council</td>
</tr>

<tr>
<td align="left"></td>
<td></td>
<td></td>
</tr>

<tr>
<td height="2"></td>
<td></td>
<td>Authorized Signatory</td>
</tr>
</table>
</td>
</tr>
<tr><td>CIN: U99100MH1966GAP013486 <br/>This is computer generated Receipt hence does not require any signature</td></tr>
</table>
</div>
</body>
</html>
<script type="text/javascript">
function PrintContent(){
	var DocumentContainer = document.getElementById("divtoprint");
	var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
}
</script>