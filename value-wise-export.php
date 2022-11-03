<?php 
$pageTitle = "Gems And Jewellery Industry In India | Value-wise Export - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
?>
<?php
		include 'db.inc.php'; 
		include 'functions.php';		
		
		if($_REQUEST['Reset']=="Reset")
		{
		  $_SESSION['valueType']  =""; 
		  $_SESSION['financialYearType']  =""; 
		  $_SESSION['year_fin_year']  	   =""; 
		  $_SESSION['year_calendar_year']  =""; 
		  $_SESSION['monthType']  		=""; 
		  $_SESSION['month_fin_year']  =""; 
		  $_SESSION['calendar_year']   =""; 
		  $_SESSION['currency']        =""; 		  	  
		  $_SESSION['currency_inr']    =""; 		  	  
		  $_SESSION['currency_usd']    =""; 		  	  
		  
		  header("Location: value-wise-export.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$valueType  = $_REQUEST['valueType'];
		$financialYearType  = $_REQUEST['financialYearType'];
		$year_fin_year  = $_REQUEST['year_fin_year'];
		$year_calendar_year  = $_REQUEST['year_calendar_year'];
		
		$monthType   = $_REQUEST['monthType'];
		$month_fin_year   = $_REQUEST['month_fin_year'];		
		$arr_string = explode("-",$month_fin_year); 
		$calendar_year   = $_REQUEST['calendar_year'];
	//	echo '<pre>'; print_r($arr_string); 
		$startYear = $arr_string[0];
		$endYear = $arr_string[1];
		$trade_type 	 = "Export";
		$currency  		 = $_POST['currency'];		
		$currency_inr	 = $_POST['currency_inr'];		
		$currency_usd	 = $_POST['currency_usd'];		
		
		$_SESSION['valueType'] = $valueType;
		$_SESSION['financialYearType'] = $financialYearType;
		$_SESSION['year_fin_year'] = $year_fin_year;
		$_SESSION['year_calendar_year'] = $year_calendar_year;		
		
		$_SESSION['monthType'] = $monthType;
		$_SESSION['month_fin_year'] = $month_fin_year;
		$_SESSION['calendar_year'] = $calendar_year;
		$_SESSION['currency'] 	   = $currency;
		$_SESSION['currency_inr']  = $currency_inr;
		$_SESSION['currency_usd']  = $currency_usd;
		
		//echo "Searched Financial year : ".$financial_year;
		$cur_year = substr($month_fin_year, 0,-5);
		//echo '<br/>'; 
		//current challan yr calculation
		//$cur_year = (int)date('Y');
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
		//echo '<br/>Last Financial year :'.$last_finyr; exit;
		//echo '<br/>Current Financial year :'.$cur_finyr; 
		$cur_calenderyr = substr($cur_finyr, 0,-5);
		$currentMonth = getCurrentMonth($conn);
		
		if($valueType=="")
		{  $signup_error = "Please Select Type."; }
		else if($valueType=="yearType" && $financialYearType=="")
		{  $signup_error = "Please Select any one Financial Year wise or Calendar Year wise"; }
	    else if($valueType=="dateType" && $monthType=="")
		{  $signup_error = "Please Select any one Financial Year wise or Calendar Year wise"; }
		else if($currency=="")
		{  $signup_error = "Please Select Currency."; }
	    else if($currency=="INR" && $currency_inr=="")
		{  $signup_error = "Please Select Currency Value."; }
		else if($currency=="USD" && $currency_usd=="")
		{  $signup_error = "Please Select Currency Value."; }
		else {

		if($currency=="INR"){ $orderBy = "inr_value"; } elseif($currency=="USD") {  $orderBy = "dollar_value"; } else {	$orderBy = "inr_value";	}
		/* Year-wise */
		if(isset($valueType) && $valueType=="yearType")
		{
			$_REQUEST['monthType'] 	   ="";
			$_REQUEST['month_fin_year'] ="";
			if($financialYearType=="financialYearTypeSelected" && isset($year_fin_year))
			{
			$sql="SELECT `year`, `financial_year`, `post_date`, `inr_value`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$year_fin_year' AND trade_type='$trade_type' order by ".$orderBy."";
			}
			if($financialYearType=="monthYearTypeSelected" && isset($year_calendar_year))
			{
			$sql=" SELECT `year`, `financial_year`, `post_date`, `inr_value`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-12-31' AND trade_type='$trade_type'";
			}
		}
		
		if(isset($valueType) && $valueType=="dateType")
		{	
			$_SESSION['year_fin_year']  	   =""; 
			$_REQUEST['financialYearType'] 	   =""; 
			
			if($monthType=="monthFinancialYearType" && isset($month_fin_year))
			{  // date format : 2019-06-03
			$sql="SELECT `year`, `financial_year`, `post_date`, `inr_value`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd, DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '$endYear-03-31' AND trade_type='$trade_type' group by entry_month order by entry_month ASC";
			}
			if($monthType=="monthPeriodYearType" && isset($calendar_year))
			{
			$sql="SELECT `year`, `financial_year`, `post_date`, `inr_value`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd, DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$calendar_year-01-01' AND '$calendar_year-12-31' AND trade_type='$trade_type' group by entry_month order by entry_month asc";
			$lastCompairYear = getLastMonths($calendar_year,$conn);			
			$sql2=$conn ->query("SELECT `year`, `financial_year`, `post_date`, `inr_value`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd, DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM gjepclivedatabase.`statistics_integration_data` WHERE 1 AND post_date BETWEEN '$lastCompairYear-01-01' AND '$lastCompairYear-12-31' AND trade_type='Export' group by entry_month order by entry_month asc");
			$lastYearMonthData = array();
			while($getRows = $sql2->fetch_assoc())
			{
				$lastYearMonthData[] = $getRows;
			}
			}
		}
		
		$sql2 = $sql;		
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
            <h1 class="bold_font">Exports Data Bank</h1>
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
                    <p class="blue text-center">EXPORTS - VALUE-WISE</p>
                </div>   
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>
                <div class="col-md-1">
                    <div class="form_side_pattern"> </div>
                </div>
                <div class="col-md-11">
                    <div class="row">
                        
                        <div class="col-12 mb-2">
                         <div class="row">
                             <div class="col-3 d-flex align-items-center">
                            <label>Date</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8 d-flex justify-content-between">
                          <label class="d-inline-block mr-3 radio-box" for="yearType">
						  <input type="radio" name="valueType" id="yearType" value="yearType" <?php if($_SESSION['valueType']=="yearType"){ echo "checked"; }?>> Year</label>                          
                          <label class="d-inline-block radio-box" for="dateType">
						  <input type="radio" name="valueType" id="dateType" value="dateType" <?php if($_SESSION['valueType']=="dateType"){ echo "checked"; }?>> Months</label>
                        </div>
						</div>
                        </div>
                        
                        <div class="col-12 mb-2" id="specific-year" <?php if(isset($_REQUEST['valueType']) && $_REQUEST['valueType']=="yearType"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3 d-flex align-items-center"><label></label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
						<div class="row">
                          	<div class="form-group col-sm-6">
                                <label class="form-label" for="fYearwise">Financial Year wise</label>
                                <input type="radio" name="financialYearType" value="financialYearTypeSelected" <?php if($_REQUEST['financialYearType']=="financialYearTypeSelected"){ echo "checked"; }?>/>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="pYearwise">Calendar Year wise</label>
                                <input type="radio" name="financialYearType" value="monthYearTypeSelected" <?php if($_REQUEST['financialYearType']=="monthYearTypeSelected"){ echo "checked"; }?>/>
                            </div>	
                        </div>						  
                        </div>
						
                        </div>
						</div>
						
						<div class="col-12 mb-2" id="financial-year-wise" <?php if($_REQUEST['financialYearType']=="financialYearTypeSelected"){ ?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
						<div class="col-3 d-flex align-items-center">
                        <label> </label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span></span>
                        </div>
                        <div class="col-8">
						<div class="row">
                          	<div class="form-group col-sm-6">
                                <label class="form-label" for="Yearwise">Select Financial Years</label>
								<select name="year_fin_year" class="form-control">
                                        <option value="">Select Financial Years</option> 
										<?php 
										$financial_query = "SELECT distinct(financial_year) FROM `statistics_integration_data` WHERE 1 order by financial_year desc";
										$execute_financial = $conn ->query($financial_query);
										while($show_financial = $execute_financial->fetch_assoc())
										{
											if($_SESSION['year_fin_year']==$show_financial['financial_year'])
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
                        </div>
                        </div>
						
						<div class="col-12 mb-2" id="financial-month-wise" <?php if($_REQUEST['financialYearType']=="monthYearTypeSelected"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
						<div class="col-3 d-flex align-items-center">
                        <label> </label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
						<div class="row">
                          	<div class="form-group col-sm-6">
                                <label class="form-label" for="Yearwise">Select Calendar Years</label>
								<select name="year_calendar_year" class="form-control">
                                        <option value="">Select Calendar Years</option>
                                        <?php 
										$financial_query = "SELECT distinct(year) FROM `statistics_integration_data` WHERE 1 order by year desc";
										$execute_financial = $conn ->query($financial_query);
										while($show_year = $execute_financial->fetch_assoc())
										{
											if($_SESSION['year_calendar_year']==$show_year['year'])
											{
												echo "<option value='$show_year[year]' selected='selected'>$show_year[year]</option>";
											} else
											{
												echo "<option value='$show_year[year]'>$show_year[year]</option>";
											}
										} ?>
                                </select> 
                            </div>
                        </div>						  
                        </div>
                        </div>
                        </div>
						
						<!------------------ End Year wise ------------------------------>
                        
                        <div class="col-12 mb-2" id="specific-date" <?php if(isset($_REQUEST['valueType']) && $_REQUEST['valueType']=="dateType"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                        <label> </label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span></span>
                        </div>
                        <div class="col-8">
						<div class="row" id="commodity_level" >
                          	<div class="form-group col-sm-6">
                                <label class="form-label" for="fYearwise">Financial Year wise</label>
                                <input type="radio" name="monthType" value="monthFinancialYearType" <?php if($_SESSION['monthType']=="monthFinancialYearType"){ echo "checked"; }?>/>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label" for="pYearwise">Calendar Year wise</label>
                                <input type="radio" name="monthType" value="monthPeriodYearType" <?php if($_SESSION['monthType']=="monthPeriodYearType"){ echo "checked"; }?>/>
                            </div>	
                        </div>						  
                        </div>
                        </div>
                        </div>
						
						<div class="col-12 mb-2" id="specific-year-wise" <?php if(isset($_REQUEST['monthType']) && $_REQUEST['monthType']=="monthFinancialYearType"){?> <?php } else { ?> style="display: none" <?php } ?> >
                        <div class="row">
						<div class="col-3 d-flex align-items-center">
                        <label> </label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
						<div class="row">
                          	<div class="form-group col-sm-6">
                                <label class="form-label" for="Yearwise">Select Financial Years</label>
								<select name="month_fin_year" class="form-control">
                                        <option value="">Select Financial Years</option> 
										<?php 
										$financial_query = "SELECT distinct(financial_year) FROM `statistics_integration_data` WHERE 1 order by financial_year desc";
										$execute_financial = $conn ->query($financial_query);
										while($show_financial = $execute_financial->fetch_assoc())
										{
											if($_SESSION['month_fin_year']==$show_financial['financial_year'])
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
                        </div>
                        </div>
						
						<div class="col-12 mb-2" id="specific-month-wise" <?php if(isset($_REQUEST['monthType']) && $_REQUEST['monthType']=="monthPeriodYearType"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
						<div class="col-3 d-flex align-items-center">
                        <label> </label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
						<div class="row">
                          	<div class="form-group col-sm-6">
                                <label class="form-label" for="Yearwise">Select Calendar Years</label>
								<select name="calendar_year" class="form-control">
                                        <option value="">Select Calendar Years</option>
                                        <?php 
										$financial_query = "SELECT distinct(year) FROM `statistics_integration_data` WHERE 1 order by year desc";
										$execute_financial = $conn ->query($financial_query);
										while($show_year = $execute_financial->fetch_assoc())
										{
											if($_SESSION['calendar_year']==$show_year['year'])
											{
												echo "<option value='$show_year[year]' selected='selected'>$show_year[year]</option>";
											} else
											{
												echo "<option value='$show_year[year]'>$show_year[year]</option>";
											}
										} ?>
                                </select> 
                            </div>
                        </div>						  
                        </div>
                        </div>
                        </div>
                                     
						<div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center"><label>Value</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 d-flex justify-content-between">
                        <label class="d-inline-block mr-3 radio-box" for="rupee">
						<input type="radio" name="currency" id="rupee" value="INR" <?php if($_SESSION['currency']=="INR"){ echo "checked"; }?> > <i class="fa fa-rupee"></i>&nbsp; INR</label>
                        <label class="d-inline-block radio-box" for="usd"><input type="radio" name="currency" id="usd" value="USD" <?php if($_SESSION['currency']=="USD"){ echo "checked"; }?>> US $ </label>
                        </div>
                        </div>
                        </div>
						
						<div class="col-12 mb-4" id="specific-inr" <?php if(isset($_SESSION['currency']) && $_SESSION['currency']=="INR"){?> <?php } else { ?> style="display: none" <?php } ?>>
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
						
                    <div class="col-12 ">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                 <input type="submit" name="submit" id='submit' value="Submit" class="gold_btn fade_anim d-block w-100 mr-3">
                            </div>
                            <div class="col-6">
                               <input type="submit" name="Reset" value="Reset" class="fade_anim btn-reset w-100 d-block ">
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
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Exports - Value-wise</h2></div>
                            
                            <div class="col-12">
                                <div class="d-flex justify-content-end">   
                                    <p><strong>Date</strong>: <?php echo date("d/m/Y");?></p>  
                                </div>
								
								<div class="row justify-content-center mt-4">
                                   		<div class="col-md-9 searchResultwrap">
                                        	<ul>
											<?php if(isset($_SESSION['valueType']) && $_SESSION['valueType']=="yearType"){	?>
                                            	<li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Selection Type</div>
                                                        <div class="col-md-8 sResult">Year</div>
                                                    </div>
                                                </li>
												<li>
													<div class="row">
                                                    	<div class="col-md-4 sCategory">
														<?php if($_REQUEST['financialYearType']=="financialYearTypeSelected") {
														echo "Financial Year "; } ?>
														<?php if($_REQUEST['financialYearType']=="monthYearTypeSelected") {
														echo "Calendar Year "; } ?>
														</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_REQUEST['financialYearType']=="financialYearTypeSelected") {
														echo $_POST['year_fin_year']; if($cur_finyr==$_POST['year_fin_year']){ echo " APR-".getCurrentMonthName($conn); } } ?>
														<?php if($_REQUEST['financialYearType']=="monthYearTypeSelected") {
														echo $_POST['year_calendar_year']; if($_POST['year_calendar_year']==$cur_calenderyr){ echo " JAN-".getCurrentMonthName($conn); } } ?>
														</div>
                                                    </div>													
                                                </li>
											<?php }	if(isset($_SESSION['valueType']) && $_SESSION['valueType']=="dateType"){ ?>
												<li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Selection Type</div>
                                                        <div class="col-md-8 sResult">Month</div>
                                                    </div>
                                                </li>
												<li>
                                                														
													<div class="row">
                                                    	<div class="col-md-4 sCategory">
														<?php if($_REQUEST['monthType']=="monthFinancialYearType") {
														echo "Financial Year"; } ?>
														<?php if($_REQUEST['monthType']=="monthPeriodYearType") {
														echo "Calendar Year "; } ?>
														</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_REQUEST['monthType']=="monthFinancialYearType") {
														echo $_POST['month_fin_year']; if($cur_finyr==$_POST['month_fin_year']){ echo " APR-".getCurrentMonthName($conn); } } ?>
														<?php if($_REQUEST['monthType']=="monthPeriodYearType") {
														echo $_POST['calendar_year']; if($_POST['calendar_year']==$cur_calenderyr){ echo " JAN-".getCurrentMonthName($conn); } } ?>
														</div>
                                                    </div>	
                                                </li>
												<?php }	?>
												
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
								   <!--<button onclick="exportToExcel('tblexportData', 'user-data')" class="btn btn-success">Export Table Data To Excel File</button>-->
                                    <div class="d-flex justify-content-start"> 
									   <!--<button onclick="exportToExcel('tblexportData', 'value-wise-export')" class="btn btn-success">Export</button>-->
									</div>
                            </div>
							<div class="col-12">
								<?php if(isset($_SESSION['valueType']) && $_SESSION['valueType']=="yearType"){ ?>
								<?php if(isset($_SESSION['financialYearType']) && $_SESSION['financialYearType']=="financialYearTypeSelected"){ ?>
                                <table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Selected Financial Year</th>
                                            <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>
											<th>Previous Financial Year</th>
                                             <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>                                         
                                            <th>%Growth (YOY)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
									
									if($cur_finyr==$_POST['year_fin_year']){ $sameYear = "YES";	} else { $sameYear = "NO"; }
									while($row = $resultx->fetch_assoc())
									{ 	
										//echo $grandTotalINR.'---'.$grandTotalUSD;
										$lastCompairYear = getLastFinancialYear($row['financial_year']);
										if($currency!="")
										{
											if($currency=="INR")
											{
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa);
											$newTotal_Paisa  = round($row['total_inr']/$_POST['currency_inr'],2);
																						
											//echo "++++".$last_finyr.'-'.$lastCompairYear; exit;
											//echo $lastCompairYear.'---'.$sameYear.'---'.$currentMonth;
											$getPreviousFinancialYearData = round(getPreviousFinancialYearExportValueINR($lastCompairYear,$sameYear,$currentMonth,$conn)/$_POST['currency_inr'],2);
											$lastYearTotal_Paisa   = str_replace(',','',$getPreviousFinancialYearData);
											$sub_lastYear_Paisa = round($sub_lastYear_Paisa + $lastYearTotal_Paisa);
											
											$growth = round((($newTotal_Paisa - $getPreviousFinancialYearData)/$getPreviousFinancialYearData)*100,2);
											$growthPer = str_replace(array('INF'),'0',$growth);									
											
											} else {
												
											$myTotal_Paisa   = str_replace(',','',$row['total_usd']);										
											$sub_total_Paisa = $sub_total_Paisa + $myTotal_Paisa/$_POST['currency_usd'];									
											$newTotal_Paisa  = round($row['total_usd']/$_POST['currency_usd'],2);
											
											$getPreviousFinancialYearData = round(getPreviousFinancialYearExportValueUSD($lastCompairYear,$sameYear,$currentMonth,$conn)/$_POST['currency_usd'],2);										
											
											$lastYearTotal_Paisa   = str_replace(',','',$getPreviousFinancialYearData);
											$sub_lastYear_Paisa = round($sub_lastYear_Paisa + $lastYearTotal_Paisa);
											
											$growth = round((($newTotal_Paisa - $getPreviousFinancialYearData)/$getPreviousFinancialYearData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
																						
											}
										}
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
                                            <td class="text-left"><?php echo $row['financial_year'];?> <?php if($cur_finyr==$_POST['year_fin_year']){ echo " APR-".getCurrentMonthName($conn); } ?></td>
											<td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo getLastFinancialYear($row['financial_year']);?> <?php if($cur_finyr==$_POST['year_fin_year']){ echo " APR-".getCurrentMonthName($conn); } ?></td>
											<td class="text-center"><?php echo $getPreviousFinancialYearData;?></td>                         
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>
							
							</tbody>
							</table>
							<?php } ?>
							<!-- Year Calendar wise -->
							<?php if(isset($_SESSION['financialYearType']) && $_SESSION['financialYearType']=="monthYearTypeSelected"){ ?>
							<table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Selected Year</th>
                                            <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>
											<th>Previous Year</th>
                                            <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>                                           
                                            <th>%Growth (YOY)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
				/* Same */			if($cur_calenderyr==$_POST['year_calendar_year']){ $sameYear = "YES";	} else { $sameYear = "NO"; }
									while($row = $resultx->fetch_assoc())
									{ 	
										//echo $grandTotalINR.'---'.$grandTotalUSD;
										$lastCompairYear = getLastMonths($year_calendar_year,$conn);
									//	$lastCompairMonths = date('m', strtotime($row['post_date']));
									//	$lastCompairDate = $row['post_date'];
										if($currency!="")
										{
											if($currency=="INR")
											{
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);
											$sub_total_Paisa = $sub_total_Paisa + $myTotal_Paisa/$_POST['currency_inr'];
											$newTotal_Paisa  = round($row['total_inr']/$_POST['currency_inr'],2);
											
											$getPreviousYearData = getLastMonthYearExportValueINR($lastCompairYear,$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_inr'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_inr'],2);
											
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF'),'0',$growth);											
											
											} else {
												
											$myTotal_Paisa   = str_replace(',','',$row['total_usd']);
											$sub_total_Paisa = $sub_total_Paisa + $myTotal_Paisa/$_POST['currency_usd'];
											$newTotal_Paisa  = round($row['total_usd']/$_POST['currency_usd'],2);
											
											$getPreviousYearData = getLastMonthYearExportValueUSD($lastCompairYear,$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_usd'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_usd'],2);								
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											
											}
										} 
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
											<td class="text-left"><?php echo $_SESSION['year_calendar_year'];?> <?php if($_POST['year_calendar_year']==$cur_calenderyr){ echo " JAN-".getCurrentMonthName($conn); } ?></td>
											<td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo getLastMonths(date('Y', strtotime($row['post_date'])));?> <?php if($_POST['year_calendar_year']==$cur_calenderyr){ echo " JAN-".getCurrentMonthName($conn); } ?></td>
											<td class="text-center"><?php echo $getPreviousData;?></td>                                      
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>									
									</tbody>
									</table>
								<?php } } ?>
								
								<!-- Month wise Start -->
								<?php if(isset($_SESSION['valueType']) && $_SESSION['valueType']=="dateType"){ ?>
								<?php if(isset($_SESSION['monthType']) && $_SESSION['monthType']=="monthFinancialYearType"){ ?>
                                <table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Selected Month</th>
                                            <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>
											<th>Previous Month</th>
                                           <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>                                           
                                            <th>%Growth (YOY) </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
									while($row = $resultx->fetch_assoc())
									{ 	
										//echo $grandTotalINR.'---'.$grandTotalUSD;
										$lastCompairYear = getLastMonths(date('Y', strtotime($row['post_date'])));
										$lastCompairMonths = date('m', strtotime($row['post_date']));
										$lastCompairDate = $row['post_date'];
									//	$lastCompairYear = getLastMonths($year_calendar_year,$conn);
										if($currency!="")
										{
											if($currency=="INR")
											{ 
										
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/$_POST['currency_inr'],2);
											$newTotal_Paisa  = round($row['total_inr']/$_POST['currency_inr'],2);
										
											$getPreviousYearData = getLastMonthExportValueINR($lastCompairYear,$lastCompairMonths,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_inr'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_inr'],2);
																						
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF'),'0',$growth);											
											//$getShare = round(($newTotal_Paisa / $grandTotalINR)*100);										
											
											} else {
												
											$myTotal_Paisa   = str_replace(',','',$row['total_usd']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/$_POST['currency_usd'],2);
											$newTotal_Paisa  = round($row['total_usd']/$_POST['currency_usd'],2);
											
											$getPreviousYearData = getLastMonthExportValueUSD($last_finyr,$lastCompairMonths,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_usd'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_usd'],2);					
											
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);										
											//$getShare = round(($newTotal_Paisa / $grandTotalUSD)*100);
											
											}
										} 
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
                                            <td class="text-left"><?php echo date('F', strtotime($row['post_date'])); echo ' - '.date('Y', strtotime($row['post_date']));?></td>
											<td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo date('F', strtotime($row['post_date'])); echo ' - '; echo getLastMonths(date('Y', strtotime($row['post_date'])));?> </td>
											<td class="text-center"><?php echo $getPreviousData;?> </td>                                           
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>
									<tr>
									<td>&nbsp;</td>
									<td class="text-center">Total</td>
									<td class="text-center"><?php echo $sub_total_Paisa; ?></td>
									<td>&nbsp;</td>
									<td class="text-center"><?php echo $sub_lastYear_Paisa; ?></td>
									<td class="text-center"><?php echo $totalgrowth = round((($sub_total_Paisa - $sub_lastYear_Paisa)/$sub_lastYear_Paisa)*100,2); ?></td>					
									</tr>
									</tbody>
									</table>
								<?php } ?>	
								<!-- Month Calendar Year -->
								<?php if(isset($_SESSION['monthType']) && $_SESSION['monthType']=="monthPeriodYearType"){ ?>
								<table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Selected Month</th>
                                            <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>
											<th>Previous Month</th>
                                           <th><?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?></th>                                           
                                            <th>%Growth (YOY) </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$j=0;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
									
									while($row = $resultx->fetch_assoc())
									{ 	
										//echo $grandTotalINR.'---'.$grandTotalUSD;
										$lastCompairYear = getLastMonths(date('Y', strtotime($row['post_date'])));
										$lastCompairMonths = date('m', strtotime($row['post_date']));
										$lastCompairDate = $row['post_date'];
										
									//	$lastCompairYear = getLastMonths($year_calendar_year,$conn);
										if($currency!="")
										{
											if($currency=="INR")
											{
										
											$myTotal_Paisa   = str_replace(',','',$row['total_inr']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/$_POST['currency_inr'],2);
											$newTotal_Paisa  = round($row['total_inr']/$_POST['currency_inr'],2);
										
										//	$getPreviousYearData = getLastMonthCalendarExportValueINR($lastCompairYear,$lastCompairMonths,$conn);
											$getPreviousYearData = $lastYearMonthData[$j]['total_inr'];
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_inr'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_inr'],2);
																						
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF'),'0',$growth);											
											//$getShare = round(($newTotal_Paisa / $grandTotalINR)*100);	  									
											
											} else {
												
											$myTotal_Paisa   = str_replace(',','',$row['total_usd']);
											$sub_total_Paisa = round($sub_total_Paisa + $myTotal_Paisa/$_POST['currency_usd'],2);
											$newTotal_Paisa  = round($row['total_usd']/$_POST['currency_usd'],2);
											//echo '---'.$calendar_year; exit;
										//	$getPreviousYearData = getLastMonthCalendarExportValueUSD($lastCompairYear,$lastCompairMonths,$conn);
											$getPreviousYearData = $lastYearMonthData[$j]['total_usd'];
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_usd'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_usd'],2);					
											
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);										
											//$getShare = round(($newTotal_Paisa / $grandTotalUSD)*100);
											
											}
										} 
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
                                            <td class="text-left"><?php echo date('F', strtotime($row['post_date'])); echo ' - '.date('Y', strtotime($row['post_date']));?></td>
											<td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo date('F', strtotime($row['post_date'])); echo ' - '; echo getLastMonths(date('Y', strtotime($row['post_date'])));?> </td>
											<td class="text-center"><?php echo $getPreviousData;?> </td>                                           
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; $j++; } ?>
									<tr>
									<td>&nbsp;</td>
									<td class="text-center">Total</td>
									<td class="text-center"><?php echo $sub_total_Paisa; ?></td>
									<td>&nbsp;</td>
									<td class="text-center"><?php echo $sub_lastYear_Paisa; ?></td>
									<td class="text-center"><?php echo $totalgrowth = round((($sub_total_Paisa - $sub_lastYear_Paisa)/$sub_lastYear_Paisa)*100,2); ?></td>					
									</tr>
									</tbody>
									</table>
								<?php } } ?>
								
							</div>
							<?php } ?>					
							
				</div>
				</div>  
				<?php } if(isset($rCount) && $rCount==0){ ?>  No Data Found <?php } ?>
				
			</div>

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
/*       $("#tableResult").hide();
    $('input[type="submit"]').click(function(e){
        e.preventDefault();
    $("#tableResult").show();

    }); */
