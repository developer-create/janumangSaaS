<div class="content-wrapper">
    <style>
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>th.sorting_asc_disabled:after, table.dataTable thead>tr>th.sorting_desc_disabled:after, table.dataTable thead>tr>td.sorting:after, table.dataTable thead>tr>td.sorting_asc:after, table.dataTable thead>tr>td.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc_disabled:after, table.dataTable thead>tr>td.sorting_desc_disabled:after {
            color:#000000 !important;
            opacity: 60 !important;
        }
        table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before, table.dataTable thead>tr>th.sorting_asc_disabled:before, table.dataTable thead>tr>th.sorting_desc_disabled:before, table.dataTable thead>tr>td.sorting:before, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:before, table.dataTable thead>tr>td.sorting_asc_disabled:before, table.dataTable thead>tr>td.sorting_desc_disabled:before {
            color:#000000 !important;
            opacity: 60 !important;
        }
    </style>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/samiti-filters.css'); ?>">
    <section class="content-header"> 
        <h1>
            <i class="fa fa-users" aria-hidden="true"></i> Ganesh Samiti Locations
        </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">गणेश समिति स्थान (Ganesh Samiti Locations) List</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('ganeshsamiti/create'); ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Location</a>
                        </div>
                    </div><!-- /.box-header -->
                    
                    <!-- Total Members Card -->
                    <div style="margin: 10px 0; padding: 10px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 5px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <span style="font-size: 12px; opacity: 0.9;">कुल सदस्य:</span>
                        <span style="font-size: 18px; font-weight: bold; margin-left: 8px;">
                            <?php echo isset($total_members) ? $total_members : 0; ?>
                        </span>
                    </div>
                    
                    <!-- Filters Section -->
                    <div class="filter-section">
                        <form method="get" action="<?php echo site_url('ganeshsamiti'); ?>" id="filterForm">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label for="filter_block">ब्लॉक (Block)</label>
                                    <select name="filter_block" id="filter_block">
                                        <option value="">-- All Blocks --</option>
                                        <?php if (!empty($blocks)): foreach ($blocks as $blk): ?>
                                        <option value="<?php echo $blk->id; ?>" <?php echo (isset($filter_block) && $filter_block == $blk->id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($blk->name); ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                                
                                <div class="filter-group">
                                    <label for="filter_year">वर्ष (Year)</label>
                                    <select name="filter_year" id="filter_year">
                                        <option value="">-- All Years --</option>
                                        <?php for ($y = 2020; $y <= 2030; $y++): ?>
                                        <option value="<?php echo $y; ?>" <?php echo (isset($filter_year) && $filter_year == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                <div class="filter-group">
                                    <label for="filter_month">महीना (Month)</label>
                                    <select name="filter_month" id="filter_month">
                                        <option value="">-- All Months --</option>
                                        <option value="1" <?php echo (isset($filter_month) && $filter_month == '1') ? 'selected' : ''; ?>>January</option>
                                        <option value="2" <?php echo (isset($filter_month) && $filter_month == '2') ? 'selected' : ''; ?>>February</option>
                                        <option value="3" <?php echo (isset($filter_month) && $filter_month == '3') ? 'selected' : ''; ?>>March</option>
                                        <option value="4" <?php echo (isset($filter_month) && $filter_month == '4') ? 'selected' : ''; ?>>April</option>
                                        <option value="5" <?php echo (isset($filter_month) && $filter_month == '5') ? 'selected' : ''; ?>>May</option>
                                        <option value="6" <?php echo (isset($filter_month) && $filter_month == '6') ? 'selected' : ''; ?>>June</option>
                                        <option value="7" <?php echo (isset($filter_month) && $filter_month == '7') ? 'selected' : ''; ?>>July</option>
                                        <option value="8" <?php echo (isset($filter_month) && $filter_month == '8') ? 'selected' : ''; ?>>August</option>
                                        <option value="9" <?php echo (isset($filter_month) && $filter_month == '9') ? 'selected' : ''; ?>>September</option>
                                        <option value="10" <?php echo (isset($filter_month) && $filter_month == '10') ? 'selected' : ''; ?>>October</option>
                                        <option value="11" <?php echo (isset($filter_month) && $filter_month == '11') ? 'selected' : ''; ?>>November</option>
                                        <option value="12" <?php echo (isset($filter_month) && $filter_month == '12') ? 'selected' : ''; ?>>December</option>
                                    </select>
                                </div>
                                
                                <div class="filter-group">
                                    <label for="filter_date">तारीख (Date)</label>
                                    <input type="date" name="filter_date" id="filter_date" class="form-control" value="<?php echo isset($filter_date) ? $filter_date : ''; ?>">
                                </div>
                                
                                <div class="filter-buttons">
                                    <button type="submit" class="btn btn-primary" style="display:none;"><i class="fa fa-filter"></i> Filter</button>
                                    <a href="<?php echo site_url('ganeshsamiti'); ?>" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="ganeshSamitiTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>Sr No</th>
                                    <th>Unique ID</th>
                                    <th>वर्ष (Year)</th>
                                    <th>AC/MP No.</th>
                                    <th>ब्लॉक (Block)</th>
                                    <th>सेक्टर (Sector)</th>
                                    <th>माइक्रो सेक्टर न (Micro Sector No)</th>
                                    <th>माइक्रो सेक्टर नाम (Micro Sector Name)</th>
                                    <th>बूथ का नाम (Booth Name)</th>
                                    <th>बूथ क (Booth No)</th>
                                    <th>ग्राम पंचायत (Gram Panchayat)</th>
                                    <th>गांव का नाम (Village)</th>
                                    <th>फलिया (Faliya)</th>
                                    <th>कुल सदस्य (Total Members)</th>
                                    <th>File</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groups as $key => $group): ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><strong><?php echo isset($group['unique_id']) ? $group['unique_id'] : '-'; ?></strong></td>
                                    <td><?php echo $group['year']; ?></td>
                                    <td><?php echo $group['ac_mp_no']; ?></td>
                                    <td><?php echo $group['block_name']; ?></td>
                                    <td><?php echo $group['sector']; ?></td>
                                    <td><?php echo $group['micro_sector_no']; ?></td>
                                    <td><?php echo $group['micro_sector_name']; ?></td>
                                    <td><?php echo $group['booth_name']; ?></td>
                                    <td><?php echo $group['booth_no']; ?></td>
                                    <td><?php echo $group['gram_panchayat']; ?></td>
                                    <td><?php echo $group['village']; ?></td>
                                    <td><?php echo $group['faliya']; ?></td>
                                    <td><span class="badge bg-blue"><?php echo $group['total_members']; ?></span></td>
                                    <td>
                                        <?php if (!empty($group['file_upload'])): ?>
                                            <a href="<?php echo base_url('uploads/samiti_files/'.$group['file_upload']); ?>" target="_blank" class="btn btn-info btn-xs" title="View File">
                                                <i class="fa fa-file"></i> View
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No File</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('ganeshsamiti/members/'.$group['id']); ?>" class="btn btn-primary btn-xs" title="View Members">
                                            <i class="fa fa-users"></i> View
                                        </a>
                                        <a href="<?php echo site_url('ganeshsamiti/edit/'.$group['id']); ?>" class="btn btn-warning btn-xs" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?php echo site_url('ganeshsamiti/delete/'.$group['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this location and all its members?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section> 
</div> 

<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#ganeshsamitiTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Ganesh Samiti Locations List',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]]
    });
});
</script>
            </div>
        </div>
    </section>
