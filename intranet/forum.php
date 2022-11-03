<?php 
session_start();
ob_start();
include_once('db.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC :: Intranet</title>
<link rel="stylesheet" type="text/css" href="css/mystyle.css" />
<link rel="stylesheet" href="css/liteaccordion.css">
<!-- Add jQuery library -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>

   <script>
$(document).ready(function(){
	var str=location.href.toLowerCase();
	$(".nav li a").each(function() {
		if (str.indexOf(this.href.toLowerCase()) > -1) {
				$("li").removeClass("active");
				$(this).parent().addClass("active");
		}
	});
	
	$('#forum_submit').click(function(){
	
			//alert($(this).parent().siblings().next('.personalComments').attr('id'));
			var id=$(this).attr('id');
			if($("#comment").val()=="")
			{
				alert("Please Enter Comment ");
				return false;
				
			}
			else
			{
			
			var forum_data=$("#forum_form").serialize();
			//alert(forum_data);
			$.ajax({ type: 'POST',
					url: 'myajax.php',
					data: "actiontype=forum&"+forum_data,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					$("#comment").val('');
					//$()
					$('#'+id).parent().siblings('.personalComments').prepend(data);
					//alert($('.personalComments').html());
					//console.log($('#'+id).parent().siblings('.personalComments').prepend(data));
					
					
					
					//$(location).attr('href','forum.php');
					}
		});
	
	}
	
	});
	
	
	/*$('#delete_comment').click(function(){
			//var ans=window.confirm('Are you sure you want to Delete.');
			
			//if(ans==true)
			//{
			var forum_data=$("#commentform").serialize();
			//alert(forum_data);
			$.ajax({ type: 'POST',
					url: 'myajax.php',
					data: "actiontype=comment&"+forum_data,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					
					$(location).attr('href','forum.php');
					}
		});
	
	//}
	
	});*/
});

function comment_delete(id,idd)
{
	var ans=window.confirm('Are you sure you want to Delete.');
	if(ans==true)
	{
		//alert($(idd).attr('id'));
		var c_id=$(idd).attr('id');
		
		
	$.ajax({ type: 'POST',
					url: 'myajax.php',
					data: "actiontype=comment&c_id="+id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					//alert(data);
					//alert(data);
					if(data=='deleted')
					{
						$('#'+c_id).parent().parent().parent().hide(500,function(){
							$('#'+c_id).parent().parent().parent().remove();
						});
						$('#'+c_id).parent().parent().parent().hide(500,function(){
							$('#'+c_id).parent().parent().parent().remove();
						});
					
					}else
					{
						alert(data);
					}
					//$(location).attr('href','forum.php');
					}
		});
	}
}
</script>

</head>

<body>

<?php include 'include/header.php';?>



<!------------------------------------------- container starts -------------------------------------->
<div class="container_wrap">
	

<div class="wrapper">

<div class="heading">Forum</div>
<?php $sql_forum="select * from forum_master where 1 limit 1";
	$result_forum=mysql_query($sql_forum);
	$row_forum=mysql_fetch_array($result_forum);

 ?>

<div class="forumHeading">

Give your views on Question.<br/><br/>
<?php echo $row_forum['q_name'];?>


</div>
<form name="forum_form" id="forum_form" action="" method="post">
<textarea name="comment" id="comment" cols="" rows="" class="comments"></textarea>

<input type="hidden" name="q_id" id="q_id" value="<?php echo $row_forum['id'];?>">
<input type="button" name="forum_submit" id="forum_submit" class="submitBtn" value="submit" />

</form>

<h2>Comments</h2>

<div class="personalComments" id="accomment">

<?php $comment_query="select * from forum_answer where q_id=".$row_forum['id']." and status='1' order by id desc";
	$result_cquery=mysql_query($comment_query);
	while($row_comment=mysql_fetch_array($result_cquery))
	{
		
	$user_query="select * from employee_details where id=".$row_comment['user_id'];
	$result_user=mysql_query($user_query);
	$row_user=mysql_fetch_array($result_user);
	

?>
<div class="grayBorder">
  <img src="images/profile/<?php echo $row_user['profile_pic'];?>"  alt="" />
  

<div class="left">
<form name="commentform" id="commentform" action="" method="post">
<?php if($row_comment['user_id']==$_SESSION['user_id']){?>
<a href="#" name="delete_comment" id="delete_comment<?php echo $row_comment['id'];?>" onclick="comment_delete(<?php echo $row_comment['id'];?>,this)"><img src="images/delete.png" style="width:16px; height:16px; float:right;" /></a><?php } ?>
<h3 style="width:30%;float:left";><?php echo $row_user['employee_name'];?></h3><strong><?php echo $row_comment['post_date'];?></strong> <div class="clear"></div><br/>


<input type="hidden" name="c_id" id="c_id" value="<?php echo $row_comment['id'];?>">
<p><?php echo $row_comment['answer']; ?></p>
</form>

</div>
  
  
  <div class="clear"></div>
  
  </div>
  <?php } ?>

    
  
  
  </div>





</div>  
    

    
    
    
    
    
    
    
    
    

    
</div>
<!------------------------------------------- container ends -------------------------------------->

<!------------------------------------------- footer starts  -------------------------------------->

<!------------------------------------------- footer ends  -------------------------------------->


<?php include 'include/footer.php';?>



</body>
</html>
