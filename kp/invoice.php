<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	include('db.inc.php');
	include('functions.php');
	//include('chk_login.php');
	$EXPORT_APP_ID=$_REQUEST['EXPORT_APP_ID'];
	$PAYMENT_MST_ID=getPAYMENTMSTID($conn,$EXPORT_APP_ID);
	
	function getLocationId($conn,$LOCATION_ID)
	{
		$query_sel = "SELECT SAP_LOCATION_CODE FROM  kp_location_master  where LOCATION_ID='$LOCATION_ID'";	
		$result_sel = mysqli_query($conn,$query_sel);								
		if($row = mysqli_fetch_array($result_sel))		 	
		{ 		
		return $row['SAP_LOCATION_CODE'];
		}
	}
	
	/*..................................kp_export_application_master data ..................................................*/
	$sql1="SELECT * FROM `kp_export_application_master` WHERE EXPORT_APP_ID='$EXPORT_APP_ID'";
	$query1=mysqli_query($conn,$sql1);
	$result1=mysqli_fetch_array($query1);
	$AGENT_ID=$result1['AGENT_ID'];
	$MEMBER_TYPE_ID=$result1['MEMBER_TYPE_ID'];
	$MEMBER_ID=$result1['MEMBER_ID'];
	$M_ADD_SR_NO=$result1['M_ADD_SR_NO'];
	$NON_MEMBER_ID=$result1['NON_MEMBER_ID'];
	$FORM_TYPE=$result1['FORM_TYPE'];
	$KP_CERT_NO=$result1['KP_CERT_NO'];
	$PROCES_CNTR=getLocationId($conn,$result1['PROCES_CNTR']);
	
	/*..................................kp_payment_master data ..................................................*/
	
	$sql2="select * from kp_payment_master where PAYMENT_MST_ID='$PAYMENT_MST_ID'";
	$query2=mysqli_query($conn,$sql2);
	$result2=mysqli_fetch_array($query2);
	$BILLING_TO=$result2['BILLING_TO'];
	$REF_NO=$result2['CHEQUE_NO'];
	$SO_NUMBER=$result2['SO_NUMBER'];
	$INVOICE_NUMBER=$result2['INVOICE_NUMBER'];
	$INVOICE_DATE=$result2['INVOICE_DATE'];
	$RECEIPT_NUMBER=$result2['RECEIPT_NUMBER'];
	$RECEIPT_DATE=$result2['RECEIPT_DATE'];
	$DELIVERY_NUMBER=$result2['DELIVERY_NUMBER'];
	$ORDER_REASON=$result2['ORDER_REASON'];
	$ODN=$result2['ODN'];
	$EXHCHNAGE_RATE=$result2['EXHCHNAGE_RATE'];
	$KP_FEE=$result2['KP_FEE'];
	$COURIER_CHARGES=$result2['COURIER_CHARGES'];
	$NET_PRICE=$result2['NET_PRICE'];
	$CGST=$result2['CGST'];
	$SGST=$result2['SGST'];
	$IGST=$result2['IGST'];
	$GSTN=$result2['GSTN'];
	
	if($BILLING_TO=="agent"){
		$BPNUMBER=trim(getBpNumber($conn,'Agent',$AGENT_ID));
		$MemberName=getMemberName($conn,'Agent',$AGENT_ID);
		$ShipToPparty=getAgentAdd1($conn,$AGENT_ID)." ".getAgentAdd2($conn,$AGENT_ID)."<br/>".getAgentState($conn,$AGENT_ID)." ".getAgentCity($conn,$AGENT_ID)." ".getAgentPincode($conn,$AGENT_ID)."<br/>".getAgentGstn($conn,$AGENT_ID);
	}else{
		if($MEMBER_TYPE_ID=="18"){
			$BPNUMBER=trim(getBpNumber($conn,'Member',$MEMBER_ID));
			$MemberName=getMemberName($conn,'Member',$MEMBER_ID);
			$ShipToPparty=getMemberAdd($conn,$MEMBER_ID,$M_ADD_SR_NO)."<br/>".$GSTN;;
		}
		elseif($MEMBER_TYPE_ID=="19"){
			$BPNUMBER=trim(getBpNumber($conn,'NonMember',$NON_MEMBER_ID));
			$MemberName=getMemberName($conn,'NonMember',$NON_MEMBER_ID);
			$ShipToPparty=getNonMemberAdd($conn,$NON_MEMBER_ID)."<br/>".$GSTN;;
		}
	}
	if($MEMBER_TYPE_ID=="18"){
			$Partner_Bp=trim(getBpNumber($conn,'Member',$MEMBER_ID));
			$PartnerName=getMemberName($conn,'Member',$MEMBER_ID);
		}
		elseif($MEMBER_TYPE_ID=="19"){
			$Partner_Bp=trim(getBpNumber($conn,'NonMember',$NON_MEMBER_ID));
			$PartnerName=getMemberName($conn,'NonMember',$NON_MEMBER_ID);
	}
	if($PROCES_CNTR=="1010")
		$headAdd="<tr><td><strong>GJEPC Head Office</strong></td></tr><tr><td><strong>Office No. AW 1010, Tower A,</strong></td></tr><tr><td><strong>G Block, Bharat Diamond Bourse,</strong></td></tr><tr><td><strong>Bandra</strong></td></tr><tr><td><strong>Maharashtra</strong></td></tr><tr><td><strong>27AAATT3202H1ZS</strong></td></tr>";
	elseif($PROCES_CNTR=="1030")
		$headAdd="<tr><td><strong>GJEPC Surat Office</strong></td></tr><tr><td><strong>401-A, International Commerce Centre,</strong></td></tr><tr><td><strong>Near Kadiwala School, Ring Road,</strong></td></tr><tr><td><strong>Surat</strong></td></tr><tr><td><strong>Gujrat</strong></td></tr><tr><td><strong>24AAATT3202H1ZY</strong></td></tr>";
	
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
<button onclick="window.print()">Print</button>
<table  width="60%" align="center" style="border:2px solid black; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:15px; border-radius:2px;">
<tbody>
     <tr>
      <td style="text-align: center; font-size: 22px; float: right; width: 100%; padding-bottom: 30px"><strong>The Gem and Jewellery Export Promotion Council </strong></td>
     </tr>
       <tr>
        <td colspan="3">
              <table width="10%" style="float: left; width: 20%; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; padding:10px;">
                <tbody>
                    <tr>
                     <td ><img src="http://www.gjepc.org/images/gjepc_logo.png">  </td>

                    </tr>
                </tbody>
              </table>        
                <table width="10%" style="width: 31%; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; padding:10px;">
                
				<tbody>            
                <?php echo $headAdd;?>
                </tbody>
               </table>
                  </td>
                </tr>
                <tr>
                   <td style="text-align: center; font-size: 15px; float: right; width: 100%; padding-bottom: 25px"><strong>Kimberley Invoice </strong></td>
                </tr>
            <tr>
        <td colspan="3">
       <table width="100%" align="left" style=" border: 1px solid black; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; border-radius:2px;padding:10px; border-collapse: collapse; margin-bottom: 10px;">

