<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-plus" aria-hidden="true"></i> Add MP Vidhan Sabha Member
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Member Details</h3>
                    </div>
                    <form role="form" id="memberForm" method="post" action="<?php echo site_url('mp_vidhan_sabha_member/store'); ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Month</label>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="date" name="date">
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
                                                <option value="<?php echo $district['id']; ?>"><?php echo htmlspecialchars($district['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vidhan_sabha_id">Vidhan Sabha</label>
                                        <select class="form-control" id="vidhan_sabha_id" name="vidhan_sabha_id">
                                            <option value="">Select Vidhan Sabha</option>
                                        </select>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block_id">Block</label>
                                        <select class="form-control" id="block_id" name="block_id">
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block['id']; ?>"><?php echo htmlspecialchars($block['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="panchayat_id">Panchayat</label>
                                        <select class="form-control" id="panchayat_id" name="panchayat_id" disabled>
                                            <option value="">Select Block first</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="village_id">Village</label>
                                        <select class="form-control" id="village_id" name="village_id" disabled>
                                            <option value="">Select Panchayat first</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" name="position" placeholder="Enter Position">
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="mobile_no">Mobile No</label>
                                         <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="locksabha">Lok Sabha</label>
                                         <input type="text" class="form-control" id="locksabha" name="locksabha" placeholder="Enter Lok Sabha">
                                     </div>
                                 </div>
                                 <div class="col-md-3">
                                     <div class="form-group">
                                         <label for="year">Year</label>
                                         <input type="text" class="form-control" id="year" name="year" placeholder="Enter Year">
                                     </div>
                                 </div>
                             </div>

                            <hr>
                            <h4>Additional Code</h4>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="bg" id="bg"> BG</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="bc" id="bc"> BC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="er" id="er"> ER</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="br" id="br"> BR</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ip" id="ip"> IP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sc" id="sc"> SC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sa" id="sa"> SA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="yc" id="yc"> YC</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ap" id="ap"> AP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fp" id="fp"> FP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pp" id="pp"> PP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="wc" id="wc"> WC</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pa" id="pa"> PA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pc" id="pc"> PC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ak" id="ak"> AK</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fm" id="fm"> FM</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="zp" id="zp"> ZP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="vp" id="vp"> VP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="sr" id="sr"> SR</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="in_field" id="in_field"> IN</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="eo" id="eo"> EO</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="gs" id="gs"> GS</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="us" id="us"> US</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="pw" id="pw"> PW</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="nl" id="nl"> NL</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="fr" id="fr"> FR</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="so" id="so"> SO</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="st" id="st"> ST</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ob" id="ob"> OB</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="smw" id="smw"> SMW</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="smtw" id="smtw"> SMTW</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="it" id="it"> IT</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="test" id="test"> TEST</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dyc" id="dyc"> DYC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dcc" id="dcc"> DCC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="obc" id="obc"> OBC</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="cell_mp" id="cell_mp"> CELL/MP</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dt" id="dt"> DT</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="dp" id="dp"> DP</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="avp" id="avp"> AVP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="meet" id="meet"> MEET</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="media" id="media"> MEDIA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="mla_x_mla" id="mla_x_mla"> MLA,X MLA</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="vech" id="vech"> VECH</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="it_cell_exp" id="it_cell_exp"> IT CELL EXP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="info" id="info"> INFO</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="nsui" id="nsui"> NSUI</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="imp" id="imp"> IMP</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="advise" id="advise"> ADVISE</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="ref" id="ref"> REF</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" id="remark" name="remark" rows="4" placeholder="Enter Remark"></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
    var base_url = "<?php echo base_url()?>";
    
    // Load Vidhan Sabha when district is selected
    $('#district_id').change(function() {
        var district_id = $(this).val();
        var $vs = $("#vidhan_sabha_id");
        $vs.empty().append('<option value="">Select Vidhan Sabha</option>').prop("disabled", !district_id);
        
        if (district_id) {
            $.ajax({
                url: '<?php echo site_url('mp_vidhan_sabha_member/get_vidhan_sabhas_by_district'); ?>',
                type: 'POST',
                data: { district_id: district_id },
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(index, vs) {
                            $vs.append('<option value="' + vs.id + '">' + vs.vidhan_sabha_name + '</option>');
                        });
                    } else {
                        $vs.append('<option value="other">Other</option>');
                    }
                },
                error: function() {
                    $vs.append('<option value="other">Other</option>');
                }
            });
        }
    });
    
    // Load Panchayat when block is selected
    $('#block_id').change(function() {
        var block_id = $(this).val();
        var $panchayat = $("#panchayat_id");
        $panchayat.empty().append('<option value="">Select Panchayat</option>').prop("disabled", !block_id);
        
        // Reset village dropdown
        $("#village_id").empty().append('<option value="">Select Panchayat first</option>').prop("disabled", true);
        
        if (block_id) {
            $.ajax({
                url: '<?php echo site_url('mp_vidhan_sabha_member/get_panchayats_by_block'); ?>',
                type: 'POST',
                data: { block_id: block_id },
                dataType: 'json',
                success: function(response) {
                    if (!response.error && response.panchayats && response.panchayats.length > 0) {
                        $.each(response.panchayats, function(index, panchayat) {
                            $panchayat.append('<option value="' + panchayat.id + '">' + panchayat.name + '</option>');
                        });
                    } else {
                        $panchayat.append('<option value="other">Other</option>');
                    }
                },
                error: function() {
                    $panchayat.append('<option value="other">Other</option>');
                }
            });
        }
    });
    
    // Load Village when panchayat is selected
    $('#panchayat_id').change(function() {
        var panchayat_id = $(this).val();
        var $village = $("#village_id");
        $village.empty().append('<option value="">Select Village</option>').prop("disabled", !panchayat_id);
        
        if (panchayat_id) {
            $.ajax({
                url: '<?php echo site_url('mp_vidhan_sabha_member/get_villages_by_panchayat'); ?>',
                type: 'POST',
                data: { panchayat_id: panchayat_id },
                dataType: 'json',
                success: function(response) {
                    if (!response.error && response.villages && response.villages.length > 0) {
                        $.each(response.villages, function(index, village) {
                            $village.append('<option value="' + village.id + '">' + village.name + '</option>');
                        });
                    } else {
                        $village.append('<option value="other">Other</option>');
                    }
                },
                error: function() {
                    $village.append('<option value="other">Other</option>');
                }
            });
        }
    });
});
</script>
