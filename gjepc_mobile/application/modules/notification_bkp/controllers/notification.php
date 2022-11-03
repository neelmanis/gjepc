<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_notification');
	}
	
	function index()
	{
		$data['viewFile']='devicelist';
		$data['page']='notification';
		$data['menu']='lists';
		$template='admin';
		$data['devicelist']=$this->mdl_notification->get();
		echo Modules::run('template/'.$template,$data);
	}
	
	function SendMessage()
		{
			$message=$this->input->post("sendMessage");
			$registatoin_ids=$this->input->post("sendIds");
			$size=sizeof($registatoin_ids);
			$counter=0;
			$strReturnVal="Android Result:-";
			$strReturnValIphone="Iphone Result:-";
               
            
                foreach($registatoin_ids as $values)
                {
                   // $this->send_notification($values, $message);
                    $strId = $values;
            		//$base_64 =$strId . str_repeat('=', strlen($strId) % 4);
        			//$strId = base64_decode($base_64);
                    $strQuery="select * from feed_registration where regId=".$strId;
                    $strResult=$this->_custom_query($strQuery);
                    $strResult=$strResult->result();
                    $devicetype=$strResult[0]->deviceType;
                    $deviceId=$strResult[0]->deviceId;
					$alert="";

                    if($devicetype=="A")
                    {
                      $strReturnVal1=$this->send_notification($deviceId, $message,"21Plus");
                      if($strReturnVal1!=1)
                      {
                        $strReturnVal.="Message not send to ".$deviceId." ,";
                      }

                    }
                    else
                    {
                      $strReturnVal1= $this->sendNotificationIphone($deviceId, $message,$alert);
                      if($strReturnVal1!=1)
                      {
                        $strReturnValIphone.="Message not send to ".$deviceId." ,";
                      }
                    }
                /*    $counter=$counter+1;
                    $strgetuserdetails="select * from feed_registration where deviceId='$deviceId'";
                    $strgetuserdetailsResult=$this->_custom_query($strgetuserdetails);

                    if($strgetuserdetailsResult->num_rows()>0)
                    {
                        $strgetuserdetailsResult=$strgetuserdetailsResult->result();
                        $strRegId=$strgetuserdetailsResult[0]->regId;
                        $strquery="insert into plus_userNotification (notificationMessage,regId) values ('$message',$strRegId)";
                        $strTResult=$this->_custom_query($strquery);
                    }*/
                                      
                }
			
				/*if($size==$counter)
				{
					echo 1;
	
				}
				else
				{
					echo $strReturnVal." ".$strReturnValIphone ;
				} */
		}

	
function send_notification($registatoin_ids, $message,$title)
{
		$API_ACCESS_KEY='AIzaSyB-sqtY6Ac6Yo2VGaPDsmqSyTCf0YkHcGg';
		//$registrationIds = array( $_GET['id'] );
		$registrationIds=$registatoin_ids;
		// prep the bundle
		$msg = array
		(
			'message'   => $message,
			'title'     => ''.$message,
			'subtitle'  => '',
			'tickerText'=> '',
			'vibrate'   => 1,
			'sound'     => 1,
			'largeIcon' => 'large_icon',
			'smallIcon' => 'small_icon',
			'icon'=>'icon',
			'alert'=>$message,
		
		);
		$fields = array
		(
			'to'  => $registrationIds,
			'data' => $msg
		);
		
		$headers = array
		(
			'Authorization: key=' .$API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		 if ($result === FALSE) {
					//die('Curl failed: ' . curl_error($ch));
					return curl_error($ch);
				}
				else 
				{
					return 1;
				}
		 
				// Close connection
				curl_close($ch);
    }
	
	
function sendNotificationIphone($registatoin_ids, $message,$title)
{
 // Provide the Host Information.
//$tHost = 'gateway.sandbox.push.apple.com';
$tHost = 'gateway.push.apple.com';
$tPort = 2195;
// Provide the Certificate and Key Data.
	
$tCert = $_SERVER['DOCUMENT_ROOT']."/iOSpushNotifications.pem";
// Provide the Private Key Passphrase (alternatively you can keep this secrete
// and enter the key manually on the terminal -> remove relevant line from code).
// Replace XXXXX with your Passphrase
$tPassphrase = 'twentyoneplus';
// Provide the Device Identifier (Ensure that the Identifier does not have spaces in it).
// Replace this token with the token of the iOS device that is to receive the notification.
//$tToken = 'b3d7a96d5bfc73f96d5bfc73f96d5bfc73f7a06c3b0101296d5bfc73f38311b4';
$tToken = $registatoin_ids;
//0a32cbcc8464ec05ac3389429813119b6febca1cd567939b2f54892cd1dcb134
// The message that is to appear on the dialog.
$tAlert = $message;
// The Badge Number for the Application Icon (integer >=0).
$tBadge = 1;
// Audible Notification Option.
$tSound = 'default';
// The content that is returned by the LiveCode "pushNotificationReceived" message.
$tPayload = 'APNS Message Handled by LiveCode';
// Create the message content that is to be sent to the device.
$tBody['aps'] = array (
'alert' => $tAlert,
'badge' => $tBadge,
'sound' => $tSound,
);
$tBody ['payload'] = $tPayload;
// Encode the body to JSON.
$tBody = json_encode ($tBody);
// Create the Socket Stream.
$tContext = stream_context_create ();
stream_context_set_option ($tContext, 'ssl', 'local_cert', $tCert);
// Remove this line if you would like to enter the Private Key Passphrase manually.
stream_context_set_option ($tContext, 'ssl', 'passphrase', $tPassphrase);
// Open the Connection to the APNS Server.
$tSocket = stream_socket_client ('ssl://'.$tHost.':'.$tPort, $error='', $errstr='', 30, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $tContext);
// Check if we were able to open a socket.
if (!$tSocket)
exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
// Build the Binary Notification.
$tMsg = chr (0) . chr (0) . chr (32) . pack ('H*', $tToken) . pack ('n', strlen ($tBody)) . $tBody;
// Send the Notification to the Server.
$tResult = fwrite ($tSocket, $tMsg, strlen ($tMsg));

if ($tResult === FALSE) {
	return curl_error($ch);
}
else {
	return 1;
 }
// Close the Connection to the Server.
fclose ($tSocket);
}	
	

	function get($order_by) {
		$query = $this->mdl_notification->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$query = $this->mdl_notification->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($addId) {
		$query = $this->mdl_notification->get_where($addId);
		return $query;
	}

	function get_where_custom($col, $value) {
		$query = $this->mdl_notification->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		return $this->mdl_notification->_insert($data);
	}

	function _update($addId, $data) {
		return $this->mdl_notification->_update($addId, $data);
	}

	function _delete($addId) {
		return $this->mdl_notification->_delete($addId);
	}

	function count_where($column, $value) {
		$count = $this->mdl_notification->count_where($column, $value);
		return $count;
	}

	function get_max() {
		$max_id = $this->mdl_notification->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$query = $this->mdl_notification->_custom_query($mysql_query);
		return $query;
	}


}
?>