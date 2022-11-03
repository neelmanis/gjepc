<?php 
$pageTitle = "Gems And Jewellery Industry In India | Calculate your Duty - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php';

if($_REQUEST['Reset']=="Reset")
{
		  $_SESSION['commodity'] =""; 		  	  
		  
		  header("Location: calculate-your-duty.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$commodity = $_POST['commodity'];
		$amount = trim($_POST['amount']);
		
		$_SESSION['commodity'] 	= $commodity;
		
		if($commodity=="")
		{  $signup_error = "Please Select Commodity."; 
		} else if($amount=="")
		{  $signup_error = "Please Enter Amount."; 
		} else {
		$sql="SELECT * from statistics_tariff_structure where hs_code='$commodity'";
		}
	
		//echo $sql;
		$resultx = $conn ->query($sql);  
		$rCount = $resultx->num_rows;
		$getValue="";
		if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
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
    <div class="row justify-content-center" >
         
            <div class="row"> 
			<form class="cmxform form-export-import col-12 box-shadow mb-4" method="post" name="regisForm" id="regisForm" autocomplete="off">
			<input type="hidden" name="search_type" id="search_type" value="SEARCH"/>  
			
                <div class="form-group col-12 mb-4"> 
                    <p class="blue text-center">Tariff Calculator</p>
                </div>
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>
				
                <div class="col-md-1">
                    <div class="form_side_pattern"> </div>
                </div>
                <div class="col-md-11 mb-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label> Select Commodity</label>
                        </div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                        <select name="commodity" id="commodity" class="form-control search_bar" placeholder="Search Specific Commodity">
						<option value="">Select Commodity</option>
								<?php 
								$commodity_query = "select * from statistics_tariff_structure where 1 order by hs_code ASC ";
								$execute_commodity = $conn ->query($commodity_query);
								while($show_commodity = $execute_commodity->fetch_assoc())
								{
									if($_SESSION['commodity']==$show_commodity['hs_code'])
									{
										echo "<option value='$show_commodity[hs_code]' selected='selected'>$show_commodity[hs_code] - $show_commodity[commodity_description]</option>";
									} else
									{
									echo "<option value='$show_commodity[hs_code]'>$show_commodity[hs_code] - $show_commodity[commodity_description]</option>";
									}
								?>
								<?php  } ?>                          
                        </select>
						</div>						
                        </div>
                        </div>
						
						<div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label>Enter Imported value in Rs.</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
                            <input type="text" name="amount" class="form-control numeric" placeholder="Enter Imported value in Rs." maxlength="10">
                        </div>
                        </div>
                        </div>
                       
                    <div class="col-12">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                 <input type="submit" name="submit" value="Calculate" class="gold_btn fade_anim d-block w-100 mr-3">
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
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Total Tariffs on the Imports of Selected Commodity</h2></div>
                            
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <p><strong>Date</strong>: <?php echo date("d/m/Y");?></p>
                                </div> 
                                <div class="row justify-content-center mt-4">
                                   		<div class="col-md-9 searchResultwrap">
                                        	<ul>
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Commodity Name</div>
                                                        <div class="col-md-8 sResult">
                                                        	<p>
															<?php 											
															echo $_POST['commodity'].' - '. getTariffCommodityDescription($_POST['commodity'],$conn); ?>
															</p>
                                                        </div>
                                                    </div>
                                                </li> 
												
                                            </ul>                                            
                                        </div>                                    
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-bordered tableInfo">
                                    <thead>
                                        <tr>
                                            <th>Particulars</th>
                                            <th>Total Tariff in Rs.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									while($row = $resultx->fetch_assoc())
									{
										$getDuty = $row['duty'];
										$getIGST = $row['igst'];
										$getCESS = $row['welfare_surcharge'];
									?>
                                        <tr>
                                           <td align="center">Value in Rs.</td>
                                           <td align="center"><?php echo $productAmount = trim($_REQUEST['amount']);?></td>
										</tr>
										<tr>
                                            <td align="center">Duty <?php echo $getDuty;?> </td>
                                            <td align="center"><?php echo $productDuty = round($productAmount*$getDuty)/100; ?></td>
										</tr>
										<tr>
                                            <td align="center">Cess <?php echo $getCESS;?></td>                                         
                                             <td align="center"><?php echo $cess = round($productDuty*$getCESS)/100; ?></td>               
										</tr>
										<tr>
                                            <td align="center">Total</td>
                                            <td align="center"><?php echo $Total = $productAmount+$productDuty+$cess; ?></td>
										</tr>
										<tr>
                                           <td align="center">IGST <?php echo $getIGST;?></td>
                                           <td align="center"><?php echo $igst = round($Total*$getIGST)/100; ?></td>  
										</tr>										
										<tr>
                                           <td align="center">Total tax</td>                                         
                                           <td align="center"><?php echo $totalTax = $productDuty+$cess+$igst; ?></td>                          
										</tr>										
                                     <?php } ?>   
                                    </tbody>
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

      $('#commodity').fastselect();
	  
	  $('.numeric').keypress(function (event) {
	  var keycode = event.which;
	  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
	  {
		event.preventDefault();
	  }
	});
</script>