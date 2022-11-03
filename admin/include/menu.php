<?php
if($_SESSION['curruser_login_id']=="" || $_SESSION['curruser_email_id']=="")
{  
    echo"<meta http-equiv=refresh content=\"0;url=index.php\">"; exit;
}
?>
<?php 
 $url = $_SERVER['PHP_SELF'];
#for Local
//$attach = "/gjepc/admin/";
#for Live
$attach = "/admin/";
?>

<div id="smoothmenu1" class="ddsmoothmenu">
<ul> 
<?php
if($_SESSION['curruser_role']=="Super Admin"){ ?>               
    <li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
    <li style="background:none;"> | </li>
    <li><a href="#"  <?php if(($url == $attach.'manage_export_amount.php') || ($url == $attach.'committee_administration_category.php') || ($url == $attach.'pm_bd_sub_committee_category.php') || ($url == $attach.'ideal_cut_newsletter_category.php') || ($url == $attach.'circulars_category.php') || ($url == $attach.'circulars_to_member_category.php')  || ($url == $attach.'notifications_category.php') || ($url == $attach.'policy_handbook_category.php') ||($url == $attach.'union_budget_category.php') ||($url == $attach.'statistics_export_category.php') || ($url == $attach.'statistics_import_category.php')  || ($url == $attach.'renewal_deadline.php'))  { ?> class="selected" <?php } ?> >Master</a>
         <ul class="terms">
            <li><a href="manage_export_amount.php?action=view">Export Amount Master</a></li>
            <li><a href="import_export_quarter_year_master.php?action=view">Export Import Quarter Year Master</a></li>
            <li><a href="import_export_master.php?action=view">Import Export HSCODE Master(Quarterly Returns)</a></li>
            <li><a href="import_export_admin_list.php?action=view">Import Export Details </a></li>
            <li><a href="import_export_statistics.php?action=view">Manage Statistics Import/Export Report</a></li>          
            <li><a href="committee_administration_category.php?action=view">Committee Administration Category</a></li>
            <li><a href="pm_bd_sub_committee_category.php?action=view">PM & BD Sub-Committee Category</a></li>
            <li><a href="ideal_cut_newsletter_category.php?action=view">Ideal Cut Newsletter Category</a></li>
            <li><a href="circulars_category.php?action=view">Circulars Category</a></li>
            <li><a href="circulars_to_member_category.php?action=view">Circulars To Member Category</a></li>
            <li><a href="notifications_category.php?action=view">Notifications Category</a></li>
            <li><a href="policy_handbook_category.php?action=view">Policy & Handbook Category</a></li>
            <li><a href="union_budget_category.php?action=view">Union Budget Category</a></li>
            <li><a href="statistics_export_category.php?action=view">Statistics Export Category</a></li>
            <li><a href="statistics_import_category.php?action=view">Statistics Import Category</a></li>
            <li><a href="renewal_deadline.php?action=view">Renewal Deadline</a></li>
        </ul>
    </li>

    <li style="background:none;"> | </li>
    <li><a href="#">Manage Membership Registration</a>
    <ul class="terms">
        <li><a href="manage_registration.php?action=view" <?php if($url == $attach.'manage_registration.php') { ?> class="selected" <?php } ?>>Company Registration</a></li>
        <li><a href="membership.php?action=view" <?php if($url == $attach.'membership.php') { ?> class="selected" <?php } ?>>Current FY Membership</a></li>
		<li><a href="membership-FY2021-22.php?action=view" <?php if($url == $attach.'membership-FY2021-22.php') { ?> class="selected" <?php } ?>>Membership FY21-22</a></li>
        <li><a href="membership-FY2020-21.php?action=view" <?php if($url == $attach.'membership-FY2020-21.php') { ?> class="selected" <?php } ?>>Membership FY20-21</a></li>
        <li><a href="manage_history_certificate.php?action=view">Manage 5 years certificate</a></li>
        <li><a href="manage_update_panel.php?action=view" <?php if($url == $attach.'manage_update_panel.php') { ?> class="selected" <?php } ?>>Update Membership Panel</a></li>
        <li><a href="manage_trade_permission.php?action=view" <?php if($url == $attach.'manage_trade_permission.php') { ?> class="selected" <?php } ?>>Trade Permission</a></li>
        <li><a href="signature_authority.php?action=view" <?php if($url == $attach.'signature_authority.php') { ?> class="selected" <?php } ?>>Signature Authority</a></li>
        <li><a href="manage-parichay-card.php?action=view">Manage Parichay Card</a>
        <li><a href="manage_outstanding.php?action=view">Outstanding Report</a></li>
        <li><a href="/dataport/index.php" target="_blank">Dataport</a></li>
        <li><a href="iec-search.php" target="_blank">Search IEC</a></li>
    </ul>

<li style="background:none;"> | </li>
<li><a href="manage_roi_forms.php?action=view" <?php if($url == $attach.'manage_roi_forms.php')  { ?> class="selected" <?php } ?>>Manage ROI Forms</a></li>
     
<li style="background:none;"> | </li>
<li><a href="#">CMS</a>
   
   <ul class="terms">
    <li><a href="committee_administration.php?action=view">Committee Administration</a></li>
    <li><a href="pm_bd_sub_committee.php?action=view">PM & BD Sub-Committee</a></li>
    <li><a href="ideal_cut_newsletter.php?action=view">Ideal Cut Newsletter</a></li>
    <li><a href="tender.php?action=view">Tender</a></li>
    <li><a href="applied_tender_list.php?action=view">Applied Tenders List</a></li>
    <li><a href="newsletter_upload.php?action=view">Newsletter</a></li>
    <li><a href="https://gjepc.org/admin/news_ticker.php?action=view">News Ticker</a></li>
    <li><a href="https://gjepc.org/admin/brochure.php?action=view">Manage Brochure</a></li>
    <li><a href="epatrika_upload.php?action=view">e-Patrika</a></li>
    <li><a href="seminars.php?action=view">Seminars</a></li>
    <li><a href="kimberly_info_english.php?action=view">Kimberly Info English</a></li>
    <li><a href="kimberly_info_hindi.php?action=view">Kimberly Info Hindi</a></li>
    <li><a href="circulars.php?action=view">GJEPC Circulars</a></li>
    <li><a href="circulars_to_member.php?action=view">Govt. Circulars</a></li>
    <li><a href="exhibition_permission.php?action=view">Exhibition Permission</a></li>
    <li><a href="notifications.php?action=view">Notifications</a></li>
    <li><a href="policy_handbook.php?action=view">Policy & Handbook</a></li>
    <li><a href="union_budget.php?action=view">Union Budget</a></li>
    <li><a href="statistics_export.php?action=view">Statistics Export</a></li>
    <li><a href="statistics_import.php?action=view">Statistics Import</a></li>
    <li><a href="trade_information.php?action=view">Trade Information</a></li>
    <li><a href="trade_news.php?action=view">Trade News</a></li>
    <li><a href="news.php?action=view">News</a></li>
    <li><a href="trade_show.php?action=view">Trade Show</a></li>
    <li><a href="press_release.php?action=view">Press Release</a></li>
    <li><a href="careers.php?action=view">Careers</a></li>
    <li><a href="marketing_development_assistance.php?action=view">Marketing Development Assistance</a></li>
    <li><a href="gold_rate.php?action=view">Gold Rate</a></li>
    <li><a href="election_for_coa.php?action=view">Election For COA</a></li>
    <li><a href="whats_new.php?action=view">Whats New</a></li>
    <li><a href="manage_annual_report.php?action=view">Manage Annual Report</a></li>
    <li><a href="current_market_rate.php?action=view">Current Market Rate</a></li>
    <li><a href="manage_polls.php?action=view">Manage Polls</a></li>
	<li><a href="manage_equitable_polls.php?action=view">Manage Equitable Survey</a></li>
    <li><a href="trade_exhibition_master.php?action=view">Manage Exhibitions Master</a></li>
    <li><a href="msme.php?action=view">Manage MSME Master</a></li>
    <li><a href="gjepc_article.php?action=view">Manage Articles</a></li>
    <li><a href="seminar_calendar.php?action=view">Manage Calendar</a></li>
    <li><a href="webinar.php?action=view">Manage Webinar</a></li>
    <?php if($_SESSION['curruser_login_id']=='1') { ?>     
    <li><a href="manage_banner.php?action=view" <?php if($url == $attach.'manage_banner.php') { ?> class="selected" <?php } ?>>Manage Banner</a></li>
    <?php } ?>

    </ul>
</li>

<li style="background:none;"> | </li>
<li><a href="#">PMBD</a>
 <ul class="terms">
    <li><a href="https://gjepc.org/admin/promo-video-orders.php?action=view">Promo Video Orders  </a></li> 
    <li><a href="relief-aid.php?action=view">Manage Relief Aid</a>
    <li><a href="manage_artisan.php?action=view">Manage Artisan Registraiton</a></li>
    <li><a href="marketing_initiatives.php?action=view">Marketing Initiatives</a></li>
    <li><a href="igjs.php?action=view">IGJS Delhi</a></li>
    <li><a href="manage_igja_awards.php?action=view">Manage  IGJA Awards </a></li> 
</ul>
</li>

<!--<li><a href="wdc.php?action=view">WDC</a></li>-->
<!--<li style="background:none;"> | </li>
<li><a href="#" > IIJS VIRTUAL 2.0</a>
   <ul class="terms">
        <li><a href="virtual_iijs_exhibitor_rgistration.php?action=view">Exhibitor Registration</a></li>
        <li><a href="manage_virtual_visitor_order.php?action=view">VIIJS Visitor Search with OrderID </a></li>
        <li><a href="manage_visitor_reports.php?action=view">VIIJS Visitor Reports</a></li>
        <li><a href="iijs_signature_ivr.php?action=view">IVR </a></li>
    </ul>
</li>-->

<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'iijs_employee_directory.php') || ($url == $attach.'iijs_information_pvr.php') || ($url == $attach.'iijs_obmp_profile_pvr.php') || ($url == $attach.'iijs_participation_&_payment_details_pvr.php') || ($url == $attach.'iijs_change_photo_form_pvr.php') || ($url == $attach.'iijs_approval_form_pvr.php') || ($url == $attach.'iijs_ivr.php') || ($url == $attach.'iijs_personal_information_IVR.php') || ($url == $attach.'iijs_obmp_info_IVR.php') || ($url == $attach.'iijs_photo_form_IVR.php') || ($url == $attach.'iijs_approval_form_ivr.php') || ($url == $attach.'iijs_hotel.php')) { ?>  <?php } ?>>IIJS 2022</a>
    <ul class="terms">
        <li><a href="iijs_exhibitor_rgistration.php">Exhibitor Registration</a></li>
		<li><a href="iijs_ivr.php?action=view">IVR</a></li>
		<!--<li><a href="iijs_hotel.php">Hotel Registration</a></li>-->
        <li><a href="manage_agency.php?action=view">Manage Agency</a></li>
        <li><a href="manage_covid_report.php?action=view">Manage Vaccination Certificate</a></li>
        <li><a href="iijs_employee_directory.php?action=view">IIJS Online Employee Directory</a></li>
        <li><a href="manage_visitor_order.php?action=view">IIJS Visitor Search with OrderID </a></li>
		<li><a href='manage_visitor_reports.php'>Visitor Reports</a></li>
        <li><a href="manage_onspot_registration.php?action=view">Manage OnSpot Registraiton</a></li> 
        <li><a href="visitor-search.php">Search Visitor Details</a></li> 
        <!--<li><a href="manage_iijs_invoice.php?action=view">Invoice</a></li> -->
    </ul>
