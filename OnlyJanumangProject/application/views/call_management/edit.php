<?php $this->load->view('includes/header'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Edit Call Record
            <small>Update call information</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('CallManagement'); ?>">Call Management</a></li>
            <li class="active">Edit Call</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    
                    <?php echo form_open('callmanagement/update/' . $call->id, array('class' => 'form-horizontal')); ?>
                    <div class="box-body">
                        
                        <?php if (validation_errors()): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Validation Error!</h4>
                                <?php echo validation_errors(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_time" class="col-sm-3 control-label">Date & Time <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" class="form-control" id="date_time" name="date_time" 
                                               value="<?php echo set_value('date_time', date('Y-m-d\TH:i', strtotime($call->date_time))); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category" class="col-sm-3 control-label">Category <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <?php if (!empty($categories) && is_array($categories)): ?>
                                                <?php foreach ($categories as $key => $value): ?>
                                                    <option value="<?php echo $key; ?>" <?php echo set_select('category', $key, (!empty($call->category) && $call->category == $key)); ?>>
                                                        <?php echo $value; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="">No categories available</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">Name <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo set_value('name', $call->name); ?>" maxlength="100" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="mobile_no" class="col-sm-3 control-label">Mobile No <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="tel" class="form-control" id="mobile_no" name="mobile_no" 
                                               value="<?php echo set_value('mobile_no', $call->mobile_no); ?>" 
                                               pattern="[6-9]{1}[0-9]{9}" maxlength="10" required>
                                        <small class="text-muted">Enter 10-digit mobile number starting with 6, 7, 8, or 9</small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">Address <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="address" name="address" rows="3" 
                                                  maxlength="255" required><?php echo set_value('address', $call->address); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subject" class="col-sm-3 control-label">Subject <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="subject" name="subject" 
                                               value="<?php echo set_value('subject', $call->subject); ?>" maxlength="200" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Description <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="description" name="description" rows="4" 
                                                  required><?php echo set_value('description', $call->description); ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="remark" class="col-sm-3 control-label">Remark</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="remark" name="remark" rows="3" 
                                                  maxlength="255"><?php echo set_value('remark', $call->remark); ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="assign_datetime" class="col-sm-3 control-label">Assign Date & Time <span class="text-red">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" class="form-control" id="assign_datetime" name="assign_datetime" 
                                               value="<?php echo set_value('assign_datetime', !empty($call->assign_datetime) ? date('Y-m-d\TH:i', strtotime($call->assign_datetime)) : ''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-save"></i> Update Call Record
                                </button>
                                <a href="<?php echo site_url('callmanagement'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                                <a href="<?php echo site_url('callmanagement/view/' . $call->id); ?>" class="btn btn-info">
                                    <i class="fa fa-eye"></i> View Details
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

<?php $this->load->view('includes/footer'); ?>