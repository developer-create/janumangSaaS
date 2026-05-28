<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Jansunwai Details</h3>
                    </div>
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editJansunwai" enctype="multipart/form-data"  action="<?php echo base_url() ?>user/updateJansunwai" method="post">
                        <div class="box-body">
                            <input type="hidden" name="id" value="<?php echo $jansunwai->id; ?>">
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector_name">Sector Name</label>
                                        <input type="text" class="form-control required" id="sector_name" name="sector_name" value="<?php echo set_value('sector_name', $jansunwai->sector_name); ?>">
                                        <?php echo form_error('sector_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">Micro Sector No.</label>
                                        <input type="text" class="form-control required" id="micro_sector_no" name="micro_sector_no" value="<?php echo set_value('micro_sector_no', $jansunwai->micro_sector_no); ?>">
                                        <?php echo form_error('micro_sector_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">Micro Sector Name</label>
                                        <input type="text" class="form-control required" id="micro_sector_name" name="micro_sector_name" value="<?php echo set_value('micro_sector_name', $jansunwai->micro_sector_name); ?>">
                                        <?php echo form_error('micro_sector_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input type="number" class="form-control required" id="year" name="year" value="<?php echo set_value('year', $jansunwai->year); ?>">
                                        <?php echo form_error('year', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                        <input type="text" class="form-control required" id="month" name="month" value="<?php echo set_value('month', $jansunwai->month); ?>">
                                        <?php echo form_error('month', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo set_value('date', $jansunwai->date); ?>">
                                        <?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <input type="text" class="form-control required" id="district" name="district" value="<?php echo set_value('district', $jansunwai->district); ?>">
                                        <?php echo form_error('district', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="assembly">Assembly</label>
                                        <input type="text" class="form-control required" id="assembly" name="assembly" value="<?php echo set_value('assembly', $jansunwai->assembly); ?>">
                                        <?php echo form_error('assembly', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block</label>
                                        <select  class="form-control select2 required" id="block" name="block">
                                            <option value="0">Select</option>
                                             <?php   foreach($blocks as $eachblock){ ?>
                                        <option value="<?php echo $eachblock['id'] ?>"  <?php if($jansunwai->block==$eachblock['id']){ echo "selected";} ?>    ><?php echo $eachblock['name'] ?></option>
                                         <?php } ?>
                                        </select>
                                        <?php echo form_error('block', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="recommended_letter_no">Recommended Letter No.</label>
                                        <input type="text" class="form-control required" id="recommended_letter_no" name="recommended_letter_no" value="<?php echo set_value('recommended_letter_no', $jansunwai->recommended_letter_no); ?>">
                                        <?php echo form_error('recommended_letter_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                           
                              <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">Booth Name</label>
                                        <input type="text" class="form-control required" id="booth_name" name="booth_name" value="<?php echo set_value('booth_name', $jansunwai->booth_name); ?>">
                                        <?php echo form_error('booth_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">Booth No.</label>
                                        <input type="text" class="form-control required" id="booth_no" name="booth_no" value="<?php echo set_value('booth_no', $jansunwai->booth_no); ?>">
                                        <?php echo form_error('booth_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                             
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panchayat_name">Panchayat Name</label>
                                        <input type="text" class="form-control required" id="panchayat_name" name="panchayat_name" value="<?php echo set_value('panchayat_name', $jansunwai->panchayat_name); ?>">
                                        <?php echo form_error('panchayat_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">Village</label>
                                        <input type="text" class="form-control required" id="village" name="village" value="<?php echo set_value('village', $jansunwai->village); ?>">
                                          <?php echo form_error('village', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="majra_faliya">Majra-Faliya</label>
                                        <input type="text" class="form-control required" id="majra_faliya" name="majra_faliya" value="<?php echo set_value('majra_faliya', $jansunwai->majra_faliya); ?>">
                                        <?php echo form_error('majra_faliya', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="work_problem">Work/Problem</label>
                                        <input type="text" class="form-control required" id="work_problem" name="work_problem" value="<?php echo set_value('work_problem', $jansunwai->work_problem); ?>">
                                        <?php echo form_error('work_problem', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office">Office</label>
                                        <input type="text" class="form-control required" id="office" name="office" value="<?php echo set_value('office', $jansunwai->office); ?>">
                                        <?php echo form_error('office', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approximate_cost">Approximate Cost</label>
                                        <input type="number" step="0.01" class="form-control required" id="approximate_cost" name="approximate_cost" value="<?php echo set_value('approximate_cost', $jansunwai->approximate_cost); ?>">
                                        <?php echo form_error('approximate_cost', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                    <select  class="form-control select2 required" id="department" name="department">
                                            <option value="0">Select</option>
                                        <?php foreach($departments as $eachblock){ ?>
                                        <option value="<?php echo $eachblock['id'] ?>" <?php if($jansunwai->department==$eachblock['id']){ echo "selected";} ?> ><?php echo $eachblock['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                        <?php echo form_error('department', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <input type="text" class="form-control required" id="priority" name="priority" value="<?php echo set_value('priority', $jansunwai->priority); ?>">
                                        <?php echo form_error('priority', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ts_no_date">TS No/Date</label>
                                        <input type="text" class="form-control required" id="ts_no_date" name="ts_no_date" value="<?php echo set_value('ts_no_date', $jansunwai->ts_no_date); ?>">
                                        <?php echo form_error('ts_no_date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="as_no_date">AS No/Date</label>
                                        <input type="text" class="form-control required" id="as_no_date" name="as_no_date" value="<?php echo set_value('as_no_date', $jansunwai->as_no_date); ?>">
                                        <?php echo form_error('as_no_date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type_of_work">Type of Work</label>
                                        <input type="text" class="form-control required" id="type_of_work" name="type_of_work" value="<?php echo set_value('type_of_work', $jansunwai->type_of_work); ?>">
                                        <?php echo form_error('type_of_work', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_men">Middle Men</label>
                                        <input type="text" class="form-control required" id="middle_men" name="middle_men" value="<?php echo set_value('middle_men', $jansunwai->middle_men); ?>">
                                        <?php echo form_error('middle_men', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cont_no">Cont No</label>
                                        <input type="text" class="form-control required" id="cont_no" name="cont_no" value="<?php echo set_value('cont_no', $jansunwai->cont_no); ?>">
                                        <?php echo form_error('cont_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="beneficial">Beneficial</label>
                                        <input type="text" class="form-control required" id="beneficial" name="beneficial" value="<?php echo set_value('beneficial', $jansunwai->beneficial); ?>">
                                        <?php echo form_error('beneficial', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">Cont No.</label>
                                        <input type="text" class="form-control required" id="mobile" name="mobile" value="<?php echo set_value('mobile', $jansunwai->mobile); ?>">
                                        <?php echo form_error('mobile', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>
 
                            
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po">PO</label>
                                        <input type="text" class="form-control required" id="po" name="po" value="<?php echo set_value('po', $jansunwai->po); ?>">
                                        <?php echo form_error('po', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="work_status">Work Status</label>-->
                                        <!--<input type="text" class="form-control required" id="work_status" name="work_status" value="<?php echo set_value('work_status', $jansunwai->work_status); ?>">-->
                                <!--         <select class="form-control required select2" id="work_status" name="work_status">             -->
                                <!--            <option value="0" >Select Status</option>-->
                                <!--            <option value="Incomplete" <?php if($jansunwai->work_status== 'Incomplete'){ echo "selected";} ?>>Incomplete</option>-->
                                <!--             <option value="In progress" <?php if($jansunwai->department== 'In progress' ){ echo "selected";} ?>>In progress</option>-->
                                <!--             <option value="Complete" <?php if($jansunwai->department== 'Complete'){ echo "selected";} ?>>Complete</option>-->
                                <!--        </select>-->
                                <!--        <?php echo form_error('work_status', '<div class="text-danger">', '</div>'); ?>-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>

                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po">Avedan</label>
                                            <input type="file" name="file" />
                                        <?php echo form_error('file', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                            <div class="form-group">
                                <label for="remark">Remark/Goshana</label>
                                <textarea class="form-control required" id="remark" name="remark_goshana"><?php echo set_value('remark_goshana', $jansunwai->remark_goshana); ?></textarea>
                                <?php echo form_error('remark', '<div class="text-danger">', '</div>'); ?>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Update" />
                            <a href="<?php echo base_url(); ?>user/jansunwai" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <?php
                $success = $this->session->flashdata('success');
                if ($success) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>

                <?php
                $error = $this->session->flashdata('error');
                if ($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

 
 
 
 
 
 
 
 
 <script type="text/javascript">
$(document).ready(function() {
});
</script>

 
 
 
 
 
 
 