</li>

<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'pvr.php') || ($url == $attach.'information_pvr.php') || ($url == $attach.'obmp_profile_pvr.php') || ($url == $attach.'participation_&_payment_details_pvr.php') || ($url == $attach.'change_photo_form_pvr.php') || ($url == $attach.'approval_form_pvr.php') || ($url == $attach.'ivr.php') || ($url == $attach.'personal_information_IVR.php') || ($url == $attach.'obmp_info_IVR.php') || ($url == $attach.'photo_form_IVR.php') || ($url == $attach.'approval_form_ivr.php') || ($url == $attach.'hotel.php')) { ?> class="selected" <?php } ?>>Signature 2022</a>
   <ul>
        <li>
            <a href="signature_exhibitor_rgistration.php">Exhibitor Registration</a>
            <ul>
                <li><a href="floor_plan_master.php?action=view">FloorPlan</a></li>
            </ul>
        </li>
        <li><a href="iijs_ivr.php?action=view">IVR</a></li>
        <li><a href="iijs_hotel.php">Hotel Registration</a></li>
        <li><a href="manage_agency.php?action=view">Manage Agency</a></li>
        <li><a href="manage_covid_report.php?action=view">Manage Vaccination Certificate</a></li>
        <li><a href="iijs_employee_directory.php?action=view">Online Employee Directory</a></li>
        <li><a href="manage_visitor_order.php?action=view">IIJS Visitor Search with OrderID </a></li>
        <li><a href='manage_visitor_reports.php'>Visitor Reports</a></li>
        <li><a href="manage_onspot_registration.php?action=view">Manage OnSpot Registraiton</a></li>
        <li><a href="visitor-search.php">Search Visitor Details</a></li>
        <!--<li><a href="manage_visitor_orders_push_to_tecogis.php?action=view">Visitor Push to Tecogis </a></li>               
        <li><a href="manage_lost_badges.php?action=view">Visitor Lost Badges</a></li>
        <li><a href="onspot_lost_badges.php?action=view">OnSpot Lost Badges</a></li>
        <li><a href="employee_directory_offline.php?action=view">OnSpot Employee Directory</a></li>
        <li><a href="hotel.php">Hotel</a></li>-->
    </ul>
