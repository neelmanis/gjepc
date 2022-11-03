<?php
ob_start();
session_start();
include('../db.inc.php');
include('../functions.php');

$ref_no = trim($_REQUEST['ref_no']);
if(isset($_REQUEST['registraton_id']) && $_REQUEST['registraton_id']!='')
	$registraton_id=$_REQUEST['registraton_id'];
else
	$registraton_id=$_SESSION['USERID'];
	
$app_id	=	filter($_REQUEST['app_id']);
?>
<?php 
$sql_max = "select * from trade_general_info where app_id=$app_id and registration_id='$registraton_id'";
$stmt = $conn -> prepare($sql_max);
$stmt -> execute();
$resultx = $stmt->get_result();		   
$result = $resultx->fetch_assoc();

$permission_no=$result['permission_no'];
$address1	=	filter($result['address1']);
$address2	=	filter($result['address2']);
$pincode	=	filter($result['pincode']);
$city		=	filter($result['city']);
$region_code=$result['region_code'];
$application_date=$result['application_date'];
$created_date=$result['created_date'];
$modified_date=$result['modified_date'];
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
$bank_name	=	filter($result['bank_name']);
$other_bank_name	=	filter($result['other_bank_name']);
$branch_name	=	filter($result['branch_name']);
$company=getCompanyName($registraton_id,$conn);

$total=intval($invoice_value1)+intval($invoice_value2)+intval($invoice_value3)+intval($invoice_value4)+intval($invoice_value5);

$doc_query=$conn ->query("select copyto,city,signature_authority,other_sign from trade_documents where app_id=$app_id and registration_id='$registraton_id'");
$doc_result=$doc_query->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Trade Permission</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $("#btnPrint").live("click", function () {
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=5500,width=1200');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            if (is_chrome) {
        setTimeout(function () { // wait until all resources loaded 
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10
                mywindow.print();  // change window to winPrint
                mywindow.close();// change window to winPrint
        }, 250);
    }
    else {
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();
    }

    return true;
    });
</script>
     
</head>
<body>
 
