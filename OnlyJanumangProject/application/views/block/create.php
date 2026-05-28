<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Block Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('block/store'); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Block Name:</label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('name'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district_id">District:</label>
                                        <select class="form-control required" id="district_id" name="district_id" required>
                                            <option value="">Select District</option>
                                            <?php foreach($districts as $district): ?>
                                                <option value="<?php echo $district['id']; ?>" <?php echo set_select('district_id', $district['id']); ?>>
                                                    <?php echo $district['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Year: <span class="text-danger">*</span></label>
                                        <select class="form-control required" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <?php for($y = 2013; $y <= 2028; $y++): ?>
                                                <option value="<?php echo $y; ?>" <?php echo set_select('year', $y, ($y == date('Y'))); ?>><?php echo $y; ?></option>
                                            <?php endfor; ?>
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