</li>

<li style="background:none;"> | </li>
<li><a href="#">IGJME 2022</a>
   <ul class="terms">
        <li><a href="igjme_exhibitor_rgistration.php">Exhibitor Registration</a></li>
    </ul>
</li>

<!--<li style="background:none;"> | </li>
<li><a href="#">Manage Invoice</a>
   <ul class="terms">
        <li><a href="manage_director.php?action=view">Manage Director</a></li>
        <li><a href='dump_iijs_all_invoice_part.php'>Import Part Invoice</a></li>
        <li><a href='dump_iijs_all_invoice_detail.php'>Import Invoice Details</a></li>
        <li><a href='dump_iijs_all_invoice_requisition.php'>Import Requisition Details</a></li>
    </ul>
</li>-->

<!--<li style="background:none;"> | </li>
<li><a href="#">Manage MAI</a>
   <ul class="terms">
        <li><a href="manage_event.php?action=view">Event Name</a></li>
        <li><a href="manage_mai.php?action=view">All MAI Application Form</a></li>
        <li><a href="export_mai_report.php?action=view">MAI Event Wise Report</a></li>
    </ul>
</li>-->

<!--<li style="background:none;"> | </li>
<li><a href="#">Manage Complaints</a>
   <ul class="terms">
        <li><a href="complaints_report.php?action=view">Complaints</a></li>
    </ul>
</li>-->
<li style="background:none;"> | </li>
<li><a href="#">GST</a>
   <ul class="terms">
        <li><a href="member_gst.php?action=view">Member GST</a></li>
        <li><a href="vendor_gst.php?action=view">Vendor GST</a></li>
        <li><a href="gst_cust.php?action=view">GST Enquiry</a></li>
        <li><a href="manage_gst_upload.php?action=view">Upload GST PDF</a></li>
    </ul>
</li>
<li style="background:none;"> | </li>
<li><a href="#">Manage Vendor Empanelment</a>
    <ul class="terms">
        <li><a href="https://gjepc.org/admin/vendor_uploaded_common_docs.php?action=view">Vendors Common Documents</a></li>
        <li><a href="https://gjepc.org/admin/vendor_uploaded_variable_docs.php?action=view">Vendors Area Specific documents</a></li>
        <li><a href="https://gjepc.org/admin/vendor_registration_list.php?action=view">Vendors Application List</a></li>
        <li><a href="https://gjepc.org/admin/vendor_area_master.php?action=view">Manage Area Master</a></li>
        <li><a href="https://gjepc.org/admin/vendor_criteria_master.php?action=view">Manage Criteria </a></li>
        <li><a href="https://gjepc.org/admin/vendor_documents.php?action=view">Manage All Document master</a></li>
        <li><a href="https://gjepc.org/admin/vendor_documents_master.php?action=view">Manage Areawise Document master</a></li>
        <li><a href="https://gjepc.org/admin/registered_vendor_list.php?action=view">All Registered Vendor List</a></li>        
    </ul>
