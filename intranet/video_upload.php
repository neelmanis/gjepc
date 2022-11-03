<?php
if ($_REQUEST['action']=='save')
{
	//$post_date = date('Y-m-d');
	 $post_date=$_REQUEST['p_date'];
	 $p_name=addslashes($_REQUEST['name']);
		$export_attachment = '';
		$target_folder = '../gallary_videos/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		
			if($_FILES['p_file']['name']!='')
			{	
				if (($_FILES["p_file"]["type"] == "video/mp4") || ($_FILES["p_file"]["type"] == "audio/mp3") || ($_FILES["p_file"]["type"] == "audio/wma") )
				{
					$target_path = $target_folder.$_FILES['p_file']['name'];
					if(@move_uploaded_file($_FILES['p_file']['tmp_name'], $target_path))
					{
						 $p_file = $_FILES['p_file']['name'];
						
						$sql="INSERT INTO videos_master (name,img_name,status,post_date) VALUES ('$p_name','$p_file','1','$post_date')";	
						if (!mysql_query($sql,$dbconn))
						{
							die('Error: ' . mysql_error());
						}
						echo"<meta http-equiv=refresh content=\"0;url=manage_videos.php?action=view\">";
					}
					else
					{
						echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_videos.php?action=add';</script>";
					return;
					}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_videos.php?action=add';</script>";
			 }	
			}
			
	
	
		
	
}
?>