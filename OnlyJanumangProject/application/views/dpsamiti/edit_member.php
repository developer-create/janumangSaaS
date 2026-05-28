<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> DP Samiti
            <small>Edit Member</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Location: <?php echo $groupInfo->block_name; ?> - <?php echo $groupInfo->booth_name_text; ?></h3>
                    </div>
                    
                    <form role="form" action="<?php echo base_url() ?>dpsamiti/updateMember" method="post">
                        <input type="hidden" name="id" value="<?php echo $memberInfo->id; ?>" />
                        <input type="hidden" name="group_id" value="<?php echo $memberInfo->group_id; ?>" />
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="member_name">सदस्य का नाम <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="member_name" name="member_name" placeholder="सदस्य का नाम" value="<?php echo $memberInfo->member_name; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="father_name">पिता/पति का नाम</label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" placeholder="पिता/पति का नाम" value="<?php echo $memberInfo->father_name; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">उम्र</label>
                                        <input type="text" class="form-control" id="age" name="age" placeholder="उम्र" value="<?php echo $memberInfo->age; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="position">पद</label>
                                        <input type="text" class="form-control" id="position" name="position" placeholder="पद" value="<?php echo $memberInfo->position; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_number">मोबाइल नंबर</label>
                                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="मोबाइल नंबर" value="<?php echo $memberInfo->mobile_number; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark">टिप्पणी</label>
                                        <textarea class="form-control" id="remark" name="remark" placeholder="टिप्पणी" rows="3"><?php echo $memberInfo->remark; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <a href="<?php echo base_url().'dpsamiti/members/'.$memberInfo->group_id; ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
