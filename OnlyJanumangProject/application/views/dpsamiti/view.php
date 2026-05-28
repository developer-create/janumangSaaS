<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> DP Samiti
            <small>View Location Details</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
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
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Location Information</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url().'dpsamiti/members/'.$groupInfo->id; ?>" class="btn btn-sm btn-info">
                                <i class="fa fa-users"></i> View Members
                            </a>
                            <a href="<?php echo base_url().'dpsamiti/edit/'.$groupInfo->id; ?>" class="btn btn-sm btn-primary">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <a href="<?php echo base_url().'dpsamiti'; ?>" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th style="width: 200px;">क्र.</th>
                                            <td><?php echo $groupInfo->serial_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th>ब्लॉक</th>
                                            <td><?php echo $groupInfo->block_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>सेक्टर</th>
                                            <td><?php echo $groupInfo->sector; ?></td>
                                        </tr>
                                        <tr>
                                            <th>माइक्रो सेक्टर न.</th>
                                            <td><?php echo $groupInfo->micro_sector_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th>माइक्रो सेक्टर नाम</th>
                                            <td><?php echo $groupInfo->micro_sector_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>बूथ का नाम</th>
                                            <td><?php echo $groupInfo->booth_name_text; ?></td>
                                        </tr>
                                        <tr>
                                            <th>बूठ न.</th>
                                            <td><?php echo $groupInfo->booth_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th>ग्राम पंचायत</th>
                                            <td><?php echo $groupInfo->gram_panchayat; ?></td>
                                        </tr>
                                        <tr>
                                            <th>गांव का नाम</th>
                                            <td><?php echo $groupInfo->village; ?></td>
                                        </tr>
                                        <tr>
                                            <th>फलिया</th>
                                            <td><?php echo $groupInfo->faliya; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Members</th>
                                            <td>
                                                <span class="badge bg-blue"><?php echo $groupInfo->total_members; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created Date</th>
                                            <td><?php echo date('d-m-Y H:i:s', strtotime($groupInfo->created_at)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Updated Date</th>
                                            <td><?php echo date('d-m-Y H:i:s', strtotime($groupInfo->updated_at)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
