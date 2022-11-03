<div class="row mt">
<div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i> User list</h4>
                            <hr>
                              <thead>
                                <tr>
                                  <th><i class="fa fa-mobile"></i> DeviceId</th>
                                  <th ><i class="fa fa-user"></i> Username</th>
                                  <th><i class="fa fa-mobile-phone"></i> Device type</th>
                                  <th><i class=" fa fa-edit"></i> Status</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php

                                 

                                foreach($devicelist as $values)
                                {
                                        
                                    $devicetype=$values->deviceType=='A'?"Android":"iPhone";
                                    $isActive=$values->isActive=='1'?"Active":"Disable";
                                  ?>
                                     <tr>
                                  <td><?php echo $values->deviceId;?></td>
                                  <td ><?php echo $values->username;?></td>
                                 <td><?php echo $devicetype;?></td>
                                  <td>
                                  <?php
                                      if($isActive=="Active")
                                      {
                                        ?>
                                         <span class="label label-success label-mini"><?php echo $isActive?></span></td>
                                        <?php

                                      }
                                      else
                                      {
                                        ?>
                                           <span class="label label-danger label-mini"><?php echo $isActive?></span></td>
                                        <?php


                                      }?>
                                 
                                 
                              </tr>
                              

                                  <?php

                                }



                              ?>
                             
                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
</div>