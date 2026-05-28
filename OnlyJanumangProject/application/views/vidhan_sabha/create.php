<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Vidhan Sabha Details</h3>
                    </div>
                    <!-- form start -->
                    <form action="<?php echo site_url('vidhan_sabha/store'); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vidhan_sabha_name">Vidhan Sabha Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="vidhan_sabha_name" name="vidhan_sabha_name" value="<?php echo set_value('vidhan_sabha_name'); ?>" required>
                                        <?php echo form_error('vidhan_sabha_name', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="district_id">District:</label>
                                        <select class="form-control" id="district_id" name="district_id">
                                            <option value="">Select District</option>
                                            <?php if (!empty($districts)): foreach ($districts as $d): ?>
                                                <option value="<?php echo $d['id']; ?>" <?php echo set_select('district_id', $d['id']); ?>><?php echo htmlspecialchars($d['name']); ?></option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                        <?php echo form_error('district_id', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="year">Year: <span class="text-danger">*</span></label>
                                        <select class="form-control required" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <?php for($y = 2013; $y <= 2028; $y++): ?>
                                                <option value="<?php echo $y; ?>" <?php echo set_select('year', $y, ($y == date('Y'))); ?>><?php echo $y; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <?php echo form_error('year', '<div class="text-danger">', '</div>'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Submit" class="btn btn-primary">
                            <a href="<?php echo site_url('vidhan_sabha'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                $this->load->helper('form');
                $success = $this->session->flashdata('success');
                $error = $this->session->flashdata('error');
                if ($success) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                </div>
                <?php } ?>
                <?php if ($error) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
</div>