<input type="button" value="Print Out" id="btnPrint" /> 
<div id="dvContainer">
<table width="100%" align="center" style="font-size:13px;">
	<tbody>
        <tr>        
         <td align="left"></td>         
          <td align="right"><img src="https://gjepc.org/admin/images/logo.png" width="132" height="91" /></td>           
        </tr>          
       
        <tr>
			<td >Ref No: <?php echo $ref_no;?></td>
			<td width="85%" align="right">DATE: <?php echo  $modified_date;?></td>
        </tr>
		<tr><td><b>To</b></td></tr>
        <tr><td colspan="2"><b>M/s.</b> <?php echo strtoupper($company);?></td></tr>
		<tr><td colspan="2"><?php echo $address1;?></td></tr>
		<tr><td colspan="2"><?php echo $address2;?></td></tr>
		<tr><td colspan="2"><?php echo $city;?>- <?php echo $pincode;?></td></tr>
		<tr><td height="20px;">Dear Sir(s),</td></tr>
		<tr><td colspan="2" align="center"><b>Reg: Approval for participation in overseas exhibition.</b></td></tr>
		<tr><td colspan="2">Please refer to your application dated <?php echo $application_date;?> on the above subject seeking permission to participate in the following exhibition:</td>
	  </tr>
		<tr><td><b>Description for item to be taken with value:</b></td></tr>
        <?php if($item1!=""){ ?>
		<tr>
		<td width="50%"><b><?php echo $item1;?> US $ </b></td>
		<td width="50%"><?php echo $invoice_value1;?></td>
		</tr>
        <?php } ?>
        <?php if($item2!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item2;?> US $ </b></td>
			<td width="50%"><?php echo $invoice_value2;?></td>
		</tr>
        <?php }?>
        <?php if($item3!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item3;?> US $  </b></td>
			<td width="50%"><?php echo $invoice_value3;?></td>
		</tr>
        <?php }?>
        <?php if($item4!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item4;?> US $ </b></td>
			<td width="50%"><?php echo $invoice_value4;?></td>
		</tr>
        <?php }?>
        <?php if($item5!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item5;?> US $ </b></td>
			<td width="50%"><?php echo $invoice_value5;?></td>
		</tr>
       	<?php } ?>		
		<tr>
		<td width="50%"><b>Total Invoice value in US $  :</b></td>
		<td width="50%"><?php echo $total;?></td>
		</tr>
		<tr>
		<td height="10"><b>In Words :</b></td>
		<td> <?php number_word_usd($total);?> ONLY </td>
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
				$query1= $conn ->query("select * from trade_exhibition_info where app_id=$app_id and registration_id='$registraton_id' order by exh_id ASC");
				while($result1=$query1->fetch_assoc()){
				$query2= $conn ->query("select * from trade_exhibition_master where Exhibition_Id='".$result1['exhibition_id']."'");
				$result2=$query2->fetch_assoc();
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
		<tr>
			<td colspan="2">Approval is hereby accorded under para 4.46 of Foreign Trade Policy read with para 4.80 of the Hand Book of Procedure for Years 2015 - 2020 amended till date, for participation in overseas exhibition.<br/>You will have to submit the complete report within one month of completion of the event(s)</td>
		</tr>
		<tr>
			<td>Note :</td>
		</tr>	
		<tr>
			<td colspan="2"><i><b>1) If under any circumstance, you fail to import the unsold goods back on or before end of the time period defined as per Para 4.80 of HBoP,  your goods shall  be liable to be imported after payment of applicable import duty unless such delay is not duly  condoned by DGFT.</b></i></td>
		</tr>	
		<tr>
			<td colspan="2"><i><b>2) For any changes in any condition as mentioned above in this approval, for any reason thereof, you are advised to apply to Council with valid reason before the date of completion of the exhibition/export promotion tour as mentioned above.</b></i></td>
		</tr>	
		
        <tr><td height="20px;"></td></tr>
		<?php
		$signature_authority=$doc_result['signature_authority'];
		$other_sign=$doc_result['other_sign'];		
		?>
		<tr><td colspan="2"><b></b></td></tr>						
		<tr><td colspan="2"><?php if($signature_authority=="Other"){ echo $other_sign;}else{ echo $signature_authority;}?></td></tr>						
		<tr><td colspan="2">Copy To : <?php echo $doc_result['copyto'];?>, <?php echo $doc_result['city'];?></td></tr>
		<tr><td colspan="2">
		<?php 
		if($bank_name=="other"){ echo strtoupper($other_bank_name);}else{echo strtoupper($bank_name);}
		echo strtoupper(",".$branch_name);
		?>
        </td></tr>
        <tr height="30px"></tr>
		<tr><td colspan="2" align="center"><h3>The Gem & Jewellery Export Promotion Council</h3></td></tr>
        <?php 
		$sqll="select * from  region_master where region_name='$region_code'";
		$resultx= $conn ->query($sqll);
		$result=$resultx->fetch_assoc();
		$add=$result['region_address'];
		$tel=$result['region_tel_no'];
		$fax=$result['region_fax'];
		$mail=$result['region_email'];
		?>
		
        <tr>
		<td colspan="2" align="center">
		<?php if($region_code=="HO-MUM (M)"){?>
		D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E), Mumbai 400 051, India. Toll Free : 1800-103-4353, Email : ho@gjepcindia.com
		<?php } else {
		 echo '<strong>Regional Office:</strong>';?>		
		<?php echo $add ;?>,Tel No. : <?php echo $tel;?> , Fax : <?php echo $fax;?>, Email : <?php echo $mail; }?></td>	
		</tr>
        <tr><td colspan="2" align="center"><strong>CIN:U99100MHI966GAP013486</strong></td></tr>
	</tbody>
</table>
</div>
</body>
</html>