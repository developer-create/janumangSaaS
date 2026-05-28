<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-chart-line"></i> User Activity Report
            <small>Date wise user activity and time spent analysis</small>
        </h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
        
        <!-- Filter Form -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-filter"></i> Report Filters</h3>
                    </div>
                    <form id="reportForm" method="post" action="<?php echo base_url('activitylog/report'); ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User:</label>
                                        <select class="form-control select2" name="selectedUser" id="selectedUser" style="width: 100%;">
                                            <option value="">All Users</option>
                                            <?php
                                            if (!empty($users)) {
                                                foreach ($users as $user) {
                                                    $selected = (isset($filters['selectedUser']) && $filters['selectedUser'] == $user->userId) ? 'selected' : '';
                                                    echo '<option value="' . $user->userId . '" ' . $selected . '>' . $user->name . ' (' . $user->email . ')</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Date From:</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" 
                                               value="<?php echo isset($filters['dateFrom']) ? $filters['dateFrom'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Date To:</label>
                                        <input type="date" class="form-control" name="dateTo" id="dateTo" 
                                               value="<?php echo isset($filters['dateTo']) ? $filters['dateTo'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Report Type:</label>
                                        <select class="form-control" name="reportType" id="reportType">
                                            <option value="summary" <?php echo (isset($filters['reportType']) && $filters['reportType'] == 'summary') ? 'selected' : ''; ?>>Summary Report</option>
                                            <option value="detailed" <?php echo (isset($filters['reportType']) && $filters['reportType'] == 'detailed') ? 'selected' : ''; ?>>Detailed Report</option>
                                            <option value="timeline" <?php echo (isset($filters['reportType']) && $filters['reportType'] == 'timeline') ? 'selected' : ''; ?>>Timeline View</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <button type="submit" class="btn btn-primary" id="generateReportBtn">
                                            <i class="fa fa-search"></i> Generate Report
                                        </button>
                                        <button type="button" class="btn btn-success" onclick="exportReport()" <?php echo (empty($reportData) && empty($treeData)) ? 'disabled' : ''; ?>>
                                            <i class="fa fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php if (!empty($reportData) || !empty($treeData)): ?>
        <!-- Report Results -->
        <div class="row">
            <div class="col-xs-12">
                <!-- Debug Info (Remove after testing) -->
                <?php if (ENVIRONMENT === 'development'): ?>
                <div class="alert alert-warning">
                    <strong>Debug Info:</strong><br>
                    Report Type: <?php echo isset($filters['reportType']) ? $filters['reportType'] : 'NOT SET'; ?><br>
                    reportData count: <?php echo !empty($reportData) ? count($reportData) : '0 or EMPTY'; ?><br>
                    treeData count: <?php echo !empty($treeData) ? count($treeData) : '0 or EMPTY'; ?><br>
                    Selected User: <?php echo isset($filters['selectedUser']) ? $filters['selectedUser'] : 'NOT SET'; ?><br>
                    Date From: <?php echo isset($filters['dateFrom']) ? $filters['dateFrom'] : 'NOT SET'; ?><br>
                    Date To: <?php echo isset($filters['dateTo']) ? $filters['dateTo'] : 'NOT SET'; ?>
                </div>
                <?php endif; ?>
                
                <!-- Tab Navigation -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="<?php echo ($filters['reportType'] == 'summary') ? 'active' : ''; ?>">
                            <a href="#summary-tab" data-toggle="tab" onclick="setReportType('summary')">
                                <i class="fa fa-table"></i> Summary Report
                            </a>
                        </li>
                        <li class="<?php echo ($filters['reportType'] == 'detailed') ? 'active' : ''; ?>">
                            <a href="#detailed-tab" data-toggle="tab" onclick="setReportType('detailed')">
                                <i class="fa fa-list"></i> Detailed Report
                            </a>
                        </li>
                        <li class="<?php echo ($filters['reportType'] == 'timeline') ? 'active' : ''; ?>">
                            <a href="#timeline-tab" data-toggle="tab" onclick="setReportType('timeline')">
                                <i class="fa fa-clock-o"></i> Timeline View
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        
                        <!-- Summary Tab -->
                        <div class="tab-pane <?php echo ($filters['reportType'] == 'summary') ? 'active' : ''; ?>" id="summary-tab">
                <?php if ($filters['reportType'] == 'summary'): ?>
                <!-- Summary Report -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-table"></i> User Activity Summary Report</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="printReport()">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="summaryTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User Name</th>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>Session Duration (Hours)</th>
                                        <th>Total Activities</th>
                                        <th>Add Actions</th>
                                        <th>Edit Actions</th>
                                        <th>Delete Actions</th>
                                        <th>View Actions</th>
                                        <th>Download Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalActivities = 0;
                                    $totalHours = 0;
                                    foreach ($reportData as $row): 
                                        $totalActivities += $row['total_activities'];
                                        $totalHours += $row['session_hours'];
                                    ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($row['activity_date'])); ?></td>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['login_time'] ? $row['login_time'] : '<span class="text-muted">N/A</span>'; ?></td>
                                        <td><?php echo $row['logout_time'] ? $row['logout_time'] : '<span class="text-muted">N/A</span>'; ?></td>
                                        <td>
                                            <?php if ($row['session_hours'] > 0): ?>
                                                <span class="label label-info"><?php echo number_format($row['session_hours'], 2); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">0.00</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-blue"><?php echo $row['total_activities']; ?></span></td>
                                        <td><span class="badge bg-green"><?php echo $row['add_count']; ?></span></td>
                                        <td><span class="badge bg-yellow"><?php echo $row['edit_count']; ?></span></td>
                                        <td><span class="badge bg-red"><?php echo $row['delete_count']; ?></span></td>
                                        <td><span class="badge bg-purple"><?php echo $row['view_count']; ?></span></td>
                                        <td><span class="badge bg-navy"><?php echo $row['download_count']; ?></span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="font-weight: bold; background-color: #f9f9f9;">
                                        <td colspan="5" class="text-right">Totals:</td>
                                        <td><span class="badge bg-blue"><?php echo $totalActivities; ?></span></td>
                                        <td colspan="4" class="text-center">
                                            Total Hours: <span class="label label-info"><?php echo number_format($totalHours, 2); ?></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                        </div>
                        
                        <!-- Detailed Tab -->
                        <div class="tab-pane <?php echo ($filters['reportType'] == 'detailed') ? 'active' : ''; ?>" id="detailed-tab">
                <?php if ($filters['reportType'] == 'detailed' && !empty($reportData)): ?>
                <!-- Detailed Report -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Detailed Activity Report</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="printReport()">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="detailedTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>User Name</th>
                                        <th>Action</th>
                                        <th>Module</th>
                                        <th>Table Name</th>
                                        <th>Record ID</th>
                                        <th>Details</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reportData as $row): ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($row['created_at'])); ?></td>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td>
                                            <?php
                                            $actionClass = 'default';
                                            switch ($row['action']) {
                                                case 'add': $actionClass = 'success'; break;
                                                case 'edit': $actionClass = 'warning'; break;
                                                case 'delete': $actionClass = 'danger'; break;
                                                case 'view': $actionClass = 'info'; break;
                                                case 'download': $actionClass = 'primary'; break;
                                            }
                                            ?>
                                            <span class="label label-<?php echo $actionClass; ?>">
                                                <?php echo ucfirst($row['action']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo $row['module']; ?></td>
                                        <td><?php echo $row['table_name'] ? $row['table_name'] : '<span class="text-muted">N/A</span>'; ?></td>
                                        <td><?php echo $row['record_id'] ? $row['record_id'] : '<span class="text-muted">N/A</span>'; ?></td>
                                        <td>
                                            <?php if ($row['details']): ?>
                                                <span class="text-sm"><?php echo htmlspecialchars($row['details']); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><code><?php echo $row['ip_address']; ?></code></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-info text-center" style="margin: 20px;">
                    <i class="fa fa-info-circle fa-2x"></i>
                    <h4>Detailed Report Not Generated</h4>
                    <p>Please select "Detailed Report" from the Report Type dropdown and click "Generate Report" to view detailed activity data.</p>
                </div>
                <?php endif; ?>
                        </div>
                        
                        <!-- Timeline View Tab -->
                        <div class="tab-pane <?php echo ($filters['reportType'] == 'timeline') ? 'active' : ''; ?>" id="timeline-tab">
                <?php if ($filters['reportType'] == 'timeline'): ?>
                    <?php if (!empty($treeData) && is_array($treeData)): ?>
                <!-- Timeline View Report -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-clock-o"></i> Activity Timeline View</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" onclick="printReport()">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <button type="button" class="btn btn-box-tool" onclick="toggleTimelineCompact()">
                                <i class="fa fa-compress"></i> Compact View
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                            <div id="activity-timeline" class="timeline-container">
                                <?php foreach ($treeData as $date => $dateData): ?>
                                    <!-- Date Header -->
                                    <div class="timeline-date-header">
                                        <div class="timeline-date-badge">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div class="timeline-date-content">
                                            <h4><?php echo date('l, F j, Y', strtotime($date)); ?></h4>
                                            <div class="timeline-date-stats">
                                                <span class="badge badge-primary"><?php echo count($dateData['activities']); ?> activities</span>
                                                <?php if (!empty($dateData['session_info'])): ?>
                                                    <span class="timeline-session-info">
                                                        <i class="fa fa-sign-in"></i> <?php echo $dateData['session_info']['login_time']; ?>
                                                        <i class="fa fa-clock-o"></i> <?php echo number_format($dateData['session_info']['session_hours'], 2); ?>h
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activities for this date -->
                                    <?php foreach ($dateData['activities'] as $index => $activity): 
                                        $currentTime = date('H:i', strtotime($activity['created_at']));
                                        $actionClass = 'primary';
                                        $actionIcon = 'fa-circle';
                                        
                                        switch ($activity['action']) {
                                            case 'add': $actionClass = 'success'; $actionIcon = 'fa-plus'; break;
                                            case 'edit': $actionClass = 'warning'; $actionIcon = 'fa-edit'; break;
                                            case 'delete': $actionClass = 'danger'; $actionIcon = 'fa-trash'; break;
                                            case 'view': $actionClass = 'info'; $actionIcon = 'fa-eye'; break;
                                            case 'download': $actionClass = 'primary'; $actionIcon = 'fa-download'; break;
                                            case 'login': $actionClass = 'success'; $actionIcon = 'fa-sign-in'; break;
                                            case 'logout': $actionClass = 'default'; $actionIcon = 'fa-sign-out'; break;
                                        }
                                    ?>
                                    <div class="timeline-item <?php echo $actionClass; ?>">
                                        <div class="timeline-point">
                                            <i class="fa <?php echo $actionIcon; ?>"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-header">
                                                <span class="timeline-time">
                                                    <i class="fa fa-clock-o"></i> <?php echo $currentTime; ?>
                                                </span>
                                                <span class="timeline-action">
                                                    <?php echo ucfirst($activity['action']); ?>
                                                </span>
                                                <span class="timeline-module">
                                                    <?php echo $activity['module']; ?>
                                                </span>
                                                <?php if ($activity['record_id']): ?>
                                                    <span class="timeline-record-id">
                                                        #<?php echo $activity['record_id']; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <?php if ($activity['details']): ?>
                                                <div class="timeline-details">
                                                    <?php echo htmlspecialchars($activity['details']); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="timeline-meta">
                                                <span><i class="fa fa-user"></i> <?php echo $activity['user_name']; ?></span>
                                                <span><i class="fa fa-map-marker"></i> <?php echo $activity['ip_address']; ?></span>
                                                <?php if ($activity['table_name']): ?>
                                                    <span><i class="fa fa-database"></i> <?php echo $activity['table_name']; ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-info-circle"></i>
                                <strong>No activity data found for timeline view.</strong>
                                <br>Please select a specific user and date range to generate the timeline report.
                                <br><strong>Note:</strong> Make sure the selected user has recorded activities during the selected date range.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                    <?php else: ?>
                <div class="alert alert-info text-center" style="margin: 20px;">
                    <i class="fa fa-info-circle fa-2x"></i>
                    <h4>Timeline Report Not Generated</h4>
                    <p>Please select "Timeline View" from the Report Type dropdown, choose a specific user, and click "Generate Report" to view timeline data.</p>
                </div>
                    <?php endif; ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <?php else: ?>
        <!-- No Data Message -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-body text-center">
                        <i class="fa fa-exclamation-triangle fa-3x text-yellow"></i>
                        <h3>No Data Found</h3>
                        <p>No activity records found for the selected filters. Please adjust your search criteria and try again.</p>
                        
                        <!-- Database Setup Instructions -->
                        <div class="alert alert-info" style="margin-top: 20px; text-align: left;">
                            <h4><i class="fa fa-info-circle"></i> Setup Required</h4>
                            <p>If this is your first time using the activity report, you may need to create the required database tables:</p>
                            <ol>
                                <li>Import <code>database/user_activity_logs.sql</code> to create the activity logging table</li>
                                <li>Import <code>database/user_sessions.sql</code> to create the session tracking table (optional, for enhanced time tracking)</li>
                                <li>Activity logging will start automatically after table creation</li>
                            </ol>
                            <p><strong>Note:</strong> These tables are required for the activity reporting system to work properly.</p>
                            <p><a href="<?php echo site_url('database_setup/activity_tables'); ?>" class="btn btn-info btn-sm">
                                <i class="fa fa-wrench"></i> Check Database Setup
                            </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
    </section>
</div>

<!-- Include Select2 CSS and JS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>

<!-- Include DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- DataTables Buttons for Export -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true
    });
    
    // Initialize DataTables
    <?php if (!empty($reportData)): ?>
        <?php if ($filters['reportType'] == 'summary'): ?>
        $('#summaryTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 25,
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": [5,6,7,8,9,10] }
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    title: 'User Activity Summary Report'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    title: 'User Activity Summary Report',
                    orientation: 'landscape'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    className: 'btn btn-info btn-sm',
                    title: 'User Activity Summary Report'
                }
            ]
        });
        <?php else: ?>
        $('#detailedTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 50,
            "order": [[ 0, "desc" ]],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    className: 'btn btn-success btn-sm',
                    title: 'User Activity Detailed Report'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    className: 'btn btn-danger btn-sm',
                    title: 'User Activity Detailed Report',
                    orientation: 'landscape'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Print',
                    className: 'btn btn-info btn-sm',
                    title: 'User Activity Detailed Report'
                }
            ]
        });
        <?php endif; ?>
    <?php endif; ?>
});

