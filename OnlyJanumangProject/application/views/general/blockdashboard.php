<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
         
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>
                      <?php 
                        $userid = $this->session->userdata('userId'); 
                        $userBlockIdQuery = $this->db->select('blockId')
                                     ->from('tbl_users')
                                     ->where('userId', $userid)
                                     ->get();
                        $userBlockIds = $userBlockIdQuery->row()->blockId;
                         $blockIdsArray = explode(',', $userBlockIds);
                          $cc1 = $this->db->query("SELECT count(*) as totalcount 
                                 FROM `jansunwai` 
                                 WHERE block IN (" . implode(',', $blockIdsArray) . ")");
                                 $ca2 = $cc1->row();
                                 echo $ca2->totalcount; 
                        ?>
                    </h3>
                  <p>कुल जनसमस्या</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner"> 
                 <h3>   <?php 
                        $date = date('Y-m-d'); 
                        $userid = $this->session->userdata('userId'); 
                        $userBlockIdQuery = $this->db->select('blockId')
                                     ->from('tbl_users')
                                     ->where('userId', $userid)
                                     ->get();
                        $userBlockIds = $userBlockIdQuery->row()->blockId;
                         $blockIdsArray = explode(',', $userBlockIds);
                          $cc1 = $this->db->query("SELECT count(*) as totalusers FROM `jansunwai` WHERE `work_status`='Complete' and
                          block IN (" . implode(',', $blockIdsArray) . ")");
                                 $ca2 = $cc1->row();
                                 echo $ca2->totalusers; 
                        ?>
                        
                        </h3>
                  <p>कुल पूर्ण जनसमस्या</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3> 
                   <?php 
                        $date = date('Y-m-d'); 
                        $userid = $this->session->userdata('userId'); 
                        $userBlockIdQuery = $this->db->select('blockId')
                                     ->from('tbl_users')
                                     ->where('userId', $userid)
                                     ->get();
                        $userBlockIds = $userBlockIdQuery->row()->blockId;
                         $blockIdsArray = explode(',', $userBlockIds);
                          $cc1 = $this->db->query("SELECT count(*) as userstoday FROM `jansunwai` WHERE  `work_status`='Incomplete'  and
                          block IN (" . implode(',', $blockIdsArray) . ")");
                                 $ca2 = $cc1->row();
                                 echo $ca2->userstoday; 
                        ?>
                        
                        </h3>
                  <p>कुल अपूर्ण जनसमस्या</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>  <?php 
                        $date = date('Y-m-d'); 
                        $userid = $this->session->userdata('userId'); 
                        $userBlockIdQuery = $this->db->select('blockId')
                                     ->from('tbl_users')
                                     ->where('userId', $userid)
                                     ->get();
                        $userBlockIds = $userBlockIdQuery->row()->blockId;
                         $blockIdsArray = explode(',', $userBlockIds);
                          $cc1 = $this->db->query(" SELECT count(*) as totalusers FROM `jansunwai` WHERE `work_status`='In progress'  and  
                          block IN (" . implode(',', $blockIdsArray) . ")");
                                 $ca2 = $cc1->row();
                                 echo $ca2->totalusers; 
                        ?>
                        </h3>
                  <p>प्रगतिरत जनसमस्या</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
  
    </section>
</div>