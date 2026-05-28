<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit गणेश समिति (Ganesh Samiti)</h3>
                    </div>

                    <?php $record = isset($record) ? $record : array(); ?>
                    <form action="<?php echo site_url('ganeshsamiti/update/'.$record['id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="unique_id">Unique ID</label>
                                        <input type="text" class="form-control" id="unique_id" name="unique_id" value="<?php echo isset($record['unique_id']) ? $record['unique_id'] : ''; ?>" readonly style="background:#f5f5f5;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">वर्ष (Year)</label>
                                        <select class="form-control" id="year" name="year">
                                            <option value="">Select Year</option>
                                            <?php for ($y = 2018; $y <= 2026; $y++): ?>
                                                <option value="<?php echo $y; ?>" <?php echo (isset($record['year']) && $record['year'] == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ac_mp_no">AC/MP No.</label>
                                        <input type="text" class="form-control" id="ac_mp_no" name="ac_mp_no" value="<?php echo isset($record['ac_mp_no']) ? $record['ac_mp_no'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="block">ब्लॉक (Block)</label>
                                        <select class="form-control" id="block" name="block">
                                            <option value="">Select Block</option>
                                            <?php if (!empty($blocks)): foreach ($blocks as $b): ?>
                                                <option value="<?php echo $b->id; ?>" <?php echo (isset($record['block']) && $record['block'] == $b->id) ? 'selected' : ''; ?>><?php echo $b->name; ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sector">सेक्टर (Sector)</label>
                                        <input type="text" class="form-control" id="sector" name="sector" value="<?php echo isset($record['sector']) ? $record['sector'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_no">माइक्रो सेक्टर न (Micro Sector No)</label>
                                        <input type="text" class="form-control" id="micro_sector_no" name="micro_sector_no" value="<?php echo isset($record['micro_sector_no']) ? $record['micro_sector_no'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="micro_sector_name">माइक्रो सेक्टर नाम (Micro Sector Name)</label>
                                        <input type="text" class="form-control" id="micro_sector_name" name="micro_sector_name" value="<?php echo isset($record['micro_sector_name']) ? $record['micro_sector_name'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_name">बूथ का नाम (Booth Name)</label>
                                        <select class="form-control" id="booth_name" name="booth_name">
                                            <option value="">Select Booth</option>
                                            <?php if (!empty($booths)): foreach ($booths as $booth): ?>
                                                <option value="<?php echo $booth['id']; ?>" <?php echo (isset($record['booth_id']) && $record['booth_id'] == $booth['id']) ? 'selected' : ''; ?>><?php echo $booth['name']; ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">बूथ नंबर (Booth No)</label>
                                        <input type="text" class="form-control" id="booth_no" name="booth_no" value="<?php echo isset($record['booth_no']) ? $record['booth_no'] : ''; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gram_panchayat">ग्राम पंचायत (Gram Panchayat)</label>
                                        <input type="text" class="form-control" id="gram_panchayat" name="gram_panchayat" value="<?php echo isset($record['gram_panchayat']) ? $record['gram_panchayat'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="village">गांव (Village)</label>
                                        <select class="form-control" id="village" name="village">
                                            <option value="">Select Village</option>
                                            <?php if (!empty($villages)): foreach ($villages as $v): ?>
                                                <option value="<?php echo $v['name']; ?>" <?php echo (isset($record['village']) && $record['village'] == $v['name']) ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="faliya">फलिया (Faliya)</label>
                                        <input type="text" class="form-control" id="faliya" name="faliya" value="<?php echo isset($record['faliya']) ? $record['faliya'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="file_upload">फाइल अपलोड (File Upload)</label>
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
                            <a href="<?php echo site_url('ganeshsamiti'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    // When block changes, fetch booths
    $('#block').on('change', function(){
        var blockId = $(this).val();
        $('#booth_name').html('<option value="">Select Booth</option>');
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village').html('<option value="">Select Village</option>');

        if (!blockId) return;

        $.post('<?php echo base_url(); ?>ganeshsamiti/get_booths_by_block', {block_id: blockId}, function(resp){
            if (!resp.error && resp.booths) {
                resp.booths.forEach(function(b){
                    $('#booth_name').append('<option value="'+b.id+'">'+b.name+'</option>');
                });
            }
        }, 'json').fail(function(){ console.warn('Failed to load booths'); });
    });

    // When booth changes, fetch details
    $('#booth_name').on('change', function(){
        var boothId = $(this).val();
        $('#booth_no').val('');
        $('#gram_panchayat').val('');
        $('#village').html('<option value="">Select Village</option>');

        if (!boothId) return;

        $.post('<?php echo base_url(); ?>ganeshsamiti/get_booth_details', {booth_id: boothId}, function(resp){
            if (!resp.error) {
                $('#booth_no').val(resp.booth_no);
                $('#gram_panchayat').val(resp.panchayat_name);
                if (resp.villages && resp.villages.length) {
                    resp.villages.forEach(function(v){
                        $('#village').append('<option value="'+v.name+'">'+v.name+'</option>');
                    });
                }
            }
        }, 'json').fail(function(){ console.warn('Failed to load booth details'); });
    });
});
</script>