<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Jansunwai Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addJansunwai" action="<?php echo base_url() ?>user/addNewJansunwai" enctype="multipart/form-data" method="post">
                        <div class="box-body">
                            <div class="row">
                                <!-- Sector Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector_name">Sector Name</label>
                                        <input type="text" class="form-control required" id="sector_name" name="sector_name" value="<?php echo set_value('sector_name'); ?>">
                                        <?php echo form_error('sector_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Micro Sector No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">Micro Sector No.</label>
                                        <input type="text" class="form-control required" id="micro_sector_no" name="micro_sector_no" value="<?php echo set_value('micro_sector_no'); ?>">
                                        <?php echo form_error('micro_sector_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                  <!-- Micro Sector Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">Micro Sector Name</label>
                                        <input type="text" class="form-control required" id="micro_sector_name" name="micro_sector_name" value="<?php echo set_value('micro_sector_name'); ?>">
                                        <?php echo form_error('micro_sector_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                              
                                <!-- Year -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input type="number" class="form-control required" id="year" name="year" value="<?php echo set_value('year'); ?>">
                                        <?php echo form_error('year', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                           
                                <!-- Month -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                         <select name="month" id="month" class="form-control">
                    <option value="">Select Month</option>
                    <?php
                    $months = [
                        '01' => 'January',
                        '02' => 'February',
                        '03' => 'March',
                        '04' => 'April',
                        '05' => 'May',
                        '06' => 'June',
                        '07' => 'July',
                        '08' => 'August',
                        '09' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December'
                    ];
                    foreach ($months as $key => $value) {
                        echo "<option value='{$key}'>{$value}</option>";
                    }
                    ?>
                </select>
                
                <?php echo form_error('month', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Date -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo set_value('date'); ?>">
                                        <?php echo form_error('date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- District -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <input type="text" class="form-control required" id="district" name="district" value="<?php echo set_value('district'); ?>">
                                        <?php echo form_error('district', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Assembly -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="assembly">Assembly</label>
                                        <input type="text" class="form-control required" id="assembly" name="assembly" value="<?php echo set_value('assembly'); ?>">
                                        <?php echo form_error('assembly', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <!-- Block -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block</label>
                                          <select  class="form-control select2 required" id="block" name="block">
                                            <option value="">Select</option>
                         <?php foreach($blocks as $eachblock){ ?>
                    <option value="<?php echo $eachblock['id'] ?>"><?php echo $eachblock['name'] ?></option>
                    <?php }   ?>
                     
                    </select>
                                        <?php echo form_error('block', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <!-- Recommended Letter No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="recommended_letter_no">Recommended Letter No</label>
                                        <input type="text" class="form-control required" id="recommended_letter_no" name="recommended_letter_no" value="<?php echo set_value('recommended_letter_no'); ?>">
                                        <?php echo form_error('recommended_letter_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            <!-- Booth Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">Booth Name</label>
                                         <select class="form-control select2 required" id="booth_name" name="booth_name">
                                            <option value="">Select Booth</option>
                                            <!-- Booth options will be populated dynamically based on selected Block -->
                                        </select>
                                        <?php echo form_error('booth_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Booth No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">Booth No.</label>
                                       <select class="form-control select2 required" id="booth_no" name="booth_no">
                                            <option value="">Select Booth</option>
                                            <!-- Booth options will be populated dynamically based on selected Block -->
                                        </select>
                                        
                                        <?php echo form_error('booth_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row">
                                <!-- Panchayat Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panchayat_name">Panchayat Name</label>
                                         <select class="form-control select2 required" id="panchayat_name" name="panchayat_name" required>
                                            <option value="">Select Panchayat</option>
                                            <!-- Panchayat options will be populated dynamically based on selected Booth -->
                                        </select>
                                        <?php echo form_error('panchayat_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Village -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">Village</label>
                                          <select class="form-control select2 required" id="village" name="village" required>
                                            <option value="">Select Village</option>
                                          </select>
                                        <?php echo form_error('village', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <!-- Majra-Faliya -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="majra_faliya">Majra-Faliya</label>
                                        <input type="text" class="form-control required" id="majra_faliya" name="majra_faliya" value="<?php echo set_value('majra_faliya'); ?>">
                                        <?php echo form_error('majra_faliya', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <!-- Work/Problem -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="work_problem">Work/Problem</label>
                                        <input type="text" class="form-control required" id="work_problem" name="work_problem" value="<?php echo set_value('work_problem'); ?>">
                                        <?php echo form_error('work_problem', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            
                                <!-- Office -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="office">Office</label>
                                        <input type="text" class="form-control required" id="office" name="office" value="<?php echo set_value('office'); ?>">
                                        <?php echo form_error('office', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Approximate Cost -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="approximate_cost">Approximate Cost</label>
                                        <input type="text" class="form-control required" id="approximate_cost" name="approximate_cost" value="<?php echo set_value('approximate_cost'); ?>">
                                        <?php echo form_error('approximate_cost', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Department -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                       <select  class="form-control select2 required" id="department" name="department">
                                            <option value="">Select</option>
                                        <?php foreach($departments as $eachblock){ ?>
                                        <option value="<?php echo $eachblock['id'] ?>"><?php echo $eachblock['name'] ?></option>
                                        <?php } ?>
                                        </select>
                                        <?php echo form_error('department', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Priority -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <input type="text" class="form-control required" id="priority" name="priority" value="<?php echo set_value('priority'); ?>">
                                        <?php echo form_error('priority', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <!-- TS No/Date -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ts_no_date">TS No/Date</label>
                                        <input type="text" class="form-control" id="ts_no_date" name="ts_no_date" value="<?php echo set_value('ts_no_date'); ?>">
                                        <?php echo form_error('ts_no_date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <!-- AS No/Date -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="as_no_date">AS No/Date</label>
                                        <input type="text" class="form-control" id="as_no_date" name="as_no_date" value="<?php echo set_value('as_no_date'); ?>">
                                        <?php echo form_error('as_no_date', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                         
                                <!-- Type of Work -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type_of_work">Type of Work</label>
                                        <input type="text" class="form-control required" id="type_of_work" name="type_of_work" value="<?php echo set_value('type_of_work'); ?>">
                                        <?php echo form_error('type_of_work', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Middle Men -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_men">Middle Men</label>
                                        <input type="text" class="form-control required" id="middle_men" name="middle_men" value="<?php echo set_value('middle_men'); ?>">
                                        <?php echo form_error('middle_men', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Cont No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cont_no">Cont No.</label>
                                        <input type="number" class="form-control required" id="cont_no" name="cont_no" value="<?php echo set_value('cont_no'); ?>" maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only">
                                        <?php echo form_error('cont_no', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <!-- Beneficial -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="beneficial">Beneficial(Name)</label>
                                        <input type="text" class="form-control required" id="beneficial" name="beneficial" value="<?php echo set_value('beneficial'); ?>">
                                        <?php echo form_error('beneficial', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                 <!-- Cont No -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile">Cont No.</label>
                                        <input type="number" class="form-control required" id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>" maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only">
                                        <?php echo form_error('mobile', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="row">
                                <!-- PO -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po">PO</label>
                                        <input type="text" class="form-control required" id="po" name="po" value="<?php echo set_value('po'); ?>">
                                        <?php echo form_error('po', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                                
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="po">Avedan</label>
                                            <input type="file" name="file" />
                                        <?php echo form_error('file', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                
                                
                                <!-- Work Status -->
    <input type="hidden" class="form-control required" id="work_status" name="work_status" value="Incomplete">

                                <!--<div class="col-md-4">-->
                                <!--    <div class="form-group">-->
                                <!--        <label for="work_status">Work Status</label>-->
                                <!--        <input type="text" class="form-control required" id="work_status" name="work_status" value="<?php echo set_value('work_status'); ?>">-->
                                        
                                <!--        <select class="form-control required select2" id="work_status" name="work_status">             -->
                                <!--            <option value="Incomplete">Select Status</option>-->
                                <!--            <option value="Incomplete">Incomplete</option>-->
                                <!--             <option value="In progress">In progress</option>-->
                                <!--             <option value="Complete">Complete</option>-->
                                <!--        </select>-->
                                        <?php echo form_error('work_status', '<div class="text-danger">', '</div>'); ?> 
                                <!--    </div>-->
                                <!--</div>-->
                            </div>

                            <div class="row">
                                <!-- Remark/Goshana -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark_goshana">Remark/Goshana (भईया द्वारा दिए गए निर्देश)</label>
                                        <textarea class="form-control required" id="remark_goshana" name="remark_goshana"><?php echo set_value('remark_goshana'); ?></textarea>
                                        <?php echo form_error('remark_goshana', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                $this->load->helper('form');
                $success = $this->session->flashdata('success');
                if($success)
                {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                 
            </div>
        </div>    
    </section>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('#block').change(function() {
        var blockId = $(this).val();
        if(blockId != 0) {
            $.ajax({
                url: '<?php echo site_url('panchayat/getBoothsByBlock'); ?>',
                method: 'POST',
                data: {blockid: blockId},
                dataType: 'json',
                success: function(response) {
                    $('#booth_name').empty();
                    $('#booth_name').append('<option value="">Select Booth</option>');
                    $.each(response, function(index, value) {
                        $('#booth_name').append('<option bnumbervalue="' + value.bnumber + '"   value="' + value.id + '">' + value.name + '</option>');
                    });  
                    
                    
                                      $('#booth_no').empty().append('<option value="">Select Booth No.</option>');

                    
                }
            });
        } else {
            
            $('#booth_name').empty();
            $('#booth_name').append('<option value="">Select Booth</option>');
            
                      $('#booth_no').empty().append('<option value="">Select Booth No.</option>');

            
            
            
        }
    });
    
     $('#booth_name').change(function() {
        var boothid = $(this).val();
        if(boothid != 0) {
            
            
             var selectedBooth = $('#booth_name option:selected');
        var bnumber = selectedBooth.attr('bnumbervalue');
        
         if (bnumber) {
            $('#booth_no').empty().append('<option value="">Select Booth No.</option>');
            $('#booth_no').append('<option value="' + selectedBooth.val() + '" selected>' + bnumber + '</option>');
        } else {
            $('#booth_no').empty().append('<option value="">Select Booth No.</option>');
        }
        
        
        
        
            $.ajax({
                url: '<?php echo site_url('panchayat/getpanchayatidByBooth'); ?>',
                method: 'POST',
                data: {boothid: boothid},
                dataType: 'json',
                success: function(response) {
                    $('#panchayat_name').empty();
                    $('#panchayat_name').append('<option value="">Select Panchayat</option>');
                    $.each(response, function(index, value) {
                        $('#panchayat_name').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#panchayat_name').empty();
            $('#panchayat_name').append('<option value="">Select Panchayat</option>');
        }
    });
    
         $('#panchayat_name').change(function() {
        var boothid = $(this).val();
        if(boothid != 0) {
            $.ajax({
                url: '<?php echo site_url('panchayat/getvillageBypanchayat'); ?>',
                method: 'POST',
                data: {panchayatid: boothid},
                dataType: 'json',
                success: function(response) {
                    $('#village').empty();
                    $('#village').append('<option value="">Select Village</option>');
                    $.each(response, function(index, value) {
                        $('#village').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#village').empty();
            $('#village').append('<option value="">Select Village</option>');
        }
    });
    
    
});
</script>

 