<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>GJEPC MOBILE</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/css/style-responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/css/table-responsive.css">
    <link href="<?php echo  base_url();?>admin_assets/css/select2-bootstrap.css" rel='stylesheet'/>
    <link href="<?php echo  base_url();?>admin_assets/css/select2.css" rel='stylesheet'/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url(); ?>admin_assets/js/jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/resources/syntax/shCore.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>admin_assets/css/tree/style.css">

    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>admin_assets/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>admin_assets/resources/syntax/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>admin_assets/resources/demo.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>admin_assets/js/bootstrap-treeview.js"></script>
    <script src="<?php echo  base_url();?>admin_assets/js/select2.min.js" ></script>
    <script> var baseUrl = '<?php echo base_url()?>'</script>
    <!--<script> var CI_ROOT="http://localhost/lifefeed/index.php/";</script>-->
    
</head>
<body>
    <section id="container" >
        <!--header start-->
        <header class="header black-bg">
             <div class="sidebar-toggle-box">
                 <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
             </div>
            <!--logo start-->
            <a href="<?php echo base_url(); ?>index.php/dashboard/home" class="logo"><b>GJEPC MOBILE</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><?php echo anchor('admin/logout', 'Log Out',array('class'=>'logout')); ?></li>
                </ul>
            </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <p class="centered">
                        <a href="<?php echo base_url(); ?>index.php/dashboard/home"><img src="<?php echo base_url(); ?>admin_assets/images/user.jpg" class="img-circle" width="60"></a>
                    </p>
                    <h5 class="centered">GJEPC</h5>
                    <li class="mt">
                        <a <?php if($page=="dashboard"){?>class="active" <?php }?> href="<?php echo base_url();?>index.php/dashboard/home">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
