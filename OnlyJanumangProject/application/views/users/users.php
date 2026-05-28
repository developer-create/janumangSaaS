<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> User Management
            <small>Add, Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNew"><i class="fa fa-plus"></i> Add
                        New</a>
                </div>
            </div>
        </div>
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
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Users List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>"
                                        class="form-control input-sm pull-right" style="width: 150px;"
                                        placeholder="Search" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr style="color:white;font-size:15px;background-color:#020254;">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <th>Created On</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                            if($record->userId!='1'){
                    ?>
                            <tr>
                                <td><?php echo $record->name ?></td>
                                <td><?php echo $record->email ?></td>
                                <td><?php echo $record->mobile ?></td>
                                <td><?php echo $record->role; if($record->roleStatus == INACTIVE) { echo ' <span class="label label-warning">Inactive</span>'; } ?>
                                </td>
                                <td><?php echo date("d-m-Y", strtotime($record->createdDtm)) ?></td>
                                <td class="text-center">

                                    <a class="btn btn-sm btn-primary"
                                        href="<?= base_url() . 'login-history/' . $record->userId; ?>"
                                        title="Login history"><i class="fa fa-history"></i></a> |

                                    <a class="btn btn-sm btn-success"
                                        href="<?= base_url().'Userwiseipuserlisting/'.$record->userId; ?>"
                                        title="User wise ip user listing"><i class="fa fa-eye"></i></a> |

                                    <?php 
                                    // Check if user has edit access: admin role (roleId == 1) OR has edit_records permission
                                    $hasEditAccess = false;
                                    $userRoleId = $this->session->userdata('role');
                                    if ($userRoleId == 1) {
                                        $hasEditAccess = true; // Admin role has all permissions
                                    } else if (isset($access_info['Users']) && is_array($access_info['Users'])) {
                                        if (isset($access_info['Users']['edit_records']) && $access_info['Users']['edit_records'] == 1) {
                                            $hasEditAccess = true;
                                        } else if (isset($access_info['Users']['total_access']) && $access_info['Users']['total_access'] == 1) {
                                            $hasEditAccess = true;
                                        }
                                    }
                                    if ($hasEditAccess) { ?>
                                    <a class="btn btn-sm btn-info"
                                        href="<?php echo base_url().'editOld/'.$record->userId; ?>" title="Edit"><i
                                            class="fa fa-pencil"></i></a>
                                    <?php } ?>

                                    <?php if($record->servaystatus=='1'){ ?>
                                    <a class="btn btn-sm btn-info"
                                        href="<?php echo base_url().'userservayview/'.$record->userId; ?>"
                                        title="View Servey"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <?php }?>
                                    <?php if ($hasEditAccess) { ?>
                                    <a class="btn btn-sm btn-danger deleteUser" href="#"
                                        data-userid="<?php echo $record->userId; ?>" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                    <?php } ?>

                                </td>
                            </tr>
                            <?php
                            }
                        }
                    }
                    ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
        jQuery("#searchList").submit();
    });
});
</script>