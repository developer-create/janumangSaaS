<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit खेल समिति (Khel Samiti) Location</h3>
                    </div>
                    <form action="<?php echo site_url('kabbadisamiti/update/'.$record['id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="unique_id">Unique ID:</label>
                                        <input type="text" class="form-control" id="unique_id" value="<?php echo $record['unique_id']; ?>" readonly style="background-color: #f5f5f5;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="samiti_type_id">समिति प्रकार (Samiti Type):</label>
                                        <div class="input-group">
                                            <select class="form-control" id="samiti_type_id" name="samiti_type_id">
                                                <option value="">Select Type</option>
                                                <?php if (!empty($samiti_types)): foreach ($samiti_types as $st): ?>
                                                <option value="<?php echo $st['id']; ?>" <?php echo (isset($record['samiti_type_id']) && $record['samiti_type_id'] == $st['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($st['name']); ?></option>
                                                <?php endforeach; endif; ?>
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success" id="btnAddSamitiType" title="Add New Samiti Type"><i class="fa fa-plus"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">वर्ष (Year):</label>
                                        <select class="form-control required" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <?php for($y = 2024; $y <= 2030; $y++): ?>
                                                <option value="<?php echo $y; ?>" <?php echo ($record['year'] == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ac_mp_no">AC/MP No.:</label>
                                        <input type="text" class="form-control required" id="ac_mp_no" name="ac_mp_no" value="<?php echo $record['ac_mp_no']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="block">ब्लॉक (Block):<span class="text-danger">*</span></label>
                                        <select class="form-control required" id="block" name="block" required>
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>" <?php echo ($record['block'] == $block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector">सेक्टर (Sector):</label>
                                        <input type="text" class="form-control" id="sector" name="sector" value="<?php echo $record['sector']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">माइक्रो सेक्टर न (Micro Sector No):</label>
                                        <input type="text" class="form-control" id="micro_sector_no" name="micro_sector_no" value="<?php echo $record['micro_sector_no']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">माइक्रो सेक्टर नाम (Micro Sector Name):</label>
                                        <input type="text" class="form-control" id="micro_sector_name" name="micro_sector_name" value="<?php echo $record['micro_sector_name']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_dropdown">बूथ का नाम (Booth Name):<span class="text-danger">*</span></label>
                                        <select class="form-control required" id="booth_dropdown" name="booth_name" required>
                                            <option value="">Select Booth</option>
                                            <?php foreach ($booths as $booth): ?>
                                                <option value="<?php echo $booth->id; ?>" <?php echo (isset($record['booth_id']) && $record['booth_id'] == $booth->id) ? 'selected' : ''; ?>><?php echo $booth->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">बूथ क (Booth No):</label>
                                        <input type="text" class="form-control" id="booth_no" name="booth_no" value="<?php echo $record['booth_no']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gram_panchayat">ग्राम पंचायत (Gram Panchayat):</label>
                                        <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat" value="<?php echo $record['gram_panchayat']; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="village_dropdown">गांव का नाम (Village):</label>
                                        <select class="form-control" id="village_dropdown">
                                            <option value="">Select Village</option>
                                            <?php foreach ($villages as $village): ?>
                                                <option value="<?php echo $village->name; ?>" <?php echo ($record['village'] == $village->name) ? 'selected' : ''; ?>><?php echo $village->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="village" id="village" value="<?php echo $record['village']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faliya">फलिया (Faliya):</label>
                                        <input type="text" class="form-control" id="faliya" name="faliya" value="<?php echo $record['faliya']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="file_upload">फाइल अपलोड (File Upload):</label>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <?php if(!empty($record['file_upload'])): ?>
                                            <p class="help-block text-blue">Current file: <?php echo $record['file_upload']; ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                            <a href="<?php echo site_url('kabbadisamiti'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal: Add New Samiti Type -->
<div class="modal fade" id="modalAddSamitiType" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New समिति प्रकार (Samiti Type)</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new_samiti_type_name">नाम (Name):</label>
                    <input type="text" class="form-control" id="new_samiti_type_name" placeholder="e.g. कबड्डी, वॉलीबॉल">
                </div>
                <div id="samiti_type_error" class="text-danger"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSaveSamitiType">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#btnAddSamitiType').on('click', function() {
        $('#new_samiti_type_name').val('');
        $('#samiti_type_error').html('');
        $('#modalAddSamitiType').modal('show');
    });
    $('#btnSaveSamitiType').on('click', function() {
        var name = $.trim($('#new_samiti_type_name').val());
        if (!name) { $('#samiti_type_error').html('Name is required.'); return; }
        $.ajax({
            url: '<?php echo base_url(); ?>kabbadisamiti/add_samiti_type',
            type: 'POST',
            data: { name: name, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
            dataType: 'json',
            success: function(res) {
                if (res.error) { $('#samiti_type_error').html(res.message || 'Error'); return; }
                $('#samiti_type_id').append('<option value="' + res.id + '" selected>' + (res.name || name) + '</option>');
                $('#modalAddSamitiType').modal('hide');
            },
            error: function() { $('#samiti_type_error').html('Request failed.'); }
        });
    });
    // When block changes, load booths
    $('#block').change(function() {
        var blockId = $(this).val();
        $('#booth_dropdown').html('<option value="">Select Booth</option>');
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village_dropdown').html('<option value="">Select Village</option>');
        
        if (blockId) {
            $.ajax({
                url: '<?php echo base_url(); ?>kabbadisamiti/get_booths_by_block',
                type: 'POST',
                data: {block_id: blockId},
                dataType: 'json',
                success: function(response) {
                    if (!response.error && response.booths) {
                        $.each(response.booths, function(index, booth) {
                            $('#booth_dropdown').append('<option value="' + booth.id + '" data-name="' + booth.name + '">' + booth.name + '</option>');
                        });
                    }
                }
            });
        }
    });

    // When booth changes, load booth details
    $('#booth_dropdown').change(function() {
        var boothId = $(this).val();
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village_dropdown').html('<option value="">Select Village</option>');
        
        if (boothId) {
            $.ajax({
                url: '<?php echo base_url(); ?>kabbadisamiti/get_booth_details',
                type: 'POST',
                data: {booth_id: boothId},
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        $('#booth_no').val(response.booth_no);
                        $('#gram_panchayat').val(response.panchayat_name);
                        
                        if (response.villages) {
                            $.each(response.villages, function(index, village) {
                                $('#village_dropdown').append('<option value="' + village.name + '">' + village.name + '</option>');
                            });
                        }
                    }
                }
            });
        }
    });

    $('#village_dropdown').change(function() {
        $('#village').val($(this).val());
    });
});
</script>