<tr>
	<td style="border:1px solid black; padding: 12px; text-align: left;">
		<strong>Ship-to-party<br><?php echo $BPNUMBER;?>/ <?php echo $MemberName;?></strong><br>
		<?php echo $ShipToPparty;?>
	</td>
	<td style="border:1px solid black; padding: 12px; text-align: left;">
		<strong>Bill-to-party<br><?php echo $BPNUMBER;?>/ <?php echo $MemberName;?></strong><br>
		<?php echo $ShipToPparty;?>
	</td>
</tr>

<tr>
<td style="padding: 8px;"><p><strong>Internal Ref. No. : <?php echo $INVOICE_NUMBER;?></strong><br><strong>Invoice Date :</strong><?php echo date('d.m.Y',strtotime($INVOICE_DATE));?><br><strong>Sales Order :</strong> <?php echo $SO_NUMBER;?><br><strong>Receipt No :</strong> <?php echo $RECEIPT_NUMBER;?>
</p></td>
<td style="padding: 8px;"><strong>Order Reason :</strong> <?php echo $ORDER_REASON;?><br><strong>Invoice No. :</strong> <?php echo $ODN;?><br><strong>Customer Ref. :</strong> <?php //echo "CHQ".$REF_NO;?><br><strong>Exchange Rate :</strong> <?php echo $EXHCHNAGE_RATE;?> INR</td>
</tr>

</table>



<table width="100%" align="left" style="  border: 1px solid black; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; border-radius:2px;padding:10px; border-collapse: collapse; margin-bottom: 200px;">

