<?php $profilePhoto = $info[0]->profilePhoto;
$coverPhoto = $info[0]->coverPhoto;
 $regId=$info[0]->regId;
//$regId=base64_decode($regId);
?>
<style>
#imgid1{
	
	height:74px;
	width:297px;
}
</style>
<?php 

$pic = (empty($profilePhoto) || !file_exists("uploads/users/$regId/$profilePhoto")) ? 'assets/images/profilePhoto.jpg' : "uploads/users/$regId/$profilePhoto"; ?>
<?php $Coverpic = (empty($coverPhoto) || !file_exists("uploads/users/$regId/$coverPhoto")) ? 'assets/images/coverPhoto.jpg' : "uploads/users/$regId/$coverPhoto"; ?>
 <div class="col-sm-9">
      <form class="profile" id="update_profile_photo" >
        <fieldset>
          <legend>Profile Photo</legend>
		  <div class="validError">
			  </div>
          <div class="form-group row uploadPhoto">
            <div class="col-xs-3">
              <div class="profilePhoto"><img id="imgid" src="<?php echo base_url($pic); ?>"></div>
            </div>
            <div class="col-xs-9">
              <div class="uploadBtn">
                <div>
                  <input type="file" id="uploadPhoto" class="hiddenFile uploads" name="profilePhoto" />
                  <a href="" onclick="document.getElementById('uploadPhoto').click(); return false" class="btn borderBtn">Upload</a></div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-xs-12">
			  <input type="hidden" name="page_type" value="update_profile_photo" />
			  <input type="hidden" name="regId" value="<?php echo $info[0]->regId; ?>" />
			  <input type="hidden" name="currentProfilePhoto" value="<?php echo $profilePhoto; ?>" />
              <input type="submit" value="Save" class="btn orangeBorder borderBtn">
			  <input onclick="location.href='<?php echo base_url().'dashboard/profile' ?>'" type="button" value="Cancel" class="btn borderBtn">
            </div>
          </div>
         
        </fieldset>
		</form>
		<form class="profile" id="update_cover_photo">
        <fieldset>
          <legend>Cover Photo</legend>
          <div class="form-group row uploadCover">
            <div class="col-xs-7">
              <div class="profilePhoto"><img src="<?php echo base_url($Coverpic); ?>" id="imgid1"></div>
            </div>
            <div class="col-xs-5">
              <div class="uploadBtn">
                <div>
                  <input type="file" id="uploadCover" class="hiddenFile uploads1" name="coverPhoto" />
                  <a href="" onclick="document.getElementById('uploadCover').click(); return false" class="btn borderBtn">Upload</a></div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-xs-12">
			  <input type="hidden" name="page_type" value="update_cover_photo" />
			  <input type="hidden" name="regId" value="<?php echo $info[0]->regId; ?>" />
			  <input type="hidden" name="currentCoverPhoto" value="<?php echo $coverPhoto; ?>" />
              <input type="submit" value="Save" class="btn orangeBorder borderBtn">
			  <input onclick="location.href='<?php echo base_url().'dashboard/profile' ?>'" type="button" value="Cancel" class="btn borderBtn">
            </div>
          </div>
         
        </fieldset>
        
      </form>
    </div>
