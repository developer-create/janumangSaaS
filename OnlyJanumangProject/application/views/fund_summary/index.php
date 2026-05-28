<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> Approved Fund Summary (FY: <?php echo htmlspecialchars($display_fy_title); ?>)
            <small><?php echo htmlspecialchars($card_subtitle); ?></small>
        </h1>
    </section>

    <section class="content">
        <!-- Fund Status Cards -->
        <div class="row">
            <?php 
            $fund_display_names = [
                'MLA FUND' => 'MLA FUND',
                'MLA Sweechanudan' => 'Swecha Nidhi',
                'CLP Sweechanudan' => 'CLP Fund',
                'Jansampark Fund' => 'Jansampark Fund'
            ];
            
            $fund_colors = [
                'MLA FUND' => 'bg-aqua',
                'MLA Sweechanudan' => 'bg-green',
                'CLP Sweechanudan' => 'bg-yellow',
                'Jansampark Fund' => 'bg-red'
            ];
            
            $card_fund_order = ['MLA FUND', 'MLA Sweechanudan', 'CLP Sweechanudan', 'Jansampark Fund'];
            foreach ($card_fund_order as $fund_name):
                $used = isset($used_totals[$fund_name]) ? (float) $used_totals[$fund_name] : 0;
                $color = isset($fund_colors[$fund_name]) ? $fund_colors[$fund_name] : 'bg-blue';
                $display_name = isset($fund_display_names[$fund_name]) ? $fund_display_names[$fund_name] : $fund_name;
                if (!empty($card_mode_all_fy)):
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box <?php echo $color; ?>">
                    <span class="info-box-icon"><i class="fa fa-inr"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b><?php echo htmlspecialchars($display_name); ?></b></span>
                        <span class="info-box-number">
                            Total: —<br>
                            Used (all FY): <?php echo number_format($used); ?><br>
                            Avail: —
                        </span>
                    </div>
                </div>
            </div>
            <?php else:
                    $total_allocation = isset($fund_limits[$fund_name]) ? (float) $fund_limits[$fund_name] : 0;
                    $available = $total_allocation - $used;
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box <?php echo $color; ?>">
                    <span class="info-box-icon"><i class="fa fa-inr"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><b><?php echo htmlspecialchars($display_name); ?></b></span>
                        <span class="info-box-number">
                            Total: <?php echo number_format($total_allocation); ?><br>
                            Used: <?php echo number_format($used); ?><br>
                            Avail: <?php echo number_format($available); ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php
                endif;
            endforeach; ?>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-filter"></i> Filter & Fund Details</h3>
                    </div>
                    <div class="box-body">
                        <form id="fundSummaryFilterForm" action="<?php echo site_url('fundSummary'); ?>" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Regi No</label>
                                        <input type="text" name="registration_no" class="form-control" value="<?php echo $filters['registration_no']; ?>" placeholder="Search Regi No">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Fund Type</label>
                                        <select name="fund_type" class="form-control">
                                            <option value="">All Funds</option>
                                            <option value="MLA FUND" <?php echo $filters['fund_type'] == 'MLA FUND' ? 'selected' : ''; ?>>MLA FUND</option>
                                            <option value="MLA Sweechanudan" <?php echo $filters['fund_type'] == 'MLA Sweechanudan' ? 'selected' : ''; ?>>MLA Swechanudan</option>
                                            <option value="CLP Sweechanudan" <?php echo $filters['fund_type'] == 'CLP Sweechanudan' ? 'selected' : ''; ?>>CLP Swechanudan</option>
                                            <option value="Jansampark Fund" <?php echo $filters['fund_type'] == 'Jansampark Fund' ? 'selected' : ''; ?>>Jansampark Fund</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Financial Year</label>
                                        <select name="financial_year" id="fundSummaryFinancialYear" class="form-control">
                                            <option value="">All FY</option>
                                            <?php for ($y = 2008; $y <= 2099; $y++):
                                                $fy = $y . '-' . ($y + 1);
                                            ?>
                                                <option value="<?php echo htmlspecialchars($fy); ?>" <?php echo (string) $filters['financial_year'] === (string) $fy ? 'selected' : ''; ?>><?php echo htmlspecialchars($fy); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="date" name="from_date" class="form-control" value="<?php echo $filters['from_date']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="date" name="to_date" class="form-control" value="<?php echo $filters['to_date']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="work_status" class="form-control">
                                            <option value="">All Status</option>
                                            <option value="Incomplete" <?php echo $filters['work_status'] == 'Incomplete' ? 'selected' : ''; ?>>Incomplete</option>
                                            <option value="In progress" <?php echo $filters['work_status'] == 'In progress' ? 'selected' : ''; ?>>In Progress</option>
                                            <option value="Complete" <?php echo $filters['work_status'] == 'Complete' ? 'selected' : ''; ?>>Complete</option>
                                            <option value="Reject" <?php echo $filters['work_status'] == 'Reject' ? 'selected' : ''; ?>>Reject</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <a href="<?php echo site_url('fundSummary'); ?>?financial_year=2026-2027" class="btn btn-default form-control"><i class="fa fa-refresh"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Fund Summary Data</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table id="fundSummaryTable" class="table table-hover">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>Sr No</th>
                                    <th>Regi No</th>
                                    <th>Recommended Letter No</th>
                                    <th>Financial Year</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <!--<th>Address</th>-->
                                    <th>Source</th>
                                    <th>District</th>
                                    
                                    <th>Block</th>
                                    <th>Booth No</th>
                                    <th>Booth Name</th>
                                    <th>Assembly</th>
                                    <th>Panchayat</th>
                                    <th>Village</th>
                                    <th>Majra/Faliya</th>
                                    <th>Department</th>
                                    <th>Work/Problem</th>
                                    <th>Status</th>
                                    <th>Approved Fund</th>
                                    <th>Approximate Cost</th>
                                    <th>Work Agency</th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div style="text-align: right; padding: 10px; font-weight: bold;">
                            Total Used Fund (filtered): ₹<span id="fundSummaryFooterTotal">—</span>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>

