<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-edit" aria-hidden="true"></i> Edit MP Vidhan Sabha Member
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Member Details</h3>
                    </div>
                    <form role="form" id="memberForm" method="post" action="<?php echo site_url('mp_vidhan_sabha_member/update/'.$member['id']); ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                        <input type="text" class="form-control" id="month" name="month" placeholder="Enter Month" value="<?php echo isset($member['month']) ? htmlspecialchars($member['month']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo isset($member['date']) ? htmlspecialchars($member['date']) : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district_id">District</label>
                                        <select class="form-control" id="district_id" name="district_id">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $district): ?>
                                                <option value="<?php echo $district['id']; ?>" <?php echo (isset($member['district_id']) && $member['district_id'] == $district['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($district['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block_id">Block</label>
                                        <select class="form-control" id="block_id" name="block_id">
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block['id']; ?>" <?php echo (isset($member['block_id']) && $member['block_id'] == $block['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($block['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="panchayat_id">Panchayat</label>
                                        <select class="form-control" id="panchayat_id" name="panchayat_id">
                                            <option value="">Select Panchayat</option>
                                            <?php foreach ($panchayats as $panchayat): ?>
                                                <option value="<?php echo $panchayat['id']; ?>" <?php echo (isset($member['panchayat_id']) && $member['panchayat_id'] == $panchayat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($panchayat['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vidhan_sabha_id">Vidhan Sabha</label>
                                        <select class="form-control" id="vidhan_sabha_id" name="vidhan_sabha_id">
                                            <option value="">Select Vidhan Sabha</option>
                                            <?php foreach ($vidhan_sabhas as $vs): ?>
                                                <option value="<?php echo $vs['id']; ?>" <?php echo (isset($member['vidhan_sabha_id']) && $member['vidhan_sabha_id'] == $vs['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($vs['vidhan_sabha_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="village_id">Village</label>
                                        <select class="form-control" id="village_id" name="village_id">
                                            <option value="">Select Village</option>
                                            <?php foreach ($villages as $village): ?>
                                                <option value="<?php echo $village['id']; ?>" <?php echo (isset($member['village_id']) && $member['village_id'] == $village['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($village['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="<?php echo isset($member['name']) ? htmlspecialchars($member['name']) : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" name="position" placeholder="Enter Position" value="<?php echo isset($member['position']) ? htmlspecialchars($member['position']) : ''; ?>">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="mobile_no">Mobile No</label>
                                         <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No" value="<?php echo isset($member['mobile_no']) ? htmlspecialchars($member['mobile_no']) : ''; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="locksabha">Lok Sabha</label>
                                         <input type="text" class="form-control" id="locksabha" name="locksabha" placeholder="Enter Lok Sabha" value="<?php echo isset($member['locksabha']) ? htmlspecialchars($member['locksabha']) : ''; ?>">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="year">Year</label>
                                         <input type="text" class="form-control" id="year" name="year" placeholder="Enter Year" value="<?php echo isset($member['year']) ? htmlspecialchars($member['year']) : ''; ?>">
                                     </div>
                                 </div>
                             </div>

                            <hr>
                            <h4>Additional Fields</h4>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="bg" id="bg" <?php echo (isset($member['bg']) && $member['bg']) ? 'checked' : ''; ?>> BG</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="bc" id="bc" <?php echo (isset($member['bc']) && $member['bc']) ? 'checked' : ''; ?>> BC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="er" id="er" <?php echo (isset($member['er']) && $member['er']) ? 'checked' : ''; ?>> ER</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="br" id="br" <?php echo (isset($member['br']) && $member['br']) ? 'checked' : ''; ?>> BR</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ip" id="ip" <?php echo (isset($member['ip']) && $member['ip']) ? 'checked' : ''; ?>> IP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sc" id="sc" <?php echo (isset($member['sc']) && $member['sc']) ? 'checked' : ''; ?>> SC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sa" id="sa" <?php echo (isset($member['sa']) && $member['sa']) ? 'checked' : ''; ?>> SA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="yc" id="yc" <?php echo (isset($member['yc']) && $member['yc']) ? 'checked' : ''; ?>> YC</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ap" id="ap" <?php echo (isset($member['ap']) && $member['ap']) ? 'checked' : ''; ?>> AP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fp" id="fp" <?php echo (isset($member['fp']) && $member['fp']) ? 'checked' : ''; ?>> FP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pp" id="pp" <?php echo (isset($member['pp']) && $member['pp']) ? 'checked' : ''; ?>> PP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="wc" id="wc" <?php echo (isset($member['wc']) && $member['wc']) ? 'checked' : ''; ?>> WC</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pa" id="pa" <?php echo (isset($member['pa']) && $member['pa']) ? 'checked' : ''; ?>> PA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pc" id="pc" <?php echo (isset($member['pc']) && $member['pc']) ? 'checked' : ''; ?>> PC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ak" id="ak" <?php echo (isset($member['ak']) && $member['ak']) ? 'checked' : ''; ?>> AK</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fm" id="fm" <?php echo (isset($member['fm']) && $member['fm']) ? 'checked' : ''; ?>> FM</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="zp" id="zp" <?php echo (isset($member['zp']) && $member['zp']) ? 'checked' : ''; ?>> ZP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="vp" id="vp" <?php echo (isset($member['vp']) && $member['vp']) ? 'checked' : ''; ?>> VP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sr" id="sr" <?php echo (isset($member['sr']) && $member['sr']) ? 'checked' : ''; ?>> SR</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="in_field" id="in_field" <?php echo (isset($member['in_field']) && $member['in_field']) ? 'checked' : ''; ?>> IN</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="eo" id="eo" <?php echo (isset($member['eo']) && $member['eo']) ? 'checked' : ''; ?>> EO</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="gs" id="gs" <?php echo (isset($member['gs']) && $member['gs']) ? 'checked' : ''; ?>> GS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="us" id="us" <?php echo (isset($member['us']) && $member['us']) ? 'checked' : ''; ?>> US</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pw" id="pw" <?php echo (isset($member['pw']) && $member['pw']) ? 'checked' : ''; ?>> PW</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="nl" id="nl" <?php echo (isset($member['nl']) && $member['nl']) ? 'checked' : ''; ?>> NL</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fr" id="fr" <?php echo (isset($member['fr']) && $member['fr']) ? 'checked' : ''; ?>> FR</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="so" id="so" <?php echo (isset($member['so']) && $member['so']) ? 'checked' : ''; ?>> SO</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="st" id="st" <?php echo (isset($member['st']) && $member['st']) ? 'checked' : ''; ?>> ST</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ob" id="ob" <?php echo (isset($member['ob']) && $member['ob']) ? 'checked' : ''; ?>> OB</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="smw" id="smw" <?php echo (isset($member['smw']) && $member['smw']) ? 'checked' : ''; ?>> SMW</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="smtw" id="smtw" <?php echo (isset($member['smtw']) && $member['smtw']) ? 'checked' : ''; ?>> SMTW</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="it" id="it" <?php echo (isset($member['it']) && $member['it']) ? 'checked' : ''; ?>> IT</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="test" id="test" <?php echo (isset($member['test']) && $member['test']) ? 'checked' : ''; ?>> TEST</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dyc" id="dyc" <?php echo (isset($member['dyc']) && $member['dyc']) ? 'checked' : ''; ?>> DYC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dcc" id="dcc" <?php echo (isset($member['dcc']) && $member['dcc']) ? 'checked' : ''; ?>> DCC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="obc" id="obc" <?php echo (isset($member['obc']) && $member['obc']) ? 'checked' : ''; ?>> OBC</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="cell_mp" id="cell_mp" <?php echo (isset($member['cell_mp']) && $member['cell_mp']) ? 'checked' : ''; ?>> CELL/MP</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dt" id="dt" <?php echo (isset($member['dt']) && $member['dt']) ? 'checked' : ''; ?>> DT</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dp" id="dp" <?php echo (isset($member['dp']) && $member['dp']) ? 'checked' : ''; ?>> DP</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="avp" id="avp" <?php echo (isset($member['avp']) && $member['avp']) ? 'checked' : ''; ?>> AVP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="meet" id="meet" <?php echo (isset($member['meet']) && $member['meet']) ? 'checked' : ''; ?>> MEET</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media" id="media" <?php echo (isset($member['media']) && $member['media']) ? 'checked' : ''; ?>> MEDIA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="mla_x_mla" id="mla_x_mla" <?php echo (isset($member['mla_x_mla']) && $member['mla_x_mla']) ? 'checked' : ''; ?>> MLA,X MLA</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="vech" id="vech" <?php echo (isset($member['vech']) && $member['vech']) ? 'checked' : ''; ?>> VECH</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="it_cell_exp" id="it_cell_exp" <?php echo (isset($member['it_cell_exp']) && $member['it_cell_exp']) ? 'checked' : ''; ?>> IT CELL EXP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="info" id="info" <?php echo (isset($member['info']) && $member['info']) ? 'checked' : ''; ?>> INFO</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="nsui" id="nsui" <?php echo (isset($member['nsui']) && $member['nsui']) ? 'checked' : ''; ?>> NSUI</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="imp" id="imp" <?php echo (isset($member['imp']) && $member['imp']) ? 'checked' : ''; ?>> IMP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="advise" id="advise" <?php echo (isset($member['advise']) && $member['advise']) ? 'checked' : ''; ?>> ADVISE</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ref" id="ref" <?php echo (isset($member['ref']) && $member['ref']) ? 'checked' : ''; ?>> REF</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" id="remark" name="remark" rows="4" placeholder="Enter Remark"><?php echo isset($member['remark']) ? htmlspecialchars($member['remark']) : ''; ?></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="<?php echo site_url('mp_vidhan_sabha_member'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Load Vidhan Sabha when district is selected
    $('#district_id').change(function() {
        var district_id = $(this).val();
        
        if (district_id) {
            $.ajax({
                url: '<?php echo site_url('mp_vidhan_sabha_member/get_vidhan_sabhas_by_district'); ?>',
                type: 'POST',
                data: { district_id: district_id },
                dataType: 'json',
                success: function(response) {
                    var vidhan_sabha_select = $('#vidhan_sabha_id');
                    var current_value = vidhan_sabha_select.val();
                    vidhan_sabha_select.html('<option value="">Select Vidhan Sabha</option>');
                    
                    if (response.length > 0) {
                        $.each(response, function(index, vs) {
                            vidhan_sabha_select.append(
                                '<option value="' + vs.id + '">' + vs.vidhan_sabha_name + '</option>'
                            );
                        });
                        // Restore previous selection if it exists in new list
                        if (current_value) {
                            vidhan_sabha_select.val(current_value);
                        }
                    }
                },
                error: function() {
                    alert('Error loading Vidhan Sabha');
                }
            });
        } else {
            $('#vidhan_sabha_id').html('<option value="">Select Vidhan Sabha</option>');
        }
    });
    
    // Trigger change on page load if district is already selected
    if ($('#district_id').val()) {
        $('#district_id').trigger('change');
    }
});
</script>
