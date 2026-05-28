<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Events Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('events/store'); ?>" method="post">
                        <div class="box-body">
                            <!-- Display Validation Errors -->
                            <?php if ($this->form_validation->run() == FALSE && $this->input->post()): ?>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    <?php echo validation_errors(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Invitation Details Section -->
                            <h4 style="background-color: #3c8dbc; color: white; padding: 10px; margin-bottom: 20px;">Invitation Received Details</h4>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="date">Invitation Date:</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo set_value('date'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="office">Invitation Received Office:</label>
                                        <select class="form-control required" id="office" name="office">
                                            <option value="">Select Office</option>
                                            <option value="Bhopal" <?php echo set_select('office', 'Bhopal'); ?>>Bhopal</option>
                                            <option value="Dhar" <?php echo set_select('office', 'Dhar'); ?>>Dhar</option>
                                            <option value="Gandhwani" <?php echo set_select('office', 'Gandhwani'); ?>>Gandhwani</option>
                                            <option value="Tanda" <?php echo set_select('office', 'Tanda'); ?>>Tanda</option>
                                            <option value="Bagh" <?php echo set_select('office', 'Bagh'); ?>>Bagh</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Event Details Section -->
                            <h4 style="background-color: #3c8dbc; color: white; padding: 10px; margin-bottom: 20px; margin-top: 30px;">Event Details</h4>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="program_date">Event Program Date:</label>
                                        <input type="date" class="form-control required" id="program_date" name="program_date" value="<?php echo set_value('program_date'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="day">Event Day:</label>
                                        <select class="form-control" id="day" name="day">
                                            <option value="">-- Select Day --</option>
                                            <option value="Monday" <?php echo set_select('day', 'Monday'); ?>>Monday</option>
                                            <option value="Tuesday" <?php echo set_select('day', 'Tuesday'); ?>>Tuesday</option>
                                            <option value="Wednesday" <?php echo set_select('day', 'Wednesday'); ?>>Wednesday</option>
                                            <option value="Thursday" <?php echo set_select('day', 'Thursday'); ?>>Thursday</option>
                                            <option value="Friday" <?php echo set_select('day', 'Friday'); ?>>Friday</option>
                                            <option value="Saturday" <?php echo set_select('day', 'Saturday'); ?>>Saturday</option>
                                            <option value="Sunday" <?php echo set_select('day', 'Sunday'); ?>>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="month">Event Month:</label>
                                        <select class="form-control required" id="month" name="month">
                                            <option value="">Select Month</option>
                                            <option value="January" <?php echo set_select('month', 'January'); ?>>January</option>
                                            <option value="February" <?php echo set_select('month', 'February'); ?>>February</option>
                                            <option value="March" <?php echo set_select('month', 'March'); ?>>March</option>
                                            <option value="April" <?php echo set_select('month', 'April'); ?>>April</option>
                                            <option value="May" <?php echo set_select('month', 'May'); ?>>May</option>
                                            <option value="June" <?php echo set_select('month', 'June'); ?>>June</option>
                                            <option value="July" <?php echo set_select('month', 'July'); ?>>July</option>
                                            <option value="August" <?php echo set_select('month', 'August'); ?>>August</option>
                                            <option value="September" <?php echo set_select('month', 'September'); ?>>September</option>
                                            <option value="October" <?php echo set_select('month', 'October'); ?>>October</option>
                                            <option value="November" <?php echo set_select('month', 'November'); ?>>November</option>
                                            <option value="December" <?php echo set_select('month', 'December'); ?>>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">Event Year:</label>
                                        <input type="number" class="form-control required" id="year" name="year" value="<?php echo set_value('year'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unique_id_preview">Unique ID:</label>
                                        <input type="text" class="form-control" id="unique_id_preview" value="Auto Generated (ET/X)" readonly style="background-color: #f5f5f5; color: #999;">
                                    </div>
                                </div> -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="event_type">Event Type:</label>
                                        <select class="form-control required" name="event_type">
                                         <option value="">Select Event Type</option>
                                         <option value="Social Events" <?php echo set_select('event_type', 'Social Events'); ?>>Social Events </option>
                                         <option value="Sports Events" <?php echo set_select('event_type', 'Sports Events'); ?>>Sports Events </option>
                                         <option value="Religious Events" <?php echo set_select('event_type', 'Religious Events'); ?>>Religious Events </option>
                                         <option value="Professional Events" <?php echo set_select('event_type', 'Professional Events'); ?>>Professional Events </option>
                                         <option value="Condolence Journal" <?php echo set_select('event_type', 'Condolence Journal'); ?>>Condolence Journal </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="time">Event Time:</label>
                                        <input type="time" class="form-control required" id="time" name="time" value="<?php echo set_value('time'); ?>">
                                    </div>
                                </div>
                            </div>
                            <h4 style="background-color: #3c8dbc; color: white; padding: 10px; margin-bottom: 20px; margin-top: 30px;">Program  Details</h4>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="event_detail">Event (Name) Details:</label>
                                        <input type="text" class="form-control required" id="event_detail" name="event_detail" value="<?php echo set_value('event_detail'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block:</label>
                                       <select class="form-control required" id="block" name="block">
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>" <?php echo set_value('block') == $block->id ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District:</label>
                                        <select class="form-control required" id="district" name="district">
                                            <option value="">Select District</option>
                                            <?php foreach ($districts as $district): ?>
                                                <option value="<?php echo $district['id']; ?>" <?php echo set_value('district') == $district['id'] ? 'selected' : ''; ?>><?php echo $district['name']; ?></option>
                                            <?php endforeach; ?>
                                            <option value="other" <?php echo set_value('district') == 'other' ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="other_district_field" style="display: none;">
                                    <div class="form-group">
                                        <label for="other_district_name">Enter District Name:</label>
                                        <input type="text" class="form-control" id="other_district_name" name="other_district_name" value="<?php echo set_value('other_district_name'); ?>" placeholder="Enter new district name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="venue_city">Venue City:</label>
                                        <input type="text" class="form-control required" id="venue_city" name="venue_city" value="<?php echo set_value('venue_city'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="referance">Reference Person Name/Post:</label>
                                         <input type="text" class="form-control required" id="referance" name="referance" value="<?php echo set_value('referance'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number:</label>
                                         <input type="number" class="form-control required" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <textarea class="form-control" id="address" name="address"><?php echo set_value('address'); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                         <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('name'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location">Location:</label>
                                         <input type="text" class="form-control required" id="location" name="location" value="<?php echo set_value('location'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Priority:</label>
                                        <select class="form-control" name="priority">
                                         <option value="">Select Priority</option>
                                         <option value="High" <?php echo set_select('priority', 'High'); ?>>High</option>
                                         <option value="Medium" <?php echo set_select('priority', 'Medium'); ?>>Medium</option>
                                         <option value="Low" <?php echo set_select('priority', 'Low'); ?>>Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="probability">PROBABILITY  ( JANA KI NAHI JANA):</label>
                                        <select class="form-control required" name="probability">
                                         <option value="">Select Option</option>
                                         <option class="form-control required" value="जाना है" <?php echo set_select('probability', 'जाना है'); ?>>जाना हैं </option>
                                         <option class="form-control required" value="नही जाना है" <?php echo set_select('probability', 'नही जाना है'); ?>>नही जाना हैं </option>
                                         <option class="form-control required" value="जानकारी नही है" <?php echo set_select('probability', 'जानकारी नही है'); ?>>जानकारी नही हैं </option>
                                        </select>
                                       
                                    </div>
                                </div>
                     
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tentative_duration">TENTATIVE DURATION :</label>
                                        <input type="text" class="form-control" id="tentative_duration" name="tentative_duration" value="<?php echo set_value('tentative_duration'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="attended">ATTENDED (YES/NO):</label>
                                        <select class="form-control required" id="attended" name="attended">
                                         <option value="">-- Select Option --</option>
                                         <option value="YES" <?php echo set_select('attended', 'YES'); ?>>YES</option>
                                         <option value="NO" <?php echo set_select('attended', 'NO'); ?>>NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="press">Press Conference:</label>
                                        <input type="text" class="form-control required" id="press" name="press" value="<?php echo set_value('press'); ?>">
                                    </div>
                                </div></div>
                             <div class="row" id="not_attended_fields" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dispatch_date">DISPATCH DATE (IF NOT ATTANDED):</label>
                                        <input type="date" class="form-control" id="dispatch_date" name="dispatch_date" value="<?php echo set_value('dispatch_date'); ?>">
                                    </div>
                                </div>
                     
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dispatch_number">DISPATCH NUMBER (IF NOT ATTANDED) :</label>
                                        <input type="text" class="form-control" id="dispatch_number" name="dispatch_number" value="<?php echo set_value('dispatch_number'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="remark"> Remark (IF NOT ATTANDED) :</label>
                                        <textarea class="form-control" id="remark" name="remark"><?php echo set_value('remark'); ?></textarea>
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
// Auto-populate Day, Month, and Year when Program Date is selected
document.getElementById('program_date').addEventListener('change', function() {
    const dateValue = this.value;
    
    if (dateValue) {
        const date = new Date(dateValue);
        
        // Get day name (using local time, not UTC)
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const dayName = dayNames[date.getDay()];
        
        // Get month name
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                            'July', 'August', 'September', 'October', 'November', 'December'];
        const monthName = monthNames[date.getMonth()];
        
        // Get year
        const year = date.getFullYear();
        
        // Auto-populate fields
        document.getElementById('day').value = dayName;
        document.getElementById('month').value = monthName;
        document.getElementById('year').value = year;
    }
});

// Show/hide and enable/disable dispatch fields based on ATTENDED selection
document.getElementById('attended').addEventListener('change', function() {
    const notAttendedFields = document.getElementById('not_attended_fields');
    const dispatchDate = document.getElementById('dispatch_date');
    const dispatchNumber = document.getElementById('dispatch_number');
    const remark = document.getElementById('remark');
    
    if (this.value === 'NO') {
        // Show fields when NO is selected
        notAttendedFields.style.display = 'flex';
        dispatchDate.disabled = false;
        dispatchNumber.disabled = false;
        remark.disabled = false;
    } else {
        // Hide fields when YES is selected
        notAttendedFields.style.display = 'none';
        dispatchDate.disabled = true;
        dispatchNumber.disabled = true;
        remark.disabled = true;
        // Clear values when disabled
        dispatchDate.value = '';
        dispatchNumber.value = '';
        remark.value = '';
    }
});

// Handle District dropdown - show/hide "Other" input field
document.getElementById('district').addEventListener('change', function() {
    const otherDistrictField = document.getElementById('other_district_field');
    const otherDistrictInput = document.getElementById('other_district_name');
    
    if (this.value === 'other') {
        otherDistrictField.style.display = 'block';
        otherDistrictInput.classList.add('required');
    } else {
        otherDistrictField.style.display = 'none';
        otherDistrictInput.classList.remove('required');
        otherDistrictInput.value = '';
    }
});

// Check on page load (for validation errors)
window.addEventListener('DOMContentLoaded', function() {
    const attended = document.getElementById('attended');
    const notAttendedFields = document.getElementById('not_attended_fields');
    const dispatchDate = document.getElementById('dispatch_date');
    const dispatchNumber = document.getElementById('dispatch_number');
    const remark = document.getElementById('remark');
    const district = document.getElementById('district');
    const otherDistrictField = document.getElementById('other_district_field');
    const otherDistrictInput = document.getElementById('other_district_name');
    
    if (attended.value === 'NO') {
        notAttendedFields.style.display = 'flex';
        dispatchDate.disabled = false;
        dispatchNumber.disabled = false;
        remark.disabled = false;
    } else {
        notAttendedFields.style.display = 'none';
        dispatchDate.disabled = true;
        dispatchNumber.disabled = true;
        remark.disabled = true;
    }
    
    // Check if "Other" is selected on page load
    if (district.value === 'other') {
        otherDistrictField.style.display = 'block';
        otherDistrictInput.classList.add('required');
    }
});
</script>