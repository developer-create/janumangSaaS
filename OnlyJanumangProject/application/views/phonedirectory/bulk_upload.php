<?php
$name = $this->session->userdata('name');
$role = $this->session->userdata('role');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-upload"></i> Bulk Upload Phone Directory
            <small>Upload multiple entries using CSV file</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Upload File</h3>
                        <div class="box-tools">
                            <a class="btn btn-primary btn-sm" href="<?php echo base_url('phonedirectory'); ?>">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                            <a class="btn btn-success btn-sm" href="<?php echo base_url('phonedirectory/download_template'); ?>">
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
                                <?php echo form_open_multipart('phonedirectory/process_bulk_upload'); ?>
                                
                                <div class="form-group">
                                    <label for="bulk_file">Select CSV File *</label>
                                    <input type="file" class="form-control" id="bulk_file" name="bulk_file" accept=".csv" required>
                                    <small class="help-block">Supported format: CSV (Comma Separated Values). Max size: 10MB</small>
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
                                            <li><strong>Required Fields:</strong> Name, Number</li>
                                            <li><strong>Mobile Numbers:</strong> 10-digit numbers without country code</li>
                                            <li><strong>Reference Fields:</strong> Use names (not IDs) for Department, District, Block, Party</li>
                                            <li><strong>Empty Rows:</strong> Will be skipped automatically</li>
                                        </ul>
                                        
                                        <h4>Reference Data (Available Names):</h4>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>Departments:</strong>
                                                <ul class="list-unstyled">
                                                    <?php foreach(array_slice($departments, 0, 5) as $dept): ?>
                                                        <li><?php echo $dept->name; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Districts:</strong>
                                                <ul class="list-unstyled">
                                                    <?php foreach(array_slice($districts, 0, 5) as $dist): ?>
                                                        <li><?php echo $dist->name; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Blocks:</strong>
                                                <ul class="list-unstyled">
                                                    <?php foreach(array_slice($blocks, 0, 5) as $block): ?>
                                                        <li><?php echo $block->name; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Parties:</strong>
                                                <ul class="list-unstyled">
                                                    <?php foreach(array_slice($parties, 0, 5) as $party): ?>
                                                        <li><?php echo $party->name; ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
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
        if (!file) return;
        
        var fileSize = file.size;
        var maxSize = 10 * 1024 * 1024; // 10MB
        
        if (fileSize > maxSize) {
            alert('File size exceeds 10MB limit. Please choose a smaller file.');
            $(this).val('');
            return false;
        }
        
        if (!file.name.endsWith('.csv')) {
            alert('Please select a valid CSV file.');
            $(this).val('');
            return false;
        }
    });
});
</script>
