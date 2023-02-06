<?php 
$pageTitle = "Gem & Jewellery | Careers- GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php
include 'include-new/header.php';
include 'db.inc.php'; 
?>
<section class="py-5">

<div class="container inner_container">
    <div class="row justify-content-center orgIntro_txt mb-3 mt-3">
        <div class="col-12 text-center">
        <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
        Careers</h1>
        </div>
    </div>
	<div class="row">

         <div class="col-12">                
            <a href="pdf/Head–Sales-&-Marketing.pdf" target="_blank" class="new_pdf_wrp">
              <p class="blue">2022-12-20</p> 
              <div class="circular_text">Head – Sales & Marketing (IJPM)</div>
            </a>              
        </div>
        
        <div class="col-12">                
            <a href="pdf/Chief-Operating-officer.pdf" target="_blank" class="new_pdf_wrp">
              <p class="blue">2022-12-20</p> 
              <div class="circular_text">Chief Operating officer</div>
            </a>              
        </div>
        <div class="col-12">                
            <a href="pdf/Director-Finance-IJPM.pdf" target="_blank" class="new_pdf_wrp">
              <p class="blue">2022-12-20</p> 
              <div class="circular_text">Director/ Dy Director/ Assistant Director </div>
            </a>              
        </div>



       <!-- <div class="col-12">
            <div name="Imports">
				<?php 
                $sql="SELECT * FROM `job_master` WHERE 1 and `status`='1' and cat_id='1' order by id desc";
                $result=$conn->query($sql);
                while($rows=$result->fetch_assoc()){
                ?>
                <ul class="career mb-5 rounded fade_anim">
                    <li>
                        <div class="docs_name">Post </div>
                        <div class="blank"><h2 class="job_head title mb-0"><?php echo filter($rows['position_name']);?></h2></div> 
                    </li>
                    <li>
                        <div class="docs_name">Location </div>
                        <div class="blank"><?php echo filter($rows['location']);?></div> 
                    </li>
                    <li>
                        <div class="docs_name">Qualification</div>
                        <div class="blank"><?php echo filter($rows['qualification']);?></div> 
                    </li>
                    <li>
                        <div class="docs_name">Experience</div>
                        <div class="blank"><?php echo filter($rows['experience']);?></div> 
                    </li>
                    <li>
                        <div class="docs_name">Description</div>
                        <div class="blank">
                            <p><a href="admin/ResumeProfile/<?php echo $rows['profile_detail'];?>" target="_blank">Click here for Complete Profile</a></p>
                            <p>Suitable candidates may forward their CV at <a href="mailto:hr@gjepcindia.com">hr@gjepcindia.com</a></p>
                        </div> 
                    </li>
                    <li>
                        <div class="blank"><a href="apply_now.php?jid=<?php echo $rows['id'];?>&page=gjepc" class="fade_anim cta">APPLY</a></div>
                    </li>
                </ul>                    
                <?php } ?>        		
			</div>   
		</div>            
			           
		<div class="col-12">
            <div name="exports">
                <?php 
                $sql="SELECT * FROM `job_master` WHERE 1 and `status`='1' and cat_id='2' order by id desc";
                $result=$conn->query($sql);
                while($rows=$result->fetch_assoc()){ ?>   
                
                <ul class="career mb-5 rounded fade_anim">
					<li>
    					<div class="docs_name">Post </div>
    					<div class="blank"><h2 class="job_head title mb-0"><?php echo filter($rows['position_name']);?></h2></div>
					</li>
                    <li>
    					<div class="docs_name">Location </div>
    					<div class="blank"><?php echo filter($rows['location']);?></div>
					</li>
					<li>
    					<div class="docs_name">Qualification </div>
    					<div class="blank"><?php echo filter($rows['qualification']);?></div>
					</li>
					<li>
    					<div class="docs_name">Experience </div>
    					<div class="blank"><?php echo filter($rows['experience']);?></div>
					</li>
                    <li>
                        <div class="docs_name">Description</div>
                        <div class="blank"><?php echo filter($rows['requirement']);?></a></div>
                    </li>
                    <li>
                        <div class="blank"><a href="apply_now.php?jid=<?php echo $rows['id'];?>&page=center" class="fade_anim cta">APPLY</a></div>
                    </li>
                </ul>  
                <?php } ?>
            </div>
		</div>	-->
        
        <!-- <h2 class="title" style="font-weight:normal; text-transform:inherit; color:#000;"> Currently no Vacancies </h2> -->
        		
    </div>
    <!-- <div  style="display: block; margin-top: 180px"></div> -->

</div>

</section>
<?php include 'include-new/footer.php'; ?>