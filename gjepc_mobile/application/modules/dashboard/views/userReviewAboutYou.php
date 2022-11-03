<?php
$userId=$info[0]->regId;
$userId=base64_encode($userId);
?>


<div class="col-sm-9">
          <div class="reviewTab"><a class="active"  href="<?php echo base_url()?>dashboard/review_about_you/<?php echo $userId; ?>" >Reviews About You <span>(<?php echo $countAbout; ?>)</span></a><a href="<?php echo base_url()?>dashboard/review_by_you/<?php echo $userId; ?>">Reviews By You <span>(<?php echo $countBy; ?>)</span></a></div>
          <ul class="reviewList">
			<?php 
			if(!empty($review))
			{	
			
			 $cnt = sizeof($review);
				
			
				foreach($review as $rev) 
				{ 
					$reviewId=$rev->reviewId;
					$name= Modules::run('users/get_name', $rev->proId);					
					$profilePic= Modules::run('users/get_profilepic', $rev->proId);	?> 
					<?php $pic = image_resizer('',58,58,$croptofit='crop-to-fit',$profilePic,$rev->proId,'profile'); ?>
					<li>
					
						<div class="review">
							<div class="avatar container-fluid">
								<div class="avatarImg"><?php //echo $reviewId; ?><img src="<?php echo $pic; ?>"></div>
								<div class="avatarInfo"><strong><?php echo ucfirst($name); ?></strong><span><?php echo calculatetime($rev->createdDate) ?></span></div>
							</div>
							<div class="avatarReview container-fluid">
								<p><strong class="avatarRated">Rated <span class="green"><?php echo $rev->reviewRate; ?></span></strong>
								<?php echo $rev->review; ?></p>
							</div>
						</div>
					
					</li>
			<?php } ?>
		<?php } 
				else
					{ ?>
				<li>
						<div class="review">
							<div class="avatar container-fluid">
								
								
							</div>
							<div class="avatarReview container-fluid">
								No Reviews....
							</div>
						</div>
					</li>
			  <?php } ?>	
			</ul>			  
			<?php 
			if(!empty($review))
			{
			if($countAbout>2)
			{ ?>	
          <div class="loadMore load-<?php echo $reviewId; ?>">
		  <a  id="<?php echo $reviewId; ?>" class="loadMoreButton loadMoreButtonAboutYou">Load more </a>
		  </div>
		  <input type="hidden" id="regId" value="<?php echo $info[0]->regId;?>" />
		
			
			<?php } } ?>
			
			
          
			
</div>
      
	  