// Form submission handling
$('#reportForm').on('submit', function() {
    $('#generateReportBtn').prop('disabled', true)
        .html('<i class="fa fa-spinner fa-spin"></i> Generating...');
});

// Export report function
function exportReport() {
    <?php if (!empty($reportData)): ?>
    var formData = $('#reportForm').serialize();
    var url = '<?php echo base_url("activitylog/export"); ?>?' + formData;
    window.open(url, '_blank');
    <?php else: ?>
    alert('No data available to export. Please generate a report first.');
    <?php endif; ?>
}

// Print report function
function printReport() {
    <?php if (!empty($reportData)): ?>
    window.print();
    <?php else: ?>
    alert('No data available to print. Please generate a report first.');
    <?php endif; ?>
}

// Validate form before submission
function validateReportForm() {
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    
    if (!dateFrom || !dateTo) {
        alert('Please select both start and end dates.');
        return false;
    }
    
    if (dateFrom > dateTo) {
        alert('Start date cannot be after end date.');
        return false;
    }
    
    return true;
}

// Add validation to form
$('#reportForm').on('submit', function(e) {
    if (!validateReportForm()) {
        e.preventDefault();
        return false;
    }
    
    // Additional validation for timeline view
    if ($('#reportType').val() === 'timeline' && $('#selectedUser').val() === '') {
        alert('Please select a specific user for Timeline View report.');
        e.preventDefault();
        return false;
    }
    
    $('#generateReportBtn').prop('disabled', true)
        .html('<i class="fa fa-spinner fa-spin"></i> Generating...');
    
    // Re-enable button after 3 seconds (in case of error)
    setTimeout(function() {
        $('#generateReportBtn').prop('disabled', false)
            .html('<i class="fa fa-search"></i> Generate Report');
    }, 3000);
});

