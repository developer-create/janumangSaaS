<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Member: <?php echo $member['member_name']; ?></h3>
                    </div>
                    <form action="<?php echo site_url('kabbadisamiti/update_member/'.$member['id']); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_name">नाम (Name):<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="member_name" name="member_name" value="<?php echo $member['member_name']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">पिता का नाम (Father's Name):</label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo $member['father_name']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">उम्र (Age):</label>
                                        <input type="number" class="form-control" id="age" name="age" value="<?php echo $member['age']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="position">पद (Position):</label>
                                        <input type="text" class="form-control" id="position" name="position" value="<?php echo $member['position']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_number">मोबाइल नंबर (Mobile):</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $member['mobile_number']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">टिप्पणी (Remark):</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3"><?php echo $member['remark']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                            <a href="<?php echo site_url('kabbadisamiti/members/'.$group['id']); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
