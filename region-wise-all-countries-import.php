<?php 
$pageTitle = "Gems And Jewellery Industry In India | Region-wise all countries - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php';

		if($_REQUEST['Reset']=="Reset")
		{
		  $_SESSION['financial_year']  =""; 
		  $_SESSION['region']	   	   =""; 	  
		  $_SESSION['currency']        =""; 		  
		  $_SESSION['display_records'] =""; 		  
		  
		  header("Location: region-wise-all-countries-import.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$financial_year  = $_REQUEST['financial_year'];
		$region	 	 	 = $_REQUEST['region'];
		$trade_type 	 = "Import";
		$currency  		 = $_POST['currency'];
		$display_records = filter($_REQUEST['display_records']);			
		
		$_SESSION['financial_year'] = $financial_year;
		$_SESSION['region'] 		= $region;
		$_SESSION['currency'] 		= $currency;
		$_SESSION['display_records'] = $display_records;
		
		//echo "Searched Financial year : ".$financial_year;
		$cur_year = substr($financial_year, 0,-5);
		//echo '<br/>'; 
		//current challan yr calculation
		//echo '--'.$cur_year = (int)date('Y');
		$curyear  = (int)date('Y');
		$cur_month = (int)date('m');
		if($cur_month < 4) {
		 $cur_fin_yr = $curyear-1;
		 $cur_fin_yr1= $cur_year-1;
		 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
		 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
		}  else {
		 $cur_fin_yr = $curyear;
		 $cur_fin_yr1= $cur_year;
		 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
		 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
		}
		//echo '<br/>Last Financial year :'.$last_finyr; 
		//echo '<br/>Current Financial year :'.$cur_finyr; 
		
		if($financial_year=="" || $financial_year=="0")
		{  $signup_error = "Please Select Year."; }
		else if($region=="")
		{  $signup_error = "Please Select Region."; }
		else if($currency=="")
		{  $signup_error = "Please Select Currency Value."; }
		else if($display_records=="")
		{  $signup_error = "Please Select Display Records."; }
		else {
		
		$sql="SELECT `id`, `year`, `financial_year`, `post_date`, `trade_type`, `data_type`, `country_id`, `hs_code_id`, `port_id`, `quantity`, `inr_value`, SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr, `dollar_value`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1";

		if($financial_year!="")
		{
		$sql.=" AND financial_year='$financial_year' ";
		}

		if(isset($region) && $region!='')
		{
			$regionCount = sizeof($region);
			if($regionCount>0)
			{
				if($_POST['region']!=''){
				if(in_array("all",$_POST['region']))
				{
					//echo "ALL";
					$sqlx = "SELECT distinct(country_name) from statistics_integration_country_master WHERE status='1'";
					$result = $conn ->query($sqlx);
					$num = $result->num_rows;
					if($num>0){
						$myArray=array();
						while($row = $result->fetch_assoc()){
						$myArray[] = $row['country_name'];
						}
							//print_r($myArray);
						$sqln= implode(",",array_unique($myArray));
						$result_string = "'" . str_replace(",", "','", $sqln) . "'";
						$sql.=" and country_id IN(".$result_string.") ";
					}
				} else {
					//echo "Single";
					$sqlm= implode(",",array_unique($_POST['region']));
					$result_string = "'" . str_replace(",", "','", $sqlm) . "'";
				    $sqlx = "SELECT country_name FROM statistics_integration_country_master where region_code IN(".$result_string.") AND status='1'";
					$result = $conn ->query($sqlx);
					$num = $result->num_rows;
					if($num>0){
						$myArray=array();
						while($row = $result->fetch_assoc()){
						$myArray[] = $row['country_name'];
						}
							//print_r($myArray);
						$sqln= implode(",",array_unique($myArray));
						$result_string = "'" . str_replace(",", "','", $sqln) . "'";
						$sql.=" and country_id IN(".$result_string.") ";					
						} 
					
					//$sql.=" and country_id IN(".$result_string.") ";
				
				/*echo	$sqlx = "SELECT country_name FROM statistics_integration_country_master where region_code='".$_POST['region']."' AND status='1'";
					$result = $conn ->query($sqlx);
					$num = $result->num_rows;
					if($num>0){
						$myArray=array();
						while($row = $result->fetch_assoc()){
						$myArray[] = $row['country_name'];
						}
							//print_r($myArray);
						$sqln= implode(",",array_unique($myArray));
						$result_string = "'" . str_replace(",", "','", $sqln) . "'";
						$sql.=" and country_id IN(".$result_string.") ";					
						} */
					}
				}
			}
		}
		
		if($currency=="INR"){ $orderBy = "inr_value"; } elseif($currency=="USD") {  $orderBy = "dollar_value"; } else {	$orderBy = "inr_value";	}

		$sql.=" AND trade_type='$trade_type' AND status='1' group by country_id order by ".$orderBy." desc";
		if($display_records!="")
		{
			if($display_records=="all")
			{
				$sql.=" ";
			} else {
				$sql.=" limit 0,$display_records ";
			}		
		}
		
		$sql2 = $sql;
		//echo '<br>';
		$replacedQuery = str_replace("group by country_id", "", $sql2);
		//echo $replacedQuery; 
		$replacedResult = $conn->query($replacedQuery);
		$replacedRow = $replacedResult->fetch_assoc();		
		$grandTotalINR = $replacedRow['total_inr'];
		$grandTotalUSD = round($replacedRow['total_usd']/1000000);
		
		$resultx = $conn ->query($sql2);  
		$rCount = $resultx->num_rows;
		$getValue="";
		if($rCount>0) { $getValue=1; } if($rCount==0) { $getValue='NO'; }
		}
		}
		}
