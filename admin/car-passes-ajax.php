<?php
session_start();
ob_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php
include('../db.inc.php');
include('../functions.php');
	if($_REQUEST['action'] == "getGround"){
        if(!isset($_POST)){
            echo json_encode(array("status"=>"fail"));
        }
        $gate_no = $_POST['gate_no'];
        $ground_date = $conn->query("SELECT * FROM gate_master WHERE `gate`= '$gate_no' and`is_active`='1'");
        $row = $ground_date->fetch_assoc();
        if (!isset($row['ground_no'])) {
            echo json_encode(array("status"=>"fail"));
            exit;
        }
        echo json_encode(array("status"=>"success","ground_no"=>$row['ground_no']));
        exit;
    } 
    if($_REQUEST['action'] == "updateStatus"){
        if(!isset($_POST)){
            echo json_encode(array("status"=>"fail"));
        }
        $unique_code = $_POST['unique_code'];
        
        $data = $conn->query("SELECT * FROM globalparking WHERE `unique_code`= '$unique_code'");
        $row = $data->fetch_assoc();
        print_r($row);
        exit;
        if (!isset($row['ground_no'])) {
            echo json_encode(array("status"=>"fail"));
            exit;
        }
        echo json_encode(array("status"=>"success","ground_no"=>$row['ground_no']));
        exit;
    } 
?>