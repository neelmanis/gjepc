<?php
ob_start();
session_start();

include('../db.inc.php');
include('../functions.php');
?>
<?php
$ref_no = filter($_REQUEST['ref_no']);
if(isset($_REQUEST['registraton_id']))
{
	$registraton_id = intval($_REQUEST['registraton_id']);
}
else
{
	$registraton_id = intval($_SESSION['USERID']);
}

$app_id = intval($_REQUEST['app_id']);
?>
<?php 
$sql_max="select * from trade_general_info where app_id=$app_id and registration_id='$registraton_id'";
$stmt = $conn -> prepare($sql_max);
$stmt -> execute();
$resultx = $stmt->get_result();		   
$result = $resultx->fetch_assoc();

$permission_no=$result['permission_no'];
$address1= trim($result['address1']);
$address2= trim($result['address2']);
$pincode=$result['pincode'];
$city=$result['city'];
$region_code=$result['region_code'];
$from_date=$result['from_date'];
$to_date=$result['to_date'];

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

$visiting_country1=$result['visiting_country1'];
$city1=$result['city1'];
$visiting_country2=$result['visiting_country2'];
$city2=$result['city2'];
$visiting_country3=$result['visiting_country3'];
$city3=$result['city3'];
$visiting_country4=$result['visiting_country4'];
$city4=$result['city4'];
$visiting_country5=$result['visiting_country5'];
$city5=$result['city5'];
$visiting_country6=$result['visiting_country6'];
$city6=$result['city6'];


$bank_name=$result['bank_name'];
$other_bank_name=$result['other_bank_name'];
$branch_name=$result['branch_name'];

$total=intval($invoice_value1)+intval($invoice_value2)+intval($invoice_value3)+intval($invoice_value4)+intval($invoice_value5);

$doc_query=$conn ->query("select copyto,city,signature_authority, other_sign from trade_documents where app_id=$app_id and registration_id='$registraton_id'");
$doc_result=$doc_query->fetch_assoc();
$company=getCompanyName($registraton_id,$conn);
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
<style>
/* media:print */
#img {
    visibility: visible;
}
</style>

