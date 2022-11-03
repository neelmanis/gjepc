<?php
include('db.inc.php');
include('functions.php');

$currentFinaicialYear = getFinancialYear($conn);

/* Export/Import Destination wise */
if(isset($_POST['actiontype']) && $_POST['actiontype']=="sendDetails")
{
		$type = $_POST['type'];
		$year = $_POST['year'];
		if($year=="2021-2022" || $year=="2020-2021" || $year=="2019-2020" || $year=="2018-2019")
		{
		$exportQuery = "SELECT `financial_year`,`country_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$year' AND trade_type='$type' group by country_id order by total_usd desc limit 0,5"; 
		} else {
		if($year=="04-11"){
		$exportQuery = "SELECT `financial_year`,`country_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND trade_type='$type' group by country_id order by total_usd desc limit 0,5"; 	
		} else {
		$exportQuery = "SELECT `financial_year`,`country_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND MONTH(post_date)='$year' AND trade_type='$type' group by country_id order by total_usd desc limit 0,5"; 	
		}
		}
		//echo $exportQuery;
		$execute_exports = $conn->query($exportQuery);
			// Store data in array
			while($row = $execute_exports->fetch_assoc()){
				$country[] = $row['country_id'];
				$datas[] = round($row['total_usd']/1000000,2);
			}
			
			$data = array(
				'labels' => $country,
				'datasets' => array(
					'data' => $datas,
				),
			);
			echo json_encode($data);
}

/* Month Wise Exports & Imports */
if(isset($_POST['actiontype']) && $_POST['actiontype']=="sendMonthDetails")
{
		$type = $_POST['type'];
		$year = $_POST['year'];
		if($year=="2021-2022" || $year=="2020-2021" || $year=="2019-2020" || $year=="2018-2019")
		{
		$arr_string = explode("-",$year); 
		$startYear = $arr_string[0];
		$endYear = $arr_string[1];
		
		$lastYear = getLastFinancialYear($year);
		$last_string = explode("-",$lastYear); 
		$getEndYear = $last_string[0];
				
		$exportQuerys = "SELECT `post_date`,financial_year, SUM(REPLACE(dollar_value, ',', '')) as total_usd, DATE_FORMAT(post_date,'%M') as entry_month FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '$endYear-03-31' AND trade_type='$type' group by entry_month order by post_date ASC";
		$execute_exports = $conn->query($exportQuerys);
			 
			while($rowx = $execute_exports->fetch_assoc()){		
			 $lastCompairYear = getLastMonths(date('Y', strtotime($rowx['post_date'])));
			 $lastCompairMonths = date('m', strtotime($rowx['post_date']));			 
			 $lastYearData = getMiniLastMonthChartExportValueUSD($lastCompairYear,$lastCompairMonths,$type,$conn);
			 
			$totalExportUSDMillionData  = round($rowx['total_usd']/1000000,2); //billion
			$totalExportUSDMillionLastData = round($lastYearData/1000000,2);   //billion						
			 
			$country[] = $rowx['entry_month'];
			$totalUSDBillionData[] = $totalExportUSDMillionData;
			$totalUSDBillionDataLast[] = $totalExportUSDMillionLastData;
			   
			}
			 // Chart data for ajax request
			$data = array(
				'currentyear' => $year,
				'lastyear' => $lastYear,
				'labels' => $country,
				'datasets' => array(
				'totalUSDBillionData' => $totalUSDBillionData,
				'totalUSDBillionDataLast' => $totalUSDBillionDataLast,
				),
			);
			
			// Convert and echo data in JSON format
			echo json_encode($data);
		} else {
	//	$currentFinaicialYear = "2020-2021";		
		$arr_string = explode("-",$currentFinaicialYear); 
		$startYear = $arr_string[0];
		$endYear = $arr_string[1];
		
		if($year=="04-11"){
		$monthArray = explode("-",$year);
		$aprMonth = $monthArray[0];
		$currentMonth = $monthArray[1];
		
		$exportQuerys = "SELECT `post_date`,financial_year, SUM(REPLACE(dollar_value, ',', '')) as total_usd, DATE_FORMAT(post_date,'%M') as entry_month FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '$endYear-$currentMonth-30' AND trade_type='$type' group by entry_month order by post_date ASC";
		} else { 
	//	$exportQuerys = "SELECT `post_date`,financial_year, SUM(REPLACE(dollar_value, ',', '')) as total_usd, DATE_FORMAT(post_date,'%M') as entry_month FROM `statistics_integration_data` WHERE 1 AND financial_year='$currentFinaicialYear' AND MONTH(post_date)='$year' AND trade_type='$type' group by entry_month order by post_date ASC";
		}
		
		$execute_exports = $conn->query($exportQuerys);
			 
			while($rowx = $execute_exports->fetch_assoc()){		
			 $lastCompairYear = getLastMonths(date('Y', strtotime($rowx['post_date'])));
			 $lastCompairMonths = date('m', strtotime($rowx['post_date']));			 
			 $lastYearData = getMiniLastMonthChartExportValueUSD($lastCompairYear,$lastCompairMonths,$type,$conn);
			 
			$totalExportUSDMillionData  = round($rowx['total_usd']/1000000,2); //billion
			$totalExportUSDMillionLastData = round($lastYearData/1000000,2);   //billion						
			 
			$country[] = $rowx['entry_month'];
			$totalUSDBillionData[] = $totalExportUSDMillionData;
			$totalUSDBillionDataLast[] = $totalExportUSDMillionLastData;			   
			}
			 // Chart data for ajax request
			$data = array(
				'currentyear' => $currentFinaicialYear,
				'lastyear' => getLastFinancialYear($currentFinaicialYear),
				'labels' => $country,
				'datasets' => array(
				'totalUSDBillionData' => $totalUSDBillionData,
				'totalUSDBillionDataLast' => $totalUSDBillionDataLast,
				),
			);
			echo json_encode($data);		
		}
}

