<?php
$name = $this->session->userdata('name');
$role = $this->session->userdata('role');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-upload"></i> Bulk Upload Jansunwai Entries
            <small>Upload multiple Jansunwai entries using CSV/Excel file</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Upload File</h3>
                        <div class="box-tools">
                            <a class="btn btn-primary btn-sm" href="<?php echo base_url('user/jansunwai'); ?>">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                            <a class="btn btn-success btn-sm" href="<?php echo base_url('user/download_jansunwai_template'); ?>">
                                <i class="fa fa-download"></i> Download Template
                            </a>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <?php
                        $error = $this->session->flashdata('error');
                        if($error) {
                            echo '<div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    '.$error.'
                                  </div>';
                        }
                        
                        $success = $this->session->flashdata('success');
                        if($success) {
                            echo '<div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    '.$success.'
                                  </div>';
                        }
                        ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <?php echo form_open_multipart('user/process_jansunwai_bulk_upload'); ?>
                                
                                <div class="form-group">
                                    <label for="bulk_file">Select CSV File *</label>
                                    <input type="file" class="form-control" id="bulk_file" name="bulk_file" accept=".csv" required>
                                    <small class="help-block">Supported format: CSV (Comma Separated Values). Max size: 10MB</small>
                                    <small class="help-block text-muted"><strong>Note:</strong> If you have an Excel file, please convert it to CSV first (File → Save As → CSV format)</small>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-upload"></i> Upload & Process
                                    </button>
                                </div>
                                
                                <?php echo form_close(); ?>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-blue"><i class="fa fa-info"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Instructions</span>
                                        <span class="info-box-number">
                                            <small>
                                                1. Download the template file<br>
                                                2. Fill in your data<br>
                                                3. Upload the completed file<br>
                                                4. Review the results
                                            </small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">File Format Guidelines</h3>
                                    </div>
                                    <div class="box-body">
                                        <ul>
                                            <li><strong>Format Match:</strong> Make sure your file exactly matches the columns in the downloaded template (which matches the final export structure).</li>
                                            <li><strong>Validations Disabled:</strong> During bulk upload, required fields and budget constraints are not strictly enforced to allow raw data import.</li>
                                            <li><strong>Reference Fields:</strong> The system will try to match Block, Department, Sub Work Type names with existing records.</li>
                                            <li><strong>Empty Rows:</strong> Will be skipped automatically.</li>
                                        </ul>
                                        
                                        <h4>Reference Data:</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Blocks:</strong>
                                                <ul class="list-unstyled">
                                                    <?php foreach(array_slice($blocks, 0, 10) as $block): ?>
                                                                                                                <li><?php echo $block['name']; ?></li>
                                                    <?php endforeach; ?>
                                                    <?php if(count($blocks) > 10): ?>
                                                        <li><em>... and <?php echo count($blocks) - 10; ?> more</em></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Departments:</strong>
                                                <ul class="list-unstyled">
                                                    <?php foreach(array_slice($departments, 0, 10) as $dept): ?>
                                                                                                                <li><?php echo $dept['name']; ?></li>
                                                    <?php endforeach; ?>
                                                    <?php if(count($departments) > 10): ?>
                                                        <li><em>... and <?php echo count($departments) - 10; ?> more</em></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <h4>Sample Values:</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Priority:</strong> High, Medium, Low
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Approved Fund:</strong> MLA Sweechanudan, CLP Sweechanudan, Jansampark Fund
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Type of Work:</strong> Construction, Repair, Development
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // File validation
    $('#bulk_file').change(function() {
        var file = this.files[0];
        var fileSize = file.size;
        var maxSize = 10 * 1024 * 1024; // 10MB
        
        if (fileSize > maxSize) {
            alert('File size exceeds 10MB limit. Please choose a smaller file.');
            $(this).val('');
            return false;
        }
        
        var allowedTypes = ['text/csv', 'application/csv'];
        if (allowedTypes.indexOf(file.type) === -1 && !file.name.endsWith('.csv')) {
            alert('Please select a valid CSV file.');
            $(this).val('');
            return false;
        }
    });
});
</script>