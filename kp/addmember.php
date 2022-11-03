<?php include('header_include.php');?>
<?php include('chk_login.php');?>
<?php
if($_REQUEST['Close']=="Close")
{
	$_SESSION['member_no']="";
	$_SESSION['name']="";
header("Location: kimberley_process_search_applications.php");
}else if($_REQUEST['action']=="search")
{
$action=$_REQUEST['action'];
$_SESSION['member_no']=$_REQUEST['member_type'];
$_SESSION['name']=$_REQUEST['name'];
if($action=='search')
{
	if($_SESSION['agent_id']=="")
	{
	$_SESSION['error_msg']="Please select Agent Name";
	}
	
	if($_SESSION['member_no']=="")
	{
	$_SESSION['error_msg1']="Please select Member Type";
	}
	
}
}
?>
<?php include('include/header.php');?>
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
				<form name="search" action="" method="post" >
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="star">Type Member</label>
								<select  class="form-control" name="member_type" id="member_type">
									<option selected="selected" value="">--Select--</option>`
									<?php
										$sql="select * from  kp_lookup_details where LOOKUP_ID='7'";
										$result=mysqli_query($conn,$sql);
										while($rows=mysqli_fetch_array($result))
										{
									?>
									 <option <?php if($rows['LOOKUP_VALUE_ID']==$_SESSION['member_no']){?> selected='selected'<?php }?> value=<?php echo $rows[LOOKUP_VALUE_ID];?>>
										<?php echo $rows['LOOKUP_VALUE_NAME'];?>
									 </option>
										
									<?php } ?>
								</select>
								<input type="hidden" name="action" value="search" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="star">
									Name ( First 3 letters ) :
								</label>
								<input type="text" name="name" id="name" value="<?php echo $_SESSION['name']; ?>" class="form-control"/>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<input class="d-inline-block cta mr-3" type="submit" value="Find" name="find" id="find" />
								<input class="d-inline-block btn btn-secondary" type="submit" value="Close" name="Close" id="Close" />
								
							</div>
						</div>
						
					</div>
				</form>
			</div>
			<div class="col-12 p-2">
				
				<form name="confirm" action="confirmation_member_add.php" method="post">
					<?php if($_REQUEST['add']=='Add') {
					$co_id=$_REQUEST['check_name'];
					if(isset($co_id)){
					?>
					<input type="hidden" name="m_type" value="<?php echo $_REQUEST['type']; ?>">
					<table>
						<tr class="orange1"  >
							<td width="50%" style="padding:3px;"><strong>Company Name</strong></td>
							<td width="50%" style="padding:3px;"><strong>IEC NO</strong></td></tr>
							<?php
							foreach($co_id as $val)
							{
								$co_name=explode("-",$val);
							//	print_r($co_name); exit;
								//echo $co_name[1];
							?>
							<tr bgcolor="#ededed">
								<td style="padding:3px"><?php echo $co_name[1];?></td>
								<td style="padding:3px"><?php echo $co_name[2];?>
								<input type="hidden" name="company_id[]" id="company_id" value="<?php echo $co_name[0];?>">
								<input type="hidden" name="company_name[]" id="company_name" value="<?php echo $co_name[1];?>"></td>
							</tr>
						<?php }?></table>
						<br>
						<div class="search_app_div">
							<div class="search_app_text1"></div>
							<div style="float:left; margin-bottom:4px;"><input class="cta mr-3 d-inline-block" type="submit" value="Submit" name="submit" id="submit" /></div>
							<div style="float:left; margin-bottom:4px;"><input class="btn btn-secondary d-inline-block" type="button" value="Close" name="Close" id="Close" /></div>
						</div>
						<?php } }?>
					</form>
					
				</div>
				<div class="col-12 p-2">
					<?php if($_REQUEST['find']=='Find' && $_SESSION['member_no']!="" && $_REQUEST['name']!="") { ?>
					
					<form name="form1" action="" method="POST" >
						
						<table>
							<tr>								
								<td ><strong>Company Name</strong></td>
								<td ><strong>Address</strong></td>
								<td ><strong>IEC No</strong></td>
								<td ><strong></strong></td>
							</tr>
							<?php
							$member_type=intval($_SESSION['member_no']);
							$name= $_REQUEST['name'];
							if(isset($member_type) && $member_type=='18')
							{
								$sql="SELECT * FROM `kp_member_master` WHERE MEMBER_CO_NAME like '$name%'";
							}
							else
							{
								$sql="SELECT * FROM `kp_non_member_master` WHERE NON_MEMBER_NAME like '$name%'";
							}
							
							$result=mysqli_query($conn,$sql);
							$rCount=mysqli_num_rows($result);
							if($rCount>0)
							{
							while($rows=mysqli_fetch_array($result))
							{
							?>
							
							<tr>								
								<?php if($member_type=='18') {?>								
								<td ><?php  echo $rows['MEMBER_CO_NAME'];?></td>
								<td ><?php echo $rows['MEMBER_ADDRESS1']." ".$rows['MEMBER_ADDRESS2']." ".$rows['MEMBER_ADDRESS3'];?></td>
								<td ><?php echo $rows['IEC_NO'];?></td>
								<td ><input type="checkbox" name="check_name[]" id="check_name" value="<?php  echo $rows['MEMBER_ID']."-".$rows['MEMBER_CO_NAME']."-".$rows['IEC_NO'];?>"></td>								
								<?php }elseif($member_type=='19' || $member_type!=18){ ?>								
								<td><?php echo $rows['NON_MEMBER_NAME'];?></td>
								<td><?php echo $rows['ADDRESS1']." ".$rows['ADDRESS2']." ".$rows['ADDRESS3'];?></td>
								<td><?php echo $rows['IEC_NO'];?></td>
								<td><input type="checkbox" name="check_name[]" id="check_name" value="<?php echo $rows['NON_MEMBER_ID']."-".$rows['NON_MEMBER_NAME']."-".$rows['IEC_NO'];?>"></td>
								<?php } ?>
							</tr>
							<?php
							}							
							}
							else
							{
							?>
							<tr>
								<td colspan="4" style="padding:3px;">Records Not Found</td>
							</tr>							
							<?php } ?>							
						</table>
						<br>
						<?php if($rCount>0){ ?>
						<input type="hidden" name="type" value="<?php if($member_type=='18'){ echo "member";}else{ echo "nonmember"; } ?>">
						<input class="cta d-inline-block" type="submit" value="Add" name="add" id="add" />
						<input class="btn btn-secondary d-inline-block" type="submit" value="Cancel" name="cancel" />
						<?php } ?>
					</form>					
					<?php } ?>
				</div>
			 	</div>
			 </div>	
			</div>
		</div>
	</section>
	
	<?php include('include/footer.php');?>
	<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
		$("#Close").click(function(){
		//alert(11);
			//window.location.href="kimberley_process_search_applications.php";
		});
		$("#add").click(function(){
		//alert(11);
			//window.location.href='kimberley_process_search_applications.php';
		});
	});
	</script>
</body>
</html>