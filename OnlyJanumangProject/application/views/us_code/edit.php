<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" aria-hidden="true"></i> Edit US Code
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">US Code Details</h3>
                    </div>

                    <form role="form" method="post" action="<?php echo site_url('us_code/update/'.$code['id']); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code">Code <span style="color:red;">*</span></label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" value="<?php echo htmlspecialchars($code['code']); ?>" required>
                                <?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Description"><?php echo htmlspecialchars($code['description']); ?></textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update
                            </button>
                            <a href="<?php echo site_url('us_code'); ?>" class="btn btn-default">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
