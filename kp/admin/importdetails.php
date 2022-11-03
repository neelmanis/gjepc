<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php //echo"<pre>";print_r($_POST);exit;?>
<?php
			 
        $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
        $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
        $attach = " order by ".$order_by." ".$asc_desc." ";
        $i=1;
		
		$kpno=$_POST['kpno'];
		$import = $_POST['importname'];
		$export = $_POST['exportname'];
		$applicationtype=$_POST['applicationtype'];
		
		$sql="SELECT * FROM kp_admin_erpweb where applicationtype='$applicationtype'";
	

		 if($applicationtype =='Import')
		 {
		 $sql.=" and importername LIKE '%$import%' and exportername Like '%$export%' and kpno='$kpno'";	
		 }
		  if($applicationtype =='Export')
		 {
		    
	    $sql.=" and importername LIKE '%$import%' and exportername Like '%$export%' and kpno='$kpno'";	
			
		 }
		//echo $sql;
        $result = mysql_query($sql);
        $rCount=0;
        $rCount = @mysql_num_rows($result);	
if($rCount>0)
{  ?>

<table id='example' width="100%">
  <thead>
    <tr class='orange1'>
      <th >kp No.</th>
      <th >Carat</th>
      <th >Amount</th>
      <th >Foreign Party</th>
      <th >Indian Party</th>
      <th >country</th>
      <th>Region</th>
      <th>Application type</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	while($row = mysql_fetch_array($result))
        {
	
      ?>
    <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
      <td><?php echo $row['kpno']; ?></td>
      <td><?php echo $row['carat']; ?></td>
      <td><?php echo $row['amount']; ?></td>
      <td><?php echo $row['importername']; ?></td>
      <td><?php echo $row['exportername']; ?></td>
      <td><?php echo $row['country']; ?></td>
      <td><?php echo $row['region']; ?></td>
      <td><?php echo $row['applicationtype']; ?></td>
      <td><a href="import_export_view.php?action=viewdetail&&erp_id=<?php echo $row['id'];?>">view details</a></td>
    </tr>
    <?php $i++;}?>
  </tbody>
</table>
<?php }
else
echo "No records found...";	
?>