// Timeline view functions
function setReportType(type) {
    $('#reportType').val(type);
}

function toggleTimelineCompact() {
    var timeline = $('#activity-timeline');
    var btn = event.target.closest('button');
    
    if (timeline.hasClass('compact')) {
        timeline.removeClass('compact');
        btn.innerHTML = '<i class="fa fa-compress"></i> Compact View';
    } else {
        timeline.addClass('compact');
        btn.innerHTML = '<i class="fa fa-expand"></i> Expand View';
    }
}

// Smooth scroll to timeline item
function scrollToTimelineItem(date) {
    var dateHeader = $('.timeline-date-header').filter(function() {
        return $(this).find('h4').text().includes(date);
    });
    
    if (dateHeader.length) {
        $('html, body').animate({
            scrollTop: dateHeader.offset().top - 100
        }, 800);
    }
}

// Highlight timeline items based on action type
function filterTimelineByAction(action) {
    if (action === 'all') {
        $('.timeline-item').show();
        return;
    }
    
    $('.timeline-item').hide();
    $('.timeline-item.' + action).show();
}

// Report type change handler
$('#reportType').on('change', function() {
    var type = $(this).val();
    if (type === 'timeline' && $('#selectedUser').val() === '') {
        alert('Timeline View requires a specific user selection. Please select a user first.');
    }
});

