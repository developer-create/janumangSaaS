<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text" aria-hidden="true"></i> Edit In Doc (जावक दस्तावेज़)
            <small>Update incoming document information</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('indocs'); ?>">In Docs</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">In Doc Information</h3>
                    </div>
                    
                    <?php echo form_open('indocs/update/' . $doc->id, array('class' => 'form-horizontal')); ?>
                    <div class="box-body">
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Validation Error!</h4>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Display Unique ID -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unique_id" class="col-sm-2 control-label">Unique ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="unique_id" value="<?php echo $doc->unique_id; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 1: Issue No & Month/Date -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="issue_no" class="col-sm-4 control-label">Issue No (जावक क्रमांक) <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="issue_no" name="issue_no" 
                                               value="<?php echo $doc->issue_no; ?>" required maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month_date" class="col-sm-4 control-label">Date (तारीख) <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" id="month_date" name="month_date" 
                                               value="<?php echo $doc->month_date; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Name & Address -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name_address" class="col-sm-2 control-label">Name & Address (नाम व पता) <span class="text-red">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="name_address" name="name_address" rows="3" 
                                                  required><?php echo $doc->name_address; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Place & Subject -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="place" class="col-sm-4 control-label">Place (स्थान)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="place" name="place" 
                                               value="<?php echo $doc->place; ?>" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject" class="col-sm-4 control-label">Subject (विषय) <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="subject" name="subject" 
                                               value="<?php echo $doc->subject; ?>" required maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Documents Count & Reference Issue No -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documents_count" class="col-sm-4 control-label">Documents Count</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="documents_count" name="documents_count" 
                                               value="<?php echo $doc->documents_count; ?>" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reference_issue_no" class="col-sm-4 control-label">Reference Issue No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="reference_issue_no" name="reference_issue_no" 
                                               value="<?php echo $doc->reference_issue_no; ?>" maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 5: Received Issue No & File Head No -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="received_issue_no" class="col-sm-4 control-label">Received Issue No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="received_issue_no" name="received_issue_no" 
                                               value="<?php echo $doc->received_issue_no; ?>" maxlength="255">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="file_head_no" class="col-sm-4 control-label">File Head & No (फाइल नंबर)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="file_head_no" name="file_head_no" 
                                               value="<?php echo $doc->file_head_no; ?>" maxlength="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 6: Stamp Received -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stamp_received" class="col-sm-4 control-label">Stamp Received (₹/पैसे)</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="stamp_received" name="stamp_received" 
                                               value="<?php echo $doc->stamp_received; ?>" min="0" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 7: Remarks (Full Width) -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks" class="col-sm-2 control-label">Remarks (टिप्पणी)</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="remarks" name="remarks" rows="4"><?php echo $doc->remarks; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-save"></i> Update In Doc Record
                                </button>
                                <a href="<?php echo site_url('indocs'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
