<?php 
//echo "<pre>";print_r($prod_list);


?>
<div class="form-group text-right">
          <a href="<?php echo base_url()?>excelController/renter_total_sale" class="btn greenBtn" id="excel_report"><i class="fa fa-file-excel-o"></i> Export</a>
		  </div>
 <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Price</th>
              <th>From</th>
              <th>To</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($prod_list)) 
			{
				$total_sale=0;
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
					$total_sale=$total_sale+($prod->total_price);
					
				
				?>
            <tr>
              <td data-th="Product Name"><a href="#">
                <div class="imgList"><img src="<?php echo $pic; ?>"></div>
                <div class="nameList"><?php echo $prod->title ?></div>
                </a></td>
              <td data-th="Price"><i class="fa fa-inr"></i><?php echo $prod->price ?>/<?php echo $timeUnit ?></td>
              <td data-th="From"><?php echo date('d-m-Y',strtotime($prod->productFrom)) ?></td>
              <td data-th="To"><?php echo date('d-m-Y',strtotime($prod->productTo)) ?></td>
              <td data-th="Total Spend"><i class="fa fa-inr"></i> <?php echo $prod->total_price; ?></td>
            </tr>
           
           <?php }//foreach
			} //if 
			 ?>			
            </tbody>
          
          
            </tbody>
	<?php if(!empty($prod_list)) 
			{	?>	
            <tfoot>
            <tr>
            <td>Total Sale</td>
            <td></td>
            <td></td>
            <td></td>
            <td><i class="fa fa-inr"></i> <?php echo number_format($total_sale,2) ?></td>
            </tr>
            </tfoot>
			<?php } ?>		
			
          </table>
        
	