<div class="profile_shital fade_anim shadow_style">  
   
  <h1>  User Information   </h1>
 
 <?php if(is_array($user_info))
        {
 ?>
  <div class="clear"> </div>
  <div class="clear"> </div>
  
  <div class="Row_style">  <span>   Registration ID </span> <?php echo $user_info[0]->regId; ?></div>
   <div class="Row_style">  <span>   User Name    </span> <?php echo $user_info[0]->username ; ?>  </div>
  <div class="Row_style">  <span>   Email    </span>  <?php echo $user_info[0]->email ; ?></div>
  
 
 <?php } ?>
  </div>