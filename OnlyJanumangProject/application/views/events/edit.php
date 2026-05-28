<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Event Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('events/update/'.$event['id']); ?>" method="post">
                        
                        <div class="box-body">
                            <!-- Invitation Details Section -->
                            <h4 style="background-color: #3c8dbc; color: white; padding: 10px; margin-bottom: 20px;">Invitation Received Details</h4>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="date">Invitation Date:</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo $event['date']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="office">Invitation Received Office:</label>
                                        <select class="form-control required" id="office" name="office">
                                            <option value="">Select Office</option>
                                            <option value="Bhopal" <?php echo ($event['office'] === 'Bhopal') ? 'selected' : ''; ?>>Bhopal</option>
                                            <option value="Dhar" <?php echo ($event['office'] === 'Dhar') ? 'selected' : ''; ?>>Dhar</option>
                                            <option value="Gandhwani" <?php echo ($event['office'] === 'Gandhwani') ? 'selected' : ''; ?>>Gandhwani</option>
                                            <option value="Tanda" <?php echo ($event['office'] === 'Tanda') ? 'selected' : ''; ?>>Tanda</option>
                                            <option value="Bagh" <?php echo ($event['office'] === 'Bagh') ? 'selected' : ''; ?>>Bagh</option>
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
                                        <input type="date" class="form-control required" id="program_date" name="program_date" value="<?php echo $event['program_date']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="day">Event Day:</label>
                                        <select class="form-control" id="day" name="day">
                                            <option value="">-- Select Day --</option>
                                            <option value="Monday" <?php echo (isset($event['day']) && $event['day'] === 'Monday') ? 'selected' : ''; ?>>Monday</option>
                                            <option value="Tuesday" <?php echo (isset($event['day']) && $event['day'] === 'Tuesday') ? 'selected' : ''; ?>>Tuesday</option>
                                            <option value="Wednesday" <?php echo (isset($event['day']) && $event['day'] === 'Wednesday') ? 'selected' : ''; ?>>Wednesday</option>
                                            <option value="Thursday" <?php echo (isset($event['day']) && $event['day'] === 'Thursday') ? 'selected' : ''; ?>>Thursday</option>
                                            <option value="Friday" <?php echo (isset($event['day']) && $event['day'] === 'Friday') ? 'selected' : ''; ?>>Friday</option>
                                            <option value="Saturday" <?php echo (isset($event['day']) && $event['day'] === 'Saturday') ? 'selected' : ''; ?>>Saturday</option>
                                            <option value="Sunday" <?php echo (isset($event['day']) && $event['day'] === 'Sunday') ? 'selected' : ''; ?>>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="month">Event Month:</label>
                                        <select class="form-control required" id="month" name="month" required>
                                            <option value="">Select Month</option>
                                            <option value="January" <?php echo (isset($event['month']) && $event['month'] === 'January') ? 'selected' : ''; ?>>January</option>
                                            <option value="February" <?php echo (isset($event['month']) && $event['month'] === 'February') ? 'selected' : ''; ?>>February</option>
                                            <option value="March" <?php echo (isset($event['month']) && $event['month'] === 'March') ? 'selected' : ''; ?>>March</option>
                                            <option value="April" <?php echo (isset($event['month']) && $event['month'] === 'April') ? 'selected' : ''; ?>>April</option>
                                            <option value="May" <?php echo (isset($event['month']) && $event['month'] === 'May') ? 'selected' : ''; ?>>May</option>
                                            <option value="June" <?php echo (isset($event['month']) && $event['month'] === 'June') ? 'selected' : ''; ?>>June</option>
                                            <option value="July" <?php echo (isset($event['month']) && $event['month'] === 'July') ? 'selected' : ''; ?>>July</option>
                                            <option value="August" <?php echo (isset($event['month']) && $event['month'] === 'August') ? 'selected' : ''; ?>>August</option>
                                            <option value="September" <?php echo (isset($event['month']) && $event['month'] === 'September') ? 'selected' : ''; ?>>September</option>
                                            <option value="October" <?php echo (isset($event['month']) && $event['month'] === 'October') ? 'selected' : ''; ?>>October</option>
                                            <option value="November" <?php echo (isset($event['month']) && $event['month'] === 'November') ? 'selected' : ''; ?>>November</option>
                                            <option value="December" <?php echo (isset($event['month']) && $event['month'] === 'December') ? 'selected' : ''; ?>>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="year">Event Year:</label>
                                        <input type="number" class="form-control required" id="year" name="year" value="<?php echo $event['year']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="unique_id">Unique ID:</label>
                                        <input type="text" class="form-control" id="unique_id" name="unique_id" value="<?php echo isset($event['unique_id']) ? $event['unique_id'] : ''; ?>" readonly style="background-color: #f5f5f5;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="event_type">Event Type:</label>
                                        <select class="form-control required" name="event_type">
                                         <option value="">Select Event Type</option>
                                         <option value="Social Events" <?php echo ($event['event_type'] === 'Social Events') ? 'selected' : ''; ?>>Social Events</option>
                                         <option value="Sports Events" <?php echo ($event['event_type'] === 'Sports Events') ? 'selected' : ''; ?>>Sports Events</option>
                                         <option value="Religious Events" <?php echo ($event['event_type'] === 'Religious Events') ? 'selected' : ''; ?>>Religious Events</option>
                                         <option value="Professional Events" <?php echo ($event['event_type'] === 'Professional Events') ? 'selected' : ''; ?>>Professional Events</option>
                                         <option value="Condolence Journal" <?php echo ($event['event_type'] === 'Condolence Journal') ? 'selected' : ''; ?>>Condolence Journal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="time">Event Time:</label>
                                        <input type="time" class="form-control required" id="time" name="time" value="<?php echo $event['time']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Details Section -->
                            <h4 style="background-color: #3c8dbc; color: white; padding: 10px; margin-bottom: 20px; margin-top: 30px;">Program  Details</h4>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="event_detail">Event (Name) Details:</label>
                                        <input type="text" class="form-control required" id="event_detail" name="event_detail" value="<?php echo $event['event_detail']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">Block:</label>
                                       <select class="form-control required" id="block" name="block">
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>"  <?php echo ((int)$event['block'] === (int)$block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">District:</label>
                                        <select class="form-control required" id="district" name="district">
                                            <option value="">Select District</option>
                                            <?php 
                                            $districtFound = false;
                                            foreach ($districts as $district): 
                                                $isSelected = $event['district'] == $district['id'];
                                                if ($isSelected) $districtFound = true;
                                            ?>
                                                <option value="<?php echo $district['id']; ?>" <?php echo $isSelected ? 'selected' : ''; ?>><?php echo $district['name']; ?></option>
                                            <?php endforeach; ?>
                                            <option value="other" <?php echo !$districtFound ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="other_district_field" style="display: <?php echo !$districtFound ? 'block' : 'none'; ?>;">
                                    <div class="form-group">
                                        <label for="other_district_name">Enter District Name:</label>
                                        <input type="text" class="form-control" id="other_district_name" name="other_district_name" value="<?php echo !$districtFound ? $event['district'] : ''; ?>" placeholder="Enter new district name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="venue_city">Venue City:</label>
                                        <input type="text" class="form-control required" id="venue_city" name="venue_city" value="<?php echo $event['venue_city']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="referance">Reference Person Name/Post:</label>
                                         <input type="text" class="form-control required" id="referance" name="referance" value="<?php echo $event['referance']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_number">Contact Number:</label>
                                         <input type="number" class="form-control required" id="contact_number" name="contact_number" value="<?php echo $event['contact_number']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Address:</label>
                                        <textarea class="form-control" id="address" name="address" required><?php echo $event['address']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name:</label>
                                         <input type="text" class="form-control required" id="name" name="name" value="<?php echo $event['name']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location">Location:</label>
                                         <input type="text" class="form-control required" id="location" name="location" value="<?php echo $event['location']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="priority">Priority:</label>
                                        <select class="form-control" name="priority">
                                         <option value="">Select Priority</option>
                                         <option value="High" <?php echo ($event['priority'] === 'High') ? 'selected' : ''; ?>>High</option>
                                         <option value="Medium" <?php echo ($event['priority'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
                                         <option value="Low" <?php echo ($event['priority'] === 'Low') ? 'selected' : ''; ?>>Low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="probability">PROBABILITY  ( JANA KI NAHI JANA):</label>
                                        <select class="form-control required" name="probability">
                                         <option value="">Select Option</option>
                                         <option value="जाना है" <?php echo ($event['probability'] === 'जाना है') ? 'selected' : ''; ?>>जाना हैं</option>
                                         <option value="नही जाना है" <?php echo ($event['probability'] === 'नही जाना है') ? 'selected' : ''; ?>>नही जाना हैं</option>
                                         <option value="जानकारी नही है" <?php echo ($event['probability'] === 'जानकारी नही है') ? 'selected' : ''; ?>>जानकारी नही हैं</option>
                                        </select>
                                    </div>
                                </div>
                     
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tentative_duration">TENTATIVE DURATION :</label>
                                        <input type="text" class="form-control" id="tentative_duration" name="tentative_duration" value="<?php echo $event['tentative_duration']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="attended">ATTENDED (YES/NO):</label>
                                        <select class="form-control required" id="attended" name="attended">
                                         <option value="">-- Select Option --</option>
                                         <option value="YES" <?php echo ($event['attended'] === 'YES') ? 'selected' : ''; ?>>YES</option>
                                         <option value="NO" <?php echo ($event['attended'] === 'NO') ? 'selected' : ''; ?>>NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="press">Press Conference:</label>
                                        <input type="text" class="form-control" id="press" name="press" value="<?php echo $event['press']; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="row" id="not_attended_fields" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dispatch_date">DISPATCH DATE (IF NOT ATTANDED):</label>
                                        <input type="date" class="form-control" id="dispatch_date" name="dispatch_date" value="<?php echo $event['dispatch_date']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dispatch_number">DISPATCH NUMBER (IF NOT ATTANDED) :</label>
                                        <input type="text" class="form-control" id="dispatch_number" name="dispatch_number" value="<?php echo $event['dispatch_number']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="remark"> Remark (IF NOT ATTANDED) :</label>
                                        <textarea class="form-control" id="remark" name="remark"><?php echo $event['remark']; ?></textarea>
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
        const date = new Date(dateValue + 'T00:00:00');
        
        // Get day name
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const dayName = dayNames[date.getUTCDay()];
        
        // Get month name
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                            'July', 'August', 'September', 'October', 'November', 'December'];
        const monthName = monthNames[date.getUTCMonth()];
        
        // Get year
        const year = date.getUTCFullYear();
        
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
</script>
