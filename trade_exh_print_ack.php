<?php
ob_start();
session_start();
include('db.inc.php');
include('functions.php');
$ref_no = $_REQUEST['ref_no'];
if(isset($_REQUEST['registraton_id']) && $_REQUEST['registraton_id']!='')
	$registraton_id=$_REQUEST['registraton_id'];
else
	$registraton_id=$_SESSION['USERID'];
	
$app_id=$_REQUEST['app_id'];
?>
<?php 
$queryTrade = $conn ->query("select * from trade_general_info where app_id=$app_id and registration_id='$registraton_id'");
$result= $queryTrade->fetch_assoc();

$permission_no=$result['permission_no'];
$address1= filter($result['address1']);
$address2= filter($result['address2']);
$pincode=$result['pincode'];
$city=$result['city'];
$region_code=$result['region_code'];
$application_date=$result['application_date'];
$item1=$result['item1'];
$invoice_value1=$result['invoice_value1'];
$item2=$result['item2'];
$invoice_value2=$result['invoice_value2'];
$item3=$result['item3'];
$invoice_value3=$result['invoice_value3'];
$item4=$result['item4'];
$invoice_value4=$result['invoice_value4'];
$item5=$result['item5'];
$invoice_value5=$result['invoice_value5'];
$bank_name=$result['bank_name'];
$other_bank_name=$result['other_bank_name'];
$branch_name=$result['branch_name'];
$company=getCompanyName($registraton_id,$conn);

$total=intval($invoice_value1)+intval($invoice_value2)+intval($invoice_value3)+intval($invoice_value4)+intval($invoice_value5);

