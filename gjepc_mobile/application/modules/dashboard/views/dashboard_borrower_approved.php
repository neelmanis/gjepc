 <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>From</th>
              <th>To</th>
              <th>Deposit</th>
              <th></th>
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
					$profilePic= image_resizer('',89,100,$croptofit='crop-to-fit',$profilePic,$info[0]->regId,'profile');
					
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
				
				?>
            <tr>
              <td data-th="Product Name"><a href="#">
                <div class="imgList"><img src="<?php echo $pic; ?>"></div>
                <div class="nameList"><?php echo $prod->title ?></div>
                </a></td>
              <td data-th="Quantity"><?php echo $prod->qty ?></td>
              <td data-th="Price"><i class="fa fa-inr"></i> <?php echo $prod->price ?>/<?php echo $timeUnit ?></td>
              <td data-th="From"><?php echo date('d-m-Y',strtotime($prod->productFrom)) ?></td>
              <td data-th="To"><?php echo date('d-m-Y',strtotime($prod->productTo)) ?></td>
              <td data-th="Deposit"><i class="fa fa-inr"></i> <?php echo $prod->deposit; ?></td>
             <!-- <td><a href="#">Dispute</a></td>-->
            </tr>
           
            
				<?php }//foreach
			} //if 
			 ?>				
           
            </tbody>
          </table>
        <!--  <div class="pagination text-right"><a href="#"><i class="fa fa-chevron-left"></i></a><a href="#" class="active">1</a><a href="#">2</a><a>...</a><a href="#">6</a><a href="#"><i class="fa fa-chevron-right"></i></a></div> -->
        
		