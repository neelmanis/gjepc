<?php 
	include 'include/header.php'; 
	include 'db.inc.php';
	include 'functions.php';
?>
<?php
$action=$_REQUEST['action'];
unset($_SESSION['artisan_eligable']);
if($action=="save")
{
	$bp_number=$_REQUEST['bp_number'];
	$query=mysql_query("select * from communication_address_master where c_bp_number='$bp_number' and type_of_address=2");
	$num=mysql_num_rows($query);
	if($num>0){
			$_SESSION['artisan_eligable']=1;
			header('location:artisan_registration.php');
		}
	else{
			unset($_SESSION['artisan_eligable']);
			$_SESSION['err_msg']="Sorry Entered Membership Number is incorrect.";
		}
}
?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript">
$().ready(function() {
	$("#regisForm").validate({
		rules: {  
			bp_number: {
				required: true,
			},  
		},
		messages: {
			bp_number: {
				required: "Membership Number is Required",
			}
	 }
	});
});
</script>
    <div class="col-xs-12 wrapper di_reg">
      <div class="title">
        <h4>Best Product Inventory at Signature IIJS 2019</h4>
      </div>
      <div class="content">
        <div class="di_reg_form">
          <div class="di_subtitle">
            <h5>Check Your Eligibility </h5>
          </div>
			<?php 
            if($_SESSION['err_msg']!=""){
            echo "<span style='color: red;'>".$_SESSION['err_msg']."</span>";
            $_SESSION['err_msg']="";
            }
            ?>	
          <form class="cmxform row" method="post" name="regisForm" id="regisForm" autocomplete="off">
            <input type="hidden" name="action" value="save" />
            <div class="col-xs-12 col-md-4 form-group">
              <input type="text" class="input_style" name="bp_number" id="bp_number" placeholder="Enter Your Membership Number"/>
              (Ex: 70000******)
            </div>
            <div class="col-xs-12 col-md-12 form-group">
              <button class="submit" id="submit"> Submit</button>
            </div>
            <div class="clear"></div>
          </form>
          
        </div>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="row mainRow">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="upcomingEvents">
            <div class="title">
              <h4>Upcoming Events</h4>
            </div>
            <?php include 'include/eventsslider.php'; ?>
          </div>
        </div>
      </div>
    </div>
    <?php include 'include/footer.php'; ?>
<style>
.di_reg .title {
	margin-bottom:25px;
}
.di_reg_form {
	background:#fff;
	width:100%;
	padding:15px;
}
.di_subtitle {
	padding-bottom:15px;
	border-bottom:1px solid #ddd;
	margin-bottom:15px;
}
.di_subtitle h5 {
	font-size:18px;
}
.di_reg_form .input_style {
	width:100%;
	padding:5px;
	border:1px solid #ddd;
}
.di_reg_form label {
	width:100%;
	font-size:16px;
}
.di_reg_form textarea {
	height:100px;
}
.di_reg_form button.submit {
	background:#000;
	color:#fff;
	padding:10px 15px;
	border:0;
}
.di_reg_form span {
	font-size:11px;
	font-style:italic;
}
.rwd-table {
	margin: 1em 0;
	min-width: 300px;
}
.rwd-table tr {
	border-top: 1px solid #ddd;
	border-bottom: 1px solid #ddd;
}
.rwd-table th {
	display: none;
}
.rwd-table td {
	display: block;
}
.rwd-table td:first-child {
	padding-top: 0.5em;
}
.rwd-table td:last-child {
	padding-bottom: 0.5em;
}
.rwd-table td:before {
	content: attr(data-th) ": ";
	font-weight: bold;
	width: 6.5em;
	display: inline-block;
}
@media (min-width: 600px) {
 .rwd-table td:before {
 display: none;
}
}
.rwd-table th, .rwd-table td {
	text-align: left;
}
@media (min-width: 600px) {
 .rwd-table th,  .rwd-table td {
 display: table-cell;
 padding: 0.25em 0.5em;
 text-align:center;
}
 .rwd-table th:first-child,  .rwd-table td:first-child {
 padding-left: 0;
}
 .rwd-table th:last-child,  .rwd-table td:last-child {
 padding-right: 0;
}
}
.rwd-table {
	overflow: hidden;
	width:100%;
}
.rwd-table tr {
	border-color: #ddd;
}
.rwd-table th, .rwd-table td {
	margin: 0.5em 1em;
}
@media (min-width: 600px) {
 .rwd-table th,  .rwd-table td {
 padding: 1em !important;
}
 .rwd-table th, .rwd-table td:before {
background:#ddd;
}
}
.di_reg_form .radio_style {
	width:auto;
	display:inline-block;
}
.radio_group label {
	display:inline-block;
	width:auto;
	margin:0 10px;
	font-size:14px;
}
</style>