</script>

<!--<script>
$(document).ready(function(){
   $("#fromDate").datepicker({
       format: 'dd-mm-yyyy',
       autoclose: true,
	   todayHighlight: true,
   }).on('changeDate', function (selected) {
       var minDate = new Date(selected.date.valueOf());
       $('#toDate').datepicker('setStartDate', minDate);
   });

   $("#toDate").datepicker({
       format: 'dd-mm-yyyy',
       autoclose: true,
   }).on('changeDate', function (selected) {
           var minDate = new Date(selected.date.valueOf());
           $('#fromDate').datepicker('setEndDate', minDate);
   });
});  
	/*
https://stackoverflow.com/questions/28381303/start-date-and-end-date-in-bootstrap	
 */
</script>-->
<script type="text/javascript">
        $('input[type="radio"]').on("change",function(){
            $('input[type="radio"]:not(:checked)').parent('label').removeClass("radio-box-active");
            $('input[type="radio"]:checked').parent('label').addClass("radio-box-active");
        });
 
   // $("#tableResult").hide();
    //$("#specific-year").hide();
    //$("#specific-date").hide();
    //$("#specific-year-wise").hide();
    //$("#specific-month-wise").hide();
    $('input[name="valueType"]').on("change",function(){
        var valueType = $(this).val();
        if(valueType =="yearType"){
        $("#specific-year").slideDown();
        $("#specific-date").slideUp();
		$("#specific-year-wise").slideUp();
		$("#specific-month-wise").slideUp();
        }else if(valueType="dateType"){
        $("#specific-date").slideDown();
        $("#specific-year").slideUp();
		$("#financial-year-wise").slideUp();
		$("#financial-month-wise").slideUp();

        }
    });
    $('input[name="financialYearType"]').on("change",function(){
				var financialYearType = $(this).val();
				if(financialYearType =="financialYearTypeSelected"){
				$("#financial-year-wise").slideDown();
				$("#financial-month-wise").slideUp();

				}else if(financialYearType="monthYearTypeSelected"){
				$("#financial-month-wise").slideDown();
				$("#financial-year-wise").slideUp();
				}
		});
	$('input[name="monthType"]').on("change",function(){
				var monthType = $(this).val();
				if(monthType =="monthFinancialYearType"){
				$("#specific-year-wise").slideDown();
				$("#specific-month-wise").slideUp();

				}else if(monthType="monthPeriodYearType"){
				$("#specific-month-wise").slideDown();
				$("#specific-year-wise").slideUp();
				}
				});
    $('input[name="monthType"]').on("change",function(){
				var monthType = $(this).val();
				if(monthType =="monthFinancialYearType"){
				$("#specific-year-wise").slideDown();
				$("#specific-month-wise").slideUp();

				}else if(monthType="monthPeriodYearType"){
				$("#specific-month-wise").slideDown();
				$("#specific-year-wise").slideUp();
				}
	});
	
	//$("#specific-inr").show();
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
	// specific-currency
  /*   $('input[type="submit"]').click(function(e){
        e.preventDefault();
    $("#tableResult").show();

    }); */
      $('#commodity').fastselect();

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