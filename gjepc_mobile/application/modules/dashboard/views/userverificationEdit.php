<?php 

 $govFile1 = $info[0]->govFile1;
 $govFile2 = $info[0]->govFile2;
 $govFile3 = $info[0]->govFile3;

 if($info[0]->govID1 > 0)
 $govID1= Modules::run('proofs/_getName', $info[0]->govID1);

if($info[0]->govID2 > 0)
 $govID2= Modules::run('proofs/_getName', $info[0]->govID2);

if($info[0]->govID3 > 0)
 $govID3= Modules::run('proofs/_getName', $info[0]->govID3);
 
  $regId=$info[0]->regId;

  $govFile1 = (empty($govFile1) || !file_exists("uploads/proofs/gov1/$govFile1")) ? 'assets/images/uploadDefault.jpg' : "uploads/proofs/gov1/$govFile1";
  $govFile2 = (empty($govFile2) || !file_exists("uploads/proofs/gov2/$govFile2")) ? 'assets/images/uploadDefault.jpg' : "uploads/proofs/gov2/$govFile2";
  $govFile3 = (empty($govFile3) || !file_exists("uploads/proofs/gov3/$govFile3")) ? 'assets/images/uploadDefault.jpg' : "uploads/proofs/gov3/$govFile3";
?>

<style>
#newProofFile{
	
	height:200px;
	width:200px;
	
}
</style>
<div class="col-sm-9">
         <form class="profile" id="proof">
            <fieldset>
              <legend>Verified identity </legend>
			  
              
			  
		<?php	  if($info[0]->govID1 > 0)
				  { ?>
			
			 <div class="form-group row">			  
                <figure>
                  <div class="docName"><?php echo $govID1; ?></div>
				  <div class="docControl"><a href="" style="padding:5px;border:1px solid #fda134" class=" orangeBorder borderBtn>Update" onclick="document.getElementById('update1').click(); return false">Update</a>
				   <?php if($info[0]->govFile2!='' &&  $info[0]->govFile3!='')
				  { ?> 
				  <span>|</span><a href="" id="<?php echo $regId."-proof1-".$info[0]->govID1."-".$info[0]->govFile1; ?>" class="del">Delete</a>
				  <?php } ?>
				  <input id="update1" type="file"  class="hiddenFile gov1" name="proof1"></div>
                  <img src="<?php echo  base_url($govFile1); ?>" id="gov1">
				</figure>						 
			  </div>
			
			<?php	
				  } ?>
				  
				  <?php	  if($info[0]->govID2 > 0)
				  { ?>
			 <div class="form-group row">			  
                <figure>
                  <div class="docName"><?php echo $govID2; ?></div>
				  <div class="docControl"><a href="" onclick="document.getElementById('update2').click(); return false">Update</a>
				  <?php if($info[0]->govFile1!='' && $info[0]->govFile3!='')
				  { ?>  
			  <span>|</span><a href="" id="<?php echo $regId."-proof2-".$info[0]->govID2."-".$info[0]->govFile2; ?>" class="del">Delete</a>
			  
				<?php } ?>
				  
				  <input id="update2" type="file" class="hiddenFile gov2" name="proof2"></div>
                  <img src="<?php echo  base_url($govFile2); ?>" id="gov2">
				</figure>				
              </div>
				<?php	
				  } ?>
				
           <?php  //--------------------------proof 3--------------------------------------   ?>
		   
		   <?php	  if($info[0]->govID3 > 0)
				  { ?>
			 <div class="form-group row">			  
                <figure>
                  <div class="docName"><?php echo $govID3; ?></div>
				  <div class="docControl"><a href="" onclick="document.getElementById('update3').click(); return false">Update</a>
				  <?php if($info[0]->govFile1!='' && $info[0]->govFile2!='')
				  { ?>  
			  <span>|</span><a href="" id="<?php echo $regId."-proof3-".$info[0]->govID3."-".$info[0]->govFile3; ?>" class="del">Delete</a>
			  
				<?php } ?>
				  
				  <input id="update3" type="file" class="hiddenFile gov3" name="proof3"></div>
                  <img src="<?php echo  base_url($govFile3); ?>" id="gov3">
				</figure>				
              </div>
				<?php	
				  } ?>
			  
		   <?php //---------------------------proof 3 ends ---------------------------------- ?>  
            </fieldset>
            <fieldset>
			<?php if(($info[0]->govID1 == 0) || ($info[0]->govID2 == 0) || ($info[0]->govID3 == 0))
			{ 
		
				$currProof=array();
				if($info[0]->govID1 == 0)
				{
					$currProof[1]= $info[0]->govID2;
					$currProof[2]= $info[0]->govID3;
					$nowUpload="proof1";
				}					
				elseif($info[0]->govID2 == 0)
				{
					$currProof[1]= $info[0]->govID1;
					$currProof[2]= $info[0]->govID3;
					$nowUpload="proof2";
				}
				else
				{
					$currProof[1]= $info[0]->govID1;
					$currProof[2]= $info[0]->govID2;
					$nowUpload="proof3";
					
				}
				//echo "<pre>"; print_r($currProof);
						
				$list= Modules::run('proofs/get_all_govt');
				$main = array();
				if(is_array($list)){
					foreach($list as $li){
						if($li->govId != $currProof[1]){
							if($li->govId != $currProof[2]){
								$main[] = $li;
							}
						}
					}
				}
				
				?>
              <legend>Add new Government IDs </legend>
			  <div class="validError">
			  </div>
			  
              <div class="form-group row">
                <div class="col-xs-12">
				<?php foreach($main as $lists) 
				{ ?>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" value="<?php echo $lists->govId; ?>" name="newProof" id="newProof" class="example">
                      <?php echo $lists->govIdName; ?> </label>
                  </div>
                <?php } ?> 
                  
                </div>
              </div>
              <div class="form-group row">
                <label class="col-xs-3 control-label">Attached documents</label>
				<img src="" id="newProofFile" style="display:none;" />
                <div class="col-xs-8">
                  <input type="file" name="newProofFile" class="newProofFile">
                </div>
              </div>
			  
			<?php } ?>  
			  
			  
              <div class="form-group row">
                <div class="col-xs-12">
				<input type="hidden" name="page_type" value="update_proof" />
				<input type="hidden" name="regId" value="<?php echo $info[0]->regId; ?>" />
				<input type="hidden" name="currentGovFile1" value="<?php echo $info[0]->govFile1; ?>" />
				<input type="hidden" name="currentGovFile2" value="<?php echo $info[0]->govFile2; ?>" />
				<input type="hidden" name="currentGovFile3" value="<?php echo $info[0]->govFile3; ?>" />
                  <input type="submit" value="Save" class="btn orangeBorder borderBtn"><input onclick="location.href='dashboard.php';" type="button" value="Cancel" class="btn borderBtn">
                </div>
              </div>
            </fieldset>
         </form>
        </div>
      
<script>





</script>	  