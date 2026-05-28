<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> गणेश समिति प्रबंधन
        <small>नया गणेश समिति जोड़ें</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">गणेश समिति विवरण दर्ज करें</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <?php $this->load->helper('form'); ?>
                    <form role="form" id="addGaneshSamiti" action="<?php echo base_url() ?>ganeshsamiti/addNewGaneshSamiti" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="serial_number">क्र.</label>
                                        <input type="text" class="form-control required" id="serial_number" name="serial_number" maxlength="50" value="<?php echo set_value('serial_number'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">वर्ष</label>
                                        <select class="form-control required" id="year" name="year">
                                            <option value="">वर्ष चुनें</option>
                                            <option value="2020" <?php echo set_select('year', '2020'); ?>>2020</option>
                                            <option value="2021" <?php echo set_select('year', '2021'); ?>>2021</option>
                                            <option value="2022" <?php echo set_select('year', '2022'); ?>>2022</option>
                                            <option value="2023" <?php echo set_select('year', '2023'); ?>>2023</option>
                                            <option value="2024" <?php echo set_select('year', '2024'); ?>>2024</option>
                                            <option value="2025" <?php echo set_select('year', '2025'); ?>>2025</option>
                                            <option value="2026" <?php echo set_select('year', '2026'); ?>>2026</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ganesh_samiti_name">गणेश समिति का नाम</label>
                                        <input type="text" class="form-control required" id="ganesh_samiti_name" name="ganesh_samiti_name" maxlength="100" value="<?php echo set_value('ganesh_samiti_name'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block_name">ब्लॉक</label>
                                        <input type="text" class="form-control" id="block_name" name="block_name" maxlength="100" value="<?php echo set_value('block_name'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sector">सेक्टर</label>
                                        <input type="text" class="form-control" id="sector" name="sector" maxlength="100" value="<?php echo set_value('sector'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="micro_sector_number">माइक्रो सेक्टर नंबर</label>
                                        <input type="text" class="form-control" id="micro_sector_number" name="micro_sector_number" maxlength="50" value="<?php echo set_value('micro_sector_number'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="micro_sector_name">माइक्रो सेक्टर नाम</label>
                                        <input type="text" class="form-control" id="micro_sector_name" name="micro_sector_name" maxlength="100" value="<?php echo set_value('micro_sector_name'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booth_number">बूथ नंबर</label>
                                        <input type="text" class="form-control" id="booth_number" name="booth_number" maxlength="50" value="<?php echo set_value('booth_number'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booth_name">बूथ नाम</label>
                                        <input type="text" class="form-control" id="booth_name" name="booth_name" maxlength="100" value="<?php echo set_value('booth_name'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="panchayat">पंचायत</label>
                                        <input type="text" class="form-control" id="panchayat" name="panchayat" maxlength="100" value="<?php echo set_value('panchayat'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gram">ग्राम</label>
                                        <input type="text" class="form-control" id="gram" name="gram" maxlength="100" value="<?php echo set_value('gram'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faliya">फलिया</label>
                                        <input type="text" class="form-control" id="faliya" name="faliya" maxlength="100" value="<?php echo set_value('faliya'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_name">सदस्य का नाम</label>
                                        <input type="text" class="form-control" id="member_name" name="member_name" maxlength="100" value="<?php echo set_value('member_name'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">पिता का नाम</label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" maxlength="100" value="<?php echo set_value('father_name'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="age">उम्र</label>
                                        <input type="text" class="form-control" id="age" name="age" maxlength="10" value="<?php echo set_value('age'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">पद</label>
                                        <input type="text" class="form-control" id="position" name="position" maxlength="100" value="<?php echo set_value('position'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_number">मोबाइल नंबर</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" maxlength="20" value="<?php echo set_value('mobile_number'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remark">रिमार्क</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3"><?php echo set_value('remark'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="जमा करें" />
                            <input type="reset" class="btn btn-default" value="रीसेट" />
                        </div>
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

<script src="<?php echo base_url(); ?>assets/js/addGaneshSamiti.js" type="text/javascript"></script>