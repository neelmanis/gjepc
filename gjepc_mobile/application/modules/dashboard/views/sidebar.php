<?php $profilePhoto = $info[0]->profilePhoto;
$userId=$info[0]->regId;
$userId=base64_encode($userId);
?>

<?php 


if($profilePhoto!='')
$pic = image_resizer('',259,194,$croptofit='crop-to-fit',$profilePhoto,$info[0]->regId,'profile');
else
$pic= base_url() . 'assets/images/profilePhoto.jpg';	
 ?>
<div class="userPanel">
    <div class="userPic"><img src="<?php echo $pic; ?>"></div>
    <div class="userArea">
        <div class="userName"><?php echo $info[0]->firstName . ' ' . $info[0]->lastName; ?></div>
        <div class="userLinks">
            <a href="<?php echo base_url()."users/view_user_profile/".$userId; ?>" class="orange">View Profile</a>
            <a href="<?php echo base_url()."dashboard/view_profile/".$userId; ?>" class="blue">Edit Profile</a>
        </div>
    </div>
</div>