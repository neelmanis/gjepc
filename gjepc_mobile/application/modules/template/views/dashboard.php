<!DOCTYPE html>
<html lang="en">
  <?php 
  $this->load->view('include/header');
  ?>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="<?php echo base_url()?>index.php/dashboard" class="logo"><b>LifeFeed</b></a>
            <!--logo end-->
            
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout"  href="template/logout">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <?php 
  $this->load->view('include/sidebar');
  ?>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
      <section class="wrapper">

              <div class="row">
                  <div class="main-chart">
                  
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
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->
                  
                  
     


              </div><! --/row -->
          </section>
      
          
      </section>

    <?php

     $this->load->view('include/footer');
    ?>

  </body>
</html>
