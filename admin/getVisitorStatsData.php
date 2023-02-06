<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');

/* Export/Import Destination wise */
function getStateShortName($state)
{
	if($state=='13'){	$c_answer = 'in-mh'; }
	else if($state=='06'){ $c_answer = 'in-2984'; }
	else if($state=='05'){ $c_answer = 'in-ga';	}			
	else if($state=='10'){ $c_answer = 'in-ka';	}			
	else if($state=='01'){ $c_answer = 'in-ap';	}			
	else if($state=='22'){ $c_answer = 'in-tn';	}			
	else if($state=='11'){ $c_answer = 'in-kl';	}			
	else if($state=='18'){ $c_answer = 'in-or';	}			
	else if($state=='25'){ $c_answer = 'in-wb';	}			
	else if($state=='16'){ $c_answer = 'in-mz';	}			
	else if($state=='14'){ $c_answer = 'in-mn';	}			
	else if($state=='17'){ $c_answer = 'in-nl';	}			
	else if($state=='02'){ $c_answer = 'in-ar';	}			
	else if($state=='03'){ $c_answer = 'in-as';	}			
	else if($state=='15'){ $c_answer = 'in-ml';	}			
	else if($state=='21'){ $c_answer = 'in-sk';	}			
	else if($state=='34'){ $c_answer = 'in-jh';	}			
	else if($state=='04'){ $c_answer = 'in-br';	}			
	else if($state=='12'){ $c_answer = 'in-mp';	}			
	else if($state=='24'){ $c_answer = 'in-up';	}			
	else if($state=='20'){ $c_answer = 'in-rj';	}			
	else if($state=='20'){ $c_answer = 'in-rj';	}			
	else if($state=='07'){ $c_answer = 'in-hr';	}			
	else if($state=='35'){ $c_answer = 'in-ut';	}			
	else if($state=='19'){ $c_answer = 'in-pb';	}			
	else if($state=='33'){ $c_answer = 'in-ct';	}			
	else if($state=='08'){ $c_answer = 'in-hp';	}			
	else if($state=='09'){ $c_answer = 'in-jk';	}	
		
	return $c_answer;
}
if(isset($_POST['actiontype']) && $_POST['actiontype']=="sendVisitorDetails")
{
		$event = $_POST['event'];
		
		$exportQuery = "SELECT count(*) as stateCount,oh.visitor_id, rm.id,rm.company_name,rm.state,sm.state_name,vd.bp_number,vd.name,
						oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status',oh.`show`
						from visitor_order_history oh 
						inner join registration_master rm on oh.registration_id=rm.id 
						inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
						inner join state_master sm on sm.state_code = rm.state
						where 1 AND oh.`payment_status` ='Y' 
						and oh.`show` ='$event'  group by rm.state"; 

		
		//echo $exportQuery;exit;
		$execute_exports = $conn->query($exportQuery);
			// Store data in array
			while($row = $execute_exports->fetch_assoc()){
				$stateCount[] = array('stateCount'=>$row['stateCount'],'state_id'=>getStateShortName($row['state']),'state_name' => $row['state_name']);
				$stateName[] = $row['state_name'];
			}
			
			$data = array(
				'datasets' => array(
					'data' => $stateCount,	
				),
			);
			echo json_encode($data);
}

?>