<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<style>
/* DataTables buttons styling */
.dt-buttons {
    float: left;
    margin-right: 10px;
    margin-bottom: 10px;
}

.dt-button {
    background-color: #337ab7 !important;
    color: white !important;
    border: 1px solid #2e6da4 !important;
    padding: 6px 12px !important;
    margin-right: 5px !important;
    border-radius: 4px !important;
    font-size: 12px !important;
}

.dt-button:hover {
    background-color: #286090 !important;
    border-color: #204d74 !important;
}

.dt-button.buttons-excel {
    background-color: #28a745 !important;
    border-color: #218838 !important;
}

.dt-button.buttons-excel:hover {
    background-color: #218838 !important;
}

/* Length menu styling */
.dataTables_length {
    float: left;
    margin-right: 20px;
}

.dataTables_length select {
    padding: 5px;
    border: 1px solid #d2d6de;
    border-radius: 3px;
}

/* Filter styling */
.dataTables_filter {
    float: right;
}

/* Wrapper styling */
.dataTables_wrapper {
    overflow-x: auto;
    clear: both;
}

/* Table column width */
table.table th, 
table.table td {
    padding: 10px !important;
    font-size: 13px !important;
}

/* Style for DataTables sorting arrows */
table.dataTable thead>tr>th.sorting:after, 
table.dataTable thead>tr>th.sorting_asc:after, 
table.dataTable thead>tr>th.sorting_desc:after {
    color: #000000 !important;
    opacity: 0.6 !important;
}

table.dataTable thead>tr>th.sorting:before, 
table.dataTable thead>tr>th.sorting_asc:before, 
table.dataTable thead>tr>th.sorting_desc:before {
    color: #000000 !important;
    opacity: 0.6 !important;
}

.dataTables_info {
    float: left;
    padding-top: 15px;
}

.dataTables_paginate {
    float: right;
    padding-top: 0px;
}

.paginate_button {
    padding: 5px 10px !important;
    margin: 2px !important;
    border: 1px solid #ddd !important;
    border-radius: 3px !important;
    background-color: #ffffff !important;
    color: #333 !important;
    cursor: pointer !important;
}

.paginate_button:hover {
    background-color: #f5f5f5 !important;
}

.paginate_button.current {
    background-color: #337ab7 !important;
    color: white !important;
    border-color: #2e6da4 !important;
}

.paginate_button.disabled {
    opacity: 0.5;
    cursor: not-allowed !important;
}

.dataTables_paginate {
    margin-top: 15px;
}

/* Table hover effect */
.table-hover tbody tr:hover td {
    background-color: #f5f5f5;
}

/* Prevent full table flash before DataTables initializes */
table#fundSummaryTable:not(.dataTable) tbody {
    display: none;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
    function formatMoney(n) {
        var x = Number(n) || 0;
        return x.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    jQuery('#fundSummaryFinancialYear').on('change', function () {
        jQuery('#fundSummaryFilterForm').submit();
    });

    var table = jQuery('#fundSummaryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo site_url('fundSummary/data'); ?>',
            type: 'POST',
            data: function (d) {
                d.filter_fund_type = jQuery('#fundSummaryFilterForm select[name="fund_type"]').val();
                d.filter_financial_year = jQuery('#fundSummaryFilterForm select[name="financial_year"]').val();
                d.filter_from_date = jQuery('#fundSummaryFilterForm input[name="from_date"]').val();
                d.filter_to_date = jQuery('#fundSummaryFilterForm input[name="to_date"]').val();
                d.filter_work_status = jQuery('#fundSummaryFilterForm select[name="work_status"]').val();
                d.filter_registration_no = jQuery('#fundSummaryFilterForm input[name="registration_no"]').val();
            },
            dataSrc: function (json) {
                if (json && typeof json.sumFiltered !== 'undefined') {
                    jQuery('#fundSummaryFooterTotal').text(formatMoney(json.sumFiltered));
                }
                return json.data;
            }
        },
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-download"></i> Export Excel',
                title: 'Approved Fund Summary Report',
                className: 'btn btn-success',
                exportOptions: { columns: ':visible' }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                title: 'Approved Fund Summary Report',
                className: 'btn btn-info'
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-columns"></i> Show/Hide Columns',
                className: 'btn btn-warning'
            }
        ],
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthMenu: [[10, 20, 50, 100, 500, -1], [10, 20, 50, 100, 500, 'All']],
        pageLength: 20,
        responsive: true,
        scrollX: true,
        order: [[22, 'desc']],
        columnDefs: [
            { targets: [6, 17], orderable: false }
        ],
        initComplete: function () {
            jQuery('#fundSummaryTable tbody').css('display', 'table-row-group');
        }
    });
});
</script>

