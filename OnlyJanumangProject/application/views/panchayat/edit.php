<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Panchayat Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('panchayat/update/'.$panchayat['id']); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="blockid">Block:</label>
                                        <select class="form-control select2 required" id="blockid" name="blockid">
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
                                                    $selected = ($panchayat['blockid'] == $blk->id) ? 'selected' : '';
                                                    
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
                                        <select class="form-control select2 required" id="boothid" name="boothid">
                                            <option value="0">Select Booth</option>
                                            <?php foreach($booths as $booth){ ?>
                                            <option value="<?php echo $booth['id'] ?>" <?php echo ($booth['id'] == $panchayat['booth_id']) ? 'selected' : ''; ?>>
                                                <?php echo $booth['name'] ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pname">Panchayat Name:</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('pname', $panchayat['name']); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                $this->load->helper('form');
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
    // Load booths when the block is selected or when the page loads with a block selected
    function loadBooths(blockId, selectedBoothId = null) {
        if (blockId != 0) {
            $.ajax({
                url: '<?php echo site_url('panchayat/getBoothsByBlock'); ?>',
                method: 'POST',
                data: {blockid: blockId},
                dataType: 'json',
                success: function(response) {
                    $('#boothid').empty();
                    $('#boothid').append('<option value="0">Select Booth</option>');
                    $.each(response, function(index, value) {
                        var selected = (value.id == selectedBoothId) ? 'selected' : '';
                        $('#boothid').append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#boothid').empty();
            $('#boothid').append('<option value="0">Select Booth</option>');
        }
    }

    // On Block change, load Booths dynamically
    $('#blockid').change(function() {
        var blockId = $(this).val();
        loadBooths(blockId);
    });

    // Load Booths on page load if Block is already selected
    var initialBlockId = $('#blockid').val();
    var selectedBoothId = '<?php echo $panchayat['boothid']; ?>';
    if (initialBlockId != 0) {
        loadBooths(initialBlockId, selectedBoothId);
    }
});
</script>

