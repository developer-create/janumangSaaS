<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> User Management
            <small>Add / Edit User</small>
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->



                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter User Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addUser" action="<?php echo base_url() ?>addNewUser" method="post"
                        role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Full Name</label>
                                        <input type="text" class="form-control required"
                                            value="<?php echo set_value('fname'); ?>" id="fname" name="fname"
                                            maxlength="128">
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="text" class="form-control required email" id="email"
                                            value="<?php echo set_value('email'); ?>" name="email" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control required" id="password"
                                            name="password" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" class="form-control required equalTo" id="cpassword"
                                            name="cpassword" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" class="form-control required digits" id="mobile"
                                            value="<?php echo set_value('mobile'); ?>" name="mobile" maxlength="10" pattern="[0-9]{10}" placeholder="10 digits only">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control required" id="role" name="role">
                                            <option value="0">Select Role</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    $roleText = $rl->role;
                                                    $roleClass = false;
                                                    if ($rl->roleStatus == INACTIVE) {
                                                        $roleText = $rl->role . ' (Inactive)';
                                                        $roleClass = true;
                                                    }
                                                    ?>
                                            <option value="<?php echo $rl->roleId ?>"
                                                <?php if ($roleClass) { echo "class=text-warning"; } if($rl->roleId == set_value('role')) {echo "selected=selected";} ?>>
                                                <?= $roleText ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="isAdmin">User Type</label>
                                        <select class="form-control required" id="isAdmin" name="isAdmin">
                                            <option value="<?= REGULAR_USER ?>">Regular User</option>
                                            <option value="<?= SYSTEM_ADMIN ?>">System Administrator</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="block">Select Block <span style="color:red">*</span></label>
                                        <select class="form-control select2" id="block" name="block[]"
                                            multiple="multiple" style="width: 100%;">
                                            <option value="" disabled selected>Select Block</option>
                                            <?php
                                            $userid = $this->session->userdata('userId');
                                            $sessionBlockId = $this->session->userdata('blockId');
                                            if ($sessionBlockId != 0) {
                                                $userBlockIds = $this->db->select('blockId')
                                                    ->from('tbl_users')
                                                    ->where('userId', $userid)
                                                    ->get()
                                                    ->row()
                                                    ->blockId;
                                                $blockIdsArray = explode(',', $userBlockIds);
                                                $this->db->where_in('block.id', $blockIdsArray);
                                            }
                                            $blocks = $this->db->get('block')->result();
                                            foreach ($blocks as $blk) {
                                                echo "<option value='{$blk->id}'>{$blk->name}</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
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
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function() {
    // Initialize Select2 on the block dropdown
    $('#block').select2({
        placeholder: "Select Block",
        allowClear: true // Allows clearing selected values
    });
});
</script>