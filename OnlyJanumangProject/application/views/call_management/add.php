<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-phone" aria-hidden="true"></i> Add New Call
            <small>Register a new call or inquiry</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('callmanagement'); ?>">Call Management</a></li>
            <li class="active">Add New Call</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Call Information</h3>
                    </div>
                    
                    <?php echo form_open('callmanagement/store', array('class' => 'form-horizontal')); ?>
                    <div class="box-body">
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Validation Error!</h4>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Row 1: Date & Time and Category -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_time" class="col-sm-4 control-label">Date & Time <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="datetime-local" class="form-control" id="date_time" name="date_time" 
                                               value="<?php echo set_value('date_time', date('Y-m-d\TH:i')); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="col-sm-4 control-label">Category <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $key => $value): ?>
                                                <option value="<?php echo $key; ?>" <?php echo set_select('category', $key); ?>>
                                                    <?php echo $value; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Name and Mobile No -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-4 control-label">Name <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo set_value('name'); ?>" maxlength="100" required 
                                               placeholder="Enter full name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile_no" class="col-sm-4 control-label">Mobile No <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="tel" class="form-control" id="mobile_no" name="mobile_no" 
                                               value="<?php echo set_value('mobile_no'); ?>" pattern="[6-9]{1}[0-9]{9}" 
                                               maxlength="10" required placeholder="10-digit mobile number">
                                        <small class="text-muted">Enter 10-digit mobile number starting with 6, 7, 8, or 9</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Subject and Assign Date -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject" class="col-sm-4 control-label">Subject <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="subject" name="subject" 
                                               value="<?php echo set_value('subject'); ?>" maxlength="200" required
                                               placeholder="Brief subject of the call">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="assign_datetime" class="col-sm-4 control-label">Assign Date & Time <span class="text-red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="datetime-local" class="form-control" id="assign_datetime" name="assign_datetime" 
                                               value="<?php echo set_value('assign_datetime'); ?>" 
                                               placeholder="Select assignment date and time (optional)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Address (Full Width) -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">Address <span class="text-red">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="address" name="address" rows="3" 
                                                  maxlength="255" required placeholder="Complete address with landmarks"><?php echo set_value('address'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 5: Description (Full Width) -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description <span class="text-red">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="description" name="description" rows="4" 
                                                  required placeholder="Detailed description of the call or issue"><?php echo set_value('description'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 6: Remark (Full Width) -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remark" class="col-sm-2 control-label">Remark</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="remark" name="remark" rows="3" 
                                                  maxlength="255" placeholder="Additional remarks or notes (optional)"><?php echo set_value('remark'); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Call Record
                                </button>
                                <a href="<?php echo site_url('callmanagement'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Set current date and time by default
    var now = new Date();
    var year = now.getFullYear();
    var month = (now.getMonth() + 1).toString().padStart(2, '0');
    var day = now.getDate().toString().padStart(2, '0');
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    
    if (!$('#date_time').val()) {
        $('#date_time').val(year + '-' + month + '-' + day + 'T' + hours + ':' + minutes);
    }
    
    // No auto-fill for assign_datetime - let user select manually
    
    // Mobile number validation
    $('#mobile_no').on('input', function() {
        var value = this.value.replace(/[^0-9]/g, '');
        if (value.length > 10) {
            value = value.slice(0, 10);
        }
        this.value = value;
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        var mobile = $('#mobile_no').val();
        if (mobile.length !== 10 || !mobile.match(/^[6-9]/)) {
            alert('Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9');
            e.preventDefault();
            return false;
        }
    });


});
</script>