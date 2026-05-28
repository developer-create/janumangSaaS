<?php $this->load->view('includes/header'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Call Details
            <small>View complete call information</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('CallManagement'); ?>">Call Management</a></li>
            <li class="active">View Call</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Date & Time:</th>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($call->date_time)); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>
                                            <?php 
                                            $category_classes = array(
                                                'Emergency' => 'danger',
                                                'Complaint' => 'warning',
                                                'Inquiry' => 'info',
                                                'Suggestion' => 'success',
                                                'Information' => 'primary',
                                                'Service Request' => 'default',
                                                'Follow Up' => 'info',
                                                'Other' => 'default'
                                            );
                                            $class = isset($category_classes[$call->category]) ? $category_classes[$call->category] : 'default';
                                            ?>
                                            <span class="label label-<?php echo $class; ?>">
                                                <?php echo $call->category; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo $call->name; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile No:</th>
                                        <td>
                                            <a href="tel:<?php echo $call->mobile_no; ?>">
                                                <i class="fa fa-phone"></i> <?php echo $call->mobile_no; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td><?php echo nl2br($call->address); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Assign Date & Time:</th>
                                        <td>
                                            <?php if (!empty($call->assign_datetime)): ?>
                                                <?php 
                                                $assign_datetime = date('d-m-Y H:i', strtotime($call->assign_datetime)); 
                                                $is_overdue = strtotime($call->assign_datetime) < strtotime(date('Y-m-d H:i:s'));
                                                ?>
                                                <span class="label label-<?php echo $is_overdue ? 'danger' : 'success'; ?>">
                                                    <?php echo $assign_datetime; ?>
                                                    <?php if ($is_overdue): ?>
                                                        <i class="fa fa-exclamation-triangle"></i> Overdue
                                                    <?php endif; ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="label label-default">
                                                    <i class="fa fa-clock-o"></i> Not Assigned
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Subject:</th>
                                        <td><?php echo $call->subject; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td><?php echo nl2br($call->description); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Remark:</th>
                                        <td><?php echo !empty($call->remark) ? nl2br($call->remark) : '<em class="text-muted">No remarks</em>'; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created On:</th>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($call->created_at)); ?></td>
                                    </tr>
                                    <?php if (!empty($call->updated_at)): ?>
                                    <tr>
                                        <th>Last Updated:</th>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($call->updated_at)); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-info" onclick="window.print();">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                                <a href="<?php echo site_url('callmanagement'); ?>" class="btn btn-default">
                                    <i class="fa fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
@media print {
    .content-wrapper {
        margin: 0 !important;
    }
    .box-tools, .box-footer, .breadcrumb, .content-header {
        display: none !important;
    }
    .box {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>



<?php $this->load->view('includes/footer'); ?>