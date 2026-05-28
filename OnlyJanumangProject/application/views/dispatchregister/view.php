<div class="content-wrapper">
    <section class="content-header">
        <h1><i class="fa fa-eye"></i> Dispatch Register Details</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-10">
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-title">विवरण</h3></div>
                    <div class="box-body">
                        <?php if(!empty($record)) { ?>
                        <table class="table table-bordered">
                            <tr><th width="30%">Year (वर्ष)</th><td><?php echo !empty($record['year']) ? $record['year'] : '-'; ?></td></tr>
                            <tr><th>Month (माह)</th><td><?php echo !empty($record['month']) ? $record['month'] : '-'; ?></td></tr>
                            <tr><th>Date (दिनांक)</th><td><?php echo !empty($record['date']) ? date('d-m-Y', strtotime($record['date'])) : '-'; ?></td></tr>
                            <tr><th>Portal No. (पोर्टल नं.)</th><td><?php echo !empty($record['portal_no']) ? $record['portal_no'] : '-'; ?></td></tr>
                            <tr><th>Samiti No. (समिति नं.)</th><td><?php echo !empty($record['samiti_no']) ? $record['samiti_no'] : '-'; ?></td></tr>
                            <tr><th>Dispatch No. (प्रेषण क्रमांक)</th><td><strong><?php echo !empty($record['dispatch_no']) ? $record['dispatch_no'] : '-'; ?></strong></td></tr>
                            <tr><th>Department (विभाग)</th><td><?php echo !empty($record['department_name']) ? $record['department_name'] : '-'; ?></td></tr>
                            <tr><th>Particular/Subject (विशेष/विषय)</th><td><?php echo !empty($record['particular_subject']) ? $record['particular_subject'] : '-'; ?></td></tr>
                            <tr><th>Reference (संदर्भ)</th><td><?php echo !empty($record['reference']) ? $record['reference'] : '-'; ?></td></tr>
                            <tr><th>District (जिला)</th><td><?php echo !empty($record['district_name']) ? $record['district_name'] : '-'; ?></td></tr>
                            <tr><th>Vidhan Sabha (विधान सभा)</th><td><?php echo !empty($record['vidhan_sabha_name']) ? $record['vidhan_sabha_name'] : '-'; ?></td></tr>
                            <tr><th>Block (ब्लॉक)</th><td><?php echo !empty($record['block_name']) ? $record['block_name'] : '-'; ?></td></tr>
                            <tr><th>Panchayat (पंचायत)</th><td><?php echo !empty($record['panchayat_name']) ? $record['panchayat_name'] : '-'; ?></td></tr>
                            <tr><th>Village (ग्राम)</th><td><?php echo !empty($record['village_name']) ? $record['village_name'] : '-'; ?></td></tr>
                            <tr><th>Upload Letter (पत्र अपलोड)</th>
                                <td>
                                    <?php if(!empty($record['upload_letter']) && file_exists($record['upload_letter'])): ?>
                                        <a href="<?php echo base_url($record['upload_letter']); ?>" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fa fa-eye"></i> View Letter
                                        </a>
                                        <a href="<?php echo base_url($record['upload_letter']); ?>" download class="btn btn-sm btn-success">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No file uploaded</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
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
                        <a href="<?php echo base_url('dispatchregister'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</a>
                        <a href="<?php echo base_url('dispatchregister/edit/'.$record['id']); ?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
