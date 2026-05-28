<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-eye"></i> भगोरिया समिति विवरण</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-title">विवरण</h3></div>
                    <div class="box-body">
                        <?php if(!empty($record)) { ?>
                        <table class="table table-bordered">
                            <tr><th width="35%">क्र. (Serial No)</th><td><?php echo $record['serial_no']; ?></td></tr>
                            <tr><th>ब्लॉक (Block)</th>
                                <td>
                                    <?php
                                    if(!empty($record['block'])) {
                                        $blockQuery = $this->db->get_where('block', array('id' => $record['block']));
                                        $blockData = $blockQuery->row();
                                        echo $blockData ? $blockData->name : '-';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr><th>दिनांक (Date)</th><td><?php echo $record['date']; ?></td></tr>
                            <tr><th>वार (Day)</th><td><?php echo $record['var']; ?></td></tr>
                            <tr><th>भगोरिया हाट (Bhagoria Hat)</th><td><?php echo $record['bhagoria_hat']; ?></td></tr>
                            <tr><th>डोल की संख्या (Number of Dol)</th><td><?php echo $record['dol_ki_sankhya']; ?></td></tr>
                            <tr><th>प्रभारी का नाम (In-charge Name)</th><td><?php echo $record['prabhari_ka_naam']; ?></td></tr>
                            <tr><th>मोबाइल नम्बर (Mobile Number)</th><td><?php echo $record['mobile_number']; ?></td></tr>
                            <tr><th>रिमार्क (Remark)</th><td><?php echo nl2br($record['remark']); ?></td></tr>
                            <tr><th>Added By (जोड़ा गया)</th>
                                <td>
                                    <?php
                                    if(!empty($record['created_by'])) {
                                        $userQuery = $this->db->get_where('tbl_users', array('userId' => $record['created_by']));
                                        $userData = $userQuery->row();
                                        echo $userData ? $userData->name : '-';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr><th>Created At (बनाया गया)</th><td><?php echo $record['created_at']; ?></td></tr>
                            <?php if(!empty($record['updated_at'])): ?>
                            <tr><th>Updated At (अपडेट किया गया)</th><td><?php echo $record['updated_at']; ?></td></tr>
                            <?php endif; ?>
                        </table>
                        <?php } else { echo '<p>No record found.</p>'; } ?>
                    </div>
                    <div class="box-footer">
                        <a href="<?php echo base_url('bhagoriasamiti'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                        <a href="<?php echo base_url('bhagoriasamiti/edit/'.$record['id']); ?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
