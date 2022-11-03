<?php 
$pageTitle = "Gems And Jewellery Industry In India | Tariff Structure in India - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php';	
if($_REQUEST['Reset']=="Reset")
		{
		  $_SESSION['country'] =""; 		  	  
		  $_SESSION['commodity'] =""; 		  	  
		  
		  header("Location: tariff_structure_intl.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$commodity = $_POST['commodity'];
		$country = $_POST['country'];
		$fta_rta = $_POST['fta_rta'];
		
		$_SESSION['commodity'] 	= $commodity;
		$_SESSION['country'] 	= $country;
		
		if($country=="")
		{  $signup_error = "Please Select Country."; 
		}
		else if($commodity=="")
		{  $signup_error = "Please Select Commodity."; 
		} else {
		
		if(isset($commodity) && $commodity!='' && $country!='')
		{
			$sql ="SELECT * from statistics_intl_tariff_structure where country='$country' AND hscode='$commodity'";
			$resultx = $conn ->query($sql);
			$rCount = $resultx->num_rows;
			$getValue="";
			if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
		}
		
		}
		}
		}
?>

<section>
<div class="container inner_container">
    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font">Trade Tools</h1>
        </div>
    </div>
    <div class="row justify-content-center">
         
            <div class="row"> 
			
			<form class="cmxform form-export-import col-12 box-shadow mb-4" method="post" name="regisForm" id="regisForm" autocomplete="off">
			<input type="hidden" name="search_type" id="search_type" value="SEARCH"/>  
			<div class="col-12">
				<a href="https://gjepc.org/statistics.php#pane-B" class="cta" onclick="goBack()"><i class="fa fa-back"></i>&nbsp;Back</a>
				</div>
                <div class="form-group col-12 mb-4">
                    <p class="blue text-center">Import tariff structure in different countries for India</p>
                </div>
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>
				
                <div class="col-md-1">
                    <div class="form_side_pattern"> </div>
                </div>
                <div class="col-md-11 mb-3">
                    <div class="row">
						<div class="col-12 mb-2">
                         <div class="row">
                        <div class="col-3 d-flex align-items-center"><label> Country</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                        <select name="country" id="country" class="form-control">
                            <option value="">--- Select Country ---</option>
                            <?php 
							$sql="SELECT distinct(country) FROM statistics_intl_tariff_structure where 1 order by country";
							$stmt = $conn -> prepare($sql);
							$stmt -> execute();			
							$query = $stmt->get_result();
							while($result = $query->fetch_assoc()) { ?>
							<option value="<?php echo $result['country'];?>" <?php if($_SESSION["country"]==$result['country']) echo "selected"; ?>><?php echo strtoupper($result['country']);?></option>
							<?php } ?>
                        </select>
						</div>
                        </div>
                        </div>
						
                        <div class="col-12 mb-2">
                         <div class="row">
                        <div class="col-3 d-flex align-items-center"><label> Select Commodity</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8" id="hscodeDiv">
                        <select name="commodity" id="commodity" class="form-control">                     
                        </select>
						</div>
                        </div>
                        </div>
						
						<!--<div class="col-12 mb-2">
                         <div class="row">
                        <div class="col-3 d-flex align-items-center"><label>Whether there is FTA/RTA ?</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                        <label class="form-label" for="yes"> Yes &nbsp;</label><input type="radio" name="fta_rta" id="fta_rta" value="Yes"/>
						<label class="form-label" for="no"> No &nbsp;</label><input type="radio" name="fta_rta" id="fta_rta" value="No"/>
						<label for="fta_rta" generated="true" style="display: none;" class="error">Please Select FTA/RTA</label>
						</div>						
                        </div>
                        </div>-->
                       
                    <div class="col-12">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <input type="submit" name="submit" value="Submit" class="gold_btn fade_anim d-block w-100 mr-3">
                            </div>
                           <div class="col-6">
                                <input type="submit" name="Reset" value="Reset" class="fade_anim btn-reset w-100 d-block">
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
			</form>
			
			<?php
			if(!empty($getValue==1)) {
			if(isset($rCount) && $rCount>0)
			{ ?>
            <div class="col-12">
                        <div class="row py-3" style="border-top: 1px solid #ccc">
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Import tariff structure in different countries for India</h2></div>
                            
                            <div class="col-12 mb-3">
                                <p class="text-center"><strong>Date</strong>: <?php echo date("d/m/Y");?></p>
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-bordered tableInfo w-auto mx-auto">
                                   
                                    <tbody>
									<?php 
									$i=1;
									while($row = $resultx->fetch_assoc())
									{ //print_r($row); exit;
									?>
                                        <tr>
                                        	<td><strong>Country Name</strong></td>
                                        	<td><?php echo $row['country'];?></td>
                                        </tr>

                                        <tr>
                                        	<td><strong>HS Code</strong></td>
                                            <td><?php echo $row['hscode'];?></td>
                                        </tr>
										<tr>
                                        	<td><strong>Product Description</strong></td>
                                            <td><?php echo $row['product_desc'];?></td>
                                        </tr>

                                        <tr>
                                        	<td><strong>Whether there is/are  any Trade agreement(s) ?</strong></td>
                                            <td><?php echo $row['is_any_trade_agreement'];?></td>
                                        </tr>

                                        <tr>
                                        	<td><strong>Trade Agreement name(s) - 1 </strong></td>
                                            <td><?php echo $row['trade_agreement1'];?></td>
                                        </tr>
										<?php if(trim($row['trade_agreement2'])!='0'){?>
										<tr>
                                        	<td><strong>Trade Agreement name(s) - 2 </strong></td>
                                            <td><?php echo $row['trade_agreement2'];?></td>
                                        </tr>
										<?php } ?>
										<!--<tr>
                                        	<td><strong>Basic Duty </strong></td>
                                            <td><?php echo $row['basic_duty'];?></td>
                                       	</tr>-->
										
										<tr>
                                        	<td><strong>Most Favoured Nation rate (MFN)</strong></td>
                                            <td><?php echo $row['mfn'];?></td>
                                       	</tr>
										<tr>
                                        	<td><strong>1 - Preferential tax rate</strong></td>
                                            <td><?php echo $row['prefered_tax_rate1'];?></td>
                                        </tr>
										<?php if(trim($row['prefered_tax_rate2'])!='0'){?>
										<tr>
                                        	<td><strong>2 - Preferential tax rate</strong></td>
                                            <td><?php echo $row['prefered_tax_rate2'];?></td>
                                        </tr>
										<?php } ?>
										<tr>
                                        	<td><strong>1 - Rules of Origin</strong> </td>
                                            <td><?php echo $row['rules_of_origin1'];?></td>
                                        </tr>
										<?php
										if(trim($row['rules_of_origin2'])!='0'){?>
										<tr>
                                        	<td><strong>2 - Rules of Origin</strong> </td>
                                            <td><?php echo $row['rules_of_origin2'];?></td>
                                        </tr>
										<?php } ?>
                                        <tr>
                                        	<td><strong>Other Taxes /Duties </strong></td>
                                            <td><?php //echo $row['other_taxes']; 
											echo $output = str_replace(',', '<br />', $row['other_taxes']);?></td>
                                        </tr>
                                     <?php 
										$i++; } ?>   
                                    </tbody>
                                </table>
                            </div>
							<div class="col-12">
                                <table class="table table-bordered tableInfo w-auto mx-auto">
									<th> Glossary </th>
                                        <tr>
                                        	<td><strong>* ROO - Rules of Origin</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>CC - Change in Chapter</strong></td>
                                        </tr>
										 <tr>
                                        	<td><strong>CTH - Change in Tariff Heading</strong></td>
                                        </tr>
                                        <tr>
                                        	<td><strong>CTSH - Change in Tariff Sub Heading</strong></td>
                                        </tr>
										<tr>
                                        	<td><strong>RVC - Regional Value Content</strong></td>
                                        </tr>
                                </table>								
                            </div>
                        </div>
            </div> 
			<?php } } if(isset($rCount) && $rCount==0){ ?>  No Data Found <?php } ?>
    </div>
