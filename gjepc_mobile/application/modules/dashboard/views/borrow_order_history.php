         <!-- <form class="container-fluid FlowupLabels">
            <div class="form-group fl_wrap pull-right searchProduct">     
                  <label class="fl_label" for="searchProducts">Search Products</label>
                  <input type="text" class="form-control fl_input" id="searchProducts">  
                  <input type="button" value="Search" class="btn searchBtn">   
            </div>
          </form>-->
           <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
              <th>Renter</th>
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
					
					$profilePic=Modules::run('users/get_profilepic',$prod->renterId);
					$profilePic= image_resizer('',89,100,$croptofit='crop-to-fit',$profilePic,$prod->renterId,'profile');
					
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
				$starRating=Modules::run('review/rating_stars',$prod->renterId);
				$productConditionImage=$this->mdl_dashboard->productConditionImage($prod->orderItemId,$regId);
				//echo "<pre>"; print_r($productConditionImage);
				$before='';
				$after='';
				if($productConditionImage!='')
				{
					foreach($productConditionImage as $condition)
					{
						if($condition->isBefore==0)
							$before=1;
						if($condition->isBefore==1)
							$after=1;
					}
				}
				?>
            <tr>              
              <td data-th="Renter">
              <a href="#">
                <div class="imgRenter"><img src="<?php echo $profilePic; ?>"></div>
                <div class="nameRenter"><?php echo $renterName; ?></div>
               <div class="star-ratings-sprite"><span style="width:<?php echo $starRating ?>" class="star-ratings-sprite-rating"></span></div>
                </a>
              </td><td data-th="Product Name"><a href="#">
                <div class="imgList"><img src="<?php echo $pic; ?>"></div>
                <div class="nameList"><?php echo $prod->title ?></div>
                </a></td>
              <td data-th="Quantity"><?php echo $prod->qty ?></td>
              <td data-th="Price"><i class="fa fa-inr"></i> <?php echo $prod->productPrice ?></td>
              <td data-th="From"><?php echo date('d-m-Y',strtotime($prod->productFrom)) ?></td>
              <td data-th="To"><?php echo date('d-m-Y',strtotime($prod->productTo)) ?></td>
              <td data-th="Deposit"><i class="fa fa-inr"></i> <?php echo $prod->deposit; ?></td>
			  <?php //if($before=='' || $after=='')
			  //{  ?> 
		  
		   <td data-th="Edit / Delete" class="editDelete"><a href="<?php echo base_url() ?>dashboard/addProductPhoto/<?php echo base64_encode($prod->orderItemId) ?>/borrow" class="addProductPhoto" >Add product photos</a></td>
		  
		  <?php //}  else { ?>
		 <!-- <td data-th="Edit / Delete" class="editDelete"><a href="#" >Product photos added</a></td>-->
		  
		  
		<?php  //} ?>
		<?php $isDispute=$this->mdl_dashboard->isDispute($prod->orderItemId,$regId); 
		if(!empty($isDispute))
		{ ?>
			<td class="editDelete"><a href="#" >Disputed</a></td>
			
	<?php	}  else { ?>
			 <td class="editDelete"><a href="" class="dispute" id="<?php  echo $prod->orderItemId."-borrower"; ?>">Dispute</a></td>
			 
		<?php	} ?>
			  
            </tr>         
            <?php }//foreach
			} //if 
			 ?>			
            </tbody>
          </table>
         <!-- <div class="pagination text-right"><a href="#"><i class="fa fa-chevron-left"></i></a><a href="#" class="active">1</a><a href="#">2</a><a>...</a><a href="#">6</a><a href="#"><i class="fa fa-chevron-right"></i></a></div>-->
     
	  
	  
	  