</div>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

<style>
/* DataTables Export Button Styling */
.dt-buttons {
    margin-bottom: 10px;
    float: left;
}

.dt-button {
    background: #337ab7 !important;
    color: white !important;
    border: 1px solid #2e6da4 !important;
    padding: 6px 12px;
    margin-right: 5px;
    border-radius: 4px;
    font-size: 12px;
}

.dt-button:hover {
    background: #286090 !important;
    border-color: #204d74 !important;
}

/* DataTables Length Menu */
.dataTables_length {
    float: left;
    margin-right: 20px;
}

.dataTables_filter {
    float: right;
}

/* Table styling */
.table-hover tbody tr:hover td {
    background-color: #f5f5f5;
}

.dataTables_wrapper .dataTables_paginate {
    float: right;
    margin: 0;
}

.dataTables_wrapper .dataTables_info {
    clear: both;
    float: left;
    padding-top: 8px;
}
</style>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/auto-filter.js" charset="utf-8"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
    // Initialize DataTables with Export and Pagination
    var table = $('#ganeshSamitiTable').DataTable({
        "processing": true,
        "serverSide": false, // Client-side processing
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'गणेश समिति सूची - ' + new Date().toLocaleDateString('hi-IN'),
                className: 'btn btn-success',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                text: 'Print',
                title: 'गणेश समिति सूची',
                className: 'btn btn-info'
            },
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
                className: 'btn btn-warning'
            }
        ],
        "paging": true, // Enable pagination
        "searching": true, // Enable searching
        "ordering": true, // Enable ordering
        "info": true, // Display info
        "lengthMenu": [
            [10, 20, 50, 100, 500, -1],
            [10, 20, 50, 100, 500, "All"]
        ],
        "pageLength": 20,
        "responsive": true,
        "scrollX": true,
        "language": {
            lengthMenu: "दिखाएं _MENU_ entries प्रति पेज",
            search: "खोजें:",
            info: "दिखाया जा रहा है _START_ से _END_ तक _TOTAL_ entries में से",
            infoEmpty: "कोई entries उपलब्ध नहीं",
            infoFiltered: "(कुल _MAX_ entries में से फ़िल्टर किया गया)",
            paginate: {
                first: "पहला",
                last: "अंतिम",
                next: "अगला",
                previous: "पिछला"
            },
            emptyTable: "टेबल में कोई डेटा उपलब्ध नहीं है"
        },
        "order": [[ 0, "asc" ]]
    });

    // Custom filter for Year column (column index 1)
    $('#yearFilter').on('change', function() {
        table.column(1).search(this.value).draw();
    });

    // Custom filter for Block column (column index 3)
    $('#blockFilter').on('change', function() {
        table.column(3).search(this.value).draw();
    });

    // Custom filter for Ganesh Samiti Name column (column index 2)
    $('#samitiFilter').on('change', function() {
        table.column(2).search(this.value).draw();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('#yearFilter').val('');
        $('#blockFilter').val('');
        $('#samitiFilter').val('');
        table.search('').columns().search('').draw();
    });
});
</script>

<script type="text/javascript">
var baseURL = "<?php echo base_url(); ?>"; // Define baseURL globally

jQuery(document).ready(function(){
    // Delete with event delegation to handle dynamic content
    jQuery(document).on('click', '.deleteGaneshSamiti', function(e) {
        e.preventDefault();
        var ganeshSamitiId = jQuery(this).data('ganeshsamitiid');
        var confirmation = confirm("Are you sure you want to delete this record?");
        
        if (confirmation) {
            var hitURL = baseURL + "ganeshsamiti/delete";
            var currentRow = jQuery(this).closest('tr');
            
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: { ganeshSamitiId: ganeshSamitiId }
            }).done(function(data) {
                console.log(data);
                if (data.status == true) {
                    alert("Record deleted successfully");
                    location.reload(); // Reload page to refresh data
                } else {
                    alert("Record deletion failed: " + data.message);
                }
            }).fail(function() {
                alert("An error occurred while processing the request");
            });
        }
    });
});
</script>