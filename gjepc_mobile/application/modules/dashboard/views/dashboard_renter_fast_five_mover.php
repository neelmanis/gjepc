<?php 
//echo "<pre>"; print_r($prod_list);
?>
 <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Price</th>
              <th>Rent Time</th>
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
					
					$profilePic=Modules::run('users/get_profilepic',$prod->renterId);
					$profilePic= image_resizer('',89,100,$croptofit='crop-to-fit',$profilePic,$info[0]->regId,'profile');
					
					$renterName=Modules::run('users/get_name',$prod->renterId);
					$renterId=base64_encode($prod->renterId);
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
                <div class="imgList"><img src="<?php echo $pic ?>"></div>
                <div class="nameList"><?php echo $prod->title ?></div>
                </a></td>
              <td data-th="Price"><i class="fa fa-inr"></i> <?php echo $prod->price ?>/<?php echo $timeUnit ?></td>
              <td data-th="Rent Time"><?php echo $prod->prod_count ?></td>
            </tr>
            
			<?php }//foreach
			} //if 
			 ?>			
            </tbody>
          </table>
        
		