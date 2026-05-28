<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" aria-hidden="true"></i> Edit Member
        </h1>
    </section>
    <section class="content">
        <!-- Location Info Card -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-map-marker"></i> Member Location</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>ब्लॉक (Block):</strong> <?php echo $group['block_name']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>बूथ (Booth):</strong> <?php echo $group['booth_name']; ?> - <?php echo $group['booth_no']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>गांव (Village):</strong> <?php echo $group['village']; ?>
                            </div>
                            <div class="col-md-3">
                                <strong>फलिया (Faliya):</strong> <?php echo $group['faliya']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Member Edit Form -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">सदस्य विवरण (Member Details)</h3>
                    </div>
                    <form role="form" action="<?php echo site_url('blocksamiti/update_member/'.$member['id']); ?>" method="post">
                        <div class="box-body">
                            <input type="hidden" name="group_id" value="<?php echo $member['group_id']; ?>">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_name">सदस्य का नाम (Member Name) <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="member_name" name="member_name" value="<?php echo $member['member_name']; ?>" placeholder="Enter Member Name" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">पिता का नाम (Father Name) <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo $member['father_name']; ?>" placeholder="Enter Father Name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">उम्र (Age)</label>
                                        <input type="number" class="form-control" id="age" name="age" value="<?php echo $member['age']; ?>" placeholder="Enter Age" min="0" max="150">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="position">पद (Position)</label>
                                        <input type="text" class="form-control" id="position" name="position" value="<?php echo $member['position']; ?>" placeholder="Enter Position">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_number">मोबाइल नम्बर (Mobile Number)</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo $member['mobile_number']; ?>" placeholder="Enter Mobile Number" pattern="[0-9]{10}" maxlength="10">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">रिमार्क (Remark)</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Enter Remark"><?php echo $member['remark']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save"></i> Update Member
                            </button>
                            <a href="<?php echo site_url('blocksamiti/members/'.$member['group_id']); ?>" class="btn btn-default">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