</li>
    

<li style="background:none;"> | </li>
<!--<li><a href="manage_registration_old_data.php?action=view">Manage Old Registrations</a></li>-->
    <li><a href="https://gjepc.org/admin/statistics_enquiries.php?action=view">Manage Statistics Enquiries  </a></li>  
<li style="background:none;"> | </li>
<?php
} else {
    /* Admin Part Start*/
?>
<?php if($_SESSION['curruser_login_id']=='81') { ?> 
<li><a href="gold_rate.php?action=view">Gold Rate</a></li> 
<li><a href="current_market_rate.php?action=view">Current Market Rate</a></li>
<?php } ?>

<li style="background:none;"> | </li>

<?php
if(preg_match('/Q/',$_SESSION['curruser_admin_access']))
{?>
<li><a href="#" class="selected">Manage Vendor Empanelment</a>
    <ul class="terms">
        <li><a href="https://gjepc.org/admin/vendor_uploaded_common_docs.php?action=view">Vendors Common Documents</a></li>
        <li><a href="https://gjepc.org/admin/vendor_uploaded_variable_docs.php?action=view">Vendors Area Specific documents</a></li>
        <li><a href="https://gjepc.org/admin/vendor_registration_list.php?action=view">Vendors Registration List</a></li>
        <li><a href="https://gjepc.org/admin/vendor_area_master.php?action=view">Manage Area Master</a></li>
        <li><a href="https://gjepc.org/admin/vendor_criteria_master.php?action=view">Manage Criteria </a></li>
        <li><a href=" https://gjepc.org/admin/vendor_documents.php?action=view">Manage All Document master</a></li>
        <li><a href="https://gjepc.org/admin/vendor_documents_master.php?action=view">Manage Areawise Document master</a></li>
        <li><a href="https://gjepc.org/admin/registered_vendor_list.php?action=view">All Registered Vendor List</a></li>          
    </ul>
</li>
<?php }?>

<li style="background:none;"> | </li>

<?php
if(preg_match('/R/',$_SESSION['curruser_admin_access']))
{?>
<li><a href="#" class="selected">Manage Vendor Empanelment</a>
    <ul class="terms">     
        <li><a href="https://gjepc.org/admin/vendor_registration_list.php?action=view">Vendors Registration List</a></li>               
    </ul>
</li>
<?php }?>

<li style="background:none;"> | </li>
<?php if($_SESSION['curruser_login_id']=='41' || $_SESSION['curruser_login_id']=='93' || $_SESSION['curruser_login_id']=='94' || $_SESSION['curruser_login_id']=='113' || $_SESSION['curruser_login_id']=='114' || $_SESSION['curruser_login_id']=='115' || $_SESSION['curruser_login_id']=='116' || $_SESSION['curruser_login_id']=='117' || $_SESSION['curruser_login_id']=='118' || $_SESSION['curruser_login_id']=='119' || $_SESSION['curruser_login_id']=='120' || $_SESSION['curruser_login_id']=='121' || $_SESSION['curruser_login_id']=='122'){
    if(preg_match('/J/',$_SESSION['curruser_admin_access']))
    { ?>
    <li><a href="#">IIJS 2022</a>
       <ul class="terms">
            <li><a href="iijs_employee_directory.php?action=view">IIJS Online Employee Directory</a></li>
             <li><a href="manage_covid_report.php?action=view">Manage Vaccination Certificate</a></li>
            <li><a href="manage_visitor_order.php?action=view">Visitor Search with OrderID </a></li>
            <li><a href="manage_visitor_orders_push_to_tecogis.php?action=view">Visitor Push to Tecogis </a></li>
            <li><a href="manage_onspot_registration.php?action=view">Manage OnSpot Registraiton</a></li> 
            <!--<li><a href="manage_lost_badges.php?action=view">Visitor Lost Badges</a></li>
            <li><a href="onspot_lost_badges.php?action=view">OnSpot Lost Badges</a></li>
            <li><a href='employee_directory_offline.php?action=view'>Signature OnSpot Employee Directory</a></li>-->
        </ul>
    </li>
    <!--<li><a href="#">IIJS 2019</a>
        <ul class="terms">
            <li><a href="iijs_employee_directory.php?action=view">IIJS Online Employee Directory</a></li>
            <li><a href="manage_visitor_order.php?action=view">IIJS Visitor Search with OrderID </a></li>
        </ul>
    </li>-->
    <li style="background:none;"> | </li>
    <li><a href="manage_registration.php?action=view" <?php if($url == $attach.'manage_registration.php') { ?> class="selected" <?php } ?>>Registration</a></li>    
    <?php } } else {?>
    <?php
    if(preg_match('/T/',$_SESSION['curruser_admin_access']))
    {?>
    <li><a href="manage_trade_permission.php?action=view" <?php if($url == $attach.'manage_trade_permission.php') { ?> class="selected" <?php } ?>>Trade Permission</a></li>
    <?php }?>
    <?php /*if(preg_match('/J/',$_SESSION['curruser_admin_access']))
    { ?>
    <li style="background:none;"> | </li>
    <li><a href="#" > IIJS VIRTUAL 2.0</a>
    <ul class="terms">
        <li><a href="virtual_iijs_exhibitor_rgistration.php?action=view">Exhibitor Registration</a></li>
        <li><a href="manage_virtual_visitor_order.php?action=view">VIIJS Visitor Search with OrderID </a></li>
        <li><a href="iijs_virtual_ivr.php?action=view">IVR </a></li>
    </ul>
    </li>
<?php } */?>
<?php if(preg_match('/L/',$_SESSION['curruser_admin_access']) || preg_match('/I/',$_SESSION['curruser_admin_access'])|| preg_match('/J/',$_SESSION['curruser_admin_access'])|| preg_match('/K/',$_SESSION['curruser_admin_access']) ){?>
<li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'iijs_ivr.php') || ($url == $attach.'iijs_personal_information_IVR.php') || ($url == $attach.'iijs_obmp_info_IVR.php') || ($url == $attach.'iijs_photo_form_IVR.php') || ($url == $attach.'iijs_approval_form_ivr.php') || ($url == $attach.'iijs_hotel.php')) { ?> class="selected" <?php } ?>>IIJS 2022</a>
  <ul class="terms">
        <?php
        if(preg_match('/L/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='iijs_exhibitor_rgistration.php'>Exhibitor Registration</a></li>";
        }
        if(preg_match('/I/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='iijs_ivr.php?action=view'>IVR</a></li>";
        }
        if(preg_match('/J/',$_SESSION['curruser_admin_access']))
        {
            echo "<li><a href='iijs_employee_directory.php?action=view'>Online Employee Directory</a></li>";
            echo "<li><a href='manage_covid_report.php?action=view'>Manage Vaccination Certificate</a></li>";
            echo "<li><a href='manage_visitor_order.php?action=view'>Visitor Search with OrderID </a></li>";
            echo "<li><a href='manage_agency.php?action=view'>Manage Agency</a></li>";
            echo "<li><a href='manage_onspot_registration.php?action=view'>Manage OnSpot Registration</a></li>";
            echo "<li><a href='visitor-search.php'>Search Visitor Details</a></li>";
            //echo "<li><a href='manage_lost_badges.php?action=view'>Visitor Lost Badges</a></li>";     
        }
        if(preg_match('/K/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='iijs_hotel.php'>Hotel Registration</a></li>";
        }
        ?>
    </ul>
</li>
<?php } ?>


<?php if(preg_match('/signature22/',$_SESSION['curruser_admin_access']) ){ ?>
 <li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'ivr.php') || ($url == $attach.'personal_information_IVR.php') || ($url == $attach.'obmp_info_IVR.php') || ($url == $attach.'photo_form_IVR.php') || ($url == $attach.'approval_form_ivr.php') || ($url == $attach.'hotel.php')) { ?> class="selected" <?php } ?>>Signature 2022</a>
   <ul class="terms">
        <?php
       echo '<li><a href="manage_registration.php?action=view" >Manage Registration</a></li>';
        echo "<li><a href='iijs_employee_directory.php?action=view'>Online Employee Directory</a></li>";
        echo "<li><a href='manage_covid_report.php?action=view'>Manage Vaccination Certificate</a></li>";
        echo "<li><a href='manage_onspot_registration.php?action=view'>Manage OnSpot Registration</a></li>";
    
     
        
        ?>  
    </ul>
</li>
<?php }?>
<?php if(preg_match('/L/',$_SESSION['curruser_admin_access']) || preg_match('/I/',$_SESSION['curruser_admin_access']) || preg_match('/K/',$_SESSION['curruser_admin_access']) || preg_match('/J/',$_SESSION['curruser_admin_access'])){ ?>
 <li style="background:none;"> | </li>
<li><a href="#" <?php if(($url == $attach.'ivr.php') || ($url == $attach.'personal_information_IVR.php') || ($url == $attach.'obmp_info_IVR.php') || ($url == $attach.'photo_form_IVR.php') || ($url == $attach.'approval_form_ivr.php') || ($url == $attach.'hotel.php')) { ?> class="selected" <?php } ?>>Signature 2022</a>
   <ul class="terms">
        <?php
        if(preg_match('/L/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='signature_exhibitor_rgistration.php'>Exhibitor Registration</a></li>";
        }
        if(preg_match('/I/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='iijs_ivr.php?action=view'>IVR</a></li>";
        }
        if(preg_match('/K/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='iijs_hotel.php'>Hotel Registration</a></li>";
        }
        if(preg_match('/J/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='iijs_employee_directory.php?action=view'>Online Employee Directory</a></li>";
        echo "<li><a href='manage_covid_report.php?action=view'>Manage Vaccination Certificate</a></li>";
        echo "<li><a href='manage_visitor_order.php?action=view'>Online Visitor Search with OrderID </a></li>";
        echo "<li><a href='manage_visitor_reports.php'>Visitor Reports</a></li>";
        echo "<li><a href='manage_agency.php?action=view'>Manage Agency</a></li>";
        echo "<li><a href='manage_onspot_registration.php?action=view'>Manage OnSpot Registration</a></li>";
        echo "<li><a href='visitor-search.php'>Search Visitor Details</a></li>";
     /*   echo "<li><a href='manage_lost_badges.php?action=view'>Signature Online Lost Badge </a></li>";
        echo "<li><a href='onspot_lost_badges.php?action=view'>OnSpot Lost Badges</a></li>";
        echo "<li><a href='employee_directory_offline.php?action=view'>Signature OnSpot Employee Directory</a></li>"; */
        }
        ?>  
    </ul>
</li>
<?php }?>

<?php if(preg_match('/L/',$_SESSION['curruser_admin_access']) ){?>
<li><a href="#" <?php if(($url == $attach.'ivr.php') || ($url == $attach.'personal_information_IVR.php') || ($url == $attach.'obmp_info_IVR.php') || ($url == $attach.'photo_form_IVR.php') || ($url == $attach.'approval_form_ivr.php') || ($url == $attach.'hotel.php')) { ?> class="selected" <?php } ?>>IGJME 2022</a>
   <ul class="terms">
         <?php
        if(preg_match('/L/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='igjme_exhibitor_rgistration.php'>Exhibitor Registration</a></li>";
        }
        /*if(preg_match('/I/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='ivr.php'>IVR</a></li>";
        }
        if(preg_match('/K/',$_SESSION['curruser_admin_access']))
        {
        echo "<li><a href='hotel.php'>Hotel Registration</a></li>";
        } */
        ?>  
    </ul>
</li>
<li style="background:none;"> | </li>
<li><a href="manage_roi_forms.php?action=view" <?php if($url == $attach.'manage_roi_forms.php')  { ?> class="selected" <?php } ?>>Manage ROI Forms</a></li>
<?php } ?>

<li style="background:none;"> | </li>
<!--<li><a href="#">IGJME 2018</a>
   <ul class="terms">
        <li><a href="igjme_exhibitor_rgistration.php">Exhibitor Registration</a></li>
        <li><a href='igjme_hotel.php'>Hotel Registration</a></li>
    </ul>
</li>-->
    <?php
    if(preg_match('/5/',$_SESSION['curruser_admin_access']))
    { ?>
    <li><a href="manage_iijs_invoice.php?action=view" <?php if($url == $attach.'manage_iijs_invoice.php') { ?> class="selected" <?php } ?>>IIJS Invoice 2018</a></li>
    <?php } ?>

    <?php
    if(preg_match('/A/',$_SESSION['curruser_admin_access']))
    {
    ?>  
    <li><a href="manage_admin.php?action=view" <?php if($url == $attach.'manage_admin.php')  { ?> class="selected" <?php } ?>>Manage Admin</a></li>
    <?php
    }
    if(preg_match('/B/',$_SESSION['curruser_admin_access']))
    {
    ?>
   
    <li><a href="manage_registration.php?action=view" <?php if($url == $attach.'manage_registration.php') { ?> class="selected" <?php } ?>>Registration</a></li>
    <li style="background:none;"> | </li>
    <li><a href="manage_roi_forms.php?action=view" <?php if($url == $attach.'manage_roi_forms.php')  { ?> class="selected" <?php } ?>>Manage ROI Forms</a></li>
    <?php 
    }if(preg_match('/C/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li style="background:none;"> | </li>
    <li><a href="#"  <?php if(($url == $attach.'manage_export_amount.php') || ($url == $attach.'committee_administration_category.php') || ($url == $attach.'pm_bd_sub_committee_category.php') || ($url == $attach.'ideal_cut_newsletter_category.php') || ($url == $attach.'circulars_category.php') || ($url == $attach.'circulars_to_member_category.php')  || ($url == $attach.'notifications_category.php') || ($url == $attach.'policy_handbook_category.php') ||($url == $attach.'union_budget_category.php') ||($url == $attach.'statistics_export_category.php') || ($url == $attach.'statistics_import_category.php'))  { ?> class="selected" <?php } ?> >Master</a>
         <ul class="terms">
            <li><a href="manage_export_amount.php?action=view">Export Amount Master</a></li>
            <li><a href="committee_administration_category.php?action=view">Committee Administration Category</a></li>
            <li><a href="pm_bd_sub_committee_category.php?action=view">PM & BD Sub-Committee Category</a></li>
            <li><a href="ideal_cut_newsletter_category.php?action=view">Ideal Cut Newsletter Category</a></li>
            <li><a href="circulars_category.php?action=view">Circulars Category</a></li>
            <li><a href="circulars_to_member_category.php?action=view">Circulars To Member Category</a></li>
            <li><a href="notifications_category.php?action=view">Notifications Category</a></li>
            <li><a href="policy_handbook_category.php?action=view">Policy & Handbook Category</a></li>
            <li><a href="union_budget_category.php?action=view">Union Budget Category</a></li>
            <li><a href="statistics_export_category.php?action=view">Statistics Export Category</a></li>
            <li><a href="statistics_import_category.php?action=view">Statistics Import Category</a></li>
        </ul>
    </li>
<?php   
    }
    if($_SESSION['curruser_login_id']==100) { /* Cyril only*/?>
    <li style="background:none;"> | </li>
    <li><a href="#" >Master</a>
    <ul class="terms">
    <li><a href="import_export_master.php?action=view">Import Export HSCODE Master(Quarterly Returns)</a></li>
    <li><a href="import_export_statistics.php?action=view">Manage Statistics Import/Export Report</a></li>
    </ul>
    </li>
    <?php 
    } 

   if($_SESSION['curruser_login_id']== 174){ ?>
    <li><a href="#">IIJS 2022</a>
       <ul class="terms">
        
           <!--  <li><a href="manage_covid_report.php?action=view">Manage Vaccine Certificate</a></li> -->
            <li><a href="manage_agency.php?action=view">Manage Agency</a></li>
        
    </ul>
    </li>
    <?php }  
    
    if(preg_match('/D/',$_SESSION['curruser_admin_access']))
    {
?>  
    <li style="background:none;"> | </li>
    <li><a href="membership.php?action=view" <?php if(($url == $attach.'membership.php') || ($url == $attach.'information_form.php')|| ($url == $attach.'communication_form.php')|| ($url == $attach.'challan_form.php')|| ($url == $attach.'approval_form.php')) { ?> class="selected" <?php } ?>>Membership</a></li>
    <li style="background:none;"> | </li>
    <li><a href="membership-FY2020-21.php?action=view" <?php if(($url == $attach.'membership-FY2020-21.php') || ($url == $attach.'information_form.php')|| ($url == $attach.'communication_form.php')|| ($url == $attach.'challan_form.php')|| ($url == $attach.'approval_form.php')) { ?> class="selected" <?php } ?>>Membership FY20-21</a></li>
    <li style="background:none;"> | </li>
	 <li><a href="membership-FY2021-22.php?action=view" <?php if(($url == $attach.'membership-FY2021-22.php') || ($url == $attach.'information_form.php')|| ($url == $attach.'communication_form.php')|| ($url == $attach.'challan_form.php')|| ($url == $attach.'approval_form.php')) { ?> class="selected" <?php } ?>>Membership FY21-22</a></li>
    <li style="background:none;"> | </li>
    <li><a href="manage_history_certificate.php?action=view">Manage 5 years certificate</a></li>
<!--<li style="background:none;"> | </li>
    <li><a href="/dataport/admin_rcmc_status.php" target="_blank">Set Rcmc Status</a></li>-->

<?php
    }
    if(preg_match('/E/',$_SESSION['curruser_admin_access']))
    {
?>
    <li style="background:none;"> | </li>
    <li><a href="#" <?php if(($url == $attach.'committee_administration.php') || ($url == $attach.'pm_bd_sub_committee.php') || ($url == $attach.'ideal_cut_newsletter.php') || ($url == $attach.'tender.php') || ($url == $attach.'seminars.php') || ($url == $attach.'kimberly_info.php') || ($url == $attach.'circulars.php') || ($url == $attach.'circulars_to_member.php') || ($url == $attach.'exhibition_permission.php') || ($url == $attach.'notifications.php') || ($url == $attach.'policy_handbook.php') ||($url == $attach.'union_budget.php') ||($url == $attach.'statistics_export.php') || ($url == $attach.'statistics_import.php') || ($url == $attach.'trade_information.php') ||($url == $attach.'trade_news.php') ||($url == $attach.'press_release.php') ||($url == $attach.'careers.php') ||($url == $attach.'whats_new.php')) { ?> class="selected" <?php } ?>>Manage Pages</a>
    
   <ul class="terms">
        <li><a href="committee_administration.php?action=view">Committee Administration</a></li>
        <li><a href="pm_bd_sub_committee.php?action=view">PM & BD Sub-Committee</a></li>
        <li><a href="ideal_cut_newsletter.php?action=view">Ideal Cut Newsletter</a></li>
        <li><a href="tender.php?action=view">Tender</a></li>
        <li><a href="seminars.php?action=view">Seminars</a></li>
        <li><a href="kimberly_info.php?action=view">Kimberly Info</a></li>
        <li><a href="circulars.php?action=view">Circulars</a></li>
        <li><a href="circulars_to_member.php?action=view">Circulars To Member</a></li>
        <li><a href="exhibition_permission.php?action=view">Exhibition Permission</a></li>
        <li><a href="notifications.php?action=view">Notifications</a></li>
        <li><a href="policy_handbook.php?action=view">Policy & Handbook</a></li>
        <li><a href="union_budget.php?action=view">Union Budget</a></li>
        <li><a href="statistics_export.php?action=view">Statistics Export</a></li>
        <li><a href="statistics_import.php?action=view">Statistics Import</a></li>
        <li><a href="trade_information.php?action=view">Trade Information</a></li>
        <li><a href="trade_news.php?action=view">Trade News</a></li>
        <li><a href="news.php?action=view">News</a></li>
        <li><a href="trade_show.php?action=view">Trade Show</a></li>
        <li><a href="press_release.php?action=view">Press Release</a></li>
        <li><a href="careers.php?action=view">Careers</a></li>
        <li><a href="marketing_development_assistance.php?action=view">Marketing Development Assistance</a></li>
        <li><a href="gold_rate.php?action=view">Gold Rate</a></li>
        <li><a href="whats_new.php?action=view">Whats New</a></li>      
    </ul>

    <?php 
    }
    if(preg_match('/F/',$_SESSION['curruser_admin_access']))
    {
    ?>  
    <li style="background:none;"> | </li>
    <li><a href="seminar_calendar.php?action=view">Manage Calendar</a></li>
    <li style="background:none;"> | </li>
<!--    <li><a href="import_export_admin_list.php?action=view" <?php if($url == $attach.'import_export_admin_list.php') { ?> class="selected" <?php } ?>>Manage Import/Export Application</a></li>-->
    <li><a href="import_export_statistics.php?action=view" <?php if($url == $attach.'import_export_statistics.php') { ?> class="selected" <?php } ?>>Manage Statistics Import/Export Application</a></li>
<?php 
    }
    if(preg_match('/N/',$_SESSION['curruser_admin_access']))
    {
?>  
    <li style="background:none;"> | </li>
    <li><a href="signature_authority.php?action=view" <?php if($url == $attach.'signature_authority.php') { ?> class="selected" <?php } ?>>Signature Authority</a></li>

<?php 
    }   
    if(preg_match('/G/',$_SESSION['curruser_admin_access']))
    {
?>  
    <li style="background:none;"> | </li>
    <li><a href="https://gjepc.org/dataport/index.php" <?php if($url == $attach.'') { ?> class="selected" <?php } ?> target="_blank">Manage DataPort</a></li>
<?php
    }
    if(preg_match('/H/',$_SESSION['curruser_admin_access']))
    {
?>
    <li style="background:none;"> | </li>
<li><a href="https://survey.jamoutsourcing.com/gjepc_new/index.php/complaint/complaint" <?php if($url == $attach.'') { ?> class="selected" <?php } ?> target="_blank">HelpDesk</a></li>

<?php
    }
    if(preg_match('/GS/',$_SESSION['curruser_admin_access']))
    {
?>
   <li style="background:none;"> | </li>
   <!--<li><a href="#">GST</a>
   <ul class="terms">
        <li><a href="member_gst.php?action=view">Member GST</a></li>
        <li><a href="vendor_gst.php?action=view">Vendor GST</a></li>
        <li><a href="gst_cust.php?action=view">GST Enquiry</a></li>
        <li><a href="manage_gst_upload.php?action=view">Upload GST PDF</a></li>
    </ul>
    </li>-->

<?php 
    }
    if(preg_match('/M/',$_SESSION['curruser_admin_access']))
    {
?>
    <li style="background:none;"> | </li>
    <li><a href="manage_trade_permission.php?action=view" <?php if($url == $attach.'manage_trade_permission.php') { ?> class="selected" <?php } ?>>Trade Permission</a></li>
    <li style="background:none;"> | </li>
    <li><a href="trade_exhibition_master.php?action=view" <?php if($url == $attach.'trade_exhibition_master.php') { ?> class="selected" <?php } ?>>Manage Exhibitions Master</a></li>
    <li style="background:none;"> | </li>
    <li><a href="trade_exhibition_data_import.php?action=view" <?php if($url == $attach.'trade_exhibition_master.php') { ?> class="selected" <?php } ?>>Download Exhibitions</a></li>
<?php 
    }
    if(preg_match('/O/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li style="background:none;"> | </li>
    <li><a href="relief-aid.php?action=view">Manage Relief Aid</a>
    <li style="background:none;"> | </li>
    
    <li><a href="#">IIJS 2021</a>
       <ul class="terms">
            <li><a href="manage_covid_report.php?action=view">Manage Vaccine Certificate</a></li>
            <li><a href="manage_agency.php?action=view">Manage Agency</a></li>
            <li><a href="iijs_employee_directory.php?action=view">IIJS Online Employee Directory</a></li>
            
        </ul>
    </li>
    <?php if($_SESSION['curruser_login_id']==145){ ?>
    <li><a href="#">SIGNATURE 2022</a>
       <ul class="terms">
        
            <li><a href="manage_covid_report.php?action=view">Manage Vaccine Certificate</a></li>
            <li><a href="manage_agency.php?action=view">Manage Agency</a></li>
        
    </ul>
    </li>
    <?php }  ?>

    <!--<li><a href="#">Manage MAI</a>
    <ul class="terms">
        <li><a href="manage_event.php?action=view">Event Name</a></li>
        <li><a href="manage_mai.php?action=view">All MAI Application Form</a></li>
        <li><a href="export_mai_report.php?action=view">MAI Event Wise Report</a></li>
        </ul>
    </li>-->
    <?php 
    }
    if(preg_match('/X/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li style="background:none;"> | </li>
    <li><a href="manage-parichay-card.php?action=view">Manage Parichay Card</a>
    <?php 
    }
    if(preg_match('/P/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="igjs.php?action=view">IGJS Delhi | </a></li> 
    <li><a href="preview_day.php?action=view">Invitation Preview Day</a></li>    
    <?php 
    }
    if(preg_match('/W/',$_SESSION['curruser_admin_access']))
    { ?>
    <li><a href="wdc.php?action=view">WDC</a></li>
    <?php } ?>
    
    <?php
    if(preg_match('/W/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="webinar.php?action=view">Manage  Webinar | </a></li> 
 
    <?php 
    } 
    ?>
    <?php
    if(preg_match('/S/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="manage_igja_awards.php?action=view">Manage  IGJA Awards | </a></li> 
 
    <?php 
    } 
    ?>
    <?php
    if(preg_match('/promo/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="https://gjepc.org/admin/promo-video-orders.php?action=view">Promo Video Orders  </a></li>  
    <?php 
    } 
    ?>

    <?php
    if(preg_match('/lab/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="https://gjepc.org/admin/manage_lab_reports.php?action=view">Manage Lab Reports  </a></li>  
 
    <?php 
    } 
    ?>
    <?php
    if(preg_match('/covid/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="https://gjepc.org/admin/manage_covid_report.php?action=view">Manage Vaccination Certificate </a></li>  
 
    <?php 
    } 
    ?>
     <?php
    if(preg_match('/bp_create/',$_SESSION['curruser_admin_access']))
    {
    ?>
    <li><a href="https://gjepc.org/admin/iijs_employee_directory.php?action=view">Manage Employee Directory </a></li>  
 
    <?php 
    } 
    ?>
    
     <?php
if(preg_match('/stastics_enquiries/',$_SESSION['curruser_admin_access']))
{?>
 <li><a href="https://gjepc.org/admin/statistics_enquiries.php?action=view">Manage Statistics Enquiries  </a></li> 
<?php }?> 
<?php   
}
}
?>
</ul>
</div>
</div>