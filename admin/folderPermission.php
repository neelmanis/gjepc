<?php  
$create_dir = "neel/ccol"; 

if (!file_exists($create_dir)) { 
   mkdir($create_dir, 0777);
} else {
	echo 'Error: Folder Creation';	
} 
?>
