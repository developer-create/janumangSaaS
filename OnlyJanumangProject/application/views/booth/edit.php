    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-8">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Booth</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo site_url('booth/update/'.$booth['id']); ?>" method="post">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $booth['name']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Number:</label>
                                        <input type="text" class="form-control required" id="bnumber" name="bnumber" value="<?php echo $booth['bnumber']; ?>">
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Block:</label>
                                        <select class="form-control select2 required" id="blockid" name="blockid" >
                                            <option value="0">Select Block</option>
                                                <?php
                                                 $userid = $this->session->userdata('userId');
                                                 $sessionBlockId = $this->session->userdata('blockId');
                                                //  $this->db->where('id !=', 6);
                                                 if ($sessionBlockId != 0) {
                                                     $userBlockIds = $this->db->select('blockId')
                                                        ->from('tbl_users')
                                                        ->where('userId', $userid)
                                                        ->get()
                                                        ->row()
                                                        ->blockId;
                                                        
                                                        $blockIdsArray = explode(',', $userBlockIds);
                                                        $this->db->where_in('block.id', $blockIdsArray);
                                                }
                                                $blocks = $this->db->get('block')->result();
                                                foreach ($blocks as $blk) {
                                                    // Check if the block ID is selected
                                                    $selected = ($booth['blockid'] == $blk->id) ? 'selected' : '';
                                                    
                                                    // Output the option element
                                                    echo "<option value='{$blk->id}' {$selected}>{$blk->name}</option>";
                                                    }
                                                ?>  
                    
                    
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
                                                <option value="<?php echo $y; ?>" <?php echo (isset($booth['year']) && $booth['year'] == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
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