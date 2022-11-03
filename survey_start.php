<?php 
include 'include/header.php'; 
include 'db.inc.php'; 
?>

<div class="col-md-12">
	<div class="title"><h4>Survey</h4></div>

<?php
$query = "select * from survey_master where status='1' limit 1";
$result = mysql_query($query);
$row = mysql_fetch_array($result);
$surceyAccess = $row['login_required'];
$_SESSION['survey_id'] = $row['id'];
?>

<form class="cmxform" method="post" name="opinion_poll" action="survey.php" autocomplete="off">

<div class='row'>
    <div class="col-md-offset-3 col-md-6">
	    <div class="opresultbox">
			<div class="widget openion">
		        <p><b><?php echo $row['survey_name']; ?></p>
		        <div class="date text-right "><?php echo date("F Y",strtotime($row['post_date']));?></div>    
              
                <div class="date text-left btn_survey"> <?php if($surceyAccess == "Y"){?>
                	<input onclick="window.location.href='login_survey.php'" class="btn btn-default" value="Start Survey with login"> <?php } ?> <input type="submit" class="btn btn-default" value="Start Survey without login">
                </div>
              
		        
          
		    </div>
		</div>  
    </div>
</div>
</form>
</div>

<style type="text/css">
	.btn_survey input{
	padding: 5px;
    font-size: 14px;
    border: 1px solid#ccc;
    cursor: pointer;
    transition: 0.4s auto;}
    .btn_survey{text-align: center;}
    .btn_survey input:hover{background: #ad376b;color: #fff}
	.opresultbox{
	    padding: 15px;
	    margin-bottom: 20px;
	    background-color: #fff;
	}
	.opresultbox .widget.openion p{
		margin-bottom: 5px;
	}
	.radio label{
		padding-left: 0px;
	}
</style>
<?php include 'include/footer.php'; ?>