/* Commodity Wise Exports & Imports */
if(isset($_POST['actiontype']) && $_POST['actiontype']=="sendCommodityDetails")
{
		$type = $_POST['type'];
		$year = $_POST['year'];
		
		if($year=="2021-2022" || $year=="2020-2021" || $year=="2019-2020" || $year=="2018-2019")
		{
		$lastCompairYear = getLastFinancialYear($year);
		$arr_string = explode("-",$year); 
		$startYear = $arr_string[0];
		$endYear = $arr_string[1];
		
		$exportQuerys = "SELECT a.financial_year,a.post_date,a.trade_type,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$year' and a.trade_type='$type' and a.hs_code_id=b.hs_code and b.level='8' group by b.commodity_category order by total_usd desc limit 7";
		$execute_exports = $conn->query($exportQuerys);
			 
		while($rowx = $execute_exports->fetch_assoc()){		
			
			$totalExportUSDBillionData  = round($rowx['total_usd']/1000000,2);  //million
			$getPreviousYearData = getMiniPreviouscommoditywiseUSD($lastCompairYear,$rowx['commodity_category'],$type,$conn);			
			$totalExportUSDBillionLastData = round($getPreviousYearData/1000000,2);   //million
			 
			$commodity_category[] = $rowx['commodity_category'];
			$totalUSDBillionData[] = $totalExportUSDBillionData;
			$totalUSDBillionDataLast[] = $totalExportUSDBillionLastData;
			   
			}
			 // Chart data for ajax request
			$data = array(
				'currentyear' => $year,
				'lastyear' => $lastCompairYear,
				'labels' => $commodity_category,
				'datasets' => array(
				'totalUSDBillionData' => $totalUSDBillionData,
				'totalUSDBillionDataLast' => $totalUSDBillionDataLast,
				),
			);
			
			// Convert and echo data in JSON format
			echo json_encode($data);
		} else {
		
		if($year=="04-11"){
		$month = getCurrentMonth($conn);
		
		$arr_string = explode("-",$currentFinaicialYear); 
		$startYear = $arr_string[0];
		$endYear = $arr_string[1];
		
		$lastCompairYear = getLastFinancialYear($currentFinaicialYear);
		//$arr_string = explode("-",$year); 
				
		$exportQuerys = "SELECT a.financial_year,a.post_date,a.trade_type,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$currentFinaicialYear' and a.trade_type='$type' and a.hs_code_id=b.hs_code and b.level='8' group by b.commodity_category order by total_usd desc limit 7";
		$execute_exports = $conn->query($exportQuerys);
			 
		while($rowx = $execute_exports->fetch_assoc()){		
			
			$totalExportUSDBillionData  = round($rowx['total_usd']/1000000,2);  //million
			$getPreviousYearData = getMiniPreviouscommodityMonthwiseUSD($lastCompairYear,$rowx['commodity_category'],$type,$month,$conn);			
			$totalExportUSDBillionLastData = round($getPreviousYearData/1000000,2);   //million
			 
			$commodity_category[] = $rowx['commodity_category'];
			$totalUSDBillionData[] = $totalExportUSDBillionData;
			$totalUSDBillionDataLast[] = $totalExportUSDBillionLastData;
			   
			}
			 // Chart data for ajax request
			$data = array(
				'currentyear' => $currentFinaicialYear,
				'lastyear' => $lastCompairYear,
				'labels' => $commodity_category,
				'datasets' => array(
				'totalUSDBillionData' => $totalUSDBillionData,
				'totalUSDBillionDataLast' => $totalUSDBillionDataLast,
				),
			);

			echo json_encode($data);
		} else {
		/* SEPT Month */
		$lastCompairYear = getLastFinancialYear($currentFinaicialYear);
				
		$exportQuerys = "SELECT a.financial_year,a.post_date,a.trade_type,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$currentFinaicialYear' AND MONTH(a.post_date)='$year' AND a.trade_type='$type' and a.hs_code_id=b.hs_code and b.level='8' group by b.commodity_category order by total_usd desc limit 7";
		$execute_exports = $conn->query($exportQuerys);
			 
		while($rowx = $execute_exports->fetch_assoc()){		
			
			$totalExportUSDBillionData  = round($rowx['total_usd']/1000000,2);  //million
			$getPreviousYearData = getMiniPreviouscommoditySingleMonthUSD($lastCompairYear,$rowx['commodity_category'],$type,$year,$conn);			
			$totalExportUSDBillionLastData = round($getPreviousYearData/1000000,2);   //million
			 
			$commodity_category[] = $rowx['commodity_category'];
			$totalUSDBillionData[] = $totalExportUSDBillionData;
			$totalUSDBillionDataLast[] = $totalExportUSDBillionLastData;
			   
			}
			 // Chart data for ajax request
			$data = array(
				'currentyear' => $currentFinaicialYear,
				'lastyear' => $lastCompairYear,
				'labels' => $commodity_category,
				'datasets' => array(
				'totalUSDBillionData' => $totalUSDBillionData,
				'totalUSDBillionDataLast' => $totalUSDBillionDataLast,
				),
			);
			
			// Convert and echo data in JSON format
			echo json_encode($data);			
		}
		}
}

