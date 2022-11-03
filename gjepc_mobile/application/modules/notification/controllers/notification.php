<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends MX_Controller
{

	function __construct() {
		parent::__construct();
		
		$this->load->model('mdl_notification');
    $this->load->library('session');
		$this->load->library('user_agent');
	}

/************************************** Start Login ****************************************************/	

	function notificationlist()
	{
    $sql = "SELECT * FROM push_notification ORDER BY id DESC LIMIT 10";
		$getUsers = $this->mdl_notification->customQuery($sql);
		 if(!empty($getUsers) && is_array($getUsers) && $getUsers !="No Data")
		 {
		  $data['getAllusers'] = $getUsers;
		 }
		 else
		 {
		  $data['getAllusers'] = ""; 
		 }
		$data['viewFile'] = "list";
		$data['page'] = 'list';
		$data['menu'] = 'infos';
		$template = 'admin';
		echo Modules::run('template/'.$template, $data);
	}

function sendNotification(){
$content = $this->input->post();
$date = date("Y-m-d");
if ($content['type']=="0" || empty($content['type']) ) {
 echo json_encode(array('status'=>'emptyType'));exit;
}else if($content['title']=="" || empty($content['title'])){
 echo json_encode(array('status'=>'emptyTitle'));exit;

}else if($content['message']=="" || empty($content['message'])){
 echo json_encode(array('status'=>'emptyMessage'));exit;
}
$sql= "";
 if($content['type']=="I"){
  $sql = "SELECT DISTINCT deviceId FROM push_notification WHERE deviceType ='I' ORDER BY modified_date DESC  ";
   //$sql = "SELECT DISTINCT deviceId FROM push_notification WHERE deviceType ='I' AND deviceId='f_RPuLkEXn8:APA91bH7cZZtMo8PModVuBcBuML6IyeT3WZozZ9rKRMOA3IVdwwp4F4s46h2L3j7kpkqL33stspSq7NmDgKtZmHPL_4mA3zen3lJVMBGKW-Nf-NpczkTHIvACcAs2l_9D2uINYPIiwSk' ORDER BY modified_date DESC  LIMIT 1";

   
   $devices = $this->mdl_notification->customQuery($sql);
   if( is_array($devices) && $devices !="" && $devices != "No Data" && !empty($devices)){
       foreach ($devices as $val) {
        $device_key =  trim($val->deviceId);

        $getBadgeCount = Modules::run('notification/getBadgeCount',$device_key);
            
        $newBadgeCount=$getBadgeCount+1;
        $message= $content['message'];
        $title = $content['title'];

        //$server_key= "AAAAMn012tY:APA91bE7pSXV92z4RdeUW-UnJz5S_NGwIHQd_pL_NNpAbi8YWh2YIt1V1mIWKYnXUqWTGwD5nqp942VDZqfPdffTboKPk_OrGoThO1i3Zwi1Y6qvvaQ8cyX3lfuC_fCR6HSjRJPU6ndo";   // Live
        //$server_key= "AAAAw5f9sfM:APA91bEDj_MnvxFddF6VsuOIjPRXpcRsM5JhKTfR5U19RKxiB1dlGGRDS5HqascF9x3kAW2BsweNeVgroiy6C7jhk2E8TnHUzQbrKL_IlzBQQZ_QFMaj4hQ2OLJZPG0YOMgvGdKhHrbh";   // New
        $server_key= "AAAApL0uOnU:APA91bHj1K2eSneqjPUyWqIEmxcpVpuuzkpSqy9uMnjLEk3qKc94piMfcZ8RBOZprrK0S2unxX1YiJx6IZBiHPr_ot0FTGBiHDAkq09pccDFMtmbKgDY8mxhgcwoaxELH91_ZtcPk5dc";


   
        $path_to_send = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
                  'Authorization:Key=' .$server_key,
                'Content-Type:application/json'
        );
        $fields= array('to'=>$device_key,
                     'notification'=>array('title'=>$title,'body'=>$message,'sound'=>'default','badge'=>$newBadgeCount),
                     'content_available'=> true,
                     'priority'=>'high');
    
        $payload =json_encode($fields);

        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $path_to_send);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER,true);
       // curl_setopt($curl_session, CURLOPT_IPRESOLVE,CURLOPT_IPRESOLVE_V4);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS,$payload);

        $result = curl_exec($curl_session);

       // print_r(json_decode($result));exit;
      $array = json_decode($result, true);
       
        $err = curl_error($curl_session);
        curl_close($curl_session);
        $data = array('badgeCount' => $newBadgeCount);
        $update=  $this->mdl_notification->updateBadge('push_notification','deviceId',$device_key,$data);
          
       }
       
      echo json_encode(array('status'=>'success'));exit;
    }
    

 }else if($content['type']=="A"){
 
  $sql = "SELECT DISTINCT deviceId FROM push_notification WHERE deviceType ='A' ORDER BY modified_date DESC ";
  //$sql = "SELECT DISTINCT deviceId FROM push_notification WHERE deviceId ='cvtN2WEKFCM:APA91bFW5yVs-8c_ABi-OAW_4ZY01Scibk8HldgE3568vh4xdcoVF6qQ83LHb1wk6orzVDQ-jrfAh3-GdcR0lnwA5VfiQ68bi-DYzkVvBtcgGmwWmeV2vj81Eoj7ftXGRzhNDq2EiAQ3'  LIMIT 1";
  
   $devices = $this->mdl_notification->customQuery($sql);

    if(is_array($devices) && $devices !="" && $devices != "No Data" && !empty($devices)){
       foreach ($devices as $value) {
          $device_key =  trim($value->deviceId);
        $getBadgeCount = Modules::run('notification/getBadgeCount',$device_key);
            
            $newBadgeCount=trim($getBadgeCount)+1;

        $message= $content['message'];

        $title = $content['title'];
        

         $server_key= "AAAApL0uOnU:APA91bHj1K2eSneqjPUyWqIEmxcpVpuuzkpSqy9uMnjLEk3qKc94piMfcZ8RBOZprrK0S2unxX1YiJx6IZBiHPr_ot0FTGBiHDAkq09pccDFMtmbKgDY8mxhgcwoaxELH91_ZtcPk5dc";   // Live
        //$server_key= "AAAAMn012tY:APA91bE7pSXV92z4RdeUW-UnJz5S_NGwIHQd_pL_NNpAbi8YWh2YIt1V1mIWKYnXUqWTGwD5nqp942VDZqfPdffTboKPk_OrGoThO1i3Zwi1Y6qvvaQ8cyX3lfuC_fCR6HSjRJPU6ndo";   // Testing
  
        $path_to_send = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
                  'Authorization:Key=' .$server_key,
                'Content-Type:application/json'
        );
        $fields= array('to'=>$device_key,
                     'data'=>array('title'=>$title,'body'=>$message,'sound'=>'default','count'=>$newBadgeCount,'click_action'=>'.HomeActivity','date'=>$date),
                     'content_available'=> true,
                     'priority'=>'high');
    
        $payload =json_encode($fields);

        $curl_session = curl_init();
        curl_setopt($curl_session, CURLOPT_URL, $path_to_send);
        curl_setopt($curl_session, CURLOPT_POST, true);
        curl_setopt($curl_session, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl_session, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER,true);
       // curl_setopt($curl_session, CURLOPT_IPRESOLVE,CURLOPT_IPRESOLVE_V4);
        curl_setopt($curl_session, CURLOPT_POSTFIELDS,$payload);

        $result = curl_exec($curl_session);

      /* print_r(json_decode($result));*/
      $array = json_decode($result, true);
       
        $err = curl_error($curl_session);
        curl_close($curl_session);
        $data = array('badgeCount' => $newBadgeCount);
        $update=  $this->mdl_notification->updateBadge('push_notification','deviceId',$device_key,$data);
      }
       
    echo json_encode(array('status'=>'success'));exit;
    }
    

 }


}

  function badgeNull(){
      $json = file_get_contents('php://input');   
      $obj = $this->security->xss_clean(json_decode($json,true));

       $deviceId=$obj['deviceId'];
       //$deviceId = substr($getdeviceId, 9, -1);
        
       $fields=array('badgeCount'=>'0');
    
       $update=  $this->mdl_notification->updateBadge('push_notification','deviceId',$deviceId, $fields);
      
       if($update===TRUE) {
        $strResponse = array('status'=>'success','msg'=>'Notification Null');
       }else{
       $strResponse = array('status'=>'fail','msg'=>'Notification not null');
       }

       header('Content-type: application/json');
       echo json_encode(array("Response"=>$strResponse));
  }

  function getBadgeCount($device_key){
    
   $devices = $this->mdl_notification->getBadgeCount($device_key);
   if($devices !== "no"){
   echo $badgeCount =  $devices[0]->badgeCount;
  }
  }




	
	
}