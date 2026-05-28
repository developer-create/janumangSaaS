<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-phone"></i> Phone Directory Management
            <small>Add New Phone Directory Entry</small>
        </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Phone Directory Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addPhoneDirectory" action="<?php echo base_url() ?>phonedirectory/add" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="name">Name <span class="required">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('name'); ?>" id="name" name="name" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post">Post</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('post'); ?>" id="post" name="post" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">Department</label>
                                        <select class="form-control" id="department_id" name="department_id">
                                            <option value="">Select Department</option>
                                            <?php
                                            if(!empty($departments))
                                            {
                                                foreach ($departments as $dept)
                                                {
                                                    ?>
                                                    <option value="<?php echo $dept->id ?>" <?php if($dept->id == set_value('department_id')) {echo "selected=selected";} ?>><?php echo $dept->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district_id">District</label>
                                        <select class="form-control" id="district_id" name="district_id">
                                            <option value="">Select District</option>
                                            <?php
                                            if(!empty($districts))
                                            {
                                                foreach ($districts as $dist)
                                                {
                                                    ?>
                                                    <option value="<?php echo $dist->id ?>" <?php if($dist->id == set_value('district_id')) {echo "selected=selected";} ?>><?php echo $dist->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vs_block_id">VS Block</label>
                                        <select class="form-control" id="vs_block_id" name="vs_block_id">
                                            <option value="">Select Block</option>
                                            <?php
                                            if(!empty($blocks))
                                            {
                                                foreach ($blocks as $block)
                                                {
                                                    ?>
                                                    <option value="<?php echo $block->id ?>" <?php if($block->id == set_value('vs_block_id')) {echo "selected=selected";} ?>><?php echo $block->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="party_id">Party</label>
                                        <select class="form-control" id="party_id" name="party_id">
                                            <option value="">Select Party</option>
                                            <?php
                                            if(!empty($parties))
                                            {
                                                foreach ($parties as $party)
                                                {
                                                    ?>
                                                    <option value="<?php echo $party->id ?>" <?php if($party->id == set_value('party_id')) {echo "selected=selected";} ?>><?php echo $party->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number">Number <span class="required">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('number'); ?>" id="number" name="number" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alternate_number">Alternate Number</label>
                                        <input type="text" class="form-control" value="<?php echo set_value('alternate_number'); ?>" id="alternate_number" name="alternate_number" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" value="<?php echo set_value('email'); ?>" id="email" name="email" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <textarea class="form-control" rows="4" id="remark" name="remark"><?php echo set_value('remark'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                            <a class="btn btn-warning" href="<?php echo base_url(); ?>phonedirectory">Back</a>
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

<script src="<?php echo base_url(); ?>assets/js/addPhoneDirectory.js" type="text/javascript"></script>