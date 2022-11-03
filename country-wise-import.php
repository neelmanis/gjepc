<?php 
$pageTitle = "Gems And Jewellery Industry In India | Country Wise Import - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php';

		if($_REQUEST['Reset']=="Reset")
		{
		  $_SESSION['financial_year']  =""; 
		  $_SESSION['country']	   	   =""; 	  
		  $_SESSION['currency']        =""; 
		  $_SESSION['allcountry']      =""; 
		  $_SESSION['currency_inr']    =""; 		  	  
		  $_SESSION['currency_usd']    =""; 
		  $_SESSION['display_records'] =""; 		  
		  
		  header("Location: country-wise-import.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$financial_year  = $_REQUEST['financial_year'];
		$country 	 	 = $_REQUEST['country'];
		$allcountry		 = $_POST['allcountry'];
		$trade_type 	 = "Import";
		$currency  		 = $_POST['currency'];
		$currency_inr	 = $_POST['currency_inr'];		
		$currency_usd	 = $_POST['currency_usd'];
		$display_records  = filter($_REQUEST['display_records']);			
		
		$_SESSION['financial_year'] = $financial_year;
		$_SESSION['country'] 		= $country;
		$_SESSION['allcountry'] 	= $allcountry;
		$_SESSION['currency'] 		= $currency;
		$_SESSION['currency_inr']  = $currency_inr;
		$_SESSION['currency_usd']  = $currency_usd;
		$_SESSION['display_records'] = $display_records;
				
		$flag=1;
		if($financial_year=="" || $financial_year=="0")
		{  $signup_error = "Please Select Year."; $flag=0;  }
		else if($country=="" && $allcountry=="")
		{  $signup_error = "Please Select Country."; $flag=0;  }
		else if($allcountry=="lists" && $country=="")
		{  $signup_error = "Please Select Any Country."; $flag=0; }
		else if($currency=="")
		{  $signup_error = "Please Select Currency."; $flag=0; }
		else if($currency=="INR" && $currency_inr=="")
		{  $signup_error = "Please Select Currency Value."; $flag=0; }
		else if($currency=="USD" && $currency_usd=="")
		{  $signup_error = "Please Select Currency Value."; $flag=0; }
		else {
		$flag=1;
		
		}
		}
		}
?>

<section>       
 
