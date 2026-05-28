<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-edit"></i> Edit Member (भगोरिया समिति)</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">समिति: <?php echo htmlspecialchars($record['bhagoria_hat']); ?> - <?php echo $record['date']; ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3"><strong>ब्लॉक:</strong> <?php
                                if (!empty($record['block'])) {
                                    $b = $this->db->get_where('block', array('id' => $record['block']))->row();
                                    echo $b ? $b->name : '-';
                                } else echo '-';
                            ?></div>
                            <div class="col-md-3"><strong>भगोरिया हाट:</strong> <?php echo htmlspecialchars($record['bhagoria_hat']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border"><h3 class="box-title">सदस्य विवरण (Member Details)</h3></div>
                    <form action="<?php echo site_url('bhagoriasamiti/update_member/'.$member['id']); ?>" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_name">सदस्य का नाम (Member Name) <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="member_name" name="member_name" value="<?php echo htmlspecialchars($member['member_name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">पिता का नाम (Father Name) <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo htmlspecialchars($member['father_name']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">उम्र (Age)</label>
                                        <input type="number" class="form-control" id="age" name="age" value="<?php echo $member['age']; ?>" min="0" max="150">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="position">पद (Position)</label>
                                        <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($member['position']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_number">मोबाइल नम्बर (Mobile)</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($member['mobile_number']); ?>" pattern="[0-9]{10}" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">रिमार्क (Remark)</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3"><?php echo htmlspecialchars($member['remark']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update Member</button>
                            <a href="<?php echo site_url('bhagoriasamiti/members/'.$member['samiti_id']); ?>" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
