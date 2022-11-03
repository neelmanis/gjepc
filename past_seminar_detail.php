<?php 
include 'include-new/header.php';
include 'db.inc.php';
?>
<?php
$id = base64_decode(filter($_REQUEST['id']));
if($id !=''){
$sql="select * from `seminar_calendar` WHERE status='1' and id='$id'";
$result = $conn ->query($sql);
$num = $result->num_rows;
if($num > 0)
{
$rows = $result->fetch_assoc();
} else {
	echo "Something Wrong";
}
}
?>

<style>
.topic_wrpp {
    margin: 20px 0;
    background: #fff;
    width: 80%;
}

.topic_wrpp td {
    padding: 10px;
    border: 1px solid #822a66;
    /* width: 7%; */
    line-height: 25px;
    font-size: 15px;
}

.no-print {
    height:40px;
	float: right;
    padding: 10px 15px;    
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    border: solid 1px #20538D;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.4);
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
}
</style>
<section>
<div class="container py-5">
    
    <div class="row justify-content-center">

        <div class="col-12 bold_font text-center d-block"> <div class="d-block"><img src="assets/images/gold_star.png"></div> Seminar Update </div>
    		
        <div class="col-12"><p class="blue text-center mb-3">GJEPC Awareness Campaign Seminars</p></div>
        
        <div class="col-md-8 box-shadow">

             <?php 
                if($rows['images']!=''){ ?>
                <div class="poster float-none m-auto" style="max-width:700px;"> 
                    <img src="admin/calendar/<?php echo $rows['images'];?>" class="img-fluid d-block">
                </div>
                <?php } else { ?>
                <div class="d-table m-auto"><img src="assets/images/logo.png"></div>
            <?php } ?>

            <table class="table">

                <thead>
                    <tr><th colspan="2"><?php echo $rows['title'];?></th></tr>
                </thead>    
                
                <tbody>

                    <tr>
                        <td><?php echo $rows['full_description'];?></td>
                    </tr>
                
                    <?php if($rows['pdf']!="") { ?>
                        <tr>
                            <td><strong>View Details : </strong><a href="admin/calendar/<?php echo $rows['pdf'];?>" target="_blank"><strong>Post Event Updates</strong></a></strong></td>
                            <!-- <td width="70"><a href="admin/calendar/<?php echo $rows['pdf'];?>" target="_blank"><strong>VIEW</strong></a></td> -->
                        </tr> 
                    <?php } ?>              
                </tbody>                
            </table>   

            <div class="reg_wrp"> <a href="seminar.php" class="cta">Back </a></div> 

        </div>

    </div>

</div>


</section>

<?php include 'include-new/footer.php'; ?>