<tr>
<th style="border:1px solid black; padding: 8px;"> Sl No </th>
<th style="border:1px solid black; padding: 8px;"> Item Desc./HSN/Batch & KPC/Del<br>
No./Partner </th>
<th style="border:1px solid black; padding: 8px;"> Qty. </th>
<th style="border:1px solid black; padding: 8px;">Price/
Unit</th>
<th style="border:1px solid black; padding: 8px;">Courier
Charges</th>
<th style="border:1px solid black; padding: 8px;">Net
Value</th>
<th style="border:1px solid black; padding: 8px;">CGST</th>
<th style="border:1px solid black; padding: 8px;">SGST</th>
<th style="border:1px solid black; padding: 8px;"> IGST </th>
<th style="border:1px solid black; padding: 8px;"> Total Item
Value </th>


</tr>

<tr>
  <td style="border:1px solid black; padding: 8px; text-align: center;" > 1 </td>
  <td style="border:1px solid black; padding: 8px;"> 
    <table width="100%" align="left" style="float: left; font-family:Roboto Condensed,sans-serif; color:#333333; font-size:13px; padding:10px;">
		<tbody> 
			<tr>
			  <td><strong><?php echo ($FORM_TYPE=="I") ? "KP Import" : "KP Export"?> </strong></td>
			</tr>
			<tr>
				<td><strong>998346 </strong></td>                   
			</tr>
			<tr>
				<td><strong><?php echo $KP_CERT_NO;?> / <?php echo $DELIVERY_NUMBER;?></strong></td>                  
			</tr>
			<tr>
				<td><strong><?php echo $Partner_Bp." ".$PartnerName;?></strong></td>                   
			</tr>              
		</tbody>
	</table>
  </td>
  <td style="border:1px solid black; padding: 8px; text-align: right;"> 1.00  </td>
  <td style="border:1px solid black; padding: 8px; text-align: right;"> EA  </td>
  <td style="border:1px solid black; padding: 8px;">  </td>
  <td style="border:1px solid black; padding: 8px; text-align: right;"> <?php echo $KP_FEE;?></td>
  <td style="border:1px solid black; padding: 8px;text-align: right;"> <?php if($CGST!="0.00"){?>9.00% <br><?php echo  $CGST;}?></td>
  <td style="border:1px solid black; padding: 8px;text-align: right;"> <?php if($SGST!="0.00"){?>9.00% <br><?php  echo $SGST;}?></td>
  <td style="border:1px solid black; padding: 8px; text-align: right;"> <?php if(!$CGST>"0"){?>18.00% <br><?php  echo $IGST;}?></td>
  <td style="border:1px solid black; padding: 8px; text-align: right;"> <?php echo $NET_PRICE;?></td>

</tr>
 <tr>
    <td style="border:1px solid black; padding: 8px; text-align: center;" >  </td>
    <td style="border:1px solid black; padding: 8px;"><strong> </strong> </td>
    <td style="border:1px solid black; padding: 8px; text-align: right;"> </td>
    <td style="border:1px solid black; padding: 8px; text-align: right;">  </td>
    <td style="border:1px solid black; padding: 8px;">  </td>
    <td style="border:1px solid black; padding: 8px; text-align: right;">  </td>
    <td style="border:1px solid black; padding: 8px;"> </td>
    <td style="border:1px solid black; padding: 8px;"> </td>
    <td style="border:1px solid black; padding: 8px; text-align: right;"> </td>
    <td style="border:1px solid black; padding: 8px; text-align: right;"><?php echo $NET_PRICE;?></td>
</tr>
<tr>
<td style="border:1px solid black; padding: 8px;" colspan="10"> <?php echo number_word_usd($NET_PRICE);?> RUPEES</td>
</tr>

<tr>
<td style="border:1px solid black; padding: 8px;" colspan="10">E.& .O.E. <span style="text-align: center; margin-left: 60px;">For The Gem & Jewellery Export Promotion Council
Authorized Signatory</span></td>
</tr>

<tr>
<td style="border:1px solid black; padding: 8px; text-align: center;" colspan="10"><strong>Receipt</strong></td>
</tr>

<tr>
<td style="border:1px solid black; padding: 15px;" colspan="10"><span style="float: right;"><strong>Receipt No. : </strong><?php echo $RECEIPT_NUMBER;?> <br><strong>Date :</strong> <?php echo date('d-m-Y',strtotime($RECEIPT_DATE));?> </span><strong>Received with thanks from </strong> <?php echo $MemberName;?> <br><?php echo number_word_usd($NET_PRICE);?> Rupees</td>
</tr>


</table>

 <p style="line-height:20px; text-align: center;">Authorized Signatory<br>CIN: U99100MH1966GAP013486</p>
</td></tr>
</tbody></table></body></html>
