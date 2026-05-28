<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-history"></i> User Activity Logs
            <small>Track all user activities across all modules</small>
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
        
        <?php
        $success = $this->session->flashdata("success");
        if ($success) {
        ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata("success"); ?>
        </div>
        <?php } ?>
        
        <!-- Filters -->
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filters</h3>
                    </div>
                    <div class="box-body">
                        <form method="POST" action="<?php echo base_url('activitylog'); ?>" id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Search</label>
                                        <input type="text" class="form-control" name="searchText" id="searchText" 
                                               value="<?php echo !empty($filters['search']) ? $filters['search'] : ''; ?>" 
                                               placeholder="Search in logs...">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>User</label>
                                        <select class="form-control" name="filterUser" id="filterUser">
                                            <option value="">All Users</option>
                                            <?php if (!empty($users)): ?>
                                                <?php foreach($users as $user): ?>
                                                    <option value="<?php echo $user->userId; ?>" 
                                                            <?php echo (!empty($filters['user_id']) && $filters['user_id'] == $user->userId) ? 'selected' : ''; ?>>
                                                        <?php echo $user->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Module</label>
                                        <select class="form-control" name="filterModule" id="filterModule">
                                            <option value="">All Modules</option>
                                            <?php if (!empty($modules)): ?>
                                                <?php foreach($modules as $module): ?>
                                                    <option value="<?php echo $module['module']; ?>" 
                                                            <?php echo (!empty($filters['module']) && $filters['module'] == $module['module']) ? 'selected' : ''; ?>>
                                                        <?php echo $module['module']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Action</label>
                                        <select class="form-control" name="filterAction" id="filterAction">
                                            <option value="">All Actions</option>
                                            <?php if (!empty($actions)): ?>
                                                <?php foreach($actions as $key => $label): ?>
                                                    <option value="<?php echo $key; ?>" 
                                                            <?php echo (!empty($filters['action']) && $filters['action'] == $key) ? 'selected' : ''; ?>>
                                                        <?php echo $label; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1.5">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" class="form-control" name="dateFrom" id="dateFrom" 
                                               value="<?php echo !empty($filters['date_from']) ? $filters['date_from'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-1.5">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" class="form-control" name="dateTo" id="dateTo" 
                                               value="<?php echo !empty($filters['date_to']) ? $filters['date_to'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                    <a href="<?php echo base_url('activitylog'); ?>" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Activity Logs Table -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Activity Logs</h3>
                    </div>
                    <div class="box-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tab-main" aria-controls="tab-main" role="tab" data-toggle="tab">All (Except Login/Logout) <span class="badge"><?php echo $total; ?></span></a></li>
                            <li role="presentation"><a href="#tab-auth" aria-controls="tab-auth" role="tab" data-toggle="tab">Login/Logout <span class="badge"><?php echo $auth_total; ?></span></a></li>
                        </ul>
                        <div class="tab-content" style="margin-top:15px;">
                            <div role="tabpanel" class="tab-pane active" id="tab-main">
                                <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="activityLogTable">
                            <thead>
                                <tr style="background-color:#020254;color:white;">
                                    <th>Sr No</th>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Module</th>
                                    <th>Record ID</th>
                                    <th>Table Name</th>
                                    <th>Details</th>
                                    <th>IP Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="10" class="text-center">Loading activity logs...</td>
                                </tr>
                            </tbody>
                                </table>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab-auth">
                                <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="authLogTable">
                                    <thead>
                                        <tr style="background-color:#020254;color:white;">
                                            <th>Sr No</th>
                                            <th>Date & Time</th>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>IP Address</th>
                                            <th>User Agent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($auth_logs)): ?>
                                            <?php foreach ($auth_logs as $index => $log): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td><?php echo date('d/m/Y H:i:s', strtotime($log['created_at'])); ?></td>
                                                    <td><?php echo htmlspecialchars($log['user_name']); ?></td>
                                                    <td>
                                                        <span class="label label-<?php echo $log['action'] == 'login' ? 'success' : 'default'; ?>">
                                                            <?php echo strtoupper($log['action']); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($log['ip_address']); ?></td>
                                                    <td><?php echo htmlspecialchars($log['user_agent']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No login/logout logs found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($total > $perPage): ?>
                    <div class="box-footer" id="serverPagination" style="display:none;">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Showing <?php echo (($page - 1) * $perPage) + 1; ?> to <?php echo min($page * $perPage, $total); ?> of <?php echo $total; ?> entries</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <?php
                                $totalPages = ceil($total / $perPage);
                                
                                // Build query string for pagination links
                                $queryParams = array();
                                if (!empty($searchText)) $queryParams['searchText'] = $searchText;
                                if (!empty($filterUser)) $queryParams['filterUser'] = $filterUser;
                                if (!empty($filterModule)) $queryParams['filterModule'] = $filterModule;
                                if (!empty($filterAction)) $queryParams['filterAction'] = $filterAction;
                                if (!empty($dateFrom)) $queryParams['dateFrom'] = $dateFrom;
                                if (!empty($dateTo)) $queryParams['dateTo'] = $dateTo;
                                
                                $baseUrl = base_url('activitylog');
                                $queryString = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                                
                                if ($page > 1): 
                                    $prevParams = $queryParams;
                                    $prevParams['page'] = $page - 1;
                                ?>
                                    <a href="<?php echo $baseUrl . '?' . http_build_query($prevParams); ?>" class="btn btn-default">Previous</a>
                                <?php endif; ?>
                                
                                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): 
                                    $pageParams = $queryParams;
                                    $pageParams['page'] = $i;
                                ?>
                                    <a href="<?php echo $baseUrl . '?' . http_build_query($pageParams); ?>" 
                                       class="btn btn-<?php echo $i == $page ? 'primary' : 'default'; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>
                                
                                <?php if ($page < $totalPages): 
                                    $nextParams = $queryParams;
                                    $nextParams['page'] = $page + 1;
                                ?>
                                    <a href="<?php echo $baseUrl . '?' . http_build_query($nextParams); ?>" class="btn btn-default">Next</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- DataTables assets -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function(){
    var table = $('#activityLogTable').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: '<?php echo base_url('activitylog/getActivityLogsAjax'); ?>',
            type: 'POST',
            data: function(d) {
                d.filterUser = $('#filterUser').val() || '';
                d.filterModule = $('#filterModule').val() || '';
                d.filterAction = $('#filterAction').val() || '';
                d.dateFrom = $('#dateFrom').val() || '';
                d.dateTo = $('#dateTo').val() || '';
            }
        },
        pageLength: 20,
        lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
        ordering: false,
        searching: true,
        info: true,
        paging: true,
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Activity Logs'
            }
        ],
        columnDefs: [
            { targets: 0, orderable: false }
        ],
        language: {
            paginate: {
                previous: "← Previous",
                next: "Next →"
            },
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            processing: "Loading...",
            emptyTable: "No data available"
        }
    });

    $('#filterUser, #filterModule, #filterAction, #dateFrom, #dateTo').on('change', function() {
        table.draw();
    });

    var searchTimeout;
    $('#searchText').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            table.search($('#searchText').val()).draw();
        }, 500);
    });

    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        table.draw();
    });
    
    $('#authLogTable').DataTable({
        pageLength: 20,
        lengthMenu: [[10, 20, 50, 100], [10, 20, 50, 100]],
        ordering: true,
        searching: true,
        info: true,
        paging: true
    });
});
</script>

<style>
    .label {
        padding: 5px 10px;
        font-size: 12px;
    }
</style>

