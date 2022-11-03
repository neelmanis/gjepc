<?php 
//echo "<pre>";print_r($address);


?>

 <table class="rwd-table" id="dataTables">
          <thead>
            <tr>
			 <th>Title</th>	
              <th>Name</th>
              <th>Address</th>
              <th>City</th>
              <th>State</th>
              <th>Country</th>
			   <th>Action</th>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($address)) 
			{
				foreach($address as $add) 
				{ 
				 
					$cityName=Modules::run('cities/_getName', $add->cityId);
					$stateName=Modules::run('states/_getName', $add->stateId);
					$countryName=Modules::run('countries/_getName', $add->countryId);
					$addId=base64_encode($add->addId);
				?>
            <tr>
			 <td data-th="Product Name"><?php echo "$add->title"?></td>
              <td data-th="Product Name"><?php echo "$add->firstName" ." ". "$add->lastName" ?></td>
              <td data-th="Price"><?php echo "$add->building" . ',' . "$add->street" ?> </td>
              <td data-th="From"><?php echo $cityName ?></td>
              <td data-th="To"><?php echo $stateName ?></td>
              <td data-th="Total Spend"> <?php echo $countryName ?></td>
			  <td data-th="Edit / Delete" class="editDelete"><a href="<?php echo base_url();?>dashboard/editaddress/<?php echo $addId ?>">Edit</a><a href="" class="deladdress" id="<?php echo $add->addId; ?>">Delete</a></td></tr>
            <?php }//foreach
			} //if 
			?>			
            </tbody>
          </table>
        
		