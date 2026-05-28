<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tasks" aria-hidden="true"></i> Project Summary Management
        <small>Edit Project</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Project Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editProject" action="<?php echo base_url() ?>projectSummary/editProject" method="post" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="district_id">District</label>
                                        <select class="form-control required" id="district_id" name="district_id">
                                            <option value="">Select District</option>
                                            <?php
                                            if(!empty($districts))
                                            {
                                                foreach ($districts as $district)
                                                {
                                                    ?>
                                                    <option value="<?php echo $district->id ?>" <?php if($district->id == $projectInfo->district_id) {echo "selected=selected";} ?>><?php echo $district->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block_id">Block</label>
                                        <select class="form-control required" id="block_id" name="block_id">
                                            <option value="">Select Block</option>
                                            <?php
                                            if(!empty($blocks))
                                            {
                                                foreach ($blocks as $block)
                                                {
                                                    ?>
                                                    <option value="<?php echo $block->id ?>" <?php if($block->id == $projectInfo->block_id) {echo "selected=selected";} ?>><?php echo $block->name ?></option>
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
                                        <label for="department_id">Department</label>
                                        <select class="form-control required" id="department_id" name="department_id">
                                            <option value="">Select Department</option>
                                            <?php
                                            if(!empty($departments))
                                            {
                                                foreach ($departments as $department)
                                                {
                                                    ?>
                                                    <option value="<?php echo $department->id ?>" <?php if($department->id == $projectInfo->department_id) {echo "selected=selected";} ?>><?php echo $department->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="work_name">Work Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $projectInfo->work_name; ?>" id="work_name" name="work_name" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount_project_cost">Project Cost (₹)</label>
                                        <input type="number" step="0.01" class="form-control required" value="<?php echo $projectInfo->amount_project_cost; ?>" id="amount_project_cost" name="amount_project_cost">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="proposal_estimate">Proposal Estimate (₹)</label>
                                        <input type="number" step="0.01" class="form-control required" value="<?php echo $projectInfo->proposal_estimate; ?>" id="proposal_estimate" name="proposal_estimate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control required" id="status" name="status">
                                            <option value="">Select Status</option>
                                            <option value="Pending" <?php if($projectInfo->status == 'Pending') {echo "selected=selected";} ?>>Pending</option>
                                            <option value="In Progress" <?php if($projectInfo->status == 'In Progress') {echo "selected=selected";} ?>>In Progress</option>
                                            <option value="Completed" <?php if($projectInfo->status == 'Completed') {echo "selected=selected";} ?>>Completed</option>
                                            <option value="On Hold" <?php if($projectInfo->status == 'On Hold') {echo "selected=selected";} ?>>On Hold</option>
                                            <option value="Cancelled" <?php if($projectInfo->status == 'Cancelled') {echo "selected=selected";} ?>>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="officer_name">Officer Name</label>
                                        <input type="text" class="form-control required" value="<?php echo $projectInfo->officer_name; ?>" id="officer_name" name="officer_name" maxlength="150">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_no">Contact Number</label>
                                        <input type="text" class="form-control required" value="<?php echo $projectInfo->contact_no; ?>" id="contact_no" name="contact_no" maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="technical_session">Technical Session</label>
                                        <input type="text" class="form-control" value="<?php echo $projectInfo->technical_session; ?>" id="technical_session" name="technical_session" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="administrative_session">Administrative Session</label>
                                        <input type="text" class="form-control" value="<?php echo $projectInfo->administrative_session; ?>" id="administrative_session" name="administrative_session" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tender_status">Tender Status</label>
                                        <select class="form-control" id="tender_status" name="tender_status">
                                            <option value="">Select Tender Status</option>
                                            <option value="Open" <?php if($projectInfo->tender_status == 'Open') {echo "selected=selected";} ?>>Open</option>
                                            <option value="Closed" <?php if($projectInfo->tender_status == 'Closed') {echo "selected=selected";} ?>>Closed</option>
                                            <option value="Pending" <?php if($projectInfo->tender_status == 'Pending') {echo "selected=selected";} ?>>Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" value="<?php echo $projectInfo->company_name; ?>" id="company_name" name="company_name" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contractor_name">Contractor Name</label>
                                        <input type="text" class="form-control" value="<?php echo $projectInfo->contractor_name; ?>" id="contractor_name" name="contractor_name" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_no">Phone No</label>
                                        <input type="text" class="form-control" value="<?php echo $projectInfo->phone_no; ?>" id="phone_no" name="phone_no" maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="usd_remark">USD Remark</label>
                                        <textarea class="form-control" id="usd_remark" name="usd_remark" rows="3" maxlength="500" placeholder="Enter USD remarks"><?php echo $projectInfo->usd_remark; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3" maxlength="500" placeholder="Enter any additional remarks or notes about the project"><?php echo $projectInfo->remark; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                            <input type="hidden" value="<?php echo $projectInfo->id; ?>" name="projectId" id="projectId" />
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

<script src="<?php echo base_url(); ?>assets/js/editProject.js" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function(){
        // Load blocks when district is selected
        jQuery('#district_id').change(function(){
            var districtId = jQuery(this).val();
            if(districtId != '')
            {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>projectSummary/getBlocksByDistrict",
                    data: {districtId: districtId},
                    dataType: "json",
                    success: function(data) {
                        jQuery('#block_id').html('<option value="">Select Block</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('#block_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
            else
            {
                jQuery('#block_id').html('<option value="">Select Block</option>');
            }
        });
    });
</script>
