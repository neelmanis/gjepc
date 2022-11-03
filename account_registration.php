<?php include 'include/header.php'; ?>

<div class="col-xs-12">
	
	<div class="title">
		<h4>New User Registration</h4>
	</div>

	<div class="sub_head minibuffer">Do you any one of the following</div>
	
	<form id="regType">
		<div class="form-group radio">
			<label for="IEC"><input type="radio" id="IEC" value="IEC Number" name="regoptions">IEC Number (Only for renewal of membership)</label>
		</div>
		<div class="form-group radio">
			<label for="uin"><input type="radio" id="uin" value="UIN Number" name="regoptions">Unique Identification Number (Only for International Visitors)</label>
		</div>
		<div class="form-group radio">
			<label for="excode"><input type="radio" id="excode" value="Exhibitor Code" name="regoptions">Exhibitor Code</label>
		</div>
		<div class="form-group radio">
			<label for="none"><input type="radio" id="none" value="none1" name="regoptions">None of the above</label>
		</div>
		<div class="form-group" id="refNum">
			<label id="refnumlabel" for="refNum">IEC No : </label> <input type="text" id="renum" name="regoptions">
		</div>
		<button type="submit" id="registration_submit" class="btn btn-default">Proceed to registration</button>
	</form>

</div>

<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="sub_head minibuffer">
		Notes
	</div>
	<div class="ab_description">
		
		<ul>
			<li>
				<strong>Last Year Renewal :</strong> If you were GJEPC member for last financial year and coming for renewal please select above radio button as IEC Number.
			</li>
			<li>
				<strong>Members prior to year 2010</strong> If you were GJEPC member any of the past years and coming after a gap of few years please select above radio button as IEC Number.
			</li>
			<li>
				<strong>First Time applicants</strong> If you are applying for GJEPC membership for the FIRST TIME please select above radio button as None of above.
			</li>
		</ul>
	
	</div>     	
</div>

<?php include 'include/footer.php'; ?>
	
<script type="text/javascript">

 jQuery(document).ready(function($) {
 	jQuery("#refNum").slideUp();
 	
 });
 		var selection = '';
     jQuery('input:radio[name=regoptions]').change(function(event) {
     	if (this.value=="IEC Number" || this.value=="UIN Number" || this.value=="Exhibitor Code" ) {
     		jQuery("#refnumlabel").text(this.value)
     		jQuery("#refNum").slideDown();
     		selection = this.value;
     	}else if (this.value=="none1") {
     		jQuery("#refNum").slideUp();
     		selection = this.value;
     	};;
     });

     jQuery("#registration_submit").click(function(event) {
     	
     	if (selection == "") {
     		event.preventDefault();
     		alert("Please Select Type");
     	}
     	else if (selection != 'none1' && jQuery("#renum").val()=="") {
     		event.preventDefault();
     		alert("Please Enter Code");
     	}
     	else if(selection == "none1"){
     		event.preventDefault();
     		window.location.href = '/new_user_registration.php';
     	};
     });


</script>


<style>
.radio {display:inline-block; margin:0 10px 0 0;}
.btn {display:block; margin-top:10px;}
.ab_description {font-style:italic; border-left:3px solid #77479b;}
.ab_description ul li {margin-bottom:10px;}

#refNum {padding:15px 0 15px 0!important;}
#refnumlabel {margin-right:10px;}

.btn-default {font-size:14px; cursor:pointer!important; background:#77479b; color:#fff; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}
.btn-default:hover {background:#000; transition:all 0.3s ease-in-out; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; -o-transition:all 0.3s ease-in-out;}

#renum {padding:5px 8px; font-size:13px;}
</style>