<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Panchayat Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('panchayat/store'); ?>" method="post">
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
                                        <select class="form-control select2 required" id="year" name="year">
                                            <option value="">Select Year</option>
                                            <?php
                                            $current_year = date('Y');
                                            for ($i = $current_year; $i >= $current_year - 10; $i--) {
                                                echo "<option value='$i'>$i</option>";
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
                                            <!-- Booth options will be populated dynamically based on selected Block -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pname">Panchayat Name:</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('pname'); ?>">
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
});
</script>


