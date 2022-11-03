<?php 
	session_start();
	ob_start();
	include_once("db.inc.php");
	
	if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='forum')
	{
		$comment=addslashes($_POST['comment']);
		$q_id=intval($_POST['q_id']);
		$user_id=$_SESSION['user_id'];
		 $post_date=date('D M j Y h:i A');
		 $sql="insert into forum_answer(q_id,user_id,answer,status,post_date) values ('$q_id','$user_id','$comment','1','$post_date')";
		 
		 $result=mysql_query($sql);
		 $l_id=mysql_insert_id();
		 if(!result)
		 {
		 	echo mysql_error();
		 }
		 else
		 {
		 	$c_query="select * from forum_answer where id=$l_id";
			$c_result=mysql_query($c_query);
			$c_row=mysql_fetch_array($c_result);
			
			$user_query="select * from employee_details where id=".$c_row['user_id'];
	$result_user=mysql_query($user_query);
	$row_user=mysql_fetch_array($result_user);
	
			echo '<div class="grayBorder">';
  			echo'<img src="images/profile/'.$row_user['profile_pic'].'"  alt="" />';
			echo '<div class="left">';
			echo '<form name="commentform" id="commentform" action="" method="post">';
		 if($c_row['user_id']==$_SESSION['user_id']){
			echo '<a href="#" name="delete_comment" id="delete_comment'.$c_row['id'].'" onclick="comment_delete(' .$c_row['id'].',this)"><img src="images/delete.png" style="width:16px; height:16px; float:right;" /></a>'; 
		}
			echo '<h3 style="width:30%;float:left";>'. $row_user['employee_name'].'</h3><strong>' .$c_row['post_date'].'</strong> <div class="clear"></div><br/>';
			echo '<input type="hidden" name="c_id" id="c_id" value="'.$c_row['id'].'">';
			echo '<p>'.$c_row['answer'].'</p></form></div><div class="clear"></div></div>';
			
		 }
		
	}
	
	
	if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='comment')
	{
		//print_r($_POST);
		//$comment=addslashes($_POST['comment']);
		$c_id=intval($_POST['c_id']);
		$user_id=$_SESSION['user_id'];
		 //$post_date=date('Y-m-d');
		 $sql="delete from forum_answer where id='$c_id' and user_id='$user_id'";
		 
		 $result=mysql_query($sql);
		 if(!result)
		 {
		 	echo mysql_error();
		 }
		 else
		 {
		 	echo "deleted";
		 }
		
	}


?>