/* Dashboard Exports & Imports */
if(isset($_POST['actiontype']) && $_POST['actiontype']=="getDetails"){
			
			$info = $_POST['info'];
	
			$getCurrentYear = date('Y');
			$getCurrentMonth = date('m');
			$getCurrentDate = date('d');
			$month = getCurrentMonth($conn);
			//$lastYear = date("Y-m-d", strtotime("-1 years")); //Getting last year’s date
			
			$cur_year = substr($currentFinaicialYear, 0,-5);
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
			
			if($info=="monthData"){
			$sqlExportMonth = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND trade_type='Export' AND MONTH(post_date) = $month group by entry_month";
			$sqlExportMonthresultlx = $conn ->query($sqlExportMonth);
			$sqlExportrows  = $sqlExportMonthresultlx->fetch_assoc();
			$totalExportUSD = $sqlExportrows['total_usd'];
			$totalExportUSDMillion = round($totalExportUSD/1000000,2);
			/* Export Growth */ 
			$getPreviousYearExportMonthData = getMiniLastMonthExportValueUSD($last_finyr,$month,$conn);
			$growthExportMonth = round((($totalExportUSD - $getPreviousYearExportMonthData)/$getPreviousYearExportMonthData)*100,2);
			$growthMothExportPer = str_replace(array('INF'),'0',$growthExportMonth);
			
			$sqlImportMonth = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND trade_type='Import' AND MONTH(post_date) = $month group by entry_month";
			$sqlImportMonthresultlx = $conn ->query($sqlImportMonth);
			$sqlImportrows  = $sqlImportMonthresultlx->fetch_assoc();
			$totalImportUSD = $sqlImportrows['total_usd'];
			$totalImportUSDMillion =  round($totalImportUSD/1000000,2);
			/* Import Growth */
			$getPreviousYearImportMonthData = getMiniLastMonthImportValueUSD($last_finyr,$month,$conn);
			$growthImportMonth = round((($totalImportUSD - $getPreviousYearImportMonthData)/$getPreviousYearImportMonthData)*100,2);
			$growthMotImportPer = str_replace(array('INF'),'0',$growthImportMonth);
			
			echo json_encode(
						array(
						'success'=>TRUE,
						'monthData'=>"monthData",
						'totalExportUSDMillion'=>"$totalExportUSDMillion",
						'totalImportUSDMillion'=>"$totalImportUSDMillion",
						'growthMothExportPer'=>"$growthMothExportPer",
						'growthMotImportPer'=>"$growthMotImportPer",
						)
						);			
			}			
			
			if($info=="fyData"){
			/* FY */
			/* 2020-2021 // Commented for last sept wala ye tha 25/10/2021 
			$sqlFYExport = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND post_date BETWEEN '2020-04-01' AND '2021-03-31' AND trade_type='Export' group by financial_year"; */
			$sqlFYExport = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND post_date BETWEEN '2021-04-01' AND '2022-03-31' AND trade_type='Export' group by financial_year"; 
			/*
			$sqlFYExport = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND post_date BETWEEN '2021-04-01' AND '2021-11-30' AND trade_type='Export' group by financial_year";
			*/
			$sqlExportFYresultx = $conn ->query($sqlFYExport);
			$sqlExportFYrows  = $sqlExportFYresultx->fetch_assoc();
			$totalExportFYUSD = $sqlExportFYrows['total_usd'];
			$totalExportFYUSDMillion = round($totalExportFYUSD/1000000,2);
			/* FY Export Growth */
			$getPreviousYearExportFYData = getMiniLastFYExportValueUSD($last_finyr,$month,$conn);
			$growthExportFY = round((($totalExportFYUSD - $getPreviousYearExportFYData)/$getPreviousYearExportFYData)*100,2);
			$growthFYExportPer = str_replace(array('INF'),'0',$growthExportFY);
			
			/* 2020-2021 // Commented for last sept wala ye tha 25/10/2021
			$sqlFYImport = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND post_date BETWEEN '2020-04-01' AND '2021-03-31' AND trade_type='Import' group by financial_year"; 
			$sqlFYImport = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND post_date BETWEEN '2021-04-01' AND '2021-11-30' AND trade_type='Import' group by financial_year";*/
			
			$sqlFYImport = "SELECT `financial_year`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE financial_year='$currentFinaicialYear' AND post_date BETWEEN '2021-04-01' AND '2022-03-31' AND trade_type='Import' group by financial_year";
			$sqlImportFYresultx = $conn ->query($sqlFYImport);
			$sqlImportFYrows  = $sqlImportFYresultx->fetch_assoc();
			$totalImportFYUSD = $sqlImportFYrows['total_usd'];
			$totalImportFYUSDMillion = round($totalImportFYUSD/1000000,2);
			/* FY Import Growth */
			$getPreviousYearImportFYData = getMiniLastFYImportValueUSD($last_finyr,$month,$conn);
			$growthImportFY = round((($totalImportFYUSD - $getPreviousYearImportFYData)/$getPreviousYearImportFYData)*100,2);
			$growthFYImportPer = str_replace(array('INF'),'0',$growthImportFY);	
			
			echo json_encode(
						array(
						'success'=>TRUE,
						'monthData'=>"fyData",
						'totalExportFYUSDMillion'=>"$totalExportFYUSDMillion",
						'totalImportFYUSDMillion'=>"$totalImportFYUSDMillion",
						'growthFYExportPer'=>"$growthFYExportPer",
						'growthFYImportPer'=>"$growthFYImportPer",
						)
						);
			
			}	
}
?>