// Set default dates on page load
$(document).ready(function() {
    if ($('#dateFrom').val() == '') {
        var thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
        $('#dateFrom').val(thirtyDaysAgo.toISOString().split('T')[0]);
    }
    
    if ($('#dateTo').val() == '') {
        var today = new Date();
        $('#dateTo').val(today.toISOString().split('T')[0]);
    }
});
</script>

<style>
.box-body .table th {
    background-color: #020254 !important;
    color: white !important;
    text-align: center !important;
    vertical-align: middle !important;
}

.badge {
    font-size: 12px;
    padding: 4px 6px;
}

.label {
    font-size: 11px;
    padding: 3px 6px;
}

/* Timeline View Styles */
.timeline-container {
    position: relative;
    padding-left: 30px;
}

/* Timeline vertical line */
.timeline-container::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
    z-index: 1;
}

/* Date Header */
.timeline-date-header {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    margin-top: 30px;
}

.timeline-date-badge {
    position: absolute;
    left: -24px;
    width: 40px;
    height: 40px;
    background: #3c8dbc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-date-content {
    margin-left: 30px;
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 8px;
    border-left: 4px solid #3c8dbc;
    flex: 1;
}

.timeline-date-content h4 {
    margin: 0 0 8px 0;
    color: #2c3e50;
    font-weight: 600;
}