<?php
//echo "<pre>"; print_r($this->session->all_userdata()); echo "</pre>";
if (isset($this->session->userdata['adminData']))
{
$userType = ($this->session->userdata['adminData']['userType']);
$dept     = ($this->session->userdata['adminData']['dept']);
}
?>
<?php
if($userType=="A")
{
?>
                    <!-- Users menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="exhibitors")echo "class='active'";?> href="javascript:;" >
                            <i class="fa fa-user"></i><span>Exhibitors</span></a>
                      <ul class="sub">
                       <li <?php if($menu=="listsA"){?>class="active" <?php }?>><?php echo anchor('exhibitors/listExhibitor/active', 'List Active Exhibitors'); ?></li>
                       <li <?php if($menu=="listsD"){?>class="active" <?php }?>><?php echo anchor('exhibitors/listExhibitor/inactive', 'List Inactive Exhibitors'); ?></li>
                      </ul>
                    </li>
                    <!-- Users menu end -->
                    
                    <!-- Notification menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
                            <i class="fa fa-cubes"></i><span>Manage Notifications</span></a>
                        <ul class="sub">
                            <li <?php if($menu=="lists"){?>class="active" <?php }?>><?php echo anchor('notification/notificationList', 'List All'); ?></li>
                        </ul>
                    </li>
                    <!-- Notification menu end -->	
						
					<!-- Firebase  Notification menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="firebase")echo "class='active'";?> href="javascript:;" >
                            <i class="fa fa-bell"></i><span>Manage Firebase Notification</span></a>
                        <ul class="sub">
                            <li <?php if($menu=="lists"){?>class="active" <?php }?>><?php echo anchor('firebase/msgList', 'List All'); ?></li>
                        </ul>
                    </li>
                    <!-- Firebase Notification menu end -->
					
					<!-- Show Info menu -->
                    <!--<li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
                            <i class="fa fa-info"></i><span>Show Info</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="detailsA"){?>class="active" <?php }?>><?php echo anchor('showinfo/listShowDetails', 'Show Details'); ?></li>
                       <li <?php if($menu=="detailsB"){?>class="active" <?php }?>><?php echo anchor('showinfo/listRegistration','Registration'); ?></li>
					   <li <?php if($menu=="detailsC"){?>class="active" <?php }?>><?php echo anchor('showinfo/listFaq', 'FAQ'); ?></li>
					   <li <?php if($menu=="detailsD"){?>class="active" <?php }?>><?php echo anchor('showinfo/listReach', 'How To reach us'); ?></li>
                       <li <?php if($menu=="detailsE"){?>class="active" <?php }?>><?php echo anchor('showinfo/listabout', 'About GJEPC'); ?></li>
					   <li <?php if($menu=="detailsF"){?>class="active" <?php }?>><?php echo anchor('showinfo/listContact', 'Contact us'); ?></li>
					   </ul>
                    </li>-->
                    <!-- Show Info menu end -->
					
					<!-- Show Info menu -->	
					<li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-asterisk" aria-hidden="true"></i><span>Show Info</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="info1"){?>class="active" <?php }?>><?php echo anchor('info/infoList','List All'); ?></li>
                      
					   </ul>
                    </li>			
                    <!-- Show Info menu end -->
					
					<!-- Services menu Start -->
					<li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-cogs" aria-hidden="true"></i><span>Services Venue</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="venue1"){?>class="active" <?php }?>><?php echo anchor('venue/venueList','List All'); ?></li>
                      
					   </ul>
                    </li>
					<!-- Services menu end -->
					
					<!-- How To Reach menu Start -->
					<li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-cogs" aria-hidden="true"></i><span>How To Reach List</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="reach"){?>class="active" <?php }?>><?php echo anchor('reach/reachList','List All'); ?></li>
                      
					   </ul>
                    </li>
					<!-- How To Reach menu end -->
					
					<!-- Show Updates menu Start -->
					<li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-cogs" aria-hidden="true"></i><span>Show Updates List</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="show_update"){?>class="active" <?php }?>><?php echo anchor('show/showList','List All'); ?></li>                      
					   </ul>
                    </li>
					<!-- Show Updates menu end -->
					
					<!-- GJEPC Events Start -->
					<li class="sub-menu">
                       <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;"/>
						<i class="fa fa-university" aria-hidden="true"></i><span>GJEPC Events List</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="show_gjepevents"){?>class="active" <?php } ?>><?php echo anchor('gjepcevents/gjepcEventsList','List All'); ?></li>                      
					   </ul>
                    </li>
					<!-- GJEPC Events end -->
                    <!-- GJEPC Events Start -->
					<li class="sub-menu">
                       <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;"/>
						<i class="fa fa-university" aria-hidden="true"></i><span>GJEPC INT Events List</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="show_gjepevents"){?>class="active" <?php } ?>><?php echo anchor('gjepcintevents/gjepcEventsList','List All'); ?></li>                      
					   </ul>
                    </li>
					<!-- GJEPC Events end -->
					
					<!-- Operational Manual Start -->
					<li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-cogs" aria-hidden="true"></i><span>Operational Manual List</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="show_oops"){?>class="active" <?php }?>><?php echo anchor('oops/oopsList','List All'); ?></li>                      
					   </ul>
                    </li>
					<!-- Operational Manual end -->
					
					<!-- Show Info menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
                            <i class="fa fa-flask"></i><span>Lab & Education</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="labA"){?>class="active" <?php }?>><?php echo anchor('labeduinfo/LaboratoryList', ' Laboratories'); ?></li>
                       <li <?php if($menu=="eduB"){?>class="active" <?php }?>><?php echo anchor('labeduinfo/InstitutesList','Institutes'); ?></li>
					   </ul>
                    </li>
                    <!-- Show Info menu end -->
					
					<!-- Zone Manager menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
                            <i class="fa fa-users" aria-hidden="true"></i><span>Zone Manager</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="zone"){?>class="active" <?php }?>><?php echo anchor('zone/ZoneList', 'List All'); ?></li>
					   </ul>
                    </li>
                    <!-- Zone Manager menu end -->
					
					<!-- Show Master menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-asterisk" aria-hidden="true"></i><span>Master</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="masterE"){?>class="active" <?php }?>><?php echo anchor('master/eventList','Events'); ?></li>
                       <li <?php if($menu=="masterY"){?>class="active" <?php }?>><?php echo anchor('master/yearList','Year'); ?></li>
					   </ul>
                    </li>
                    <!-- Show Master menu end -->
					
					<!-- Show Dept menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-asterisk" aria-hidden="true"></i><span>Enquiry</span></a>
                       <ul class="sub">
                       <li <?php if($menu=="masterEnquiry"){?>class="active" <?php }?>><?php echo anchor('enquiry/enquiryList','List All'); ?></li>                      
					   </ul>
                    </li>
                    <!-- Dept menu end -->
					
<?php } else { ?>	
					
					<!-- Show Dept menu -->
                    <li class="sub-menu">
                        <a <?php if($page=="notification")echo "class='active'";?> href="javascript:;" >
						<i class="fa fa-asterisk" aria-hidden="true"></i><span>Enquiry</span></a>
                       <ul class="sub">
                      <li <?php if($menu=="masterEnquiry"){?>class="active" <?php }?>><?php echo anchor('enquiry/enquiryList','List All'); ?></li>                        
					   </ul>
                    </li>
                    <!-- Dept menu end -->
<?php } ?>
					
                </ul>
              <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper site-min-height">
                <div class="row mt">
                    <div class="col-lg-12">
                    <?php
                    if(!isset($module)){
                        $module = $this->uri->segment(1);
                    }

                    if(!isset($viewFile)){
                        $viewFile = $this->uri->segment(2);
                    }

                    if( $module != '' && $viewFile != '' ){
                        $path = $module. '/' . $viewFile;
                        echo $this->load->view($path);
                    }
                    ?>
                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->

        <!--footer start-->
        <footer class="site-footer">
            <div class="text-center"><?php echo date("Y"); ?> - GJEPC</div>
        </footer>
        <!--footer end-->
    </section>

    <script src="<?php echo base_url(); ?>admin_assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/jquery.nicescroll.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>admin_assets/js/common-scripts.js"></script>
</body>
</html>
