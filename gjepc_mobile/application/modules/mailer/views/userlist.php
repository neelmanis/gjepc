<div class="row mt">
          		  	
              <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
                            <h4><i class="fa fa-angle-right"></i> User list</h4>
                            <hr>
                              <thead>
                                <tr>
                                  <th><i class="fa fa-envelope-o"></i> Email</th>
                                  <th ><i class="fa fa-user"></i> Username</th>
                                  <th><i class="fa fa-user-plus"></i> Account type</th>
                                  <th><i class=" fa fa-edit"></i> Status</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php

                                  $count=1;

                                foreach($userlist as $values)
                                {
                                        if($count==1)
                                        {
                                          
                                              $count+=1;
                                              continue;

                                        }
                                    $accounttype=$values->usertype=='A'?"Admin":"users";
                                    $isActive=$values->isActive=='1'?"Active":"Disable";
                                  ?>
                                     <tr>
                                  <td><?php echo $values->email;?></td>
                                  <td ><?php echo $values->username;?></td>
                                 <td><?php echo $accounttype;?></td>
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
                                 
                                  <td>
                                      <a href="#" title="View <?php echo $values->email;?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                                      <a href="#" title="Edit <?php echo $values->email;?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                      <a href="#" title="Delete <?php echo $values->email;?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                  </td>
                              </tr>
                              

                                  <?php

                                }



                              ?>
                             
                              </tbody>
                          </table>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
          	</div><!-- /row -->