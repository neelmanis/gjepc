<?php 

$regId=base64_encode($info[0]->regId);
$result=Modules::run('review/review_by_user',$info[0]->regId);
$countBy=sizeof($result);

$result1=Modules::run('review/review_about_user',$info[0]->regId);
$countAbout=sizeof($result1);
?>
          <div class="tabLinks tabLinksD"><a href="#Renter">Renter</a><a href="#Borrower">Borrower</a></div>
          <div class="tab_contain">
		  
		  
            <div id="Renter" class="row tab_cont">
              <div class="col-sm-6">
                <div class="dashboardBlock">
				<?php
				$count_renter_app_prd=0;
				$renter_approval_pending=Modules::run('dashboard/renter_awaiting_approval','1');
				if(!empty($renter_approval_pending))
				{
					$count_renter_app_prd= sizeof($renter_approval_pending);
					
				} ?>			
				
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r1.png"> </div>
                    <div class="col-xs-8"><strong><?php echo $count_renter_app_prd; ?></strong><span>Awaiting for Approval</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/renter_awaiting_approval">Awaiting for Approval<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="dashboardBlock">
				<?php
				$renter_fast_movers=0;
				$renter_five_fast_movers=Modules::run('dashboard/renter_five_fast_movers','1');
				if(!empty($renter_five_fast_movers))
				{
					$renter_fast_movers= sizeof($renter_five_fast_movers);
					
				} ?>
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r2.png"> </div>
                    <div class="col-xs-8"><strong><?php echo $renter_fast_movers; ?></strong><span>Top Rent Product</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/renter_five_fast_movers">Top Rent Product<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="dashboardBlock">
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r3.png"> </div>
					<?php 
						$sales=Modules::run('dashboard/dashboard_renter_total_sale');
						$total_sale=0;
						
						if(!empty($sales))
						{
							foreach($sales as $sale)
							{
								$total_sale=$total_sale+($sale->total_price);
							}
						}
					?>
                    <div class="col-xs-8"><strong><?php echo number_format($total_sale,2) ?></strong><span>Total Sales</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/renter_total_sale">Total Sales<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="dashboardBlock">
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r4.png"> </div>
                    <div class="col-xs-8"><strong><?php echo $countAbout; ?></strong><span>Reviews</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/review_about_you/<?php echo $regId ?>">Reviews<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
            </div>
			
			
			
			<!-------------------------------------------------------------------------------------------------------->
			
			
			
			
			
            <div id="Borrower" class="row tab_cont">
              <div class="col-sm-6">
                <div class="dashboardBlock">
				<?php
				$count_borr_app_prd=0;
				$borrower_approved_products=Modules::run('dashboard/borrower_approved','1');
				if(!empty($borrower_approved_products))
				{
					$count_borr_app_prd= sizeof($borrower_approved_products);
					
				} ?>
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r6.png"> </div>
                    <div class="col-xs-8"><strong><?php echo $count_borr_app_prd; ?></strong><span>Approved Product</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url() ?>dashboard/borrower_approved">Approved Product<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="dashboardBlock">
				<?php
				$count_borr_pen_prd=0;
				$borrower_pending_products=Modules::run('dashboard/borrower_approval_pending','1');
				if(!empty($borrower_pending_products))
				{
					$count_borr_pen_prd= sizeof($borrower_pending_products);
					
				} ?>
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r5.png"> </div>
                    <div class="col-xs-8"><strong><?php echo $count_borr_pen_prd; ?></strong><span>Order Product</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/borrower_approval_pending">Approval Pending<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="dashboardBlock">
				<?php
				$total_spend=0;
				$borrower_total_spend=Modules::run('dashboard/borrower_total_spend','1');
				if(!empty($borrower_total_spend))
				{
					foreach($borrower_total_spend as $sale)
							{
								$total_spend=$total_spend+($sale->total_price);
							}
					
				} ?>
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r3.png"> </div>
                    <div class="col-xs-8"><strong><?php echo number_format($total_spend,2) ?></strong><span>Total Spend</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/borrower_total_spend">Total spend<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="dashboardBlock">
				
                  <div class="row">
                    <div class="col-xs-4"> <img src="<?php echo base_url()?>assets/images/dashboard/r4.png"> </div>
                    <div class="col-xs-8"><strong><?php echo $countBy; ?></strong><span>Reviews</span></div>
                  </div>
                  <div class="top"><a href="<?php echo base_url()?>dashboard/review_by_you/<?php echo $regId ?>">Reviews<img src="<?php echo base_url()?>assets/images/moreIcon.png"></a></div>
                </div>
              </div>
            </div>
 </div>
     
     