?>

<section>       
 
<div class="container inner_container">
    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font">Export Import Data bank</h1>
        </div>
    </div>
    <div class="row justify-content-center">
         
            <div class="row"> 
				<form class="cmxform form-export-import col-12 box-shadow mb-4" method="POST" name="regisForm" id="regisForm" autocomplete="off">
				<input type="hidden" name="search_type" id="search_type" value="SEARCH"/>
                <div class="form-group col-12 mb-4">
                    <p class="blue text-center">Region-wise all countries</p>
                </div> 
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>				
                <div class="col-md-1">
                    <div class="form_side_pattern"> </div>
                </div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-12  mb-2">
                              <div class="row">
                             <div class="col-3 d-flex align-items-center">
                            <label>Year</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
                            <select name="financial_year" class="form-control">
                                <option value="">Select Year</option>                                
                                <?php 
								$financial_query = "SELECT distinct(financial_year) FROM `statistics_integration_data` WHERE 1 order by financial_year desc";
								$execute_financial = $conn ->query($financial_query);
								while($show_financial = $execute_financial->fetch_assoc())
								{
									if($_SESSION['financial_year']==$show_financial['financial_year'])
									{
										echo "<option value='$show_financial[financial_year]' selected='selected'>$show_financial[financial_year]</option>";
									} else
											{
									echo "<option value='$show_financial[financial_year]'>$show_financial[financial_year]</option>";
									}
								} ?>
                            </select>
                        </div>
                        </div>
                        </div>

						<div class="col-12 mb-2" >
                        <div class="row">
                        <div class="col-3 d-flex align-items-center"><label> Region</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                            <select name="region[]" id="region" class="form-control search_bar" placeholder="Search Region" multiple="multiple">
								<option value="all">All Regions</option>
                                <?php 
								$region_query = "SELECT distinct(regions),region_code FROM statistics_integration_country_master where status ='1' order by regions ASC";
								$execute_region = $conn ->query($region_query);
								while($show_region = $execute_region->fetch_assoc())
								{
									if($_SESSION['region']==$show_region['region_code'])
									{
										echo "<option value='$show_region[region_code]' selected='selected'>$show_region[regions]</option>";
									} else
									{
										echo "<option value='$show_region[region_code]'>$show_region[regions]</option>";
									}
								} ?>                              
							</select>
						</div>						
                        </div>
						</div>
                       
                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center"><label>Value</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 d-flex justify-content-between">
                        <label class="d-inline-block mr-3 radio-box" for="rupee">
						<input type="radio" name="currency" id="rupee" value="INR" <?php if($_SESSION['currency']=="INR"){ echo "checked"; }?> checked> <i class="fa fa-rupee"></i>&nbsp; Rupees</label>
                        <label class="d-inline-block radio-box" for="usd"><input type="radio" name="currency" id="usd" value="USD" <?php if($_SESSION['currency']=="USD"){ echo "checked"; }?>> US $ Million</label>
                        </div>
                        </div>
                        </div>
						
                        <div class="col-12 mb-4">
                        <div class="row">
                        <div class="col-3  d-flex align-items-center"><label>Display Records</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 ">
							<select name="display_records" class="form-control">
                            <option value="">Select display Limit</option> 
                            <option value="all" selected> All Records</option>
                            <option value="10" <?php if($_SESSION['display_records']=="10"){ echo "selected='selected'"; }?>>Top 10</option>
                            <option value="20" <?php if($_SESSION['display_records']=="20"){ echo "selected='selected'"; }?>>Top 20</option>
                            <option value="30" <?php if($_SESSION['display_records']=="30"){ echo "selected='selected'"; }?>>Top 30</option>
                            </select>
                        </div>
                        </div>                       
						</div>
						
						<div class="col-12 ">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                 <input type="submit" name="submit" id="submit" value="Submit" class="gold_btn fade_anim d-block w-100 mr-3">
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
                        <div class="row py-3"  style="border-top: 1px solid #ccc">
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Region-wise all countries Result</h2></div>
                            
                            <div class="col-12">
                                <div class="d-flex justify-content-end"> 
                                <p><strong>Date</strong>: <?php echo date("d/m/Y");?></p>   
                                </div>
								
								<div class="row justify-content-center mt-4">
                                   		<div class="col-md-9 searchResultwrap">
                                        	<ul>
                                            	<li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Year</div>
                                                        <div class="col-md-8 sResult"><?php echo $_POST['financial_year'];?></div>
                                                    </div>
                                                </li>												
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Region</div>
                                                        <div class="col-md-8 sResult">
															<?php //echo getCountryRegion($_POST['region'],$conn);?>
															<?php 
																if(isset($region) && $region!='')
																{
																	$regionCount = sizeof($region);
																	if($regionCount>0)
																	{ 
																		if($_POST['region']!=''){
																			if(in_array("all",$_POST['region']))
																			{
																				echo "All Regions";										
																			} else {
																			foreach(array_unique($_POST['region']) as $value ) {
																			//echo "Value is $value <br />";
																			echo getCountryRegion($value,$conn)."<br/>";
																			}
																			}
																		}
																	}
																}
															?>
                                                        </div>
                                                    </div>
                                                </li>												
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Value</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_SESSION['currency']=="INR"){ echo "Rupees"; } ?>
														<?php if($_SESSION['currency']=="USD"){ echo "US $ Million"; } ?>
														</div>
                                                    </div>
                                                </li>
                                            </ul>                                            
                                        </div>                                    
                                </div>
								   
                                <div class="d-flex justify-content-start"> 
								   <button onclick="exportToExcel('tblexportData', 'region-wise-all-countries-import')" class="btn btn-success">Export</button>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Country</th>
                                            <th><?php echo $last_finyr;?></th>
                                            <th><?php echo $_REQUEST['financial_year'];?></th>
                                            <th>%Growth (YOY)</th>
                                            <th>%Share</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
									while($row = $resultx->fetch_assoc())
									{
										//echo $grandTotalINR.'--'.$grandTotalUSD;
										if($currency!="")
										{
											if($currency=="INR")
											{
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa);
											$newTotal_Paisa  = $row['total_inr'];
											$currencySign = "";
																						
											$getPreviousFinancialYearData = getPreviousFinancialYearCRegionImportINR($last_finyr,$row['country_id'],$conn);
											$lastYearTotal_Paisa   = str_replace(',','',$getPreviousFinancialYearData);
											$sub_lastYear_Paisa = round($sub_lastYear_Paisa + $lastYearTotal_Paisa);
											
											$growth = round((($newTotal_Paisa - $getPreviousFinancialYearData)/$getPreviousFinancialYearData)*100);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											
											$getShare = round(($newTotal_Paisa / $grandTotalINR)*100);											
											
											} else {
												
											$myTotal_Paisa   = str_replace(',','',$row['total_usd']);
										//	$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa);
										//	$newTotal_Paisa  = $row['total_usd'];
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/1000000);
											$newTotal_Paisa  = round($row['total_usd']/1000000);
											
											$currencySign = "";
											$getPreviousFinancialYearData = round(getPreviousFinancialYearCRegionImportUSD($last_finyr,$row['country_id'],$conn)/1000000);
											$lastYearTotal_Paisa   = str_replace(',','',$getPreviousFinancialYearData);
											$sub_lastYear_Paisa = round($sub_lastYear_Paisa + $lastYearTotal_Paisa);
											
											$growth = round((($newTotal_Paisa - $getPreviousFinancialYearData)/$getPreviousFinancialYearData)*100);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											
											$getShare = round(($newTotal_Paisa / $grandTotalUSD)*100);
											
											}
										} else { 
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa);
											$newTotal_Paisa  = $row['total_inr'];

											$currencySign = "";
											$getPreviousFinancialYearData = getPreviousFinancialYearCRegionImportINR($last_finyr,$row['country_id'],$conn);
											$lastYearTotal_Paisa   = str_replace(',','',$getPreviousFinancialYearData);
											$sub_lastYear_Paisa = round($sub_lastYear_Paisa + $lastYearTotal_Paisa); 
											
											$growth = round((($newTotal_Paisa - $getPreviousFinancialYearData)/$getPreviousFinancialYearData)*100);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											
											$getShare = round(($newTotal_Paisa / $grandTotalINR)*100);
										}																	
										
										?>			
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row['country_id'];?></td>
                                            <td><?php echo moneyFormatIndia($getPreviousFinancialYearData);?> </td>
                                            <td><?php echo moneyFormatIndia($newTotal_Paisa);?></td>
                                            <td><?php echo $growthPer;?></td>
                                            <td><?php echo $getShare;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>
						<tr>						
						<td>&nbsp;</td>										
						<td>Total</td>						
						<td><?php echo moneyFormatIndia($sub_lastYear_Paisa); ?></td>
						<td><?php echo moneyFormatIndia($sub_total_Paisa); ?></td>						
						<td>&nbsp;</td>						
						<td>&nbsp;</td>																		
					    </tr>
						</tbody>
                        </table>
						<?php } ?>						
                        </div>
                        </div>
					<?php } if(isset($rCount) && $rCount==0){ ?> No Data Found <?php } ?>	
            </div>   
			</div>
		</div>           
</section>  
 
<?php include 'include-new/footer.php'; ?>

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
	$("#regisForm").on("submit",function(e){
		//$(".otp-messages").html("<div>").show();
	$("#preloader").fadeIn();
	$("#status").fadeIn();
	})
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[type="radio"]').on("change",function(){
             $('input[type="radio"]:not(:checked)').parent('label').removeClass("radio-box-active");
             $('input[type="radio"]:checked').parent('label').addClass("radio-box-active");
        });
    });

      $('#region').fastselect();
</script>
<script type="text/javascript">
function exportToExcel(tableID, filename = ''){
    var downloadurl;
    var dataFileType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTMLData = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'export_excel_data.xls';
    
    // Create download link element
    downloadurl = document.createElement("a");
    
    document.body.appendChild(downloadurl);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTMLData], {
            type: dataFileType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadurl.href = 'data:' + dataFileType + ', ' + tableHTMLData;
    
        // Setting the file name
        downloadurl.download = filename;
        
        //triggering the function
        downloadurl.click();
    }
}
</script>