.timeline-date-stats {
    display: flex;
    gap: 15px;
    align-items: center;
}

.timeline-session-info {
    color: #7f8c8d;
    font-size: 13px;
}

.timeline-session-info i {
    margin-right: 4px;
    margin-left: 10px;
}

/* Timeline Items */
.timeline-item {
    position: relative;
    display: flex;
    margin-bottom: 20px;
}

.timeline-point {
    position: absolute;
    left: -28px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Action-based colors */
.timeline-item.success .timeline-point { background: #27ae60; }
.timeline-item.warning .timeline-point { background: #f39c12; }
.timeline-item.danger .timeline-point { background: #e74c3c; }
.timeline-item.info .timeline-point { background: #3498db; }
.timeline-item.primary .timeline-point { background: #3c8dbc; }
.timeline-item.default .timeline-point { background: #95a5a6; }

.timeline-content {
    margin-left: 20px;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 16px 20px;
    flex: 1;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: box-shadow 0.3s ease;
}

.timeline-content:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.timeline-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.timeline-time {
    background: #ecf0f1;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    color: #2c3e50;
    font-weight: 500;
}

.timeline-action {
    background: #3c8dbc;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
}

.timeline-module {
    background: #34495e;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.timeline-record-id {
    background: #95a5a6;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.timeline-details {
    margin: 10px 0;
    padding: 12px;
    background: #f8f9fa;
    border-left: 3px solid #3c8dbc;
    border-radius: 0 4px 4px 0;
    color: #2c3e50;
    font-size: 13px;
    line-height: 1.5;
}

.timeline-meta {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #ecf0f1;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    font-size: 12px;
    color: #7f8c8d;
}

.timeline-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.timeline-meta i {
    color: #95a5a6;
}

/* Compact view */
.timeline-container.compact {
    padding-left: 20px;
}

.timeline-container.compact::before {
    left: 10px;
}

.timeline-container.compact .timeline-date-badge {
    left: -14px;
    width: 28px;
    height: 28px;
    font-size: 14px;
}

.timeline-container.compact .timeline-point {
    left: -18px;
    width: 24px;
    height: 24px;
    font-size: 10px;
}

.timeline-container.compact .timeline-content {
    margin-left: 15px;
    padding: 12px 16px;
}

.timeline-container.compact .timeline-date-content {
    margin-left: 20px;
    padding: 10px 15px;
}

/* Tab content styling */
.nav-tabs-custom {
    margin-bottom: 20px;
}

.nav-tabs-custom > .nav-tabs {
    border-bottom-color: #ddd;
    margin: 0;
}

.nav-tabs-custom > .nav-tabs > li {
    border-top: 3px solid transparent;
    margin-bottom: -2px;
    margin-right: 5px;
}

.nav-tabs-custom > .nav-tabs > li > a {
    border-radius: 0;
    color: #444;
    border-color: transparent;
}

.nav-tabs-custom > .nav-tabs > li.active {
    border-top-color: #3c8dbc;
}

.nav-tabs-custom > .nav-tabs > li.active > a {
    background-color: #fff;
    color: #444;
    border-top: 0;
    border-left-color: #ddd;
    border-right-color: #ddd;
}

.tab-content {
    padding: 10px 0;
}

@media print {
    .content-wrapper {
        margin-left: 0 !important;
    }
    .box-tools,
    .btn,
    .form-group,
    .nav-tabs {
        display: none !important;
    }
    .box {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    .tab-content {
        padding: 0;
    }
}
</style>