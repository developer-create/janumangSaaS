    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Samiti</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo site_url('samiti/update/'.$samiti['id']); ?>" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control required" id="name" name="name" value="<?php echo $samiti['name']; ?>" required>
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
                                                        <option value="<?php echo $block['id']; ?>" <?php echo (isset($samiti['block_id']) && $samiti['block_id'] == $block['id']) ? 'selected' : ''; ?>>
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
                                                    <option value="<?php echo $y; ?>" <?php echo (isset($samiti['year']) && $samiti['year'] == $y) ? 'selected' : ''; ?>>
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
                                                <option value="1" <?php echo (isset($samiti['month']) && $samiti['month'] == 1) ? 'selected' : ''; ?>>January</option>
                                                <option value="2" <?php echo (isset($samiti['month']) && $samiti['month'] == 2) ? 'selected' : ''; ?>>February</option>
                                                <option value="3" <?php echo (isset($samiti['month']) && $samiti['month'] == 3) ? 'selected' : ''; ?>>March</option>
                                                <option value="4" <?php echo (isset($samiti['month']) && $samiti['month'] == 4) ? 'selected' : ''; ?>>April</option>
                                                <option value="5" <?php echo (isset($samiti['month']) && $samiti['month'] == 5) ? 'selected' : ''; ?>>May</option>
                                                <option value="6" <?php echo (isset($samiti['month']) && $samiti['month'] == 6) ? 'selected' : ''; ?>>June</option>
                                                <option value="7" <?php echo (isset($samiti['month']) && $samiti['month'] == 7) ? 'selected' : ''; ?>>July</option>
                                                <option value="8" <?php echo (isset($samiti['month']) && $samiti['month'] == 8) ? 'selected' : ''; ?>>August</option>
                                                <option value="9" <?php echo (isset($samiti['month']) && $samiti['month'] == 9) ? 'selected' : ''; ?>>September</option>
                                                <option value="10" <?php echo (isset($samiti['month']) && $samiti['month'] == 10) ? 'selected' : ''; ?>>October</option>
                                                <option value="11" <?php echo (isset($samiti['month']) && $samiti['month'] == 11) ? 'selected' : ''; ?>>November</option>
                                                <option value="12" <?php echo (isset($samiti['month']) && $samiti['month'] == 12) ? 'selected' : ''; ?>>December</option>
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