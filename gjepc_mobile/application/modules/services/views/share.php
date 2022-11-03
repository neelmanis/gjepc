<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lifefeed</title>

<link rel="stylesheet" type="text/css" href="http://digitalagencymumbai.com/lifefeed/public/css/style.css"/>

<link rel="stylesheet" type="text/css" href="http://digitalagencymumbai.com/lifefeed/public/css/font-awesome.css"/>


<link rel="stylesheet" type="text/css" href="http://digitalagencymumbai.com/lifefeed/public/css/slick.css"/>

<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://digitalagencymumbai.com/lifefeed/public/js/slick.js"></script>

<script type="text/javascript">
    $(document).on('ready', function() {
      $(".regular").slick({
       
        infinite: false,
		arrows:false,
		dots:false,
        slidesToShow: 3,
        slidesToScroll: 1,
		autoplay: true,
		
		  responsive: [
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		
        
      }
	}
  ]
		
});
	  
	  
	 $(".conDiv").slick({
       
        infinite: false,
		arrows:false,
		dots:false,
        slidesToShow: 2,
        slidesToScroll: 1,
		autoplay: true,
		
	responsive: [
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        
      }
	},
	  {
      breakpoint: 320,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        
      }
	  
	}
	
	 
  ]
		
      });  
	  
	
	  
      /*$(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true
      });*/
    });
  </script>

</head>

<body>
<?php 

if(is_array($records) && !empty($records['Result']))
{
 /* echo "<pre>";
   print_R($records);
exit;*/
?>
<div id="wrapper">

<div class="title"><img src="http://digitalagencymumbai.com/lifefeed/public/images/logo.png" alt="" /></div>
<?php 
if($share[0]->images == "true") {
?>
<div class="postImage">
<a href="http://digitalagencymumbai.com/lifefeed/uploads/feeds/<?php echo $records['Result'][0]['userfeed'][0]['feeddata']['regId'];?>/images/<?php echo $records['Result'][0]['userfeed'][1]['feedimages'][0]->imageName; ?>">
<img src="http://digitalagencymumbai.com/lifefeed/uploads/feeds/<?php echo $records['Result'][0]['userfeed'][0]['feeddata']['regId'];?>/images/<?php echo $records['Result'][0]['userfeed'][1]['feedimages'][0]->imageName; ?>"/></a>
</div>
<?php  } ?>

<div class="postName">
<div class="postText"><?php echo $records['Result'][0]['userfeed'][0]['feeddata']['catName'];?></div>
<div class="clear"></div>
</div>

<p class="mainPara"><?php echo $records['Result'][0]['userfeed'][0]['feeddata']['description'];?></p>

<?php 
if($share[0]->images == "true")
{
if (count($records['Result'][0]['userfeed'][1]['feedimages'])>1)
{
?>

<div class="grayBg regular slider bottomSpace_1">
       <?php 
             $images = $records['Result'][0]['userfeed'][1]['feedimages'];
             if(is_array($images)) {
				foreach($images as $val) 
				{
			
        ?>  
<div class="scrollImages">
<div>
<a href="images/scrollImg.jpg"><img src="http://digitalagencymumbai.com/lifefeed/uploads/feeds/<?php echo $records['Result'][0]['userfeed'][0]['feeddata']['regId'];?>/images/<?php echo $val->imageName; ?>" alt="" /></a>
</div>
</div>
<?php } } ?>
</div>

<?php } } ?>

 <?php 
 if($share[0]->no_of_people == "true")
 {
 if(!empty($records['Result'][0]['userfeed'][2]['feedcontact'])) {?>
<div class="tableDivNew bottomSpace">

<div class="firstColoumnNew">
<img src="http://digitalagencymumbai.com/lifefeed/public/images/contacts.png" alt="" />
</div>

<div class="conDiv">
<?php 
             $contacts = $records['Result'][0]['userfeed'][2]['feedcontact'];
             if(is_array($contacts)) {
				foreach($contacts as $val) 
				{
				
        ?>  
<div class="contactColoumn1">
<div>

<i class="fa fa-user" aria-hidden="true"></i> <?php echo $val->contactName;?>
</div>
</div>

<?php } } ?>


</div>


<div class="clear"></div>

</div>
<?php } } ?>

<?php 
 if($share[0]->expense == "true")
 {
 if(!empty($records['Result'][0]['userfeed'][0]['feeddata']['amount'])) {?>
<div class="tableDiv">

<div class="firstColoumn">
<img src="http://digitalagencymumbai.com/lifefeed/public/images/expenses.png" alt="" />
</div>



<div class="contactColoumn">
Rs.<?php echo $records['Result'][0]['userfeed'][0]['feeddata']['amount'];?>
</div>



</div>
<?php } } ?>



<?php 
 if($share[0]->location == "true")
 {
   $loc = str_replace(' ', '+',trim($records['Result'][0]['userfeed'][0]['feeddata']['location'])); 
  
 if(!empty($records['Result'][0]['userfeed'][0]['feeddata']['location'])) {?>
<div class="tableDiv">

<div class="firstColoumn">
<a href="https://www.google.co.in/maps/place/<?php echo $loc; ?>/@19.074519,19.074519,18z/data=!3m1!4b1!4m5!3m4!1s0x3be7cebbee994a39:0x7ee7c65c1c7c481a!8m2!3d19.0174653!4d72.8201599"><img src="http://digitalagencymumbai.com/lifefeed/public/images/location.png" alt="" /></a>
</div>
<div class="contactColoumn">
<a href="https://www.google.co.in/maps/place/<?php echo $loc; ?>/@19.074519,19.074519,18z/data=!3m1!4b1!4m5!3m4!1s0x3be7cebbee994a39:0x7ee7c65c1c7c481a!8m2!3d19.0174653!4d72.8201599">
<?php echo $records['Result'][0]['userfeed'][0]['feeddata']['location'];?>
</a>
</div>
</div>
<?php } } ?>



<?php 
if($share[0]->note == "true")
 {

if(!empty($records['Result'][0]['userfeed'][0]['feeddata']['note'])) {?>
<div class="tableDiv">
<div class="firstColoumn">
<img src="http://digitalagencymumbai.com/lifefeed/public/images/notes.png" alt="" />
</div>
<div class="contactColoumn">

<p><?php echo $records['Result'][0]['userfeed'][0]['feeddata']['note'];  ?></p>

</div>
</div>

<?php } } ?>

<div class="bottomDiv"></div>

</div>
<?php  }  else {
echo "<h2>No Feed Found!</h2>";
}
?>
</body>
</html>
