<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Visitor Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('visitors/store'); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district">District:</label>
                                        <select class="form-control required" id="district" name="district" data-district-id="">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $district): ?>
                                                <option value="<?php echo $district['id']; ?>" data-district-id="<?php echo $district['id']; ?>" <?php echo set_value('district') == $district['id'] ? 'selected' : ''; ?>>
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
                                                <option value="<?php echo htmlspecialchars($vidhan_sabha['vidhan_sabha_name'] ?? $vidhan_sabha['id']); ?>" <?php echo set_value('vidhan_sabha') == ($vidhan_sabha['vidhan_sabha_name'] ?? $vidhan_sabha['id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($vidhan_sabha['vidhan_sabha_name'] ?? ''); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Block">Block:</label>
                                       <select class="form-control required" id="block" name="block">
    <option value="">Select Block</option>
  
                    <?php foreach ($blocks as $block): ?>
                                    <option value="<?php echo $block->id; ?>"  <?php echo set_value('block') == $block->id ? 'selected' : ''; ?> ><?php echo $block->name; ?></option>
                                <?php endforeach; ?>
</select>

                                    </div>
                                </div> </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo set_value('date'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="time">Time:</label>
                                        <input type="time" class="form-control required" id="time" name="time" value="<?php echo set_value('time'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('name'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <select class="form-control required" id="category" name="category">
            <option value="">-- Select Category --</option>
            <option value="General Visitor" <?php echo set_select('category', 'General Visitor'); ?>>General Visitor</option>
            <option value="Party Worker" <?php echo set_select('category', 'Party Worker'); ?>>Party Worker</option>
            <option value="Jan Pratinidhi (जन प्रतिनिधि)" <?php echo set_select('category', 'Jan Pratinidhi (जन प्रतिनिधि)'); ?>>Jan Pratinidhi (जन प्रतिनिधि)</option>
            <option value="Govt. Employee" <?php echo set_select('category', 'Govt. Employee'); ?>>Govt. Employee</option>
            <option value="Pvt. Employee" <?php echo set_select('category', 'Pvt. Employee'); ?>>Pvt. Employee</option>
            <option value="Social Worker(NGO)" <?php echo set_select('category', 'Social Worker(NGO)'); ?>>Social Worker (NGO)</option>
            <option value="Media Person" <?php echo set_select('category', 'Media Person'); ?>>Media Person</option>
            <option value="Student" <?php echo set_select('category', 'Student'); ?>>Student</option>
            <option value="Others" <?php echo set_select('category', 'Others'); ?>>Others</option>
        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post">Post:</label>
                                        <input type="text" class="form-control required" id="post" name="post" value="<?php echo set_value('post'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place">Place:</label>
                                        <input type="text" class="form-control required" id="place" name="place" value="<?php echo set_value('place'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No:</label>
                                        <input type="text" class="form-control required" id="mobile_no" name="mobile_no" value="<?php echo set_value('mobile_no'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="in_coming_visitor">In-coming / Visitor:</label>
                                        <select class="form-control" id="in_coming_visitor" name="in_coming_visitor">
                                            <option value="IN-COMING" <?php echo set_select('in_coming_visitor', 'IN-COMING'); ?>>IN-COMING</option>
                                            <option value="VISITOR" <?php echo set_select('in_coming_visitor', 'VISITOR'); ?>>VISITOR</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Visitor Type <span style="color: red;">*</span></label>
                                        <select class="form-control required" id="type" name="type" required>
            <option value="">-- Visitor Type --</option>
            <option value="General Visitor" <?php echo set_select('type', 'General Visitor'); ?>>General Visitor</option>
            <option value="Problem" <?php echo set_select('type', 'Problem'); ?>>Problem</option>
            
        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attend">Attend By:</label>
                                        <input type="text" class="form-control required" id="attend" name="attend" value="<?php echo set_value('attend'); ?>">
                                    </div>
                                </div>
                                </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="message">Message:</label>
                                        <textarea class="form-control" id="message" name="message"><?php echo set_value('message'); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">Remark:</label>
                                        <textarea class="form-control" id="remark" name="remark"><?php echo set_value('remark'); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="uss_coding">USS Coding:</label>
                                        <input type="text" class="form-control" id="uss_coding" name="uss_coding" value="<?php echo set_value('uss_coding'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="bhaiya_ke_nirdesh">भईया के निर्देश :</label>
                                        <textarea class="form-control" id="bhaiya_ke_nirdesh" name="bhaiya_ke_nirdesh"><?php echo set_value('bhaiya_ke_nirdesh'); ?></textarea>
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
