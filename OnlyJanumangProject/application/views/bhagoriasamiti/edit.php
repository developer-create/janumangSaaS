<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit भगोरिया कार्यक्रम समिति Details</h3>
                    </div>
                    <form action="<?php echo site_url('bhagoriasamiti/update/'.$record['id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="serial_no">क्र. (Serial No):</label>
                                        <input type="text" class="form-control required" id="serial_no" name="serial_no" value="<?php echo $record['serial_no']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block">ब्लॉक (Block):</label>
                                        <select class="form-control required" id="block" name="block" required>
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>" <?php echo ($record['block'] == $block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">दिनांक (Date):</label>
                                        <input type="date" class="form-control required" id="date" name="date" value="<?php echo $record['date']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="var">वार (Day):</label>
                                        <select class="form-control required" id="var" name="var">
                                            <option value="">Select Day</option>
                                            <option value="रविवार" <?php echo ($record['var'] == 'रविवार') ? 'selected' : ''; ?>>रविवार (Sunday)</option>
                                            <option value="सोमवार" <?php echo ($record['var'] == 'सोमवार') ? 'selected' : ''; ?>>सोमवार (Monday)</option>
                                            <option value="मंगलवार" <?php echo ($record['var'] == 'मंगलवार') ? 'selected' : ''; ?>>मंगलवार (Tuesday)</option>
                                            <option value="बुधवार" <?php echo ($record['var'] == 'बुधवार') ? 'selected' : ''; ?>>बुधवार (Wednesday)</option>
                                            <option value="गुरुवार" <?php echo ($record['var'] == 'गुरुवार') ? 'selected' : ''; ?>>गुरुवार (Thursday)</option>
                                            <option value="शुक्रवार" <?php echo ($record['var'] == 'शुक्रवार') ? 'selected' : ''; ?>>शुक्रवार (Friday)</option>
                                            <option value="शनिवार" <?php echo ($record['var'] == 'शनिवार') ? 'selected' : ''; ?>>शनिवार (Saturday)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bhagoria_hat">भगोरिया हाट (Bhagoria Hat):</label>
                                        <input type="text" class="form-control required" id="bhagoria_hat" name="bhagoria_hat" value="<?php echo $record['bhagoria_hat']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dol_ki_sankhya">डोल की संख्या (Number of Dol):</label>
                                        <input type="text" class="form-control required" id="dol_ki_sankhya" name="dol_ki_sankhya" value="<?php echo $record['dol_ki_sankhya']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prabhari_ka_naam">प्रभारी का नाम (In-charge Name):</label>
                                        <input type="text" class="form-control required" id="prabhari_ka_naam" name="prabhari_ka_naam" value="<?php echo $record['prabhari_ka_naam']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_number">मोबाइल नम्बर (Mobile Number):</label>
                                        <input type="text" class="form-control required" id="mobile_number" name="mobile_number" value="<?php echo $record['mobile_number']; ?>" pattern="[0-9]{10}" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="remark">रिमार्क (Remark):</label>
                                        <textarea class="form-control" id="remark" name="remark" rows="3"><?php echo $record['remark']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="file_upload">फाइल अपलोड (File Upload)</label>
                                        <?php if (!empty($record['file_upload'])): ?>
                                        <p class="text-muted">Current file: <a href="<?php echo base_url('uploads/samiti_files/'.$record['file_upload']); ?>" target="_blank"><?php echo htmlspecialchars($record['file_upload']); ?></a></p>
                                        <?php endif; ?>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <small class="text-muted">Leave empty to keep current file. PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                            <a href="<?php echo site_url('bhagoriasamiti'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <?php
                $this->load->helper('form');
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
