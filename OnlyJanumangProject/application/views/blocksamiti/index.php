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
            <i class="fa fa-users" aria-hidden="true"></i> Block Samiti Locations
        </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">ब्लॉक समिति स्थान (Block Samiti Locations) List</h3>
                        <div style="float: right;">
                            <a href="<?php echo site_url('blocksamiti/create'); ?>" class="btn btn-success">Add New Location</a>
                        </div>
                    </div><!-- /.box-header -->
                    <!-- Total Members Card -->
                    <div style="margin: 10px 0; padding: 10px 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 5px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <span style="font-size: 12px; opacity: 0.9;">कुल सदस्य:</span>
                        <span style="font-size: 18px; font-weight: bold; margin-left: 8px;">
                            <?php echo isset($total_members) ? $total_members : 0; ?>
                        </span>
                    </div>
                    <!-- Filters -->
                    <div class="box-body">
                        <form method="get" action="<?php echo site_url('blocksamiti'); ?>" class="form-inline" id="filterForm">
                            <div class="form-group">
                                <label for="filter_block" class="control-label">ब्लॉक (Block):</label>
                                <select name="filter_block" id="filter_block" class="form-control input-sm">
                                    <option value="">All</option>
                                    <?php if (!empty($blocks)): foreach ($blocks as $blk): ?>
                                    <option value="<?php echo $blk->id; ?>" <?php echo (isset($filter_block) && $filter_block == $blk->id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($blk->name); ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <label for="filter_year" class="control-label">वर्ष (Year):</label>
                                <select name="filter_year" id="filter_year" class="form-control input-sm">
                                    <option value="">All</option>
                                    <?php if (!empty($years)): foreach ($years as $yr): ?>
                                    <option value="<?php echo $yr['year']; ?>" <?php echo (isset($filter_year) && $filter_year == $yr['year']) ? 'selected' : ''; ?>><?php echo $yr['year']; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <label for="filter_month" class="control-label">महीना (Month):</label>
                                <select name="filter_month" id="filter_month" class="form-control input-sm">
                                    <option value="">All</option>
                                    <?php 
                                    $months_names = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 
                                                          7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                                    if (!empty($months)): 
                                        foreach ($months as $m): 
                                            $month_num = (int)$m['month'];
                                    ?>
                                    <option value="<?php echo $month_num; ?>" <?php echo (isset($filter_month) && $filter_month == $month_num) ? 'selected' : ''; ?>><?php echo $months_names[$month_num]; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <label for="filter_date" class="control-label">तारीख (Date):</label>
                                <input type="date" name="filter_date" id="filter_date" class="form-control input-sm" value="<?php echo isset($filter_date) ? $filter_date : ''; ?>">
                            </div>
                            <div class="form-group" style="margin-left: 15px;">
                                <button type="submit" class="btn btn-primary btn-sm" style="display:none;"><i class="fa fa-filter"></i> Filter</button>
                                <a href="<?php echo site_url('blocksamiti'); ?>" class="btn btn-default btn-sm">Reset</a>
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover" id="blocksamitiTable">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th>Sr No</th>
                                    <th>Unique ID</th>
                                    <th>वर्ष (Year)</th>
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
                                        <a href="<?php echo site_url('blocksamiti/members/'.$group['id']); ?>" class="btn btn-primary btn-xs" title="View Members">
                                            <i class="fa fa-users"></i> View
                                        </a>
                                        <a href="<?php echo site_url('blocksamiti/edit/'.$group['id']); ?>" class="btn btn-warning btn-xs" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="<?php echo site_url('blocksamiti/delete/'.$group['id']); ?>" class="btn btn-danger btn-xs" title="Delete" onclick="return confirm('Are you sure you want to delete this location and all its members?');">
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
    $('#blocksamitiTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Block Samiti Locations List',
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

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/auto-filter.js" charset="utf-8"></script>
