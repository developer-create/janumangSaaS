 <div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Village</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('village/update/'.$village['id']); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Village Name:</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $village['name']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="blockid">Block:</label>
                                        <select class="form-control select2 required" id="blockid" name="blockid" required>
                                            <option value="0">Select Block</option>
                                           
                                            
                                             <?php
                                                 $userid = $this->session->userdata('userId');
                                                 $sessionBlockId = $this->session->userdata('blockId');
                                                //  $this->db->where('id !=', 6);
                                                 if ($sessionBlockId != 0) {
                                                     $userBlockIds = $this->db->select('blockId')
                                                        ->from('tbl_users')
                                                        ->where('userId', $userid)
                                                        ->get()
                                                        ->row()
                                                        ->blockId;
                                                        
                                                        $blockIdsArray = explode(',', $userBlockIds);
                                                        $this->db->where_in('block.id', $blockIdsArray);
                                                }
                                                $blocks = $this->db->get('block')->result();
                                                foreach ($blocks as $blk) {
                                                    // Check if the block ID is selected
                                                    $selected = ($village['blockid'] == $blk->id) ? 'selected' : '';
                                                    
                                                    // Output the option element
                                                    echo "<option value='{$blk->id}' {$selected}>{$blk->name}</option>";
                                                    }
                                                ?>  
                                                
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="boothid">Booth:</label>
                                        <select class="form-control select2 required" id="boothid" name="boothid" required>
                                            <option value="0">Select Booth</option>
                                            <?php foreach($booths as $eachBooth){ ?>
                                            <option value="<?php echo $eachBooth['id']; ?>" 
                                            <?php if($village['boothid'] == $eachBooth['id']){ echo "selected"; } ?>>
                                            <?php echo $eachBooth['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="panchayatid">Panchayat:</label>
                                        <select class="form-control select2 required" id="panchayatid" name="panchayatid" required>
                                            <option value="0">Select Panchayat</option>
                                            <?php foreach($panchayats as $eachPanchayat){ ?>
                                            <option value="<?php echo $eachPanchayat['id']; ?>" 
                                            <?php if($village['panchayatid'] == $eachPanchayat['id']){ echo "selected"; } ?>>
                                            <?php echo $eachPanchayat['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                $success = $this->session->flashdata('success');
                if ($success) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var blockId = $('#blockid').val();
    var selectedBoothId = '<?php echo $village['boothid']; ?>';
    var selectedPanchayatId = '<?php echo $village['panchayatid']; ?>';
    
    if(blockId != 0) {
        $.ajax({
            url: '<?php echo site_url('panchayat/getBoothsByBlock'); ?>',
            method: 'POST',
            data: {blockid: blockId},
            dataType: 'json',
            success: function(response) {
                $('#boothid').empty();
                $('#boothid').append('<option value="0">Select Booth</option>');
                $.each(response, function(index, value) {
                    $('#boothid').append('<option value="' + value.id + '"' + (value.id == selectedBoothId ? ' selected' : '') + '>' + value.name + '</option>');
                });

                // Trigger the change event to load the Panchayats
                if(selectedBoothId != 0) {
                    $('#boothid').trigger('change');
                }
            }
        });
    }

    $('#blockid').change(function() {
        blockId = $(this).val();
        if(blockId != 0) {
            $.ajax({
                url: '<?php echo site_url('panchayat/getBoothsByBlock'); ?>',
                method: 'POST',
                data: {blockid: blockId},
                dataType: 'json',
                success: function(response) {
                    $('#boothid').empty();
                    $('#boothid').append('<option value="0">Select Booth</option>');
                    $.each(response, function(index, value) {
                        $('#boothid').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#boothid').empty();
            $('#boothid').append('<option value="0">Select Booth</option>');
        }
    });
    
    $('#boothid').change(function() {
        var boothid = $(this).val();
        if(boothid != 0) {
            $.ajax({
                url: '<?php echo site_url('panchayat/getpanchayatidByBooth'); ?>',
                method: 'POST',
                data: {boothid: boothid},
                dataType: 'json',
                success: function(response) {
                    $('#panchayatid').empty();
                    $('#panchayatid').append('<option value="0">Select Panchayat</option>');
                    $.each(response, function(index, value) {
                        $('#panchayatid').append('<option value="' + value.id + '"' + (value.id == selectedPanchayatId ? ' selected' : '') + '>' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#panchayatid').empty();
            $('#panchayatid').append('<option value="0">Select Panchayat</option>');
        }
    });

    // On page load, trigger change event for Booth if a Booth is already selected
    if (selectedBoothId != 0) {
        $('#boothid').trigger('change');
    }
});
</script>
