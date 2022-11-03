<?php 

session_start();
include ("../db.inc.php");
include('../functions.php');

/*======================GET SECTIONS SHOW WISE=======================*/
if(isset($_POST['action']) && $_POST['action']=="getExhDataShowWise"){
    $show= filter($_POST['exh_show']);
    if($show !=""){
    	switch ($show) {
    		case 'IIJS':
    			$sql_section = "SELECT * FROM iijs_section_master WHERE `status`='Y'";
    			$sql_category = "SELECT * FROM iijs_category_master";
    			$sql_premium = "SELECT * FROM iijs_premium_master";
    			break;
    		case 'IIJS Signature':
    			$sql_section = "SELECT * FROM signature_section_master WHERE `status`='Y'";
    			$sql_category = "SELECT * FROM signature_category_master";
    			$sql_premium = "SELECT * FROM signature_premium_master";
    			break;
    		
    		default:
    			$sql_section ="";
    			$sql_category ="";
    			$sql_premium ="";
    			break;
    	}
        $section = "";
        $category = "";
        $premium = "";

    	if($sql_section !==""){
    		$result_section = $conn->query($sql_section);
    		while ($row_section = $result_section->fetch_assoc() ) {
    			$section .='<label> <input type="checkbox" name="exh_section[]" value="'.$row_section["section"].'"  /> '.$row_section["section"].'&nbsp;</label>';
    		}
    	}else{
    		$section .= "Sections not available";
    	}

    	if($sql_category !==""){
    		$result_category = $conn->query($sql_category);
    		while ($row_category = $result_category->fetch_assoc() ) {
    			$category .='<label> <input type="checkbox" name="exh_category[]" value="'.$row_category["category"].'"  /> '.$row_category["category"].'&nbsp;</label>';
    		}
    	}else{
    		$category .= "Category not available";
    	}
    	if($sql_premium !==""){
    		$result_premium = $conn->query($sql_premium);
    		while ($row_premium = $result_premium->fetch_assoc() ) {
    			$premium .='<label> <input type="checkbox" name="exh_premium[]" value="'.$row_premium["premium"].'"  /> '.$row_premium["premium"].'&nbsp;</label>';
    		}
    	}else{
    		$premium .= "Category not available";
    	}

    	
    
    	echo json_encode(array("section"=>$section,"category"=>$category,"premium"=>$premium));
    }
    
}
?>