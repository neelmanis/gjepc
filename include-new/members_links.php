<script language="javascript">
function first_alert()
{
	alert("Only Registered Members can access the Link. \n Please Login First");
}
</script>
<ul class="reltdLinks">
    <!--<li><a href="total_members.php">Total Members</a>-->
    <li><a href="region_wise_panel_wise_members_during_2018-19.php">Region-wise & Panel-wise Members During 2018-19</a></li>
    <li><a href="#" class="show_hide sub_link">Member information</a>
    	<div class="slidingDiv">
        	<!--<a href="#" class="show_hide">hide</a>-->
			<?php if(!isset($_SESSION['USERID'])) { ?>
            <a href="javascript: void(0)" onclick = "first_alert()">Members Directory</a>
			<?php }	else { ?>
			 <a href="members_directory.php">Members Directory</a>
			<?php } ?>
            <a href="apply_for_membership.php">Apply for Membership</a>
			<?php if(!isset($_SESSION['USERID'])) { ?>
            <a href="javascript: void(0)" onclick = "first_alert()">Marketing Development Assistance</a>
            <a href="javascript: void(0)" onclick = "first_alert()">Membership Renewal</a>
			<?php }	else {?>
			<a href="marketing_development_asst.php">Marketing Development Assistance</a>
            <a href="images/pdf/rcmc.pdf" target="_blank">Membership Renewal</a>
			<?php }?>
        </div>
    </li>
    <li><a href="kimberley_process.php">Kimberley Process</a></li>
    <li><a href="#" class="show_hide sub_link">Trade Information</a>
    	<div class="slidingDiv">
            <a href="circulars_and_notifications.php">Circulars & Notifications</a>
            <a href="exhibition_permission.php">Exhibition Permission</a>
<!--            <a href="policy_and_handbook.php">Policy & Handbook</a>-->
            <a href="union_budget.php">Union Budget</a>
            <a href="related_links.php">Related Links</a>
            <a href="miscellaneous_information.php">Miscellaneous Information</a>
            <a href="archives_list.php">Archive List</a>
        </div>
    </li>
	 <li><a href="#" class="show_hide sub_link">Policy</a>
        <div class="slidingDiv">
            <a href="policy_and_handbook.php">Policy & Handbook</a>
        </div>
    </li>


    <li><a href="sdb.php">SDB Diamond Bourse Surat</a></li>
    <li><a href="#" class="show_hide sub_link">For Members Only</a>
    	<div class="slidingDiv">
			<?php if(!isset($_SESSION['USERID'])) { ?>
            <a href="javascript: void(0)" onclick = "first_alert()">Election for COA</a>
			<a href="javascript: void(0)" onclick = "first_alert()">Visa Recommendation</a>
            <a href="javascript: void(0)" onclick = "first_alert()">Circulars for Members</a>
			
			<?php } else {?>
			<a href="election_coa.php">Election for COA</a>
			<a href="pdf/Visa_Format.pdf" target="_blank">Visa Recommendation</a>
            <a href="circulars_to_members.php">Circulars for Members</a>
			
			<?php } ?>
        </div>
    </li>
    <li><a href="micro_small_and_medium_enterprises_sector.php">Micro Small and Medium Enterprises Sector</a></li>
</ul>
