<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-phone"></i> Phone Directory Management
            <small>View Phone Directory Details</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Phone Directory Details</h3>
                    </div><!-- /.box-header -->
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Name:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->name) ? $phoneDirectoryInfo->name : '-'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Post:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->post) ? $phoneDirectoryInfo->post : '-'; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Department:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->department_name) ? $phoneDirectoryInfo->department_name : '-'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>District:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->district_name) ? $phoneDirectoryInfo->district_name : '-'; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>VS Block:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->block_name) ? $phoneDirectoryInfo->block_name : '-'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Party:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->party_name) ? $phoneDirectoryInfo->party_name : '-'; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Number:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->number) ? $phoneDirectoryInfo->number : '-'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Alternate Number:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->alternate_number) ? $phoneDirectoryInfo->alternate_number : '-'; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Email:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->email) ? $phoneDirectoryInfo->email : '-'; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Status:</strong></label>
                                    <p><?php echo $phoneDirectoryInfo->status == 'Active' ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Remark:</strong></label>
                                    <p><?php echo !empty($phoneDirectoryInfo->remark) ? nl2br($phoneDirectoryInfo->remark) : '-'; ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Created On:</strong></label>
                                    <p><?php echo date("d-m-Y H:i:s", strtotime($phoneDirectoryInfo->created_at)); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Last Updated:</strong></label>
                                    <p><?php echo date("d-m-Y H:i:s", strtotime($phoneDirectoryInfo->updated_at)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    
                    <div class="box-footer">
                        <a class="btn btn-info" href="<?php echo base_url(); ?>phonedirectory/edit/<?php echo $phoneDirectoryInfo->id; ?>">Edit</a>
                        <a class="btn btn-warning" href="<?php echo base_url(); ?>phonedirectory">Back to List</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Quick Actions</h3>
                    </div>
                    <div class="box-body">
                        <div class="btn-group-vertical" style="width: 100%;">
                            <a class="btn btn-info" href="<?php echo base_url(); ?>phonedirectory/edit/<?php echo $phoneDirectoryInfo->id; ?>">
                                <i class="fa fa-edit"></i> Edit Entry
                            </a>
                            <a class="btn btn-primary" href="<?php echo base_url(); ?>phonedirectory/add">
                                <i class="fa fa-plus"></i> Add New Entry
                            </a>
                            <a class="btn btn-warning" href="<?php echo base_url(); ?>phonedirectory">
                                <i class="fa fa-list"></i> View All Entries
                            </a>
                            <?php if(!empty($phoneDirectoryInfo->number)) { ?>
                            <a class="btn btn-success" href="tel:<?php echo $phoneDirectoryInfo->number; ?>">
                                <i class="fa fa-phone"></i> Call Primary Number
                            </a>
                            <?php } ?>
                            <?php if(!empty($phoneDirectoryInfo->alternate_number)) { ?>
                            <a class="btn btn-success" href="tel:<?php echo $phoneDirectoryInfo->alternate_number; ?>">
                                <i class="fa fa-phone"></i> Call Alternate Number
                            </a>
                            <?php } ?>
                            <?php if(!empty($phoneDirectoryInfo->email)) { ?>
                            <a class="btn btn-info" href="mailto:<?php echo $phoneDirectoryInfo->email; ?>">
                                <i class="fa fa-envelope"></i> Send Email
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>