<?php
$userId = @$userInfo->userId;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Servey Management
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">View Servey Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 1</h3></div></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>District</label>
                                        <p><?php
                                        $district_id = isset($userInfo->district) ? $userInfo->district : null;
                                        if ($district_id) {
                                            $dq = $this->db->query("SELECT name FROM district WHERE id = " . (int)$district_id);
                                            $dr = $dq->row();
                                            echo $dr ? htmlspecialchars($dr->name) : '-';
                                        } else { echo '-'; }
                                        ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vidhan Sabha</label>
                                        <p><?php
                                        $vs_id = isset($userInfo->vidhan_sabha_id) ? $userInfo->vidhan_sabha_id : null;
                                        if (!empty($vs_id) && (int)$vs_id > 0) {
                                            $vsq = $this->db->query("SELECT vidhan_sabha_name FROM vidhan_sabha WHERE id = " . (int)$vs_id);
                                            $vsr = $vsq ? $vsq->row() : null;
                                            echo $vsr ? htmlspecialchars($vsr->vidhan_sabha_name) : 'N/A';
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">ब्लॉक का नाम और नंबर</label>
                                       <p><?php echo @$userInfo->block_name_number; ?></p>
                                           
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="janpad_panchayat">Janpad Panchayat</label>
                                        <p><?php echo @$userInfo->janpad_panchayat; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mandalam">Mandalam</label>
                                        <p><?php echo @$userInfo->mandalam; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">बूथ का नाम & नंबर</label>
                                        <p><?php echo @$userInfo->boothname; ?></p>
                                        <p><?php echo @$userInfo->boothnumber; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">ग्राम पंचायत</label>
                                       <p><?php echo @$userInfo->grampanchayat; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">गाँव</label>
                                        <p><?php echo @$userInfo->village;?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">फालिया  / मजरा / टोल</label>
                                        <p><?php echo @$userInfo->toll; ?></p>
                                    </div>
                                </div>
                                
                                
                            </div>
                             <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 2</h3></div></div>
                              <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> नाम </label>
                                        <p><?php echo @$userInfo->name; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">पिता का नाम</label>
                                        <p><?php echo @$userInfo->fathername; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> जाति </label>
                                       <p><?php echo @$userInfo->jaati; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">पिता का नाम</label>
                                      <p><?php echo @$userInfo->age; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> जाति </label>
                                      <p>  <?php echo @$userInfo->jaati; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">शिक्षा</label>
                                        <p><?php echo @$userInfo->education; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> मोबाइल नंबर </label>
                                       <p><?php echo @$userInfo->mobile; ?></p>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 3</h3></div></div>
                             <div class="row">
                                <!--<div class="col-md-6">                                -->
                                <!--    <div class="form-group">-->
                                <!--        <label for="fname"> मतदाता पहचान पत्र </label>-->
                                <!--        <p><?php echo @$userInfo->votarcode; ?></p>-->
                                <!--    </div>-->
                                    
                                <!--</div>-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">पता</label>
                                       <p><?php echo @$userInfo->address; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> मतदाता पहचान पत्र </label>
                                       <p><?php echo @$userInfo->votarcode; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">लिंग</label>
                                        <p><?php echo @$userInfo->gender; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> समूह </label>
                                        <p><?php echo @$userInfo->group; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">वाहन</label>
                                        <p><?php echo @$userInfo->vehicle; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> सरकारी कर्मचारी </label>
                                        <p><?php echo @$userInfo->government_employee; ?></p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row"> <div class="col-md-6">  <h3 class="box-title">Step 4</h3></div></div>
                             <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> पार्टी </label>
                                        <p><?php echo @$userInfo->parti; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">कोड</label>
                                        <p><?php echo @$userInfo->code; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname"> नारी सम्मान  </label>
                                       <p><?php echo @$userInfo->respect_for_women; ?></p>
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">किसान कर्ज माफी</label>
                                       <p><?php echo @$userInfo->farmer_loan_waiver	; ?></p>
                                    </div>
                                </div>
                            </div>
                            



                        </div><!-- /.box-body -->
    
                        <!--<div class="box-footer">-->
                        <!--    <input type="submit" class="btn btn-primary" value="Submit" />-->
                        <!--    <input type="reset" class="btn btn-default" value="Reset" />-->
                        <!--</div>-->
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>