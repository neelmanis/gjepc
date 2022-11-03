<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
			$match_bp = array();
		    $smx = "SELECT bp_number FROM visitor_directory where mobile='9004446114' AND bp_number!=''";
			$result = mysql_query($smx);
			$counx = mysql_num_rows($result);
			if($counx>0)
			{
				echo "Already";
			}
			 else {
				 echo "Created";				 
			 }
			/*while($row = mysql_fetch_array($result))
			{
				$match_bp[] = $row['bp_number'];
			//print_r($row); 	
			} 
			echo '<pre>'; print_r($match_bp); 
			foreach($match_bp as $key => $value) {
			if(empty($value))
			{ echo 'Created';
			} else { echo 'Already';}
			
			}*/
			
?>