<div class="container inner_container">
    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font">Imports Data Bank</h1>
        </div>
    </div>
    <div class="row justify-content-center">
         
            <div class="row"> 
			
			<form class="cmxform form-export-import col-12 box-shadow mb-4" method="POST" name="regisForm" id="regisForm" autocomplete="off">
			<input type="hidden" name="search_type" id="search_type" value="SEARCH"/>
				<div class="col-12">
				<a href="https://gjepc.org/statistics.php#pane-B" class="cta" onclick="goBack()"><i class="fa fa-back"></i>&nbsp;Back</a>
				</div>
			
                <div class="form-group col-12 mb-4">
                    <p class="blue text-center">IMPORTS - COUNTRY-WISE</p>
                </div>   
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>
                <div class="col-md-1">
                    <div class="form_side_pattern"> </div>
                </div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3  d-flex align-items-center">
                        <label>Year</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
                            <select name="financial_year" class="form-control">
                                <option value=""> Select Year</option>                                
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

                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label>Country</label>
                        </div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        
						<div class="col-4">
						<label class="d-inline-block mr-3 radio-box">
						<input type="radio" name="allcountry" id="listscountry" value="lists" <?php if($_SESSION['allcountry']=="lists"){ echo "checked"; }?> > Selected Country</label>	
                        </div>
						
						<div class="col-4">
						<label class="d-inline-block mr-3 radio-box">
						<input type="radio" name="allcountry" id="allcountry" value="all" <?php if($_SESSION['allcountry']=="all"){ echo "checked"; }?> > All Country</label>	
                        </div>
						</div>
                        </div>
                        
						<div class="col-12 mb-2" id="list-country" 
						<?php if(isset($_SESSION['allcountry']) && $_SESSION['allcountry']=="lists"){?> <?php } else { ?> style="display: none" <?php } ?>>
						<div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label> Selected Country</label>
                        </div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                        <select name="country[]" class="form-control" id="country" multiple="multiple">
                        <?php 
						$country_query = "select * from statistics_integration_country_master where status ='1' order by country_name ASC";
						$execute_country = $conn ->query($country_query);
						while($show_country = $execute_country->fetch_assoc()){
						?>
						<option value="<?php echo $show_country["country_name"];?>"><?php echo strtoupper($show_country["country_name"]);?></option>
						<?php } ?>  
                        </select>
                        </div>
                        </div>
                        </div> 
                       
                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label>Value</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8 d-flex justify-content-between">
                        <label class="d-inline-block mr-3 radio-box" for="rupee">
						<input type="radio" name="currency" id="rupee" value="INR" <?php if($_SESSION['currency']=="INR"){ echo "checked"; }?>> <i class="fa fa-rupee"></i>&nbsp; INR</label>
                        <label class="d-inline-block radio-box" for="usd"><input type="radio" name="currency" id="usd" value="USD" <?php if($_SESSION['currency']=="USD"){ echo "checked"; }?>> US $ </label>
                        </div>
                        </div>
                        </div>
						
						<div class="col-12 mb-4" id="specific-inr" 
						<?php if(isset($_SESSION['currency']) && $_SESSION['currency']=="INR"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3  d-flex align-items-center"><label>Currency INR</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 ">
							<select name="currency_inr" class="form-control">
							<option value=""> Select Currency</option>
                            <option value="100000" <?php if($_SESSION['currency_inr']=="100000"){ echo "selected='selected'"; }?>>Lakhs</option>
                            <option value="10000000" <?php if($_SESSION['currency_inr']=="10000000"){ echo "selected='selected'"; }?>>Crores</option>
                            </select>
                        </div>
                        </div>                       
						</div>
						
						<div class="col-12 mb-4" id="specific-usd" <?php if(isset($_SESSION['currency']) && $_SESSION['currency']=="USD"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3  d-flex align-items-center"><label>Currency USD</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 ">
						<select name="currency_usd" class="form-control">
						<option value=""> Select Currency</option>
                        <option value="1000" <?php if($_SESSION['currency_usd']=="1000"){ echo "selected='selected'"; }?>>Thousand</option>
                        <option value="1000000" <?php if($_SESSION['currency_usd']=="1000000"){ echo "selected='selected'"; }?>>Million</option>
                        <option value="1000000000" <?php if($_SESSION['currency_usd']=="1000000000"){ echo "selected='selected'"; }?>>Billion</option>
                        </select>
                        </div>
                        </div>                       
						</div>
						
                        <!--<div class="col-12 mb-4">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label>Display Records</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8 ">
							<select name="display_records" class="form-control">
                            <option value="">Select display Limit</option> 
                            <option value="all" selected> All Records</option>
                            <option value="10" <?php if($_SESSION['display_records']=="10"){ echo "selected='selected'";}?>>Top 10</option>
                            <option value="20" <?php if($_SESSION['display_records']=="20"){ echo "selected='selected'";}?>>Top 20</option>
                            <option value="50" <?php if($_SESSION['display_records']=="50"){ echo "selected='selected'";}?>>Top 50</option>
                            </select>
                        </div>
                        </div>                       
						</div>-->
						
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
			
			<?php if(!empty($flag==1)) { ?>
			<?php
			//echo "Searched Financial year : ".$financial_year;
			$cur_year = substr($financial_year, 0,-5);
			//echo '<br/>'; 
			//current challan yr calculation
			//echo '--'.$cur_year = (int)date('Y');
			$curyear  = (int)date('Y');
			$cur_month = (int)date('m');
			if($cur_month < 4) { /*Comment for Year Change when last year become blank then uncomment*/
			/*	if($cur_month > 4) { */
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
			
			$currentMonth = getCurrentMonth($conn);
			
			//echo '<br/>Last Financial year :'.$last_finyr; 
			//echo '<br/>Current Financial year :'.$cur_finyr; 
			
		$sql="SELECT `financial_year`, `country_id`, `hs_code_id`, `inr_value`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$financial_year'";

		if(isset($allcountry) && $allcountry!='' && $allcountry=="all")
		{
			$sqlx = "SELECT distinct(country_id) from statistics_integration_data";
			$result = $conn ->query($sqlx);
			$num = $result->num_rows;
			if($num>0){
			$myArray=array();
			while($row = $result->fetch_assoc()){
			$myArray[] = $row['country_id'];
			}
			//print_r($myArray);
			$sqln= implode(",",array_unique($myArray));
			$result_string = "'" . str_replace(",", "','", $sqln) . "'";
			$sql.=" AND country_id IN(".$result_string.") ";
			}
		}
		
		if(isset($country) && $country!='' && $allcountry=="lists")
		{
			$countryCount = sizeof($country);
			if($countryCount>0)
			{ 
				if($_POST['country']!=''){
					$sqlm= implode(",",array_unique($_POST['country']));
					$result_string = "'" . str_replace(",", "','", $sqlm) . "'";
					$sql.=" and country_id IN(".$result_string.") ";
				}
			}
		}
		
		if($currency=="INR"){ $orderBy = "total_inr"; } elseif($currency=="USD") {  $orderBy = "total_usd"; } else {	$orderBy = "total_inr";	}

		$sql.=" AND trade_type='$trade_type' AND status='1' group by country_id order by ".$orderBy." desc";

		$sql2 = $sql;
		//echo '<br>';
		$replacedQuery = str_replace("group by country_id", "", $sql2);
		//echo $replacedQuery; 
		$replacedResult = $conn->query($replacedQuery);
		$replacedRow = $replacedResult->fetch_assoc();		
		$grandTotalINR = $replacedRow['total_inr']/$_POST['currency_inr'];
		$grandTotalUSD = $replacedRow['total_usd']/$_POST['currency_usd'];
		
		if(getFinancialYear($conn)!=$financial_year){
			$replacedQuery2 = str_replace($financial_year, $last_finyr, $replacedQuery);
		} else { 
		//echo $replacedQuery; echo '<br/>';
		/*	Sept Code 29/09/2021 
		$getLastFinYear = getLastFinancialYear($financial_year);
		$getfinancial_year ="financial_year='$financial_year'";
		$arr_string = explode("-",$getLastFinYear); 
		$startYear = $arr_string[0];
		$finreplace ="post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30'";		
		$replacedQuery2 = str_replace($getfinancial_year, $finreplace, $replacedQuery);
		*/
		/*25/10/2021 FOR FY	*/ $replacedQuery2 = str_replace($financial_year, $last_finyr, $replacedQuery); 
		}
		
		$replacedResult1 = $conn->query($replacedQuery2);
		$replacedRow1 = $replacedResult1->fetch_assoc();		
		$grandTotalLastINR = $replacedRow1['total_inr']/$_POST['currency_inr'];
		$grandTotalLastUSD = $replacedRow1['total_usd']/$_POST['currency_usd'];
		
		$resultx = $conn ->query($sql2);  
		$rCount = $resultx->num_rows;
		if($rCount>0)
		{
		?>
		
            <div class="col-12">
                        <div class="row py-3"  style="border-top: 1px solid #ccc">
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Imports - Country-wise </h2></div>
                            
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
                                                        <div class="col-md-8 sResult"><?php echo $_POST['financial_year'];
														if(getFinancialYear($conn)==$_POST['financial_year']){ 
														echo " APR-".getCurrentMonthName($conn); }?></div>
                                                    </div>
                                                </li>	
												<li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Country</div>
                                                        <div class="col-md-8 sResult">
															<?php 
																if(isset($country) && $country!='' && $allcountry=="lists")
																{
																	$countryCount = sizeof($country);
																	if($countryCount>0)
																	{ 
																		if($_POST['country']!=''){
																			if(in_array("all",$_POST['country']))
																			{
																				echo "All Countries";										
																			} else {
																			foreach(array_unique($_POST['country']) as $value ) {
																			//echo "Value is $value <br />";
																			echo $value."<br/>";
																			}
																			}
																		}
																	}
																}
																if(isset($allcountry) && $allcountry!='' && $allcountry=='all')
																{
																	echo "All Countries";	
																}
															?>
                                                        </div>
                                                    </div>
                                                </li>
												
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Value</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?>
														<?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>
														</div>
                                                    </div>
                                                </li>
                                            </ul>                                            
                                        </div>                                    
                                </div>
								   
                                <div class="d-flex justify-content-start"> 
								   <button onclick="exportToExcel('tblexportData', 'country-wise-import')" class="cta" title="Export To Excel"><i class="fa fa-file-excel-o" style="font-size: 40px;"></i></button>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Country</th>
                                            <th><?php echo $last_finyr;?> (<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>)</th>
                                            <th><?php echo $_REQUEST['financial_year'];?> (<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>)</th>
                                            <th>%Growth (YOY)</th>
                                            <th>%Share </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
				/* Same */		if(getFinancialYear($conn)==$financial_year){ $sameYear = "YES"; } else { $sameYear = "NO"; }
									while($row = $resultx->fetch_assoc())
									{					
										//echo $grandTotalINR.'--'.$grandTotalUSD;
										if($currency!="")
										{
											if($currency=="INR")
											{
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);										
											$newTotal_Paisa  = round($row['total_inr']/$_POST['currency_inr'],2);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/$_POST['currency_inr'],2);
																					
											$getPreviousYearData = getcountrywiseINR_i($last_finyr,$row['country_id'],$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_inr'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_inr'],2);					
											
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											$getShare = round(($newTotal_Paisa / $grandTotalINR)*100,2);							
											
											} else {
												
											$myTotal_Paisa   = str_replace(',','',$row['total_usd']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/$_POST['currency_usd'],2);
										//	$newTotal_Paisa  = round($row['total_usd']/$_POST['currency_usd'],2);
											$numbers = $row['total_usd']/$_POST['currency_usd'];			
											$newTotal_PaisaNOround  = number_format($numbers, 12, '.', '');
											$zeroLevels = strspn($newTotal_PaisaNOround, "0", strpos($newTotal_PaisaNOround, ".")+1);
											if($zeroLevels>=3 || $zeroLevels>=2){ 
											$newTotal_Paisa = round($newTotal_PaisaNOround,4); 
											} else { 
											$newTotal_Paisa  = round($newTotal_PaisaNOround,2);  
											}
											
											$getPreviousYearData = getcountrywiseUSD_i($last_finyr,$row['country_id'],$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_usd'],2);
										//	$getPreviousData	 = round($getPreviousYearData/$_POST['currency_usd'],2);
											$number  = $getPreviousYearData/$_POST['currency_usd'];
											$getPreviousDataNOround  = number_format($number, 12, '.', '');
											$zeroLevel = strspn($getPreviousDataNOround, "0", strpos($getPreviousDataNOround, ".")+1);
											if($zeroLevel>=3 || $zeroLevel>=2){ 
											$getPreviousData = round($getPreviousDataNOround,4); 
											} else { 
											$getPreviousData = round($getPreviousDataNOround,2);
											}
																						
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);										
											$getShare = round(($newTotal_Paisa / $grandTotalUSD)*100,2);
											
											}
										}
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
                                            <td class="text-left"><?php echo $row['country_id'];?></td>
                                            <td class="text-center"><?php echo $getPreviousData;?> </td>
                                            <td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                            <td class="text-center"><?php echo $getShare;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>
						<?php if($rCount>1){ ?>
						<?php 
							//Total Diff
							if($currency=="USD"){ $diff=round($grandTotalLastUSD-$sub_lastYear_Paisa,2); } 
										else { $diff=round($grandTotalLastINR-$sub_lastYear_Paisa,2); }?> 
						<?php if($diff>0){?>
						<tr>
                                <td class="text-left"><?php echo $i;?></td>
                                <td class="text-left">Others</td>
                                <td class="text-center">
								<?php if($currency=="USD"){ echo $otherTotalLast=round($grandTotalLastUSD-$sub_lastYear_Paisa,2); } 
									else { echo $otherTotalLast=round($grandTotalLastINR-$sub_lastYear_Paisa,2); }?> 
								</td>								
                                <td class="text-center">
								<?php if($currency=="USD"){ echo $otherTotalNew =0; }
									else { echo $otherTotalNew =0; }?>
								</td>
                                <td class="text-center"><?php echo round((($otherTotalNew - $otherTotalLast)/$otherTotalLast)*100,2); ?></td>
                               <td class="text-center"><?php echo round(($otherTotalNew / $grandTotalUSD)*100,2);?></td>
                        </tr>
						<?php } ?>
						<tr>						
						<td>&nbsp;</td>			
						<td class="text-center">Total</td>
						<td class="text-center"><?php if($currency=="INR"){ echo $last_yr=round($grandTotalLastINR,2); } else { echo $last_yr=round($grandTotalLastUSD,2); }?></td>
						<td class="text-center"><?php if($currency=="USD"){ echo $curr_yr=round($grandTotalUSD,2); } else { echo $curr_yr=round($grandTotalINR,2); }?></td>
						<td class="text-center"><?php echo $totalgrowth = round((($curr_yr - $last_yr)/$last_yr)*100,2); ?></td>	
						<td class="text-center"><?php echo $totalshares = round(($sub_total_Paisa / $sub_total_Paisa)*100,2);?></td>
					    </tr>
						<?php } ?>
						</tbody>
                        </table>
                        </div>
											
                        </div>
            </div> 
			<?php } else {  echo 'Not Found'; } ?>
			<?php } ?>
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
     /*$("#tableResult").hide();
    $('input[type="submit"]').click(function(e){
        e.preventDefault();
    $("#tableResult").show();
     */
    $('#country').fastselect();
    $('#select_all').click(function() {
    //    alert();
    $('#country option').prop('selected', true);
	});
	
	$('input[name="allcountry"]').on("change",function(){
				var allcountry = $(this).val();
				if(allcountry =="lists"){
				$("#list-country").slideDown();
				}else if(allcountry="all"){
				$("#list-country").slideUp();
				}
	});
$('input[name="currency"]').on("change",function(){
				var currency = $(this).val();
				if(currency =="INR"){
				$("#specific-inr").slideDown();
				$("#specific-usd").slideUp();

				}else if(currency="USD"){
				$("#specific-usd").slideDown();
				$("#specific-inr").slideUp();
				}
	});
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