$doc_query = $conn ->query("select copyto,city,signature_authority,other_sign from trade_documents where app_id=$app_id and registration_id='$registraton_id'");
$doc_result = $doc_query->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Trade Permission</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $("#btnPrint").live("click", function () {
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=5500,width=1200');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    </script>
    
   <style>	
	#dvContainer{margin-top:10%;}
	.letter_style {
    width: 200px;
    height: auto;
    font-weight:bold;
    font-size: 20px;
    position: absolute;
    left: 40%;
    top: 30px;
    text-align: center;
}
	.letter_note{
	
    font-size: 14px;
	font-family:"Times New Roman", Times, serif;
   
	font-weight:bold;
	padding-top:10px;
    text-align:justify;
}

</style>
</head>
<body>
<input type="button" value="Print Out" id="btnPrint" /> 
<div id="dvContainer">

<table width="100%" align="center" style="font-size:13px;">
<tbody>
        <div class="letter_style"> Sample Letter </div>
       
        <!--<tr>
			<td >Ref No: <?php echo $ref_no;?></td>
			<td width="85%" align="right">DATE: <?php echo $application_date;?></td>
        </tr>-->
		<tr><td><b>To</b></td></tr>
        <tr><td colspan="2"><?php echo strtoupper($company);?></td></tr>
		<tr><td colspan="2"><?php echo $address1;?></td></tr>
		<tr><td colspan="2"><?php echo $address2;?></td></tr>
		<tr><td colspan="2"><?php echo $city;?>- <?php echo $pincode;?></td></tr>
		<tr><td height="20px;">Dear Sir</td></tr>
		<tr><td colspan="2" align="center"><b>Reg: Approval for participation in overseas exhibition.</b></td></tr>
		<tr>
		  <td colspan="2">Kindly refer to your letter dated <?php echo $application_date;?> on the above subject seeking permission to participate in the following exhibition:</td>
	  </tr>
		<tr><td  ><b>Description for item to be taken:</b></td></tr>
        <?php if($item1!=""){?>
		<tr>
			<td width="50%"><b><?php echo $item1;?></b></td>
			<td width="50%"><?php echo $invoice_value1;?></td>
		</tr>
        <?php }?>
        <?php if($item2!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item2;?></b></td>
			<td width="50%"><?php echo $invoice_value2;?></td>
		</tr>
        <?php }?>
        <?php if($item3!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item3;?></b></td>
			<td width="50%"><?php echo $invoice_value3;?></td>
		</tr>
        <?php }?>
        <?php if($item4!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item4;?></b></td>
			<td width="50%"><?php echo $invoice_value4;?></td>
		</tr>
        <?php }?>
        <?php if($item5!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item5;?></b></td>
			<td width="50%"><?php echo $invoice_value5;?></td>
		</tr>
       	<?php }?>
		<tr>
			<td width="50%"><b>Total Invoice value USD  :</b></td>
		  <td width="50%"><?php echo $total;?></td>
		</tr>
		<tr>
			<td height="10"><b>In Words :</b></td>
			<td><?php number_word_usd($total);?> ONLY </td>
	  </tr>	
		<tr>
			<td colspan="2">
				<table width="100%" border="1" cellpadding="0" cellspacing="0" style="font-size:11px;">
                <tr>
                    <th width="10%" align="center">Exhibition Name</th>
                    <th align="center">Venue</th>
                    <th align="center">Organizer</th>
                    <th width="15%" align="center">From Date</th>
                    <th width="15%" align="center">To Date</th>
                </tr>
                <?php 
				$query1 = $conn ->query("select * from trade_exhibition_info where app_id=$app_id and registration_id='$registraton_id'");
				while($result1 = $query1->fetch_assoc()){
				$query2  = $conn ->query("select * from trade_exhibition_master where Exhibition_Id='".$result1['exhibition_id']."'");
				$result2 = $query2->fetch_assoc();
				?>
                <tr>
                    <td><?php echo $result2['Exhibition_Name'];?></td>
                    <td><?php echo $result1['venue_address'];?></td>
                    <td><?php echo $result1['organizer_address'];?></td>
                    <td><?php echo $result1['exhibition_date_from'];?></td>
                    <td><?php echo $result1['exhibition_date_to'];?></td>
                </tr>
                <?php } ?>
				</table>
		  </td>
		</tr>	
        <tr><td height="20px;"></td></tr>
		<?php
		$signature_authority=$doc_result['signature_authority'];
		$other_sign=$doc_result['other_sign'];		
		?>
		<!--<tr><td colspan="2"><b></b></td></tr>						
		<tr><td colspan="2"><?php if($signature_authority=="Other"){ echo $other_sign;}else{ echo $signature_authority;}?></td></tr>-->						
		<tr><td colspan="2">Copy To : <?php echo $doc_result['copyto'];?>,<?php echo $doc_result['city'];?></td></tr>
		<tr><td colspan="2">
		<?php 
		if($bank_name=="other"){echo strtoupper($other_bank_name);}else{echo strtoupper($bank_name);}
		echo strtoupper(",".$branch_name);
		?>
        </td></tr>
        <!--<tr><td colspan="2" align="center" height="30px;"><h3>The Gem & Jewellery Export Promotion Council</h3></td></tr>-->
          <?php 
		$sqll = $conn ->query("select * from  region_master where region_name='$region_code'");
		$result = $sqll->fetch_assoc();
		$add=$result['region_address'];
		$tel=$result['region_tel_no'];
		$fax=$result['region_fax'];
		$mail=$result['region_email'];
		?>
        <!--<tr><td colspan="2" align="center">
		<?php if($region_code=="HO-MUM (M)"){ echo '<strong>Exhibition Cell:</strong>';}
		 else { echo '<strong>Regional Office:</strong>';}?>		
		<?php echo $add ;?>,Tel No. : <?php echo $tel;?> , Fax : <?php echo $fax;?>, Email : <?php echo $mail;?></td></tr>
        <tr><td colspan="2" align="center"><strong>Head Office:</strong>Tower-A, AW-1010, G Block, Bharat Diamond Bource, Bandra-Kurla Complex, Bandra(E) Mumbai - 400 051 , India Phone:91-22-26544600, Fax:91-22-26524764, Email : gjepc@vsnl.com / ho@gjepcindia.com</td></tr>
        <tr><td colspan="2" align="center"><strong>CIN:U99100MHI966GAP013486</strong></td></tr>-->
	</tbody>
</table>
<div class="letter_note">Note: Kindly collect the Signed permission copy from GJEPC office.</div>
</div>
</body>
</html>