<table cellpadding="1" width="95%" align="center" id="print_div" style="font-size:13px;"> 
	<tbody>
		<!--<tr> <td height="40"> </td> </tr>-->
        <tr>         
        <td colspan="2" align="right"><img id="img" src="https://gjepc.org/assets/images/logo.png" width="132" height="91" /></td>
        </tr>
        <tr>
			<td >Ref No: <?php echo $ref_no;?></td>
			<td width="85%" align="right">DATE: <?php echo date('d-m-Y');?></td>
        </tr>
		<tr><td><b>To  </b></td></tr>
		<tr><td colspan="2"><b>M/s.</b> <?php echo strtoupper($company);?></td></tr>
		<tr><td colspan="2"><?php echo $address1;?></td></tr>
		<tr><td colspan="2"><?php echo $address2;?></td></tr>
		<tr><td colspan="2"><?php echo $city;?>- <?php echo $pincode;?></td></tr>
		<tr><td height="20px;">Dear Sir(s),</td></tr>
		<tr><td colspan="2" align="center"><b>Reg: Approval for participation in export promotion tour overseas. </b></td></tr>
		<tr><td colspan="2" >Please refer to your application dated <?php echo $application_date;?> on the above subject seeking permission for Export Promotion Tour as Per details given below:</td></tr>
		<tr><td colspan="2"><b>Description for item to be taken with value:</b></td></tr>
		<?php if($item1!=""){?>
		<tr>
			<td width="50%"><b><?php echo $item1;?> US $ </b></td>
			<td width="50%"><?php echo $invoice_value1;?></td>
		</tr>
        <?php }?>
        <?php if($item2!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item2;?>  US $  </b></td>
			<td width="50%"><?php echo $invoice_value2;?></td>
		</tr>
        <?php }?>
        <?php if($item3!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item3;?>  US $  </b></td>
			<td width="50%"><?php echo $invoice_value3;?></td>
		</tr>
        <?php }?>
        <?php if($item4!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item4;?>  US $ </b></td>
			<td width="50%"><?php echo $invoice_value4;?></td>
		</tr>
        <?php }?>
        <?php if($item5!=""){?>
        <tr>
			<td width="50%"><b><?php echo $item5;?>  US $ </b></td>
			<td width="50%"><?php echo $invoice_value5;?></td>
		</tr>
       	<?php }?>
		
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
						<th colspan="2">Export Promotion Tour To </th><th colspan="2">Dates</th>
					</tr>
					<tr>
						<th colspan="2"> Country</th><th>From</th><th>To</th>
					</tr>
                    <?php if($visiting_country1!=''){?>
					<tr>
						<td><?php echo getCountryName($visiting_country1,$conn);?></td><td><?php echo strtoupper($city1);?></td><td><?php echo $from_date;?></td><td><?php echo $to_date;?></td>
					</tr>
                    <?php }?>
                    <?php if($visiting_country2!=''){?>
					<tr>
						<td><?php echo getCountryName($visiting_country2,$conn);?></td><td><?php echo strtoupper($city2);?></td><td><?php echo $from_date;?></td><td><?php echo $to_date;?></td>
					</tr>
                    <?php }?>
                    <?php if($visiting_country3!=''){?>
					<tr>
						<td><?php echo getCountryName($visiting_country3,$conn);?></td><td><?php echo strtoupper($city3);?></td><td><?php echo $from_date;?></td><td><?php echo $to_date;?></td>
					</tr>
                    <?php }?>
                    <?php if($visiting_country4!=''){?>
					<tr>
						<td><?php echo getCountryName($visiting_country4,$conn);?></td><td><?php echo strtoupper($city4);?></td><td><?php echo $from_date;?></td><td><?php echo $to_date;?></td>
					</tr>
                    <?php }?>
                    <?php if($visiting_country5!=''){?>
					<tr>
						<td><?php echo getCountryName($visiting_country5,$conn);?></td><td><?php echo strtoupper($city5);?></td><td><?php echo $from_date;?></td><td><?php echo $to_date;?></td>
					</tr>
                    <?php }?>
                    <?php if($visiting_country6!=''){?>
					<tr>
						<td><?php echo getCountryName($visiting_country6,$conn);?></td><td><?php echo strtoupper($city6);?></td><td><?php echo $from_date;?></td><td><?php echo $to_date;?></td>
					</tr>
                    <?php }?>
																					
				</table>
			</td>
		</tr>	
		<tr>
			<td colspan="2">Approval is hereby accorded under para 4.46 of Foreign Trade Policy read with of the Hand Book of Procedure for Years 2015 - 2020 (UPDATED AS ON) amended till date, for participation in export promotion tour overseas.<br/>You will have to submit a complete report within one month of completion of the tour.</td>
		</tr>		
		<tr>
			<td>Note :</td>
		</tr>	
		<tr>
			<td colspan="2"><i><b>1) If under any circumstance, you fail to import the unsold goods back on or before end of the time period defined as per Para 4.80 of HBoP, your goods shall be liable to be imported after payment of applicable import duty unless such delay is not duly  condoned by DGFT.</b></i></td>
		</tr>	
		<tr>
			<td colspan="2"><i><b>2) For any changes in any condition as mentioned above in this approval, for any reason thereof, you are advised to apply to Council with valid reason before the date of completion of the exhibition/export promotion tour as mentioned above.</b></i></td>
		</tr>	
		
        <tr><td height="20px"></td></tr>
		<?php
		$signature_authority=$doc_result['signature_authority'];
		$other_sign=$doc_result['other_sign'];		
		?>
		<tr><td colspan="2"><b></b></td></tr>						
		<tr><td colspan="2"><?php if($signature_authority=="Other"){ echo $other_sign;}else{ echo $signature_authority;}?></td></tr>
		<tr><td colspan="2">Copy To : <?php echo $doc_result['copyto'];?>,<?php echo $doc_result['city'];?></td></tr>
		<tr><td colspan="2">
        <?php 
		if($bank_name=="other"){echo strtoupper($other_bank_name);}else{echo strtoupper($bank_name);}
		echo strtoupper(",".$branch_name);
		?>
        </td></tr>
		<tr height="10px"></tr>
        <tr><td colspan="2" align="center" ><h3>The Gem & Jewellery Export Promotion Council</h3></td></tr>
        <?php 
		$sqll="select * from region_master where region_name='$region_code'";
		$query=$conn ->query($sqll);
		$result=$query->fetch_assoc();
		$add=$result['region_address'];
		$tel=$result['region_tel_no'];
		$fax=$result['region_fax'];
		$mail=$result['region_email'];
		?>
        <tr><td colspan="2" align="center">
		<?php if($region_code=="HO-MUM (M)"){?>
		<strong>Exhibition Cell:</strong>D2B, Ground Floor, D Tower, West Core, Bharat Diamond Bource, Bandra-Kurla Complex, Bandra(E) Mumbai - 400051, India Phone:91-22-24226 3600, Email : exhibitions@gjepcindia.com
		<?php } else {
		 echo '<strong>Regional Office:</strong>';?>		
		<?php echo $add ;?>,Tel No. : <?php echo $tel;?> , Fax : <?php echo $fax;?>, Email : <?php echo $mail; }?></td>	
		</tr>
    
        <tr><td colspan="2" align="center"><strong>Head Office:</strong>D2B, Ground Floor, D Tower, West Core, Bharat Diamond Bourse, Bandra Kurla Complex, Bandra (E) Mumbai - 400 051, India Phone:91-22-24226 3600, Email : gjepc@vsnl.com  / ho@gjepcindia.com</td></tr>
        <tr><td colspan="2" align="center"><strong>CIN:U99100MHI966GAP013486</strong></td></tr>
	</tbody>
</table>
</div>
</body>
</html>