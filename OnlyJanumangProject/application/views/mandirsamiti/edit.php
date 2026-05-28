<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Mandir Samiti
            <small>Edit Location</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
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
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Location Details</h3>
                    </div>
                    
                    <form role="form" action="<?php echo base_url() ?>mandirsamiti/update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="groupId" value="<?php echo $groupInfo->id; ?>" />
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="unique_id">Unique ID:</label>
                                        <input type="text" class="form-control" id="unique_id" value="<?php echo isset($groupInfo->unique_id) ? $groupInfo->unique_id : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">Year <span class="text-danger">*</span></label>
                                        <select class="form-control" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <?php for($y = 2018; $y <= 2026; $y++): ?>
                                                <option value="<?php echo $y; ?>" <?php echo (isset($groupInfo->year) && $groupInfo->year == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ac_mp_no">AC/MP No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="ac_mp_no" name="ac_mp_no" placeholder="AC/MP No" value="<?php echo isset($groupInfo->ac_mp_no) ? $groupInfo->ac_mp_no : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">ब्लॉक <span class="text-danger">*</span></label>
                                        <select class="form-control" id="block" name="block" required>
                                            <option value="">Select Block</option>
                                            <?php if (!empty($blocks)): ?>
                                                <?php foreach ($blocks as $block): ?>
                                                    <option value="<?php echo $block->id; ?>" <?php echo (isset($groupInfo->block) && $groupInfo->block == $block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector">सेक्टर</label>
                                        <input type="text" class="form-control" id="sector" name="sector" placeholder="सेक्टर" value="<?php echo $groupInfo->sector; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">माइक्रो सेक्टर न.</label>
                                        <input type="text" class="form-control" id="micro_sector_no" name="micro_sector_no" placeholder="माइक्रो सेक्टर न." value="<?php echo $groupInfo->micro_sector_no; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">माइक्रो सेक्टर नाम</label>
                                        <input type="text" class="form-control" id="micro_sector_name" name="micro_sector_name" placeholder="माइक्रो सेक्टर नाम" value="<?php echo $groupInfo->micro_sector_name; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">बूथ का नाम <span class="text-danger">*</span></label>
                                        <select class="form-control" id="booth_name" name="booth_name" required>
                                            <option value="">Select Booth</option>
                                            <?php 
                                            if (!empty($booths)) {
                                                foreach ($booths as $booth) {
                                                    $selected = (isset($groupInfo->booth_id) && $groupInfo->booth_id == $booth['id']) ? 'selected' : '';
                                                    echo '<option value="'.$booth['id'].'" '.$selected.'>'.$booth['name'].'</option>';
                                                }
                                            } else {
                                                echo '<!-- No booths found. Block: '.$groupInfo->block.' -->';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">बूठ न.</label>
                                        <input type="text" class="form-control" id="booth_no" name="booth_no" placeholder="बूठ न." value="<?php echo $groupInfo->booth_no; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gram_panchayat">ग्राम पंचायत</label>
                                        <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat" placeholder="ग्राम पंचायत" value="<?php echo $groupInfo->gram_panchayat; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">गांव का नाम</label>
                                        <select class="form-control" id="village" name="village">
                                            <option value="">Select Village</option>
                                            <?php if (!empty($villages)): ?>
                                                <?php foreach ($villages as $village): ?>
                                                    <option value="<?php echo $village['name']; ?>" <?php echo ($groupInfo->village == $village['name']) ? 'selected' : ''; ?>><?php echo $village['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faliya">फलिया</label>
                                        <input type="text" class="form-control" id="faliya" name="faliya" placeholder="फलिया" value="<?php echo $groupInfo->faliya; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file_upload">फाइल अपलोड (File Upload):</label>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <?php if (!empty($groupInfo->file_upload)): ?>
                                            <small class="text-muted">Current file: <a href="<?php echo base_url('uploads/samiti_files/'.$groupInfo->file_upload); ?>" target="_blank"><?php echo $groupInfo->file_upload; ?></a></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <a href="<?php echo base_url().'mandirsamiti'; ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Store initial values
    var initialBoothId = '<?php echo $groupInfo->booth_name; ?>';
    var initialVillageName = '<?php echo $groupInfo->village; ?>';
    
    // Load booth details on page load if booth is already selected
    if (initialBoothId) {
        // Booth dropdown is already populated from PHP, just trigger loading villages if needed
        // Since villages are already loaded from PHP, no need to reload
    }
    
    // When block changes, load booths
    $('#block').change(function() {
        var blockId = $(this).val();
        var currentBoothId = $('#booth_name').val();
        
        $('#booth_name').html('<option value="">Select Booth</option>');
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village').html('<option value="">Select Village</option>');
        
        if (blockId) {
            loadBooths(blockId, currentBoothId);
        }
    });

    // When booth changes, load booth details
    $('#booth_name').change(function() {
        var boothId = $(this).val();
        var currentVillage = $('#village').val();
        
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village').html('<option value="">Select Village</option>');
        
        if (boothId) {
            loadBoothDetails(boothId, currentVillage);
        }
    });
    
    function loadBooths(blockId, selectedBoothId) {
        $.ajax({
            url: '<?php echo base_url(); ?>mandirsamiti/get_booths_by_block',
            type: 'POST',
            data: {block_id: blockId},
            dataType: 'json',
            success: function(response) {
                if (!response.error && response.booths) {
                    if (response.booths.length > 0) {
                        $.each(response.booths, function(index, booth) {
                            var selected = (booth.id == selectedBoothId) ? 'selected' : '';
                            $('#booth_name').append('<option value="' + booth.id + '" ' + selected + '>' + booth.name + '</option>');
                        });
                        
                        // If a booth was selected, load its details
                        if (selectedBoothId) {
                            loadBoothDetails(selectedBoothId, initialVillageName);
                        }
                    }
                }
            }
        });
    }
    
    function loadBoothDetails(boothId, selectedVillage) {
        $.ajax({
            url: '<?php echo base_url(); ?>mandirsamiti/get_booth_details',
            type: 'POST',
            data: {booth_id: boothId},
            dataType: 'json',
            success: function(response) {
                if (!response.error) {
                    $('#booth_no').val(response.booth_no);
                    $('#gram_panchayat').val(response.panchayat_name);
                    
                    $('#village').html('<option value="">Select Village</option>');
                    if (response.villages && response.villages.length > 0) {
                        $.each(response.villages, function(index, village) {
                            var selected = (village.name == selectedVillage) ? 'selected' : '';
                            $('#village').append('<option value="' + village.name + '" ' + selected + '>' + village.name + '</option>');
                        });
                    }
                }
            }
        });
    }
});
</script>
