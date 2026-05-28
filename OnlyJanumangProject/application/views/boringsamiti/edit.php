<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit बोरिंग समिति (Boring Samiti) Details</h3>
                    </div>
                    <form action="<?php echo site_url('boringsamiti/update/'.$record['id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="unique_id">Unique ID:</label>
                                        <input type="text" class="form-control" id="unique_id" name="unique_id" value="<?php echo isset($record['unique_id']) ? $record['unique_id'] : ''; ?>" readonly style="background-color: #f5f5f5;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">वर्ष (Year):</label>
                                        <select class="form-control required" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <?php for($y = 2018; $y <= 2026; $y++): ?>
                                                <option value="<?php echo $y; ?>" <?php echo (isset($record['year']) && $record['year'] == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ac_mp_no">AC/MP No.:</label>
                                        <input type="text" class="form-control required" id="ac_mp_no" name="ac_mp_no" value="<?php echo isset($record['ac_mp_no']) ? $record['ac_mp_no'] : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="boring_samiti_name">बोरिंग समिति नाम (Boring Samiti Name):</label>
                                        <input type="text" class="form-control" id="boring_samiti_name" name="boring_samiti_name" value="<?php echo isset($record['boring_samiti_name']) ? $record['boring_samiti_name'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">ब्लॉक (Block):</label>
                                        <select class="form-control required" id="block" name="block" required>
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>" <?php echo (isset($record['block']) && $record['block'] == $block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector">सेक्टर (Sector):</label>
                                        <input type="text" class="form-control" id="sector" name="sector" value="<?php echo isset($record['sector']) ? $record['sector'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">माइक्रो सेक्टर न (Micro Sector No):</label>
                                        <input type="text" class="form-control" id="micro_sector_no" name="micro_sector_no" value="<?php echo isset($record['micro_sector_no']) ? $record['micro_sector_no'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">माइक्रो सेक्टर नाम (Micro Sector Name):</label>
                                        <input type="text" class="form-control" id="micro_sector_name" name="micro_sector_name" value="<?php echo isset($record['micro_sector_name']) ? $record['micro_sector_name'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">बूथ का नाम (Booth Name):</label>
                                        <select class="form-control required" id="booth_name" name="booth_name" required>
                                            <option value="">Select Booth</option>
                                            <?php if (!empty($booths)): ?>
                                                <?php foreach ($booths as $booth): ?>
                                                    <option value="<?php echo $booth['id']; ?>" <?php echo (isset($record['booth_id']) && $record['booth_id'] == $booth['id']) ? 'selected' : ''; ?>><?php echo $booth['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">बूथ क (Booth No):</label>
                                        <input type="text" class="form-control" id="booth_no" name="booth_no" value="<?php echo isset($record['booth_no']) ? $record['booth_no'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gram_panchayat">ग्राम पंचायत (Gram Panchayat):</label>
                                        <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat" value="<?php echo isset($record['gram_panchayat']) ? $record['gram_panchayat'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village">गांव का नाम (Village):</label>
                                        <select class="form-control" id="village" name="village">
                                            <option value="">Select Village</option>
                                            <?php if (!empty($villages)): ?>
                                                <?php foreach ($villages as $village): ?>
                                                    <option value="<?php echo $village['name']; ?>" <?php echo (isset($record['village']) && $record['village'] == $village['name']) ? 'selected' : ''; ?>><?php echo $village['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="faliya">फलिया (Faliya):</label>
                                        <input type="text" class="form-control" id="faliya" name="faliya" value="<?php echo isset($record['faliya']) ? $record['faliya'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="file_upload">फाइल अपलोड (File Upload):</label>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <?php if (!empty($record['file_upload'])): ?>
                                            <small class="text-muted">Current file: <a href="<?php echo base_url('uploads/samiti_files/'.$record['file_upload']); ?>" target="_blank"><?php echo $record['file_upload']; ?></a></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                            <a href="<?php echo site_url('boringsamiti'); ?>" class="btn btn-default">Cancel</a>
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
    $('#block').change(function() {
        var blockId = $(this).val();
        $('#booth_name').html('<option value="">Select Booth</option>');
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village').html('<option value="">Select Village</option>');
        
        if (blockId) {
            $.ajax({
                url: '<?php echo base_url(); ?>boringsamiti/get_booths_by_block',
                type: 'POST',
                data: {block_id: blockId},
                dataType: 'json',
                success: function(response) {
                    if (!response.error && response.booths) {
                        $.each(response.booths, function(index, booth) {
                            $('#booth_name').append('<option value="' + booth.id + '">' + booth.name + '</option>');
                        });
                    }
                }
            });
        }
    });

    $('#booth_name').change(function() {
        var boothId = $(this).val();
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village').html('<option value="">Select Village</option>');
        
        if (boothId) {
            $.ajax({
                url: '<?php echo base_url(); ?>boringsamiti/get_booth_details',
                type: 'POST',
                data: {booth_id: boothId},
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        $('#booth_no').val(response.booth_no);
                        $('#gram_panchayat').val(response.panchayat_name);
                        if (response.villages && response.villages.length > 0) {
                            $.each(response.villages, function(index, village) {
                                $('#village').append('<option value="' + village.name + '">' + village.name + '</option>');
                            });
                        }
                    }
                }
            });
        }
    });
});
</script>