<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Village Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('village/store'); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Village Name:</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('name'); ?>" required>
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
                        echo "<option value='{$blk->id}'>{$blk->name}</option>";
                    }
                    ?>  
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Year:</label>
                                        <select class="form-control select2 required" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <?php 
                                            $currentYear = date('Y');
                                            for($i=$currentYear; $i>=2020; $i--) {
                                                echo "<option value='{$i}'>{$i}</option>";
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
                                            <!-- Booth options will be populated dynamically based on selected Block -->
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
                                            <!-- Panchayat options will be populated dynamically based on selected Booth -->
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
    function fetchBooths() {
        var blockId = $('#blockid').val();
        var year = $('#year').val();
        if(blockId != 0 && year != "") {
            $.ajax({
                url: '<?php echo site_url('panchayat/getBoothsByBlock'); ?>',
                method: 'POST',
                data: {blockid: blockId, year: year},
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
    }

    $('#blockid, #year').change(function() {
        fetchBooths();
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
                        $('#panchayatid').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#panchayatid').empty();
            $('#panchayatid').append('<option value="0">Select Panchayat</option>');
        }
    });
    
});
</script>

 