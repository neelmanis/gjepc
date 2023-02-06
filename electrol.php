<?php
include 'db.inc.php';
?>

			<?php
			$sql = "SELECT * FROM gjepclivedatabase.electrol group by plant";
			$sqlx = $conn ->query($sql);
			$count = $sqlx->num_rows;
			$html ='<!doctype html>
						<html style="margin:0; padding:0; box-sizing:border-box;">
						  <head>
							<meta charset="utf-8">
							<title></title>
						  </head>
							<table cellpadding="10" cellspacing="0" border="1" width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;">';
							
				$html.='<tr><td colspan="3" style="text-align:center" align="center"><img src="https://registration.gjepc.org/images/logo.png"> </td> </tr>';
				
			while($results = $sqlx->fetch_assoc())
			{	
				
				$html .='<tr>
					<th colspan="3">'.$results['region'].'
						Electoral Roll for year (2022)
						</th>
				   </tr>
				   <tr>
					<td style="width:50%">Panel</td>
					<td style="width:50%">List of Ordinary Members</td>
					<td style="width:50%">Authorized Person Details</td>
				   </tr>';
				   
				$region = $results['region']; 				
				   
				$sqlm = "SELECT * FROM gjepclivedatabase.electrol where region='$region' order by panel";
				$sqlxm = $conn ->query($sqlm);
				while($result = $sqlxm->fetch_assoc())
				{
					 $html .= '			   
				   
				   <tr>
				   <td>
						'.$result['panel'].'
					</td>
					<td>
						SR NO- '.$result['id'].'<br/>
		'.$result['voter_no'].'<br/>	'.$result['company'].'<br/>
		'.$result['address1'].'<br/>		
		
					</td>
					<td>
						'.$result['mobile1'].'<br/>'.$result['authorised_person'].'<br/>'.$result['email'].'
					</td>
				   </tr>				   
				';
				}
			}	
			
			$html.='</table>
			</body>
		</html>';
		
			echo $html;			
			?>
		