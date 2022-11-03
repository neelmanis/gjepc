<?php 
include 'include-new/header.php';
include 'db.inc.php';
?>
<?php
$id = filter($_REQUEST['id']);
$sql="select * from `seminar_calendar` WHERE status='1' and id='$id'";
$result = $conn ->query($sql);
$num = $result->num_rows;
if($num > 0)
{
$rows = $result->fetch_assoc();
} else {
	echo "Something Wrong";
}
// print_r($rows);
?>

<section class="py-5">
    <div class="row mb">
        <div class="col-12">
            	<div class="innerpg_title">
                	<h1>Seminar Update</h1>
                </div>
            </div>
        
<div class="col-12"><p class="blue text-center mb-3">GJEPC Awareness Campaign Seminars - 2018-19</p></div>

<div class="col-12">
<?php 
if($rows['images']!=''){ ?>
<div class="poster float-none m-auto" style="max-width:700px;"><img src="admin/calendar/<?php echo $rows['images'];?>" class="img-fluid d-block"></div>
<?php } else { ?>
<div class="d-table m-auto"> <img src="admin/calendar/logo_gjepc.png"></div></td>
<?php } ?>
</td></tr>
<?php 
$currentDate = date('Y-m-d'); // Current Date
$endDate = date("Y-m-d",strtotime($rows['end']));
?>
<table>
	<thead>
		<tr><th colspan="2"><?php echo filter($rows['title']);?></th></tr>
	</thead>
    <tbody>
		<tr>
            <td><?php echo $rows['full_description'];?></td>
		</tr>
		<?php if($rows['pdf']!="") { ?>
				<tr>
                	<td>
                    	<strong>View Details : </strong> <a href="admin/calendar/<?php echo $rows['pdf'];?>" target="_blank">
                        <strong>Post Event Update</strong>
                    </a></td>
                </tr> 
				<?php } ?>
     </tbody>       
</table>            

		<div class="reg_wrp">
			 <?php
			 if($currentDate < $endDate) { ?>
			 <a href="seminar_registration.php?id=<?php echo $id;?>" class="cta">Registration </a> <?php } ?> &nbsp;
			 <a href="seminar.php" class="cta">Back </a></div>	
</div>
</div>
</div>

<?php include 'include-new/footer_stats.php'; ?>