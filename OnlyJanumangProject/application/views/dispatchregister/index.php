<div class="content-wrapper">
    <style>
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>th.sorting_asc_disabled:after, table.dataTable thead>tr>th.sorting_desc_disabled:after, table.dataTable thead>tr>td.sorting:after, table.dataTable thead>tr>td.sorting_asc:after, table.dataTable thead>tr>td.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc_disabled:after, table.dataTable thead>tr>td.sorting_desc_disabled:after{
            color:#000000 !important;
            opacity: 60 !important;
        }

        table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before, table.dataTable thead>tr>th.sorting_asc_disabled:before, table.dataTable thead>tr>th.sorting_desc_disabled:before, table.dataTable thead>tr>td.sorting:before, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:before, table.dataTable thead>tr>td.sorting_asc_disabled:before, table.dataTable thead>tr>td.sorting_desc_disabled:before{
            color:#000000 !important;
            opacity: 60 !important;
        }
    </style>
    <section class="content-header">
        <h1>
            <i class="fa fa-book" aria-hidden="true"></i> In/Out Register Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php
                    $success = $this->session->flashdata('success');
                    if($success) {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $success; ?>
                </div>
                <?php } ?>
                <?php
                    $error = $this->session->flashdata('error');
                    if($error) {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $error; ?>
                </div>
                <?php } ?>
                
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">In/Out Register List</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('dispatchregister/create'); ?>" class="btn btn-success">Add New Entry</a>
                        </div>
                    </div>
                    
                    <!-- Tabs Navigation -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#all-docs" data-toggle="tab" data-filter="all">All Records</a>
                            </li>
                            <li>
                                <a href="#dispatch-docs" data-toggle="tab" data-filter="dispatch">Dispatch Records</a>
                            </li>
                            <li>
                                <a href="#inward-docs" data-toggle="tab" data-filter="inward">Inward Doc Records</a>
                            </li>
                            <li>
                                <a href="#misc-docs" data-toggle="tab" data-filter="miscellaneous">Miscellaneous Records</a>
                            </li>
                        </ul>
                        
                        <!-- Filters -->
                        <div style="padding: 15px; background-color: #f4f4f4; border-bottom: 1px solid #ddd;">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>District</label>
                                    <select id="districtFilter" class="form-control select2">
                                        <option value="">All Districts</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Vidhan Sabha</label>
                                    <select id="vidhanSabhaFilter" class="form-control select2">
                                        <option value="">All Vidhan Sabhas</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Year</label>
                                    <select id="yearFilter" class="form-control select2">
                                        <option value="">All Years</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Month</label>
                                    <select id="monthFilter" class="form-control select2">
                                        <option value="">All Months</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Date</label>
                                    <input type="date" id="dateFilter" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button id="resetFilters" class="btn btn-default btn-block">Reset Filters</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-content">
                            <div class="tab-pane active" id="all-docs">
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover" id="dispatchTable">
                                        <thead>
                                            <tr style="color:white;font-size:15px;background-color:#020254;">
                                                <th>S.NO</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Portal No.</th>
                                                <th>Samiti No.</th>
                                                <th>Dispatch No.</th>
                                                <th>Department</th>
                                                <th>Particular (subject)</th>
                                                <th>Reference</th>
                                                <th>District</th>
                                                <th>Vidhan Sabha</th>
                                                <th>Block</th>
                                                <th>Letter</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($dispatch_registers as $key => $register): ?>
                                            <tr class="record-row" 
                                                data-dispatch="<?php echo !empty($register['dispatch_no']) ? '1' : '0'; ?>"
                                                data-month="<?php echo $register['month']; ?>"
                                                data-district="<?php echo $register['district_name']; ?>">
                                                <td><?php echo $key + 1; ?></td>
                                                <td>
                                                    <?php 
                                                    if (isset($register['type'])) {
                                                        switch($register['type']) {
                                                            case '1': echo 'Dispatch (Outward)'; break;
                                                            case '2': echo 'Inward'; break;
                                                            case '3': echo 'Miscellaneous'; break;
                                                            default: echo '-'; break;
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $register['date'] ? date('d-m-Y', strtotime($register['date'])) : '-'; ?></td>
                                                <td><?php echo $register['year'] ? $register['year'] : '-'; ?></td>
                                                <td><?php echo $register['month'] ? $register['month'] : '-'; ?></td>
                                                <td><?php echo $register['portal_no'] ? $register['portal_no'] : '-'; ?></td>
                                                <td><?php echo $register['samiti_no'] ? $register['samiti_no'] : '-'; ?></td>
                                                <td><?php echo $register['dispatch_no'] ? $register['dispatch_no'] : '-'; ?></td>
                                                <td><?php echo $register['department_name'] ? $register['department_name'] : '-'; ?></td>
                                                <td class="particular-subject-cell"><?php echo $register['particular_subject'] ? $register['particular_subject'] : '-'; ?></td>
                                                <td><?php echo $register['reference'] ? $register['reference'] : '-'; ?></td>
                                                <td><?php echo $register['district_name'] ? $register['district_name'] : '-'; ?></td>
                                                <td><?php echo !empty($register['vidhan_sabha_name']) ? $register['vidhan_sabha_name'] : '-'; ?></td>
                                                <td><?php echo $register['block_name'] ? $register['block_name'] : '-'; ?></td>
                                                <td>
                                                    <?php if(!empty($register['upload_letter']) && file_exists($register['upload_letter'])): ?>
                                                        <a href="<?php echo base_url($register['upload_letter']); ?>" target="_blank" class="btn btn-xs btn-primary" title="View Letter">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url('dispatchregister/view/' . $register['id']); ?>" class="btn btn-xs btn-info" title="View Details">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('dispatchregister/edit/' . $register['id']); ?>" class="btn btn-xs btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo site_url('dispatchregister/delete/' . $register['id']); ?>" class="btn btn-xs btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Initialize Select2 for filters
    $('.select2').select2({
        width: '100%'
    });

    // Custom search function for tab filtering
    var currentTabFilter = 'all';
    
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'dispatchTable') {
                return true;
            }
            
            var typeText = data[1] || ''; // Column 1 is Type
            
            if (currentTabFilter === 'all') {
                return true;
            } else if (currentTabFilter === 'dispatch') {
                // Filter by type = "Dispatch (Outward)"
                return typeText === 'Dispatch (Outward)';
            } else if (currentTabFilter === 'inward') {
                // Filter by type = "Inward"
                return typeText === 'Inward';
            } else if (currentTabFilter === 'miscellaneous') {
                // Filter by type = "Miscellaneous"
                return typeText === 'Miscellaneous';
            }
            
            return true;
        }
    );

    var table = $('#dispatchTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Docs Register List',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "order": [[0, "desc"]],
        "initComplete": function() {
            populateFilters(this.api());
        }
    });

    function populateFilters(api) {
        var columnsToFilter = {
            11: '#districtFilter',
            12: '#vidhanSabhaFilter',
            3: '#yearFilter',
            4: '#monthFilter',
            2: '#dateFilter'
        };

        var monthOrder = {
            "January": 1, "February": 2, "March": 3, "April": 4, "May": 5, "June": 6,
            "July": 7, "August": 8, "September": 9, "October": 10, "November": 11, "December": 12,
            "Jan": 1, "Feb": 2, "Mar": 3, "Apr": 4, "May": 5, "Jun": 6,
            "Jul": 7, "Aug": 8, "Sep": 9, "Oct": 10, "Nov": 11, "Dec": 12
        };

        $.each(columnsToFilter, function(index, selector) {
            if (selector !== '#dateFilter') {
                var columnData = api.column(index).data().unique().sort();
                
                if (selector === '#monthFilter') {
                    var sortedMonths = columnData.toArray().sort(function(a, b) {
                        return (monthOrder[a] || 99) - (monthOrder[b] || 99);
                    });
                    $.each(sortedMonths, function(i, d) {
                        if (d && d !== '-') {
                            $(selector).append('<option value="' + d + '">' + d + '</option>');
                        }
                    });
                } else {
                    columnData.each(function(d, j) {
                        if (d && d !== '-') {
                            $(selector).append('<option value="' + d + '">' + d + '</option>');
                        }
                    });
                }
            }
        });
    }

    // Apply filters
    $('#districtFilter').on('change', function() {
        var districtVal = this.value;
        
        // When district changes, we should clear Vidhan Sabha selection and search
        $('#vidhanSabhaFilter').val('').trigger('change.select2');
        table.column(12).search('');
        
        table.column(11).search(districtVal).draw();
        
        // Repopulate Vidhan Sabha filter based on currently visible rows
        updateVidhanSabhaOptions();
    });

    $('#vidhanSabhaFilter').on('change', function() {
        table.column(12).search(this.value).draw();
    });

    function updateVidhanSabhaOptions() {
        var vsFilter = $('#vidhanSabhaFilter');
        var currentVS = vsFilter.val();
        vsFilter.empty().append('<option value="">All Vidhan Sabhas</option>');
        
        // Get unique Vidhan Sabhas from rows matching current filters (which includes District)
        var uniqueVS = table.column(12, { search: 'applied' }).data().unique().sort();
        
        uniqueVS.each(function(d) {
            if (d && d !== '-') {
                var selected = (d === currentVS) ? ' selected' : '';
                vsFilter.append('<option value="' + d + '"' + selected + '>' + d + '</option>');
            }
        });
        
        vsFilter.trigger('change.select2');
    }

    $('#yearFilter').on('change', function() {
        table.column(3).search(this.value).draw();
    });
    $('#monthFilter').on('change', function() {
        table.column(4).search(this.value).draw();
    });
    $('#dateFilter').on('change', function() {
        var dateVal = this.value; // yyyy-mm-dd
        if (dateVal) {
            var parts = dateVal.split('-');
            var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0]; // dd-mm-yyyy
            table.column(2).search(formattedDate).draw();
        } else {
            table.column(2).search('').draw();
        }
    });

    $('#resetFilters').on('click', function() {
        $('.select2').val('').trigger('change');
        $('#dateFilter').val('');
        table.columns().search('').draw();
        
        // After reset, repopulate VS filter with all options
        repopulateAllFilters();
    });

    function repopulateAllFilters() {
        // Just clear and repopulate the VS filter with all possible values
        var vsFilter = $('#vidhanSabhaFilter');
        vsFilter.empty().append('<option value="">All Vidhan Sabhas</option>');
        
        table.column(12).data().unique().sort().each(function(d) {
            if (d && d !== '-') {
                vsFilter.append('<option value="' + d + '">' + d + '</option>');
            }
        });
        vsFilter.trigger('change.select2');
    }

    // Tab filtering
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var filter = $(e.target).data('filter');
        currentTabFilter = filter;
        table.draw();
        // Update VS options when tab changes as well
        updateVidhanSabhaOptions();
    });

});
</script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<style>
.nav-tabs-custom .tab-content {
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
}

.record-row {
    cursor: pointer;
}

.record-row:hover {
    background-color: #f5f5f5;
}

.particular-subject-cell {
    max-width: 250px;
    word-wrap: break-word;
    white-space: normal;
    line-height: 1.4;
    padding: 8px;
}

#dispatchTable td {
    vertical-align: top;
    padding: 8px;
}

#dispatchTable tr {
    height: auto;
    min-height: 40px;
}
</style>