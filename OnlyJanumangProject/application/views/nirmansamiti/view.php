<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-eye"></i> निर्माण समिति विवरण</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-title">विवरण</h3></div>
                    <div class="box-body">
                        <?php if(!empty($record)) { ?>
                        <table class="table table-bordered">
                            <tr><th width="30%">क्र. (Serial No)</th><td><?php echo $record['serial_no']; ?></td></tr>
                            <tr><th>ब्लॉक (Block)</th><td><?php echo $record['block_name'] ? $record['block_name'] : '-'; ?></td></tr>
                            <tr><th>सेक्टर (Sector)</th><td><?php echo $record['sector'] ? $record['sector'] : '-'; ?></td></tr>
                            <tr><th>माइक्रो सेक्टर न (Micro Sector No)</th><td><?php echo $record['micro_sector_no']; ?></td></tr>
                            <tr><th>माइक्रो सेक्टर नाम (Micro Sector Name)</th><td><?php echo $record['micro_sector_name']; ?></td></tr>
                            <tr><th>बूथ क (Booth No)</th><td><?php echo $record['booth_no']; ?></td></tr>
                            <tr><th>बूथ का नाम (Booth Name)</th>
                                <td>
                                    <?php
                                    if(!empty($record['booth_name'])) {
                                        $boothQuery = $this->db->get_where('booth', array('id' => $record['booth_name']));
                                        $boothData = $boothQuery->row();
                                        echo $boothData ? $boothData->name : '-';
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr><th>ग्राम पंचायत (Gram Panchayat)</th><td><?php echo $record['gram_panchayat']; ?></td></tr>
                            <tr><th>गांव (Village)</th><td><?php echo $record['village']; ?></td></tr>
                            <tr><th>फलिया (Faliya)</th><td><?php echo $record['faliya']; ?></td></tr>
                            <tr><th>सदस्य का नाम (Member Name)</th><td><?php echo $record['member_name']; ?></td></tr>
                            <tr><th>पिता का नाम (Father Name)</th><td><?php echo $record['father_name']; ?></td></tr>
                            <tr><th>उम्र (Age)</th><td><?php echo $record['age']; ?></td></tr>
                            <tr><th>पद (Position)</th><td><?php echo $record['position']; ?></td></tr>
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
                        <a href="<?php echo base_url('nirmansamiti'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                        <a href="<?php echo base_url('nirmansamiti/edit/'.$record['id']); ?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
