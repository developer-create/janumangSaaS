<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-eye"></i> Activity Log Details
            <small>View detailed information about this activity</small>
        </h1>
    </section>
    
    <section class="content">
        <?php
        $this->load->helper("form");
        $error = $this->session->flashdata("error");
        if ($error) {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata("error"); ?>
        </div>
        <?php } ?>
        
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Activity Information</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url('activitylog'); ?>" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php if (empty($log)): ?>
                        <div class="alert alert-warning">
                            <p>Activity log not found.</p>
                        </div>
                        <?php else: ?>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 200px;">Date & Time</th>
                                <td><?php echo isset($log['created_at']) ? date('d/m/Y H:i:s', strtotime($log['created_at'])) : '-'; ?></td>
                            </tr>
                            <tr>
                                <th>User</th>
                                <td>
                                    <strong><?php echo isset($log['user_name']) ? htmlspecialchars($log['user_name']) : '-'; ?></strong>
                                    <?php if (isset($log['user_id'])): ?>
                                    <small class="text-muted">(ID: <?php echo $log['user_id']; ?>)</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td>
                                    <?php if (isset($log['action'])): ?>
                                    <span class="label label-<?php 
                                        echo $log['action'] == 'add' ? 'success' : 
                                            ($log['action'] == 'edit' ? 'warning' : 
                                            ($log['action'] == 'delete' ? 'danger' : 
                                            ($log['action'] == 'download' ? 'info' : 
                                            ($log['action'] == 'login' ? 'primary' : 
                                            ($log['action'] == 'logout' ? 'default' : 'default'))))); 
                                    ?>">
                                        <?php echo strtoupper($log['action']); ?>
                                    </span>
                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Module</th>
                                <td><?php echo isset($log['module']) ? htmlspecialchars($log['module']) : '-'; ?></td>
                            </tr>
                            <tr>
                                <th>Table Name</th>
                                <td><?php echo isset($log['table_name']) && $log['table_name'] ? htmlspecialchars($log['table_name']) : '-'; ?></td>
                            </tr>
                            <tr>
                                <th>Record ID</th>
                                <td><?php echo isset($log['record_id']) && $log['record_id'] ? $log['record_id'] : '-'; ?></td>
                            </tr>
                            <tr>
                                <th>IP Address</th>
                                <td><?php echo isset($log['ip_address']) ? htmlspecialchars($log['ip_address']) : '-'; ?></td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td>
                                    <small><?php echo isset($log['user_agent']) ? htmlspecialchars($log['user_agent']) : '-'; ?></small>
                                </td>
                            </tr>
                            <?php if (!empty($log['details'])): ?>
                            <tr>
                                <th>Details</th>
                                <td><?php echo nl2br(htmlspecialchars($log['details'])); ?></td>
                            </tr>
                            <?php endif; ?>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($log) && (!empty($log['record_data_decoded']) || !empty($log['old_data_decoded']))): ?>
        <div class="row">
            <?php if (!empty($log['record_data_decoded'])): ?>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <?php echo isset($log['action']) && $log['action'] == 'edit' ? 'New Data' : 'Record Data'; ?>
                        </h3>
                    </div>
                    <div class="box-body">
                        <pre style="max-height: 500px; overflow-y: auto; background-color: #f9f9f9; padding: 15px; border-radius: 4px;"><?php echo htmlspecialchars(json_encode($log['record_data_decoded'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($log['old_data_decoded'])): ?>
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Old Data</h3>
                    </div>
                    <div class="box-body">
                        <pre style="max-height: 500px; overflow-y: auto; background-color: #f9f9f9; padding: 15px; border-radius: 4px;"><?php echo htmlspecialchars(json_encode($log['old_data_decoded'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </section>
</div>
