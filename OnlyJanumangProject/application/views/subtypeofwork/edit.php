<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Subtype Of Work</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form action="<?php echo site_url('subtypeofwork/update/'.$subtype_of_work['id']); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="work_type_id">Type Of Work: <span class="text-danger">*</span></label>
                                        <select class="form-control required" id="work_type_id" name="work_type_id" required>
                                            <option value="">Select Type Of Work</option>
                                            <?php foreach ($worktypes as $worktype): ?>
                                                <option value="<?php echo $worktype['id']; ?>" 
                                                    <?php echo ($subtype_of_work['work_type_id'] == $worktype['id']) ? 'selected' : ''; ?>>
                                                    <?php echo $worktype['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Sub Type Of Work: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $subtype_of_work['name']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                            <a href="<?php echo site_url('subtypeofwork'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
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
                <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
        </div>
    </section>
</div>

