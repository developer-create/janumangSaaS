<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-plus" aria-hidden="true"></i> Add New Inward Register
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Inward Register Form</h3>
                </div>
                <div class="box-body">
                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>
                    
                    <?php echo form_open('inwardregister/store'); ?>
                    
                    <div class="row">
                        <!-- Column 1 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="issue_no">Issue No / वार्षिक पंजी क्रमांक <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="issue_no" name="issue_no" placeholder="Enter issue number" 
                                    value="<?php echo set_value('issue_no'); ?>" required>
                                <?php echo form_error('issue_no', '<p class="text-danger">', '</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="issue_date">Issue Date / दिनांक <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="issue_date" name="issue_date" 
                                    value="<?php echo set_value('issue_date'); ?>" required>
                                <?php echo form_error('issue_date', '<p class="text-danger">', '</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="letter_name">पत्र का नाम / Letter Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="letter_name" name="letter_name" placeholder="Enter letter name" 
                                    value="<?php echo set_value('letter_name'); ?>" required>
                                <?php echo form_error('letter_name', '<p class="text-danger">', '</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="letter_received_date">आयी का दिनांक / Letter Received Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="letter_received_date" name="letter_received_date" 
                                    value="<?php echo set_value('letter_received_date'); ?>" required>
                                <?php echo form_error('letter_received_date', '<p class="text-danger">', '</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="from_whom_received">From whom Received / पत्र किसने और से आया <span style="color: red;">*</span></label>
                                <textarea class="form-control" id="from_whom_received" name="from_whom_received" rows="3" placeholder="Enter sender details" required><?php echo set_value('from_whom_received'); ?></textarea>
                                <?php echo form_error('from_whom_received', '<p class="text-danger">', '</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="received_letter_description">आए हुए पत्र का विवरण / Letter Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" id="received_letter_description" name="received_letter_description" rows="3" placeholder="Enter letter description" required><?php echo set_value('received_letter_description'); ?></textarea>
                                <?php echo form_error('received_letter_description', '<p class="text-danger">', '</p>'); ?>
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="received_letter_number">क्रमांक / Received Letter Number</label>
                                <input type="text" class="form-control" id="received_letter_number" name="received_letter_number" placeholder="Enter received letter number" 
                                    value="<?php echo set_value('received_letter_number'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="received_letter_date">दिनांक / Received Letter Date</label>
                                <input type="date" class="form-control" id="received_letter_date" name="received_letter_date" 
                                    value="<?php echo set_value('received_letter_date'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="received_letter_attachment">संलग्न / Attachment</label>
                                <input type="text" class="form-control" id="received_letter_attachment" name="received_letter_attachment" placeholder="Enter attachment details" 
                                    value="<?php echo set_value('received_letter_attachment'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="reply_to_number">उत्तर क्रमांक / Reply To Number</label>
                                <input type="text" class="form-control" id="reply_to_number" name="reply_to_number" placeholder="Enter reply number" 
                                    value="<?php echo set_value('reply_to_number'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="reply_to_date">दिनांक / Reply To Date</label>
                                <input type="date" class="form-control" id="reply_to_date" name="reply_to_date" 
                                    value="<?php echo set_value('reply_to_date'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="our_reply_number">उत्तर क्रमांक / Our Reply Number</label>
                                <input type="text" class="form-control" id="our_reply_number" name="our_reply_number" placeholder="Enter our reply number" 
                                    value="<?php echo set_value('our_reply_number'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="our_reply_date">दिनांक / Our Reply Date</label>
                                <input type="date" class="form-control" id="our_reply_date" name="our_reply_date" 
                                    value="<?php echo set_value('our_reply_date'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="forwarded_letter_number">क्रमांक / Forwarded Letter Number</label>
                                <input type="text" class="form-control" id="forwarded_letter_number" name="forwarded_letter_number" placeholder="Enter forwarded letter number" 
                                    value="<?php echo set_value('forwarded_letter_number'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="forwarded_letter_date">दिनांक / Forwarded Letter Date</label>
                                <input type="date" class="form-control" id="forwarded_letter_date" name="forwarded_letter_date" 
                                    value="<?php echo set_value('forwarded_letter_date'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject">Subject / पत्र का विषय <span style="color: red;">*</span></label>
                                <textarea class="form-control" id="subject" name="subject" rows="3" placeholder="Enter subject" required><?php echo set_value('subject'); ?></textarea>
                                <?php echo form_error('subject', '<p class="text-danger">', '</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="file_number">File No / फाइल क्रमांक</label>
                                <input type="text" class="form-control" id="file_number" name="file_number" placeholder="Enter file number" 
                                    value="<?php echo set_value('file_number'); ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="section">Section / शाखा नया विभाग</label>
                                <input type="text" class="form-control" id="section" name="section" placeholder="Enter section" 
                                    value="<?php echo set_value('section'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="signed_date">Signed Date / हस्तां. दितांक</label>
                                <input type="date" class="form-control" id="signed_date" name="signed_date" 
                                    value="<?php echo set_value('signed_date'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="sent_to">Sent To / जिसको पत्र भेजा गया</label>
                                <input type="text" class="form-control" id="sent_to" name="sent_to" placeholder="Enter recipient name/department" 
                                    value="<?php echo set_value('sent_to'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="remarks">Remarks / टिप्पणी</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter remarks"><?php echo set_value('remarks'); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        <a href="<?php echo site_url('inwardregister'); ?>" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                    </div>

                    <?php echo form_close(); ?>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>
