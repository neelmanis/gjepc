<?php include('header_include.php');?>
<?php include('chk_login.php');?>

<?php include('include/header.php');?>

<?php
	$_SESSION['member_type']="";
	$_SESSION['name']=""; 
	$company_id=$_REQUEST['company_id'];
	$company_name=$_REQUEST['company_name'];
	$member_type=$_REQUEST['m_type'];
	$agent_id=$_SESSION['AGENT_ID'];
	$agent_name=$_SESSION['USERNAME'];
	
		if($member_type=="member")
		{
			$i=0;
			foreach($company_id as $co_id)
			{
				
				$sql="select * from kp_agent_member_link where MEMBER_ID='$co_id' and AGENT_ID='$agent_id'";
				$result=mysqli_query($conn,$sql);
				$cnt=mysqli_num_rows($result);
				if($cnt==0)
				{
					$sqlinsert="insert into kp_agent_member_link (AGENT_ID,MEMBER_ID,STATUS,ENTERED_BY,ENTERED_ON,MODIFIED_BY,MODIFIED_ON) values ('$agent_id','$co_id','22','$agent_name',now(),'$agent_name',now())";
					$result1=mysqli_query($conn,$sqlinsert);
					if(!$result)
						echo mysqli_error();
						
						
					$insert_id[]=$company_name[$i];
				}
				else
				{
					$ninsert_id[]=$company_name[$i];
				}
				$i++;
			}
		}
		elseif($member_type=="nonmember")
		{
			$i=0;
			foreach($company_id as $co_id)
			{
				  $sql="select * from kp_agent_member_link where NON_MEMBER_ID='$co_id' and AGENT_ID='$agent_id'";
					$result=mysqli_query($conn,$sql);
					  $cnt=mysqli_num_rows($result);
					//exit;
					if($cnt==0)
					{
						 $sqlinsert="insert into kp_agent_member_link (AGENT_ID,NON_MEMBER_ID,STATUS,ENTERED_BY,ENTERED_ON,MODIFIED_BY,MODIFIED_ON) values ('$agent_id','$co_id','22','$agent_name',now(),'$agent_name',now())";
						//exit;
						$result1=mysqli_query($conn,$sqlinsert);
						if(!$result)
							echo mysqli_error();
							
							
						$insert_id[]=$company_name[$i];
					}
					else
					{
						$ninsert_id[]=$company_name[$i];
					}
					$i++;
			}
		}
		

?>
<section>
	<div class="banner_wrap mb">
		
		<ul class="d-flex breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li> Kimberley Process </li>
			<li class="active">Add Member</li>
			
		</ul>
		
	</div>
	<div class="container inner_container mb">
		<div class="row">
			<div class="col-12">
				<div class="innerpg_title">
					<h1>Add Member</h1>
				</div>
			</div>
			 

			 <div class="col-12 border">
			 	<div class="row">
			 	<div class="col-12  p-2">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div style="margin-left:30px">
									<strong>Thank You For Adding Member/Non Member in your List. </strong><br> 
								<?php if($insert_id!=""){ ?> You have added the following Members.
								<table width="40%" border="0" cellspacing="1" cellpadding="0" class="detail_txt" style="text-align:center">
								<tr class="orange1">
								<td>COMPANY</td>
								</tr>
								<?php foreach($insert_id as $add_id)
								{?>
								<tr bgcolor="#ededed"><td><?php echo $add_id;?><td></tr>
								<?php } } ?>
								</table><br>
								<?php if($ninsert_id!="")
								{ ?>

								<b style="color:#FF3333">The Following Members are not add in your list.<br>Because this Members is Already Added in the List.</b><br><br>
								<table width="40%" border="0" cellspacing="1" cellpadding="0" class="detail_txt" style="text-align:center">
								<tr class="orange1">
								<td>COMPANY</td>
								</tr>
								<?php

								foreach($ninsert_id as $nadd_id)
								{?>
								<tr bgcolor="#ededed"><td><?php echo $nadd_id;?><td></tr>
								<?php } } ?>
								</table>
								<br>
								<p>The Gem & Jewellery Export Promotion Council <br>
								(KP Import / Export Authority)<br>
								319-A , Dr DB Marg Diamond Plaza, V Floor,<br>
								Mumbai - 400 004 <br>
								Tel: +91-22-23821801<br>
								Fax: +91-22-2380 8752<br>
								Email: sumatiloindia.com, ramdas@gjepcindia.com<br>
								Website:www.gjepc.org</p>
								<br>
								<form name="ok" action="" method="post">
								<input class="input_bg" type="submit" value="OK" name="ok" id="ok" />
								</form>
								<?php if($_REQUEST['ok']=='OK'){

								header("Location: kimberley_process_search_applications.php");
								//header(location:"");
								}
								?>
								</div>
							</div>
						</div>
					</div>
				</div>
			 	</div>
			 </div>
			 
			</div>
		</div>
	</section>
	
	<?php include('include/footer.php');?>
</body>
</html>