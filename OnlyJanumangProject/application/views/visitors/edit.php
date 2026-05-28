<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Visitor Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('visitors/update/'.$visitor['id']); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district">District:</label>
                                        <select class="form-control required" id="district" name="district">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $district): ?>
                                                <option value="<?php echo $district['id']; ?>" <?php echo $district['is_selected'] ? 'selected' : ''; ?>>
                                                    <?php echo $district['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="vidhan_sabha">Vidhan Sabha:</label>
                                        <select class="form-control required" id="vidhan_sabha" name="vidhan_sabha">
                                            <option value="">Select Vidhan Sabha</option>
                                            <?php foreach ($vidhan_sabhas as $vidhan_sabha): ?>
                                                <option value="<?php echo $vidhan_sabha['name']; ?>" <?php echo $vidhan_sabha['is_selected'] ? 'selected' : ''; ?>>
                                                    <?php echo $vidhan_sabha['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block">Block:</label>
                                         <select class="form-control required" id="block" name="block">
                                            <option value="">Select Block</option>
  
                                             <?php foreach ($blocks as $block): ?>
                                            <option value="<?php echo $block->id; ?>" <?php echo ($visitor['block'] == $block->id) ? 'selected' : ''; ?> ><?php echo $block->name; ?></option>
                                             <?php endforeach; ?>
                                        </select>
                                        

                                    </div>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $visitor['date']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time">Time:</label>
                                        <input type="time" class="form-control" id="time" name="time" value="<?php echo $visitor['time']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $visitor['name']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <select class="form-control" id="category" name="category" required>
            <option value="">-- Select Category --</option>
            <option value="General Visitor" <?php echo ($visitor['category'] == 'General Visitor') ? 'selected' : ''; ?>>General Visitor</option>
            <option value="Party Worker" <?php echo ($visitor['category'] == 'Party Worker') ? 'selected' : ''; ?>>Party Worker</option>
            <option value="Jan Pratinidhi (जन प्रतिनिधि)" <?php echo ($visitor['category'] == 'Jan Pratinidhi (जन प्रतिनिधि)') ? 'selected' : ''; ?>>Jan Pratinidhi (जन प्रतिनिधि)</option>
            <option value="Govt. Employee" <?php echo ($visitor['category'] == 'Govt. Employee') ? 'selected' : ''; ?>>Govt. Employee</option>
            <option value="Pvt. Employee" <?php echo ($visitor['category'] == 'Pvt. Employee') ? 'selected' : ''; ?>>Pvt. Employee</option>
            <option value="Social Worker(NGO)" <?php echo ($visitor['category'] == 'Social Worker(NGO)') ? 'selected' : ''; ?>>Social Worker (NGO)</option>
            <option value="Media Person" <?php echo ($visitor['category'] == 'Media Person') ? 'selected' : ''; ?>>Media Person</option>
            <option value="Student" <?php echo ($visitor['category'] == 'Student') ? 'selected' : ''; ?>>Student</option>
            <option value="Others" <?php echo ($visitor['category'] == 'Others') ? 'selected' : ''; ?>>Others</option>
        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post">Post:</label>
                                        <input type="text" class="form-control" id="post" name="post" value="<?php echo $visitor['post']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place">Place:</label>
                                        <input type="text" class="form-control" id="place" name="place" value="<?php echo $visitor['place']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No:</label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $visitor['mobile_no']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="in_coming_visitor">In-coming / Visitor:</label>
                                        <select class="form-control" id="in_coming_visitor" name="in_coming_visitor">
                                            <option value="IN-COMING" <?php echo ($visitor['in_coming_visitor'] == 'IN-COMING') ? 'selected' : ''; ?>>IN-COMING</option>
                                            <option value="VISITOR" <?php echo ($visitor['in_coming_visitor'] == 'VISITOR') ? 'selected' : ''; ?>>VISITOR</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="type">Visitor type:</label>
                                        <select class="form-control" id="type" name="type">
                                            <option value="General Visitor" <?php echo ($visitor['type'] == 'General Visitor') ? 'selected' : ''; ?>>General Visitor</option>
                                            <option value="Problem" <?php echo ($visitor['type'] == 'Problem') ? 'selected' : ''; ?>>Problem</option>
                                        </select>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="attend">Attend By:</label>
                                        <input type="text" class="form-control" id="attend" name="attend" value="<?php echo $visitor['attend']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message">Message:</label>
                                        <textarea class="form-control" id="message" name="message"><?php echo $visitor['message']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark:</label>
                                        <textarea class="form-control" id="remark" name="remark"><?php echo $visitor['remark']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="uss_coding">USS Coding:</label>
                                        <input type="text" class="form-control" id="uss_coding" name="uss_coding" value="<?php echo $visitor['uss_coding']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="bhaiya_ke_nirdesh">भईया के निर्देश :</label>
                                        <textarea class="form-control" id="bhaiya_ke_nirdesh" name="bhaiya_ke_nirdesh"><?php echo $visitor['bhaiya_ke_nirdesh']; ?></textarea>
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
<script>
$(document).ready(function() {
    // Handle district change event
    $('#district').on('change', function() {
        var district_id = $(this).val();
        
        if (district_id === '') {
            // Clear vidhan sabha dropdown if no district selected
            $('#vidhan_sabha').html('<option value="">Select Vidhan Sabha</option>');
            return;
        }
        
        // Make AJAX request to get vidhan sabhas for selected district
        $.ajax({
            url: '<?php echo site_url("visitors/get_vidhan_sabhas_by_district"); ?>',
            type: 'POST',
            data: { district_id: district_id },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.vidhan_sabhas.length > 0) {
                    var options = '<option value="">Select Vidhan Sabha</option>';
                    $.each(response.vidhan_sabhas, function(index, vs) {
                        options += '<option value="' + vs.vidhan_sabha_name + '">' + vs.vidhan_sabha_name + '</option>';
                    });
                    $('#vidhan_sabha').html(options);
                } else {
                    $('#vidhan_sabha').html('<option value="">No Vidhan Sabha available for this district</option>');
                }
            },
            error: function() {
                $('#vidhan_sabha').html('<option value="">Error loading Vidhan Sabha</option>');
            }
        });
    });
});
</script>
