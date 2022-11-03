<?php 
//echo "<pre>"; print_r($prod_list);


?>
     
          <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
              <th>Items</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Remove</th>
              <th>Rent Now</th>
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
              <td data-th="Items"><a href="#"><img src="<?php echo $pic; ?>"></a></td>
              <td data-th="Product Name"><a href="#">
                <div class="nameList"><?php echo $prod->title ?></div>
                </a></td>
              <td data-th="Price"><i class="fa fa-inr"></i> <?php echo $prod->price ?>/<?php echo $timeUnit ?></td>
              <td data-th="Remove" class="editDelete deleteWishlist" id="<?php echo $prod->wish_id; ?>"><a href="">Delete</a></td>
              <td data-th="Rent Now"><div class="rwd-btn"><a href="#">Select Options</a></div></td>
            <?php }//foreach
			} //if 
			 ?>			
            </tbody>
          </table>
     
    
	
	
	