</div> 
</section>

<?php include 'include-new/footer_export.php'; ?>

<style type="text/css">
    .form-export-import label, .form-export-import span{color: #9e9457;font-weight: bold;}
    
    .form_side_pattern:before{content:"";position: absolute;top: 0;bottom: 0;left: 13px;width: 79%;background: url(https://gjepc.org/assets/images/mobile_bg.png) repeat left;background-size: 300px;}
    .radio-box{border:1px solid#9e9457;width: 100%;padding: 6px 5px; border-radius: 5px;}
    .radio-box:hover{background: #9e9457;border:1px solid#9e9457;color:#000;}
    .radio-box input[type=radio]{margin-bottom: 6px }
    .radio-box-active{border:1px solid#7b702c;background: #9e9457;color: #000!important}
    .search_bar{position: relative;}
    .fix-into-input{    position: absolute;
    top: 10px;
    right: 7%;
    font-size: 19px;
    color: #9e9457;cursor: pointer;}
    .fix-into-input:hover{color: #000}
    .btn-reset{    background: #ccc;
    padding: 10px 15px;
    color: #fff;
  
    margin-bottom: 15px;
    position: relative;
    text-align: center;}
    .btn-reset:hover{    background: #a2a1a1;
   }
   .tableInfo thead{background: #000;
    color: #a89c5d;}
    .fstElement {
    display: block;}
    .fstToggleBtn{padding: 8px;font-size: 13px}
    .fstMultipleMode .fstControls{width: 100%}
    .fstChoiceItem,.fstResultItem,.fstMultipleMode .fstQueryInput{font-size: 12px;width: 100%}
    .fstNoResults {
    font-size: 13px;}
    .fstChoiceItem{    border: 1px solid #888158;background-color: #948b52;}
    .fstResultItem.fstSelected {
    color: #fff;
    background-color: #948b52;
    border-color: #847d54;}
    .fstResultItem.fstFocused {
    color: #fff;
    background-color: #948b52;
    border-color: #7d7855;}
    .fstMultipleMode.fstActive .fstResults{max-height:200px }
</style>

<script type="text/javascript">
          $('input[type="radio"]').on("change",function(){
             $('input[type="radio"]:not(:checked)').parent('label').removeClass("radio-box-active");
             $('input[type="radio"]:checked').parent('label').addClass("radio-box-active");
        });
</script>
<script>
$(document).ready(function(){
$("#country").change(function(){
	country=$("#country").val();
		$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getCommodity&country="+country,
					dataType:'html',
					beforeSend: function(){
					$('#preloader').show();
					$('#status').show();
					},
					success: function(data){						
							//alert(data);
					$('#preloader').hide();
					$('#status').hide();
					$("#hscodeDiv").html(data);  
					}
		});
 });
 });
</script>
