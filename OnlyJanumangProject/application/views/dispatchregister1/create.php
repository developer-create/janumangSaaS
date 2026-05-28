<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i> Add Dispatch Register Entry
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Enter Details</h3>
                    </div>
                    
                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>'); ?>
                    
                    <form action="<?php echo site_url('dispatchregister/store'); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">Year:</label>
                                        <select class="form-control" id="year" name="year">
                                            <option value="">Select Year</option>
                                            <?php 
                                            $currentYear = date('Y');
                                            for($y = 2020; $y <= 2028; $y++) { 
                                                $selected = ($y == $currentYear) ? 'selected' : '';
                                            ?>
                                                <option value="<?php echo $y; ?>" <?php echo $selected; ?>><?php echo $y; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="month">Month:</label>
                                        <select class="form-control" id="month" name="month">
                                            <option value="">Select Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="portal_no">Portal No.:</label>
                                        <input type="text" class="form-control" id="portal_no" name="portal_no">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="samiti_no">Samiti No.:</label>
                                        <input type="text" class="form-control" id="samiti_no" name="samiti_no">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="dispatch_no">Dispatch No.: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="dispatch_no" name="dispatch_no" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_id">Department:</label>
                                        <select class="form-control" id="department_id" name="department_id">
                                            <option value="">Select Department</option>
                                            <?php foreach($departments as $dept): ?>
                                                <option value="<?php echo $dept->id; ?>"><?php echo $dept->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="particular_subject">Particular (subject):</label>
                                        <textarea class="form-control" id="particular_subject" name="particular_subject" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reference">Reference:</label>
                                        <textarea class="form-control" id="reference" name="reference" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="block_id">Block:</label>
                                        <select class="form-control" id="block_id" name="block_id">
                                            <option value="">Select Block</option>
                                            <?php foreach($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>"><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="panchayat_id">Panchayat (Multiple):</label>
                                        <select class="form-control select2-multiple" id="panchayat_id" name="panchayat_id[]" multiple="multiple">
                                            <option value="">Select Panchayat(s)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="village_id">Village (Multiple):</label>
                                        <select class="form-control select2-multiple" id="village_id" name="village_id[]" multiple="multiple">
                                            <option value="">Select Village(s)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="upload_letter">Upload Letter:</label>
                                        <input type="file" class="form-control" id="upload_letter" name="upload_letter" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        <small class="text-muted">Allowed: PDF, JPG, PNG, DOC, DOCX (Max 5MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="<?php echo site_url('dispatchregister'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Custom Select2 styling for blue badges -->
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff !important;
    border-color: #0056b3 !important;
    color: white !important;
    padding: 3px 8px !important;
    border-radius: 3px !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white !important;
    font-weight: bold !important;
    margin-right: 5px !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #ffcccc !important;
}
</style>

<script>
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {
    // Initialize Select2 for multiple selects
    $('.select2-multiple').select2({
        placeholder: "Select...",
        allowClear: true,
        width: '100%'
    });
    
    // Block change - load panchayats AND villages
    $('#block_id').change(function() {
        var block_id = $(this).val();
        $('#panchayat_id').empty();
        $('#village_id').empty();
        
        if (block_id) {
            // Load panchayats
            $.ajax({
                url: base_url + 'dispatchregister/get_panchayats_by_block',
                type: 'POST',
                data: { block_id: block_id },
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        $.each(response.panchayats, function(index, panchayat) {
                            var option = new Option(panchayat.name, panchayat.id, false, false);
                            $('#panchayat_id').append(option);
                        });
                        $('#panchayat_id').trigger('change');
                    }
                }
            });
            
            // Load villages directly from block
            $.ajax({
                url: base_url + 'dispatchregister/get_villages_by_block',
                type: 'POST',
                data: { block_id: block_id },
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        $.each(response.villages, function(index, village) {
                            var option = new Option(village.name, village.id, false, false);
                            $('#village_id').append(option);
                        });
                        $('#village_id').trigger('change');
                    }
                }
            });
        }
    });
});
</script>
