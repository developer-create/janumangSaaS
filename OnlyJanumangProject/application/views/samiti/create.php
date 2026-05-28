<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Create New Samiti</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('samiti/store'); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo set_value('name'); ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block_id">Block:</label>
                                        <select name="block_id" id="block_id" class="form-control">
                                            <option value="">Select Block</option>
                                            <?php if (!empty($blocks)): ?>
                                                <?php foreach ($blocks as $block): ?>
                                                    <option value="<?php echo $block['id']; ?>" <?php echo set_select('block_id', $block['id']); ?>>
                                                        <?php echo $block['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Year:</label>
                                        <select name="year" id="year" class="form-control">
                                            <option value="">Select Year</option>
                                            <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                                <option value="<?php echo $y; ?>" <?php echo set_select('year', $y); ?>>
                                                    <?php echo $y; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Month:</label>
                                        <select name="month" id="month" class="form-control">
                                            <option value="">Select Month</option>
                                            <option value="1" <?php echo set_select('month', 1); ?>>January</option>
                                            <option value="2" <?php echo set_select('month', 2); ?>>February</option>
                                            <option value="3" <?php echo set_select('month', 3); ?>>March</option>
                                            <option value="4" <?php echo set_select('month', 4); ?>>April</option>
                                            <option value="5" <?php echo set_select('month', 5); ?>>May</option>
                                            <option value="6" <?php echo set_select('month', 6); ?>>June</option>
                                            <option value="7" <?php echo set_select('month', 7); ?>>July</option>
                                            <option value="8" <?php echo set_select('month', 8); ?>>August</option>
                                            <option value="9" <?php echo set_select('month', 9); ?>>September</option>
                                            <option value="10" <?php echo set_select('month', 10); ?>>October</option>
                                            <option value="11" <?php echo set_select('month', 11); ?>>November</option>
                                            <option value="12" <?php echo set_select('month', 12); ?>>December</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Submit" class="btn btn-primary">
                            <a href="<?php echo site_url('samiti'); ?>" class="btn btn-default">Cancel</a>
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
