      <table class="rwd-table" id="dataTables">
            <thead>
              <tr>
                <th>Borrower</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>From</th>
                <th>To</th>
                <th>Deposit</th>
              </tr>
            </thead>
            <tbody>
			<?php if(!empty($prod_list)) 
			{
				foreach($prod_list as $prod) 
				{ //echo "<pre>";print_r($prod);
					$productImage=$this->mdl_dashboard->get_product_image($prod->proId);
					
					if(!empty($productImage))
					{
						foreach($productImage as $img)
						{
							$image=$img->Name;
						}						
						
						$pic = image_resizer('',89,100,$croptofit='crop-to-fit',$image,$info[0]->regId,'products');
						
					}
					else $pic=base_url() . 'assets/images/uploadDefault.jpg';
					
					$profilePic=Modules::run('users/get_profilepic',$prod->rentID);
					$profilePic= image_resizer('',89,100,$croptofit='crop-to-fit',$profilePic,$prod->rentID,'profile');
					
					$renterName=Modules::run('users/get_name',$prod->rentID);
					$renterId=base64_encode($prod->rentID);
					//----------------------------------------------------------------------
					if($prod->priceTimeUnit == "D"){
						$timeUnit= "Day";
					} else if($prod->priceTimeUnit == "W"){
						$timeUnit= "Week";
					} else if($prod->priceTimeUnit == "M"){
						$timeUnit= "Month";
					} else {
						$timeUnit= "Year";
					}
				$starRating=Modules::run('review/rating_stars',$prod->rentID);
				//echo $this->db->last_query();exit;
				?>
              <tr>
                <td data-th="Borrower"><a href="<?php echo base_url().'users/view_user_profile/'.$renterId ?>">
                  <div class="imgRenter"><img src="<?php echo $profilePic; ?>"></div>
                  <div class="nameRenter"><?php echo $renterName; ?></div>
                  
				<div class="star-ratings-sprite"><span style="width:<?php echo $starRating ?>" class="star-ratings-sprite-rating"></span></div>
				
                  </a>
                  <div class="statusBtns"> <a href="" id="<?php echo $prod->orderItemId ?>" class="orange accept">Accept</a>
					<a id="<?php echo $prod->orderItemId ?>" class="orange reject">Decline</a>				  <!--<button class="blue reject" id="<?php //echo $prod->orderItemId ?>" >Decline </button>--> </div>
				<div id="rejectReason" style="display:none;"><textarea name="reject_reason" id="reject_reason" placeholder="Enter Reason"></textarea> <br/>
				<div class="userLinks">
				<a href="" class="orange rejectReasonSave" id="<?php echo $prod->orderItemId ?>"> Submit</a>          
				</div>
				</div>
				</td>
                <td data-th="Product Name"><a href="#">
                  <div class="imgList"><img src="<?php echo $pic ?>"></div>
                  <div class="nameList"><?php echo $prod->title ?></div>
                  </a></td>
                <td data-th="Quantity"><?php echo $prod->qty ?></td>
                <td data-th="Price"><i class="fa fa-inr"></i> <?php echo $prod->productPrice ?></td>
                <td data-th="From"><?php echo date('d-m-Y',strtotime($prod->productFrom)) ?></td>
                <td data-th="To"><?php echo date('d-m-Y',strtotime($prod->productTo)) ?></td>
                <td data-th="Deposit"><i class="fa fa-inr"></i> <?php echo $prod->deposit; ?></td>
              </tr>
             <?php }//foreach
			} //if 
			 ?>			
            </tbody>
          </table>
      
	  
	  